@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                            <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Tambah URL {{ $subTopic->title }}</h2>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('url.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                                <div class="row g-4">
                                    <div class="col-12 col-md-6">
                                        <label for="name" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Nama URL</label>
                                        <input type="text" name="name" id="name" class="form-control rounded" style="border-color: #E4E6EF;" required>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Nama URL wajib diisi.</div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="url_link" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Link URL</label>
                                        <input type="url" name="url_link" id="url_link" class="form-control rounded" style="border-color: #E4E6EF;" placeholder="https://example.com" required>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Link URL wajib diisi dan harus valid.</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Deskripsi</label>
                                        <textarea name="description" id="description" rows="4" class="form-control rounded" style="border-color: #E4E6EF;" required></textarea>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Deskripsi wajib diisi.</div>
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
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">
                                            <i class="fas fa-save me-1"></i> Buat URL
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Restriction Options Modal -->
    <div class="modal fade" id="restrictionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: 'Poppins', sans-serif;">Add restriction...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 px-0 py-2 d-flex align-items-center restriction-option" data-type="date">
                            <i class="fas fa-calendar-alt me-3 text-muted"></i>
                            <div>
                                <h6 class="mb-0" style="font-family: 'Poppins', sans-serif;">Date</h6>
                                <p class="mb-0 text-muted small" style="font-family: 'Poppins', sans-serif;">Prevent access until (or from) a specified date and time.</p>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0 py-2 d-flex align-items-center restriction-option" data-type="grade">
                            <i class="fas fa-star me-3 text-muted"></i>
                            <div>
                                <h6 class="mb-0" style="font-family: 'Poppins', sans-serif;">Grade</h6>
                                <p class="mb-0 text-muted small" style="font-family: 'Poppins', sans-serif;">Require students to achieve a specified grade.</p>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0 py-2 d-flex align-items-center restriction-option" data-type="group">
                            <i class="fas fa-users me-3 text-muted"></i>
                            <div>
                                <h6 class="mb-0" style="font-family: 'Poppins', sans-serif;">Group</h6>
                                <p class="mb-0 text-muted small" style="font-family: 'Poppins', sans-serif;">Allow only students who belong to a specified group, or all groups.</p>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0 py-2 d-flex align-items-center restriction-option" data-type="profile">
                            <i class="fas fa-user me-3 text-muted"></i>
                            <div>
                                <h6 class="mb-0" style="font-family: 'Poppins', sans-serif;">User profile</h6>
                                <p class="mb-0 text-muted small" style="font-family: 'Poppins', sans-serif;">Control access based on fields within the student's profile.</p>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0 py-2 d-flex align-items-center restriction-option" data-type="set">
                            <i class="fas fa-layer-group me-3 text-muted"></i>
                            <div>
                                <h6 class="mb-0" style="font-family: 'Poppins', sans-serif;">Restriction set</h6>
                                <p class="mb-0 text-muted small" style="font-family: 'Poppins', sans-serif;">Add a set of nested restrictions to apply complex logic.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE tidak dimuat!');
            } else {
                console.log('TinyMCE terdeteksi, inisialisasi dimulai...');
                tinymce.init({
                    selector: '#description',
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
                            console.log('TinyMCE berhasil diinisialisasi untuk #description');
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
