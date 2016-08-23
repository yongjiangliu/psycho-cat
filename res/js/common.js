

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