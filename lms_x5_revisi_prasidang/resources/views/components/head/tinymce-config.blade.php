<script src="https://cdn.tiny.cloud/1/6o3izkti4a37f76xo6gc1hvt5hqgc6jjx432r4k7at1h3r2l/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
   tinymce.init({
    selector: '#konten', // Target spesifik textarea dengan ID konten
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    setup: function (editor) {
      editor.on('init', function () {
        console.log('TinyMCE berhasil diinisialisasi untuk #konten');
      });
      editor.on('error', function (e) {
        console.error('TinyMCE error:', e);
      });
    }
  });
</script>


