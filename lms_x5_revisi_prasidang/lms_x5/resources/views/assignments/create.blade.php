@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Assignment Baru</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Course -->
        <div class="mb-3">
          <label for="course_id" class="form-label">Pilih Course</label>
          <select name="course_id" id="course_id" class="form-control" required>
              @foreach(\App\Models\MDLCourse::all() as $course)
                  <option value="{{ $course->id }}">{{ $course->full_name }}</option>
              @endforeach
          </select>
        </div>

        <!-- Learning Style -->
        <div class="mb-3">
          <label for="learning_style" class="form-label">Learning Style</label>
          <select name="learning_style" id="learning_style" class="form-control" required>
              <option value="">-- Pilih Learning Style --</option>
              @foreach($learningStyles as $style)
                  <option value="{{ $style }}">{{ ucfirst($style) }}</option>
              @endforeach
          </select>
        </div>

        <!-- Topik -->
        <div class="mb-3">
          <label for="topik" class="form-label">Topik</label>
          <select name="topik" id="topik" class="form-control" required>
              <option value="">-- Pilih Topik --</option>
              @foreach($topik as $topik)
                  <option value="{{ $topik }}">{{ ucfirst($topik) }}</option>
              @endforeach
          </select>
        </div>


        <!-- Nama Assignment -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Assignment</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
        </div>

        <!-- Tanggal Due -->
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="datetime-local" name="due_date" id="due_date" class="form-control" required>
        </div>

        <!-- File Assignment -->
        <div class="mb-3">
            <label for="file" class="form-label">Upload File (Drag and Drop or Select)</label>
            <div id="dropzone" class="dropzone">
                <div class="dz-message">Seret dan jatuhkan file di sini atau pilih file untuk mengunggah.</div>
                <input type="file" name="file" id="file" class="form-control" hidden>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Buat Assignment</button>
    </form>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.css">
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.js"></script>

<script>
    // Initialize Dropzone for drag-and-drop functionality
    Dropzone.options.dropzone = {
      url: '{{ route('assignments.store') }}',  // Ganti dengan URL untuk mengunggah file
      maxFilesize: 2, // Maksimal ukuran file dalam MB
      addRemoveLinks: true,
      dictDefaultMessage: "Seret dan jatuhkan file di sini atau pilih file untuk mengunggah.",
      acceptedFiles: ".pdf,.doc,.docx,.jpg,.png", // Tipe file yang diterima
      paramName: "file",  // Nama parameter untuk file yang akan diunggah
      init: function() {
        this.on("success", function(file, response) {
          console.log("File berhasil diunggah: ", response);
        });
        this.on("error", function(file, response) {
          console.log("Terjadi kesalahan saat mengunggah file: ", response);
        });
      }
    };
</script>

<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'mediaembed', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    // Konfigurasi penting untuk embed video:
    media_live_embeds: true, // Aktifkan embed otomatis
    media_alt_source: false,
    media_poster: false,
    media_filter_html: false, // Nonaktifkan filter HTML untuk media
    allow_unsafe_link_target: true, // Izinkan target link tidak aman (iframe)
    link_default_protocol: 'https', // Default protokol untuk link
    extended_valid_elements: 'iframe[src|width|height|style|scrolling|class|frameborder|allowfullscreen|allow|title|data*]',
    // Gaya untuk iframe:
    content_style: 'iframe {max-width: 100%; height: auto; border: none;}',
    // Opsi lainnya:
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>

@endsection
