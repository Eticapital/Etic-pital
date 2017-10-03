// File button
$('.file-upload .file-button').click(function() {
  var fileTrigger = $(this).parent().siblings('.file-trigger');
  $(fileTrigger).trigger('click');
});

// Add url button
var newUrl = '<div class="form-row new-field"><div class="col-11"><div class="form-group"><input type="url" class="form-control" value="http://"></div></div><div class="col-1"><button type="button" class="close"><span>&times;</span></button></div></div>';
$('.add-url-button').click(function() {
  $(this).before(newUrl);
});

// Close/remove button for new fields
$(document).on('click', '.new-field .close', function(){
  $(this).parents().remove('.new-field');
});
