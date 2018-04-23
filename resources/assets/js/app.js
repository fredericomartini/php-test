/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function () {
    /**
     * Waiting for click .open-modal-window
     */
    $('.open-modal-window').on('click', function (event) {
        event.preventDefault();
        //request data
        axios
            .get($(this).attr('href'))
            .then(function (response) {
                let $data = response.data;
                //Replaces content into the modal
                //Modal body
                let modal = $('#modal-default');
                $('#modal-replaceable').html($data);
                modal.modal('show');
            })
            .catch(function (error) {
                console.log(error.response);
            });
    });
});
