var g = {
    'refreshingCaptcha' :   false,
    'siteURL':              siteURL
};

$('#subject_info').submit(function(e){
    var canSubmit = true;
    var line;
    var val;
    var reg;
    for (var field in regex)
    {

        if (regex.hasOwnProperty(field))
        {
            line    = $('#' + field.toString());
            val     = line.val();
            reg     = regex[field.toString()];
            if (reg.test(val))
            {
                line.removeClass().addClass('form-control alert-success');
            }
            else
            {
                line.removeClass().addClass('form-control alert-danger');
                canSubmit = false;
            }
        }
    }

    if (!canSubmit)
    {
        e.preventDefault();
    }
});

$('#refresh_captcha').click(function()
{
    if (g.refreshingCaptcha)
    {
        return;
    }
    else
    {
        g.refreshingCaptcha = true;
    }
    var loading = "<img src='" + g.siteURL + "res/img/loading.gif' height=30px>";
    $('#captcha_container').html(loading);
    $.ajax({
            method: "GET",
            url: g.siteURL + "home/captcha"
        })
        .done(function(msg) {
            $('#captcha_container').html(msg);
            g.refreshingCaptcha = false;
        });
});