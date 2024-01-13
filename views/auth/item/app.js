$("form").submit(function (e) {
  e.preventDefault();
  submitForm(
    $(this).attr("action"),
    $(this).attr("method"),
    $(this).serialize(),
    $(this).find("button[type=submit]"),
    $(this).attr("href")
  );
});