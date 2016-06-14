$(document).ready(function() {
    var text_max = 200;
    $('#fileDescriptionCount').html(text_max + ' characters remaining');

    $('#fileDescription').keyup(function() {
        var text_length = $('#fileDescription').val().length;
        var text_remaining = text_max - text_length;

        $('#fileDescriptionCount').html(text_remaining + ' characters remaining');
    });
});