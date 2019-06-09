$.ajax({
  url: '../controller/countNotifications.php',
  success: function (data) {
    $('.count').html(data);
  }
});

$(document).on("click", ".notifications", function () {
  $.ajax({
    url: "../controller/fetchNotifications.php",
    success: function (data) {
      if (data !== '1') {
        $('.notif-area').html(data);
      } else {
        let notifVal = `
        <h6 class="dropdown-header" style="font-weight: 600;">Notifications</h6>
        <div class="dropdown-divider"></div>
        <div class="notif text-center">
          <i class="far fa-envelope fa-5x"></i>
          <h5>No notifications</h5>
        </div>
        `;
        $('.notif-area').html(notifVal);
      }
    }
  });
});