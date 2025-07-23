@extends('layouts.v_template')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Test TinyMCE</h2>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="konten" class="form-label">Konten</label>
                    <textarea id="konten" name="konten" rows="4" class="form-control"></textarea>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/yfqawquyfm7j3if4r87pex17imhoo6xmc04b5yg0j9pafsk0/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#konten',
        plugins: 'lists link image',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image',
        menubar: false,
        height: 300,
        setup: function(editor) {
            editor.on('init', function() {
                console.log('TinyMCE berhasil diinisialisasi untuk #konten');
            });
            editor.on('error', function(e) {
                console.error('TinyMCE error:', e);
            });
        }
    });
</script>
@endsection
