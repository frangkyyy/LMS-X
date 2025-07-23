@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Lesson</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
        </div>

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


        <button type="submit" class="btn btn-primary">Buat Lesson</button>
    </form>
</div>

<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until May 12, 2025:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>

@endsection
