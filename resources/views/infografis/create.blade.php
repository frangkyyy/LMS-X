@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white py-3 px-4">
                        <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">Tambah Infografis {{ $subTopic->title }} (Khusus Visual)</h2>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        @if(session('success'))
                            <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4 rounded" style="font-family: 'Poppins', sans-serif;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('infografis.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="file_upload" class="form-label fw-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Upload Gambar/Video Infografis (Khusus Visual)</label>
                                    <div id="upload-area" class="file-upload-area p-4 rounded border text-center"
                                         style="border-color: #E4E6EF; border-style: dashed; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer;"
                                         onclick="document.getElementById('file_upload').click()">
                                        <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 2rem; color: #3699FF;"></i>
                                        <h5 class="mb-1" style="font-family: 'Poppins', sans-serif;">Klik atau tarik file ke sini</h5>
                                        <p class="mb-0 text-muted" style="font-family: 'Poppins', sans-serif;">Format: mp4, JPG, PNG, JPEG</p>
                                        <input type="file" name="file_upload[]" id="file_upload" class="d-none" onchange="previewFile(this)" multiple accept="video/mp4,image/jpeg,image/png">
                                    </div>
                                    <div id="file-preview-container" class="mt-3"></div>
                                    @error('file_upload')
                                    <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                    <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">File infografis wajib diunggah.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                    <div id="dimension-container">
                                        @php
                                            $selectedDimension = $dimensions->firstWhere('id', 3);
                                        @endphp
                                        @if($selectedDimension)
                                            <input type="hidden" name="dimension[]" value="{{ $selectedDimension->id }}">
                                            <div class="mb-2">
                                                <span class="fw-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">{{ $selectedDimension->dimension }}</span>
                                            </div>
                                            <div id="options-container">
                                                <label class="form-label fw-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Pilih Opsi Dimensi</label>
                                                <div id="options-list">
                                                    @foreach($selectedDimension->options as $option)
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input option-radio" type="radio"
                                                                   name="dimension_options[]"
                                                                   value="{{ $option->id }}"
                                                                   id="option-{{ $option->id }}"
                                                                   {{ old('dimension_options.0') == $option->id ? 'checked' : '' }}
                                                                   required>
                                                            <label class="form-check-label" for="option-{{ $option->id }}" style="font-family: 'Poppins', sans-serif; color: #3F4254;">
                                                                {{ $option->nama_opsi_dimensi }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="invalid-feedback d-block" id="options-error" style="display: none; font-family: 'Poppins', sans-serif;">
                                                    Pilih satu opsi dimensi.
                                                </div>
                                            </div>
                                        @else
                                            <p style="font-family: 'Poppins', sans-serif; color: #3F4254;">Dimensi dengan ID: 3 tidak ditemukan.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary px-4 py-2 fw-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Buat Infografis</button>
                                        <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}" class="btn btn-secondary px-4 py-2 fw-medium ms-auto" style="font-family: 'Poppins', sans-serif;">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            (function () {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        const checkedOption = document.querySelector('.option-radio:checked');
                        const optionsError = document.getElementById('options-error');

                        if (!form.checkValidity() || !checkedOption) {
                            event.preventDefault();
                            event.stopPropagation();
                            if (!checkedOption) {
                                optionsError.style.display = 'block';
                            } else {
                                optionsError.style.display = 'none';
                            }
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();

            // File preview and drag-and-drop functionality
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
                                <i class="fas fa-file-alt me-3" style="font-size: 1.5rem; color: #3699FF;"></i>
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

                for (let i = 0; i < input.files.length; i++) {
                    if (i !== index) {
                        newFiles.items.add(input.files[i]);
                    }
                }

                input.files = newFiles.files;
                previewFile(input);
            }

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
        });
    </script>
@endsection
