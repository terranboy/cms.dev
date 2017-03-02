function setImageValue(url){
  $('.mce-btn.mce-open').parent().find('.mce-textbox').val(url);
}

$(document).ready(function(){

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  tinymce.init({
    menubar: false,
    selector:'textarea.richTextBox',
    skin: 'voyager',
    plugins: 'link, image, code, youtube, giphy, table, responsivefilemanager',
    extended_valid_elements : 'input[onclick|value|style|type]',
    toolbar: 'responsivefilemanager styleselect bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code',

     external_filemanager_path:"/filemanager/",
     filemanager_title:"File manager" ,
     external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},

    convert_urls: false,
    image_caption: true,
    image_title: true
  });

});
