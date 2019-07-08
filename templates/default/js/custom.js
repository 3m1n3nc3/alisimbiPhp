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

function connector(type) {  
  $('#preloader').show();

  $('#login_b').removeAttr('onclick');  
  
  if (type == 0) {
    var username = $('input[name="username"]').val();  
    var password = $('input[name="password"]').val();
    var remember = $('input[name="remember"]').val();

    $.ajax({
      type: "POST",
      url: siteUrl+"/connection/connector.php",
      data: "username="+username+"&password="+password+"&remember="+remember+"&login=1", 
      dataType:"json",
      cache: false,
      success: function(html) {
        var message = html.message; 
        $('#preloader').hide();
        $('#login_msg').html(message);
        if (html.status == 1) { 
          window.top.location=html.header; 
        } 
      },
      error: function(xhr, status, error) {
        var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error; 
        $('#login_msg').html(errorHtml(errorMessage, xhr.responseText));
      }
    });
  } else if (type == 1) {
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
  var country = document.getElementById("country");
  var country_id = country.options[country.selectedIndex].id; 
  $.ajax({
    type: 'POST',
    url: siteUrl+'/connection/location.php',
    data: {country_id:country_id, type:2},  
    success: function(html) {
      $('#state').html(html);
      $('#state').attr('onchange', 'fetch_city()'); 
    }   
  })
}

function fetch_city() { 
  var state = document.getElementById("state");
  var state_id = state.options[state.selectedIndex].id; 
  $.ajax({
    type: 'POST',
    url: siteUrl+'/connection/location.php',
    data: {state_id:state_id, type:1},  
    success: function(html) { 
      $('#city').html(html);
    } 
  })
}