
$(function() {
    var option = [];
    var mc_answer = "";
    option[0] = $("#option_1");
    option[1] = $("#option_2");
    option[2] = $("#option_3");
    option[3] = $("#option_4");
    option[4] = $("#option_5");

    function getVal(key)
    {
      if (option[key] != null)
      {
        if (option[key].prop('checked'))
        {
          return option[key].val();
        }
        else
        {
          return "";
        }
      }
    }
    function mergeAnswer()
    {
      for(var i = 0; i < 5; i++)
      {
        mc_answer = mc_answer + getVal(i);
      }
      if (mc_answer != "")
      {
        $("#answer").val(mc_answer);
        return true;
      }
      else
      {
        return false;
      }
    }

    function doSubmit()
    {
      var img = "<img src='"+ imgPath +"/loading.gif' alt='loading' class='img-rounded'>";
      $('#submitDiv').html(img);
      return true;
    }

    // focus on option 1 so we can use arrow keys and enter key
    $("#option_1").focus();
    // change submit button to gif to prevent crazy enter press
    $('#test').submit(function () {
      if ($("#type").val() == 'mc')
      {
        if (mergeAnswer())
        {
          return doSubmit();
        }
        else
        {
          return false;
        }
      }
      else
      {
        return doSubmit();
      }
    });

});
