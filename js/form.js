// File button
$('.file-upload .file-button').click(function() {
  var fileTrigger = $(this).parent().siblings('.file-trigger');
  $(fileTrigger).trigger('click');
});

// Add url button
var urlInput = '<div class="form-group"><input type="url" class="form-control" value="http://"></div>';
$('.add-url-button').click(function() {
  $(this).before(urlInput);
});
