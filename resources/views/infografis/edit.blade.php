@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white py-3 px-4">
                        <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">Edit Infografis {{ $subTopic->title }} (Khusus Visual)</h2>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        @if(session('success'))
                            <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger mb-4 rounded" style="font-family: 'Poppins', sans-serif;">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('infografis.update', $infografis->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="file_upload" class="form-label fw-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Upload Infografis (Khusus Visual)</label>
                                    <small class="text-muted d-block mb-2" style="font-family: 'Poppins', sans-serif;">Unggah file baru untuk menggantikan file lama.</small>

                                    <!-- Tampilkan file yang sudah ada -->
                                    @if($infografis->file_path)
                                        <div class="mb-2">
                                            <small class="text-muted">File saat ini: {{ basename(str_replace('storage/', '', $infografis->getRawOriginal('file_path'))) }}</small>
                                            <a href="{{ Storage::url('infografis/' . basename($infografis->file_path)) }}" target="_blank" class="text-primary ms-2">Lihat file</a>
                                        </div>
                                    @endif

                                    <!-- Area upload file -->
                                    <input type="file" class="form-control" id="file_upload" name="file_upload" accept="video/mp4,image/jpeg,image/png,image/jpg">
                                    <div class="invalid-feedback">File tidak valid.</div>
                                    <small class="form-text text-muted">Format: MP4, JPG, PNG, JPEG. Maks. 5MB</small>
                                    <div id="file-preview-container" class="mt-2"></div>
                                    @error('file_upload')
                                    <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                    <div id="dimension-container">
                                        @php
                                            $selectedDimension = $dimensions->firstWhere('id', 3);
                                        @endphp
                                        @if($selectedDimension)
                                            <input type="hidden" name="dimension" value="{{ $selectedDimension->id }}">
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
                                                                   {{ $infografis->options->pluck('id')->contains($option->id) ? 'checked' : (old('dimension_options.0') == $option->id ? 'checked' : '') }}
                                                                   required>
                                                            <label class="form-check-label" for="option-{{ $option->id }}" style="font-family: 'Poppins', sans-serif; color: #3F4254;">
                                                                {{ $option->nama_opsi_dimensi }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('dimension_options')
                                                <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Pilih satu opsi dimensi.</div>
                                            </div>
                                        @else
                                            <p style="font-family: 'Poppins', sans-serif; color: #3F4254;">Dimensi dengan ID: 3 tidak ditemukan.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary px-4 py-2 fw-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Update Infografis</button>
                                        <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}" class="btn btn-secondary px-4 py-2 fw-medium ms-auto" style="font-family: 'Poppins', sans-serif;">Batal</a>
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

            // File preview
            const fileInput = document.getElementById('file_upload');
            const previewContainer = document.getElementById('file-preview-container');
            if (!fileInput || !previewContainer) {
                console.error('Elemen file_upload atau file-preview-container tidak ditemukan!');
            } else {
                fileInput.addEventListener('change', function () {
                    previewContainer.innerHTML = '';
                    const maxFileSize = 5 * 1024 * 1024; // 5MB
                    const allowedTypes = ['video/mp4', 'image/jpeg', 'image/png', 'image/jpg'];

                    if (fileInput.files && fileInput.files.length > 0) {
                        const file = fileInput.files[0]; // Hanya ambil file pertama
                        if (!allowedTypes.includes(file.type) || file.size > maxFileSize) {
                            alert(`File ${file.name} tidak valid. Pastikan format adalah MP4, JPG, PNG, atau JPEG dan ukuran kurang dari 5MB.`);
                            fileInput.value = '';
                            return;
                        }
                        const fileElement = document.createElement('div');
                        fileElement.className = 'd-flex align-items-center justify-content-between bg-light rounded p-2 mb-1';
                        fileElement.innerHTML = `
                            <div>
                                <small class="text-muted">${file.name} (${(file.size / 1024).toFixed(2)} KB)</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeFile()">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        previewContainer.appendChild(fileElement);
                    }
                });
            }

            window.removeFile = function () {
                if (!fileInput) {
                    console.error('fileInput tidak ditemukan saat removeFile!');
                    return;
                }
                fileInput.value = '';
                fileInput.dispatchEvent(new Event('change'));
            };
        });
    </script>
@endsection
