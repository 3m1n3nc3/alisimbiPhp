$(document).ready(function() {
  $(window).resize(function () {
    if($(window).width > 600){
      $('#popular_course_panel').removeClass('collapse');
    }else{
      $('#popular_course_panel').addClass('collapse');
    }
  });
  "use strict";

  /* =============================================
  jQuery Countdown
  ================================================ */
  var date = '2019-07-15';
  let countdownDate = new Date(date);

  $('.countdownValue').each(function(){
    $(this).countdown({
      until: countdownDate,
      padZeroes: true,
      labels: [ 'hrs', 'min', 'sec']
    });
  });

});



function errorHtml(message, response) {
  htmlX =
  '<div class="card m-2 text-center">'+
  '<div class="card-header p-2">Server Response: </div>'+
  '<div class="card-body p-2 text-info">'+
  '<div class="card-text font-weight-bold text-danger">'+message+'</div>'
  +response+
  '</div>'+
  '</div>';
  return htmlX;
}

function connector(type, target) {
  // let preloader = $(target).find('.form-preloader');
  // $(preloader).show();
  $('.loader_bg').fadeToggle();
  let messager = $('#login_section_alert'); 
 
  if (type == 0) {

    /*For login*/
    // var username = $('input[name="username"]').val();
    // var password = $('input[name="password"]').val();
    // var remember = $('input[name="remember"]').val();

    let username = target.username.value;
    let password = target.password.value;
    let remember = target.remember.value;
    let submit_b = target.submit.value;

    $(submit_b).attr('disabled', 'disabled');
    let url = siteUrl + "/connection/connector.php";
    let url_data = "username="+username+"&password="+password+"&remember="+remember+"&login=1";

    $.ajax({
      type: "POST",
      url: url,
      data: url_data,
      dataType:"json",
      cache: false,
      success: function(html) {
        $('.loader_bg').fadeToggle();
        var response = html.message;
        var status= html.status;
        $(messager).html(response);
        $(submit_b).removeAttr('disabled');

        if (status == 1) {
          window.top.location=html.header;
        }
      },
      error: function(xhr, status, error) {
        $('.loader_bg').fadeToggle();
        var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error;
        $(messager).html(errorHtml(errorMessage, xhr.responseText));
      }
    });
  }
  else if (type == 1) {
    /*For registration*/
    var username = $('input[name="register-username"]').val();
    var password = $('input[name="register-password"]').val();
    var cc_password = $('input[name="register-confirm-password"]').val();
    var email = $('input[name="register-email"]').val();
    var firstname = $('input[name="register-fname"]').val();
    var lastname = $('input[name="register-lname"]').val();
    var country = $('select[name="register-country"] option:selected').val();
    var state = $('select[name="register-state"] option:selected').val(); console.log(state);
    var city = $('select[name="register-city"] option:selected').val(); 
    $.ajax({
      type: "POST",
      url: siteUrl+"/connection/connector.php",
      data: "username="+username+"&password="+password+"&cc_password="+cc_password+"&email="+email+"&firstname="+firstname+"&lastname="+lastname+"&country="+country+"&state="+state+"&city="+city+"&register=1",
      dataType:"json",
      cache: false,
      success: function(html) {
        $('.loader_bg').fadeToggle();
        var response = html.message; 
        $(messager).html(response);
        if (html.status == 1) {
          window.top.location=html.header;        
        } 
      },
      error: function(xhr, status, error) {
        $('.loader_bg').fadeToggle();
        var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error;
        $(messager).html(errorHtml(errorMessage, xhr.responseText));
      }
    });
  }
}

$('.select-country-list').on('change',function (){
  try{
    let target =  $('#' +$(this).attr('data-target'));
    fetch_state(this, target);
  }
  catch(e){
    console.log(e.message);
  }
});


function fetch_state(sender,receiver) { 
  var sender_id = sender.options[sender.selectedIndex].id; 
  
  $.ajax({
    type: 'POST',
    url: siteUrl+'/connection/location.php',
    data: {country_id:sender_id, type:2},
    success: function(html) {
      $(receiver).html(html);
      $(receiver).on('change',function (){
        let target = $('#' +$(this).attr('data-target'));
        fetch_city(receiver, target);
      });
    }
  });
}

function fetch_city(sender, receiver) {
  var sender_id = sender[0].options[sender[0].selectedIndex].id; 

   $.ajax({
    type: 'POST',
    url: siteUrl+'/connection/location.php',
    data: {state_id:sender_id, type:1},
    success: function(html) {
      $(receiver).html(html);
    }
  })
}

$('.cc-input').keyup(function (){
  if(this.value.length === this.maxLength){
    var $next = $(this).next('.cc-input'); 
    if($next.length){
      $next.focus();
    }else{
      $(this).blur();
    }
  }
});
$('.cc-num').on("blur", function(){
  $(this).attr('type', 'password');
});
$('.cc-group').on("focusin", function (){
  $(this).css({
    border: "1px solid green"
  })
});
$('.cc-group').on("focusout", function (){
  $(this).css({
    border: "1px solid #d6d6d6"
  })
});
$('.cc-num').on("focusin", function(){
  $(".cc-num").attr('type', 'password');
  $(this).attr('type', 'text');
});
