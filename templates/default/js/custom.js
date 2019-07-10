$(document).ready(function() {

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
  let message = $('#login_section_alert');
  console.log(message);


  if (type == 0) {

    /*For login*/
    var username = $('input[name="username"]').val();
    var password = $('input[name="password"]').val();
    var remember = $('input[name="remember"]').val();

    // let username = target.username;
    // let password = target.password;
    // let remember = target.remember;
    // let submit_b = target.submit;


    $(submit_b).attr('disabled', 'disabled');
    let url = siteUrl + "/connection/connector.php";
    let url_data = "username="+username+"&password="+password+"&remember="+remember+"&login=1";
    console.log(url_data);

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
        $(message).html(response);
        $(submit_b).removeAttr('disabled');

        if (status == 1) {
          window.top.location=html.header;
        }
      },
      error: function(xhr, status, error) {
        var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error;
        $(message).html(errorHtml(errorMessage, xhr.responseText));
      }
    });
    console.log(message);
  }
  else if (type == 1) {
    /*For registration*/
    var username = $('input[name="username"]').val();
    var password = $('input[name="password"]').val();
    var email = $('input[name="email"]').val();
    var firstname = $('input[name="fname"]').val();
    var lastname = $('input[name="lname"]').val();
    var country = $('select[name="country"] option:selected').val();
    var state = $('select[name="state"] option:selected').val();
    var city = $('select[name="city"] option:selected').val();

    $.ajax({
      type: "POST",
      url: siteUrl+"/connection/connector.php",
      data: "username="+username+"&password="+password+"&email="+email+"&firstname="+firstname+"&lastname="+lastname+"&country="+country+"&state="+state+"&city="+city+"&register=1",
      dataType:"json",
      cache: false,
      success: function(html) {
        var message = html.message;
        $('#preloader').hide();
        $('#reg_msg').html(message);
        if (html.status == 1) {
          window.top.location=html.header;
        }
      },
      error: function(xhr, status, error) {
        var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error;
        $('#reg_msg').html(errorHtml(errorMessage, xhr.responseText));
      }
    });
  }
}

function fetch_state() {
  var country = document.getElementById("register-country");
  var country_id = country.options[country.selectedIndex].id;console.log(country_id);
  $.ajax({
    type: 'POST',
    url: siteUrl+'/connection/location.php',
    data: {country_id:country_id, type:2},
    success: function(html) {
      $('#register-state').html(html);
      $('#register-state').attr('onchange', 'fetch_city()');
    }
  })
}

function fetch_city() {
  var state = document.getElementById("register-state");
  var state_id = state.options[state.selectedIndex].id;
  $.ajax({
    type: 'POST',
    url: siteUrl+'/connection/location.php',
    data: {state_id:state_id, type:1},
    success: function(html) {
      $('#register-city').html(html);
    }
  })
}
