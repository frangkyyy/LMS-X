@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                            <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Tambah Forum {{ $subTopic->title }}</h2>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('forums.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                                <div class="row g-4">
                                    <!-- Nama Forum -->
                                    <div class="col-12 col-md-6">
                                        <label for="name" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Nama Forum</label>
                                        <input type="text" name="name" id="name" class="form-control rounded" style="border-color: #E4E6EF;" required>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Nama Forum wajib diisi.</div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="col-12">
                                        <label for="description" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Deskripsi</label>
                                        <textarea name="description" id="description" rows="4" class="form-control rounded" style="border-color: #E4E6EF;"></textarea>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Deskripsi wajib diisi.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Learning Style</label>
                                        <div id="dimension-container">
                                            @forelse($dimensions as $dimension)
                                                <div class="form-check">
                                                    <input class="form-check-input dimension-checkbox" type="checkbox"
                                                           name="dimension[]"
                                                           value="{{ $dimension->id }}"
                                                           id="dimension-{{ $dimension->id }}"
                                                           data-options='@json($dimension->options)'>
                                                    <label class="form-check-label" for="dimension-{{ $dimension->id }}">
                                                        {{ $dimension->dimension }}
                                                    </label>
                                                </div>
                                            @empty
                                                <p>No dimensions available</p>
                                            @endforelse
                                        </div>
                                        <div class="invalid-feedback d-block" id="dimension-error" style="display: none;">
                                            Pilih setidaknya satu dimensi.
                                        </div>
                                    </div>

                                    <div class="mb-3" id="options-container" style="display: none;">
                                        <label class="form-label">Dimension Options</label>
                                        <div id="options-list"></div>
                                        <div class="invalid-feedback d-block" id="options-error" style="display: none;">
                                            Pilih setidaknya satu opsi dimensi.
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Buat Forum</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dimensionCheckboxes = document.querySelectorAll('.dimension-checkbox');
            const optionsContainer = document.getElementById('options-container');
            const optionsList = document.getElementById('options-list');

            dimensionCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const checkedCheckboxes = document.querySelectorAll('.dimension-checkbox:checked');
                    optionsList.innerHTML = '';

                    if (checkedCheckboxes.length > 0) {
                        let allOptions = [];
                        checkedCheckboxes.forEach(cb => {
                            const options = JSON.parse(cb.getAttribute('data-options'));
                            allOptions = [...allOptions, ...options];
                        });

                        // Hilangkan duplikat opsi berdasarkan ID
                        const uniqueOptions = Array.from(new Map(allOptions.map(opt => [opt.id, opt])).values());

                        // Urutkan opsi berdasarkan id, nama_opsi_dimensi, mdl_learning_styles_id, description
                        uniqueOptions.sort((a, b) => {
                            // Urutkan berdasarkan id (ascending)
                            if (a.id !== b.id) {
                                return a.id - b.id;
                            }
                            // Urutkan berdasarkan nama_opsi_dimensi (ascending)
                            if (a.nama_opsi_dimensi !== b.nama_opsi_dimensi) {
                                return a.nama_opsi_dimensi.localeCompare(b.nama_opsi_dimensi);
                            }
                            // Urutkan berdasarkan mdl_learning_styles_id (ascending)
                            if (a.mdl_learning_styles_id !== b.mdl_learning_styles_id) {
                                return a.mdl_learning_styles_id - b.mdl_learning_styles_id;
                            }
                            // Urutkan berdasarkan description (ascending, NULL dianggap kecil)
                            if (a.description === null && b.description === null) {
                                return 0;
                            }
                            if (a.description === null) {
                                return -1;
                            }
                            if (b.description === null) {
                                return 1;
                            }
                            return a.description.localeCompare(b.description);
                        });

                        // Tambahkan opsi sebagai checkbox
                        uniqueOptions.forEach(opt => {
                            const div = document.createElement('div');
                            div.className = 'form-check';
                            div.innerHTML = `
                                <input class="form-check-input option-checkbox" type="checkbox"
                                       name="dimension_options[]"
                                       value="${opt.id}"
                                       id="option-${opt.id}">
                                <label class="form-check-label" for="option-${opt.id}">
                                    ${opt.nama_opsi_dimensi}
                                </label>
                            `;
                            optionsList.appendChild(div);
                        });

                        optionsContainer.style.display = 'block';
                    } else {
                        optionsContainer.style.display = 'none';
                    }
                });
            });

            // Validasi formulir
            document.querySelector('form.needs-validation').addEventListener('submit', function (event) {
                const checkedDimensions = document.querySelectorAll('.dimension-checkbox:checked');
                const checkedOptions = document.querySelectorAll('.option-checkbox:checked');
                const dimensionError = document.getElementById('dimension-error');
                const optionsError = document.getElementById('options-error');

                let isValid = true;

                if (checkedDimensions.length === 0) {
                    dimensionError.style.display = 'block';
                    isValid = false;
                } else {
                    dimensionError.style.display = 'none';
                }

                if (checkedDimensions.length > 0 && checkedOptions.length === 0) {
                    optionsError.style.display = 'block';
                    isValid = false;
                } else {
                    optionsError.style.display = 'none';
                }

                if (!isValid) {
                    -                    event.preventDefault();
                    event.stopPropagation();
                }

                this.classList.add('was-validated');
            });
        });
    </script>
@endsection
