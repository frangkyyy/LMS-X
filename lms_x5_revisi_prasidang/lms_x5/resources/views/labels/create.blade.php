@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                            <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Tambah Label {{ $subTopic->title }}</h2>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('labels.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="konten" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Teks Label</label>
                                        <textarea name="konten" id="konten" rows="4" class="form-control rounded" style="border-color: #E4E6EF;" required></textarea>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Teks Label wajib diisi.</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="learning_style_id" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                        <select name="learning_style_id" id="learning_style_id" class="form-control rounded" style="border-color: #E4E6EF;" required>
                                            <option value="">-- Pilih Learning Style --</option>
                                            @foreach($learningStyles as $style)
                                                <option value="{{ $style->id }}">{{ $style->nama_opsi_dimensi }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Learning Style wajib dipilih.</div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Buat Label</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE tidak dimuat!');
            } else {
                console.log('TinyMCE terdeteksi, inisialisasi dimulai...');
                tinymce.init({
                    selector: '#konten',
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
            }
        });

        // Form validation
        (function () {
            'use strict';
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
        })();
    </script>
@endsection
