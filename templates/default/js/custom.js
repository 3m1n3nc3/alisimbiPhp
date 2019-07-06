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
