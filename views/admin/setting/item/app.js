
CKEDITOR.replace('note');

$("form").submit(function (e) {
  e.preventDefault();
  for ( instance in CKEDITOR.instances ) {
      CKEDITOR.instances[instance].updateElement();
  }
  submitForm(
    $(this).attr("action"),
    $(this).attr("method"),
    $(this).serialize(),
    $(this).find("button[type=submit]"),
    $(this).attr("href")
  );
});