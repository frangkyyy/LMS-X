@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Page Baru  {{ $subTopic->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea name="content" id="content" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="learning_style_id" class="form-label">Learning Style</label>
            <select name="learning_style_id" id="learning_style_id" class="form-control rounded" required>
                <option value="">-- Pilih Learning Style --</option>
                @foreach($learningStyles as $style)
                    <option value="{{ $style->id }}">{{ $style->nama_opsi_dimensi }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Buat Page</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce === 'undefined') {
            console.error('TinyMCE tidak dimuat!');
        } else {
            tinymce.init({
                selector: '#content, #description',
                plugins: [
                    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount'
                    // Add premium plugins if licensed
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                setup: function (editor) {
                    editor.on('init', function () {
                        console.log('TinyMCE initialized');
                    });
                    editor.on('error', function (e) {
                        console.error('TinyMCE error:', e);
                    });
                }
            });
        }

        // Form validation
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endsection
