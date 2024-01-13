$(document).ready(function() {
    $('.table').DataTable({
        paging: true,
        filter: true,
        "pageLength": 10
    });
  });
  
  $("form").submit(function (e) {
      e.preventDefault();
      submitForm(
        $(this).attr("action"),
        $(this).attr("method"),
        $(this).serialize(),
        $(this).find("button[type=submit]"),
      );
    });
    