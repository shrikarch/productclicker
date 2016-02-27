$(document).ready(function() {

    $('#captcha-section').hide();
    $("#footer").load("../footing.html");

    $('#footer .fa').mouseover(function() {
        var prefix = '.' + $(this).data('social') + '-content';
        $('.pholder').addClass('hide');
        $(prefix).removeClass('fadeOut');
        $(prefix).addClass('fadeIn');
        $(prefix).removeClass('hide');
    });
    $('#footer .fa-facebook').mouseout(function() {
    });
    $('#footer .fa-twitter').mouseout(function() {
        $('.tw-content').addClass('hide fadeOut');
        $('.pholder').removeClass('hide');
    });

    $(document).bind('contextmenu', function (e) {
        e.preventDefault();
        //alert('temporary message showing right click is off.');
    });
    $('.navigation .nav a').smoothScroll({
        offset: -130,
        speed: 1500
    });
    $('#message').focusin(function(){
        $('#captcha-section').slideDown();
    });
    
    var form = $('#ajax-contact');

    // Get the messages div.
    var formMessages = $('#form-messages');

    // Set up an event listener for the contact form.
    $(form).submit(function(event) {
        // Stop the browser from submitting the form.
        event.preventDefault();
        var formData = $(form).serialize();
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        }).done(function(response) {
            // Make sure that the formMessages div has the 'success' class.
            $(formMessages).removeClass('error');
            $(formMessages).addClass('success');

            // Set the message text.
            $(formMessages).text(response);

            // Clear the form.
            $('#name').val('');
            $('#email').val('');
            $('#phone').val('');
            $('#message').val('');
        }).fail(function(data) {
            // Make sure that the formMessages div has the 'error' class.
            $(formMessages).removeClass('success');
            $(formMessages).addClass('error');

            // Set the message text.
            if (data.responseText !== '') {
                $(formMessages).text(data.responseText);
            } else {
                $(formMessages).text('Oops! An error occured and your message could not be sent.');
            }
        });
    });
});
