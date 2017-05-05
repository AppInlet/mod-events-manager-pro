// PayFast redirection
/*Copyright (c) 2008 PayFast (Pty) Ltd
You (being anyone who is not PayFast (Pty) Ltd) may download and use this plugin / code in your own website in conjunction with a registered and active PayFast account. If your PayFast account is terminated for any reason, you may not use this plugin / code or part thereof.
    Except as expressly indicated in this licence, you may not use, copy, modify or distribute this plugin / code or part thereof in any way.*/
$(document).bind('em_booking_gateway_add_payfast', function(event, response){
    // called by EM if return JSON contains gateway key, notifications messages are shown by now.
    if(response.result){
        var ppForm = $('<form action="'+response.payfast_url+'" method="post" id="em-payfast-redirect-form"></form>');
        $.each( response.payfast_vars, function(index,value){
            ppForm.append('<input type="hidden" name="'+index+'" value="'+value+'" />');
        });
        ppForm.append('<input id="em-payfast-submit" type="submit" style="display:none" />');
        ppForm.appendTo('body').trigger('submit');
    }
});