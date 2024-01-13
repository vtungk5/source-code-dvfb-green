function submitForm(url, method, data, button = null, href = null) {
  if (button == null) {
    $.ajax({
      type: method,
      url: url,
      data: data,
      dataType: "json",
      statusCode: {
        400: function () {
          noti("error", "400 status code! user error");
        },
        500: function () {
          noti("error", "500 status code! server error");
        },
      },
      success: (data) => {
        if (href != null) {
          window.location.href = href;
          noti(data.status, data.msg);
        } else {
          noti(data.status, data.msg);
        }
      },
      error: function (request) {
        let data = JSON.parse(request.responseText);
        noti(data.status, data.msg);
      },
    });
  } else {
      let textButton = button.html().trim();

    $.ajax({
      type: method,
      url: url,
      data: data,
      dataType: "json",
      beforeSend: function () {
        button
          .prop("disabled", !0)
          .html('<i class="fas fa-spinner fa-spin"></i> Đang tải...');
      },
      complete: function () {
        button.prop("disabled", !1).html(textButton);
      },
      statusCode: {
        403: function () {
          noti("error", "Đường dẫn API không chính xác");
        },
        404: function () {
            noti("error", "Đường dẫn API không chính xác");
        },
        500: function () {
          noti("error", "API đã xảy ra lỗi gì đó , vui lòng liên admin để khắc phục lỗi");
        },
      },
      success: (data) => {
        if (href != null) {
            setInterval(() => {
                window.location.href = href;
            }, 700);
          noti(data.status, data.msg);
        } else {
          noti(data.status, data.msg);
        }
      },
      error: function (request) {
        let data = JSON.parse(request.responseText);
        noti(data.status, data.msg);
      },
    });
  }
}
function copy(text) {
  var copyText = document.getElementById(text);

  copyText.select();
  
  navigator.clipboard.writeText(copyText.value);

  Swal.fire({
      title: 'Thành Công!',
      text: 'Đã sao chép nội dung thành công',
      icon: 'success',
      confirmButtonText: 'Đồng ý'
  });
}

function noti(status, text) {
  if (status === "error") {
    var title = "Thất Bại!";
    var button = "Thử lại";
  } else {
    var title = "Thành Công!";
    var button = "Đồng ý";
  }
  Swal.fire({
    title: title,
    text: text,
    icon: status,
    confirmButtonText: button,
  });
}
$(function () {
  $('.nav-link[href="' + location.pathname + '"]').addClass("active");
});

$(function () {
  var loc = window.location.pathname;
  var dts = loc.substring(0, loc.lastIndexOf("/"));
  $('.nav-link[path="' + dts + '/"]').addClass("active");
  $('.nav-link[path="' + dts + '/"] > img').click();
});

$(function () {
  let sidebar = document.querySelector("#sidebar");
  $('button[data-sidebar="on"]').click(() => {
    sidebar.classList.toggle("show");
  });
  $("#edit-name").click(() => {
    $("#demo").toggleClass("d-none");
    $("#edit-v").toggleClass("d-none");
  });
  $("#edit-name2").click(() => {
    $("#demo").toggleClass("d-none");
    $("#edit-v").toggleClass("d-none");
  });
  $("#changeName").click(() => {
    $("#demo").toggleClass("d-none");
    $("#edit-v").toggleClass("d-none");
  });
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );
});
