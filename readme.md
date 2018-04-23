### PHP Test Application Using Laravel 5.6
#### Todo
Please write a PHP web application and send it back a github link to us.

- Wait for a user action, like clicking buttons. According to these actions some data (see further below) should be:
    - either shown nicely formatted on the screen
    - or downloaded as CSV file
- You can either download the data on each request during the runtime of your PHP program or load the data from a database (in this case do NOT provide a DB dump, but a script which automatically transfers the data from the remote location to the DB)
- preferably the implementation should be written in "clean code", separate concerns using pattern like MVC, be object oriented, very good testable, best even already contain Unit tests and maybe even follow the KISS and SOLID principles

AND

Country List
- the data should be a list of countries with their country code
- Please download the base data from https://gist.github.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230
- afterwards you will have to change the whole list from "Country code - Country name" to "CountryName - CountryCode" and sorts the list by CountryName

### Environment using Docker and Docker-compose

#### To run on Linux (distros based on debian)
- 1 Clone or download the repository
    ```bash
    git clone https://github.com/fredericomartini/php-test.git
  
- 2 Enter project folder
    ```bash
    cd php-test
  
- 3 To run the environment create a copy or rename `.env.sample`
    ```bash
    cp .env.example .env    

- 4 Enter environment folder
    ```bash
    cd environment/
  
- 5 Run the environment (build de images with docker-compose). There is a script to make the process easier 
     ```bash
     ./start.sh start
  
- 6 Create an entry in the /etc/hosts file 
    ```bash
    sudo sed -i '1s/^/127.0.0.1       phptest.local\n/' /etc/hosts
  
- 7 Get into the container to run commands like (php, composer, phpunit..)
    ```bash
    ./start.sh enter-web
  
- 8 Install vendor, composer required files
    ```bash
    composer install

- 9 Generate the app KEY
    ```bash
    php artisan key:generate
  
It's DONE!

Available at: [http://phptest.local/](http://phptest.local/)

### Tests

- To run tests, get into the container and run:
    ```bash
    vendor/bin/phpunit

### Other options for start.sh
    ```
    start     :: Build and Start the stack
    stop      :: Stop the stack
    clear     :: Remove the stack and clear images that are builded
    clearAndDeleteAll :: Remove the stack, clear the images and remove volumes, WARNING (ALL DATA WILL BE LOST)
    enter-db  :: Get into the database container to run commands like (mysql -v, mysql -u)
    enter-web :: Get into the web container to run commands like (php -v, composer install)
