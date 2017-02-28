<script>
// JavaScript for admin enabled pages

/*$(document).ready(function() {
  alert('admin js page ready');
});*/

var editor;

function makePageEditable(item) {
  if ($(".editablecontent").length == 0) {
    alert ('No editable content on page!');
    return;
  }
  $(".admin-hidden").addClass('admin-display').removeClass('admin-hidden');
  $(item).attr("onclick","turnOffEditing(this)");
  $(item).html("Turn off editing");
  $(".editablecontent").attr("contenteditable","true");
  $(".editablecontent").addClass("outlined");
  $("#old").val($("#editablecontent").html());

  var editoroptions = {
    allowedContent: true,
    floatSpaceDockedOffsetX: 150
  }

  var elements = document.getElementsByClassName( 'editablecontent' );
  for ( var i = 0; i < elements.length; ++i ) {
    CKEDITOR.inline( elements[ i ], editoroptions );
  }

  CKEDITOR.on( 'instanceLoaded', function(event) {
    editor = event.editor;
  });
}

function turnOffEditing(item) {
  for (name in CKEDITOR.instances) {
    CKEDITOR.instances[name].destroy()
  }
  $(".admin-display").addClass('admin-hidden').removeClass('admin-display');
  $(".menu-item").attr("onclick","makePageEditable(this)");
  $(".menu-item").html("Edit content");
  $(".editablecontent").attr("contenteditable","false");
  $(".editablecontent").removeClass("outlined");
  if ($('#old').val() != ''){
    $(".editablecontent").html($("#old").val());
  }
}

function saveEditedPage() {
  // NOTE: form data saved via ajax form lib: jquery.form
  // get the data from ckeditor
  var pagedata = editor.getData();
  // save this data in form. Upon POST, available via $_REQUEST['thedata']
  $("#thedata").val(pagedata);
  // After ajax submit and getting a response from the server, execute showResponse().
  var options = { success: processResponse };
  // unbind the browser submit, and then submit the form via jquery.form ajax.
  $("#editpage").unbind('submit').ajaxSubmit(options);
  // always return false to prevent standard browser submit and page navigation
  return false;
}

function processResponse(responseText, statusText, xhr, $form) {
  if (responseText == 'OK') {
    $("#old").val('');
    turnOffEditing();
  } else {
    alert(responseText);
  }
}

</script>
