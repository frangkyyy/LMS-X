@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Edit Page</h4>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                <input type="hidden" name="topik" value="{{ request('topik') }}">

                <div class="mb-3">
                    <label for="name" class="form-label">Judul Page</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $page->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-control">{{ old('description', $page->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea name="content" id="content" class="form-control tinymce-editor">
                        {{ old('content', $page->content) }}
                    </textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select name="course_id" id="course_id" class="form-control" disabled>
                            <option value="{{ $course->id }}">{{ $course->full_name }}</option>
                        </select>
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="learning_style" class="form-label">Gaya Belajar</label>
                        <select name="learning_style" id="learning_style" class="form-control" required>
                            @foreach($learningStyles as $style)
                                <option value="{{ $style }}" {{ $page->learning_style == $style ? 'selected' : '' }}>
                                    {{ ucfirst($style) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="topik" class="form-label">Topik</label>
                        <select name="topik" id="topik" class="form-control" required>
                            @foreach($topik as $t)
                                <option value="{{ $t }}" {{ $page->topik == $t ? 'selected' : '' }}>
                                    {{ ucfirst($t) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Tipe Konten</label>
                    <select name="type" id="type" class="form-control" required>
                        @foreach($type as $t)
                            <option value="{{ $t }}" {{ $page->type == $t ? 'selected' : '' }}>
                                {{ ucfirst($t) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Page</button>
            </form>
        </div>
    </div>
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

<style>
    .tox-tinymce {
        border-radius: 4px;
        border: 1px solid #ddd !important;
    }
    
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }
    
    .form-control {
        border-radius: 4px;
    }
    
    .btn {
        border-radius: 4px;
    }
</style>
@endsection