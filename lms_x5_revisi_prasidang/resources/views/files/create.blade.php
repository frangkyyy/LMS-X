@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                            <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Tambah Files {{ $subTopic->title }}</h2>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="name" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Name</label>
                                        <input type="text" name="name" id="name" class="form-control rounded" style="border-color: #E4E6EF;" required></input>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Name wajib diisi.</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control rounded" style="border-color: #E4E6EF;" required></textarea>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Description wajib diisi.</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="file_upload" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Upload File</label>

                                        <div id="upload-area" class="file-upload-area p-4 rounded border text-center"
                                             style="border-color: #E4E6EF; border-style: dashed; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer;"
                                             onclick="document.getElementById('file_upload').click()">
                                            <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 2rem; color: #3699FF;"></i>
                                            <h5 class="mb-1" style="font-family: 'Poppins', sans-serif;">Klik atau tarik file ke sini</h5>
                                            <p class="mb-0 text-muted" style="font-family: 'Poppins', sans-serif;">Format: PDF, DOC(X), PPT(X), JPG, PNG. Maks. 5MB</p>
                                            <input type="file" name="file_upload[]" id="file_upload" class="d-none" onchange="previewFile(this)" multiple>
                                        </div>
                                        <div id="file-preview-container" class="mt-3"></div>
                                        @error('file_upload')
                                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="learning_style_id" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                        <select name="learning_style_id" id="learning_style_id" class="form-control rounded" style="border-color: #E4E6EF;" required>
                                            @foreach($learningStyles as $style)
                                                <option value="{{ $style->id }}">{{ $style->nama_opsi_dimensi }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Learning Style wajib dipilih.</div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Buat Files</button>
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
    <script>
        function previewFile(input) {
            const previewContainer = document.getElementById('file-preview-container');
            previewContainer.innerHTML = '';

            if (input.files.length > 0) {
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const fileElement = document.createElement('div');
                    fileElement.className = 'd-flex align-items-center justify-content-between bg-light rounded p-3 mb-2';

                    fileElement.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt mr-3" style="font-size: 1.5rem; color: #3699FF;"></i>
                        <div>
                            <div style="font-family: 'Poppins', sans-serif; font-weight: 500;">${file.name}</div>
                            <small class="text-muted" style="font-family: 'Poppins', sans-serif;">${(file.size/1024).toFixed(2)} KB</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeFile(this, ${i})">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                    previewContainer.appendChild(fileElement);
                }
            }
        }

        function removeFile(button, index) {
            const input = document.getElementById('file_upload');
            const newFiles = new DataTransfer();

            // Add all files except the one to be removed
            for (let i = 0; i < input.files.length; i++) {
                if (i !== index) {
                    newFiles.items.add(input.files[i]);
                }
            }

            // Update file input
            input.files = newFiles.files;

            // Update preview
            previewFile(input);
        }

        // Add drag and drop functionality
        const uploadArea = document.querySelector('.file-upload-area');

        ['dragenter', 'dragover'].forEach(event => {
            uploadArea.addEventListener(event, (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#3699FF';
                uploadArea.style.backgroundColor = 'rgba(54, 153, 255, 0.05)';
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            uploadArea.addEventListener(event, (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#E4E6EF';
                uploadArea.style.backgroundColor = '';
            });
        });

        uploadArea.addEventListener('drop', (e) => {
            const input = document.getElementById('file_upload');
            input.files = e.dataTransfer.files;
            previewFile(input);
        });
    </script>
@endsection
