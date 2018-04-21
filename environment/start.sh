#!/bin/bash
INSTALLED_DOCKER=$(which docker)
INSTALLED_DOCKER_COMPOSE=$(which docker-compose)
OPTION=$1
LOGIN_AS_USER=$2
#espera que arquivo .env esteja em um diretório acima (raiz projeto)
export ENV_FILE=$(pwd)/../.env
COMPOSE_FILE=docker-composes/app.yml
COMPOSE_NGINX_PROXY=docker-composes/nginx-proxy.yml
CONT_NGINX_PROXY_NAME=nginx-proxy
COMPOSE_LOGGLY=docker-composes/loggly.yml
CONT_LOGGLY_NAME=loggly



# Verificar se docker está instalado, caso não esteja, instalar
if [ ! -e "$INSTALLED_DOCKER" ]; then
    echo "Docker isn't installed, must be installed first!"
    echo 'Running script installation docker...'
    sleep 2
    wget -O - https://raw.githubusercontent.com/fredericomartini/shell/master/install_docker.sh | sh
fi

# Verificar se docker-compose está instalado, caso não esteja, instalar
if [ ! -e "$INSTALLED_DOCKER_COMPOSE" ]; then
   #instalar 
   INSTALLED_CURL=$(which curl)
   if [ ! -e "$INSTALLED_CURL" ]; then
       sudo apt-get update && sudo apt-get install curl -y
   fi
   
   sudo curl -L https://github.com/docker/compose/releases/download/1.20.1/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose

   sudo chmod +x /usr/local/bin/docker-compose
fi       


# Verifica se container do nginx-proxy (monitorar containers/sites e apontar p/ porta 80) está rodando
runNginxProxy() {
  if [ ! "$(docker ps -q -f name=${CONT_NGINX_PROXY_NAME})" ]; then
    if [ "$(docker ps -aq -f status=exited -f name=${CONT_NGINX_PROXY_NAME})" ]; then
        # cleanup
        docker rm $CONT_NGINX_PROXY_NAME
    fi
    # run your container
    docker-compose -f $COMPOSE_NGINX_PROXY up --no-start
    docker-compose -f $COMPOSE_NGINX_PROXY start
  fi

}

# Verifica se container de logs (loggly) (monitorar containers/sites e enviar logs p/ loggly) está rodando
runLoggly() {
  if [ ! "$(docker ps -q -f name=${CONT_LOGGLY_NAME})" ]; then
    if [ "$(docker ps -aq -f status=exited -f name=${CONT_LOGGLY_NAME})" ]; then
        # cleanup
        docker rm $CONT_LOGGLY_NAME
    fi
    # run your container
    docker-compose -f $COMPOSE_LOGGLY up --no-start
    docker-compose -f $COMPOSE_LOGGLY start
  fi

}

# Script automático do Loggly p/ configurar syslog no host (necessário rodar somente uma vez)
configureSyslog(){
  curl -O https://www.loggly.com/install/configure-linux.sh
  sudo bash configure-linux.sh -a ${LOGGLY_SUB_DOMAIN} -u ${LOGGLY_USERNAME} -p ${LOGGLY_PASSWORD} --force-secure
  rm -rf configure-linux.sh
}

# Exporta variáveis para ficarem disponíveis no terminal e assim serem utilizadas
function exportEnvVars() {
    export $(egrep -v '^#' $ENV_FILE | xargs)    
    #exporta varíáveis que ñ estão presente no .env diretamente, mas são utilizadas
    export USER_ID=$(id -u)
    export GROUP_ID=$(id -g)
    export COMPOSE_PROJECT_NAME=${APP_NAME}
}

function confirmationYesNo(){
  read -p "Tem certeza que deseja remover container e os volumes (dados em database serão perdidos) Operação não poderá ser desfeita
 Confirma (y/n)?" choice

  case "$choice" in 
    y|Y )
    
      ;;
    n|N ) 
      exit 0
      ;;
      * ) 
      echo "invalid"
      exit 0
    ;;
  esac
}

# Verifica opção do usuário
function run() {
    case $OPTION in
            start) 
                docker-compose -f $COMPOSE_FILE down
                # Verificar se container proxy rodando, caso ñ rodar
                runNginxProxy
                # Verificar se container loggly rodando, caso ñ rodar
                #runLoggly
                docker-compose -f $COMPOSE_FILE up --no-start --build
                docker-compose -f $COMPOSE_FILE start
                #remover imagens sem name/tag
                docker rmi -f $(docker images -a  |grep "<none>") > /dev/null 2>&1
                ;;
            stop) 
                docker-compose -f $COMPOSE_FILE stop
                ;;
            clear)
                docker-compose -f $COMPOSE_FILE down
                #TODO: executar rm de imagens do docker-compose
                 docker rmi ${APP_NAME}/php:${PHP_VERSION}
                ;;
            enter-db)
                # echo $(pwd);
                docker exec -it $(docker ps -q -f name=${APP_NAME}_db_1) bash
                ;;
            enter-web)
                # User default (logado) ou usuários especificado 'root'
                docker exec -it --user=${LOGIN_AS_USER:-$USER} $(docker ps -q -f name=${APP_NAME}_web_1) bash

                ;;
            clearAndDeleteAll)
                # Validar se usuário tem certeza que deseja deseja remover tudo.
                confirmationYesNo
                sudo docker-compose -f $COMPOSE_FILE down --volumes
                #TODO: executar rm de imagens do docker-compose
                sudo docker rmi -f ${APP_NAME}/php:${PHP_VERSION}
                ;;
            *) echo "USAGE: (star | stop | clear | enter-db | enter-web)
  start     :: Build and Start the stack
  stop      :: Stop the stack
  clear     :: Remove the stack and clear images that are builded
  clearAndDeleteAll :: Remove the stack, clear the images and remove volumes, WARNING (ALL DATA WILL BE LOST)
  enter-db  :: Get into the database container to run commands like (mysql -v, mysql -u)
  enter-web :: Get into the web container to run commands like (php -v, composer install)"
    esac
}

exportEnvVars
#configureSyslog #rodar somente uma vez e em produção
run
