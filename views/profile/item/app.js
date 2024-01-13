$(document).ready(function() {
    $('.table').DataTable({
        paging: true,
        filter: true,
        "pageLength": 10
    });
});

$("#change_password").submit(function(e) {
    e.preventDefault();
    submitForm($(this).attr('action'), $(this).attr('method'), $(this).serialize(),$(this).find("button[type=submit]"))
});

$("#changeApiKey").click(function() {
    $.ajax({
        type: 'PUT',
        url: '/api/profile/thay-doi-apikey',
        dataType: "json",
        statusCode: {
            403: function() {
                noti("error", "Đường dẫn API không chính xác");
            },
            404: function() {
                noti("error", "Đường dẫn API không chính xác");
            },
            500: function() {
                noti("error", "API đã xảy ra lỗi gì đó , vui lòng liên admin để khắc phục lỗi");
            },
            405: function(request) {
                let data = JSON.parse(request.responseText);
                noti(data.status, data.msg);
            },
        },
        success: function(data) {
            $("#apikey").val(data.apikey);
        }
    })
});

$("#changeName").click(function() {
    var name = $("#hovaten").val();
    $.ajax({
        type: 'POST',
        url: '/api/profile/thay-doi-ho-va-ten',
        data: {
            name: name
        },
        statusCode: {
            403: function() {
                noti("error", "Đường dẫn API không chính xác");
            },
            404: function() {
                noti("error", "Đường dẫn API không chính xác");
            },
            500: function() {
                noti("error", "API đã xảy ra lỗi gì đó , vui lòng liên admin để khắc phục lỗi");
            }
        },
        dataType: "json",
        success: function(data) {
            $("#name").val(data.name);
        }
    })
});
