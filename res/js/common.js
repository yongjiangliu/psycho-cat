$(function() {

//  Bind the event handler to the "submit" JavaScript event
function check (name){
  var input = $('#'+name);
  var value = $.trim(input.val());
  if (value === ''){
    input.parent().parent().attr("class","form-group has-error");
    return 1;
  }
  else {
    input.parent().parent().attr("class","form-group");
    return 0;
  }
}

function checkSimple(name)
{
  var input = $('#'+name);
  var value = $.trim(input.val());
  if (value === ''){
    return 1;
  }
  else {
    return 0;
  }
}

// if jquery can't find element with given id, it will ignore it without throwing an error
// user infomation form @ home page
$('#userInfo').submit(function () {
    var result = 0;
    // Get trimmed values
    result += check('name');
    result += check('occupation');
    result += check('gender');
    result += check('birthday');
    result += check('education');
    result += check('bloodType');
    result += check('marriage');
    if (result == 0){
        return true;
    }
    else {
        return false;
    }
});
// search form @ search bar @ admin/panel page (search answer by name)
$('#searchAnswer').submit(function () {
    var result = 0;
    // Get trimmed values
    result += checkSimple('name');
    if (result == 0){
        return true;
    }
    else {
        return false;
    }
});
// admin login form @ admin login page
$('#adminLogin').submit(function () {
    var result = 0;
    // Get trimmed values
    result += check('username');
    result += check('password');
    if (result == 0){
        return true;
    }
    else {
        return false;
    }
});
// upload form @ question list upload page
$('#uploadQuestion').submit(function () {
    var result = 0;
    // Get trimmed values
    result += checkSimple('file');
    if (result == 0){
        return true;
    }
    else {
        return false;
    }
});
// test code submit form @ test code page
$('#testCode').submit(function () {
    var result = 0;
    // Get trimmed values
    result += checkSimple('test_code');
    if (result == 0){
        return true;
    }
    else {
        return false;
    }
});


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
