@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <div class="container mt-4">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">Edit Folder untuk {{ $subTopic->title }}</h2>
                </div>
                <div class="card-body p-4">
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

                    <form action="{{ route('folders.update', $folder->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                        <div class="row gap-4">
                            <div class="col-12">
                                <label for="name" class="form-label fw-medium text-dark" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Nama Folder <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control rounded border-light-subtle @error('name') is-invalid @enderror" value="{{ old('name', $folder->name) }}" required aria-describedby="name-error">
                                <div id="name-error" class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Nama folder wajib diisi.</div>
                                @error('name')
                                <div class="text-danger small mt-1" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-medium text-dark" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" class="form-control rounded border-light-subtle @error('description') is-invalid @enderror">{{ old('description', $folder->description) }}</textarea>
                                <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Deskripsi wajib diisi.</div>
                                @error('description')
                                <div class="text-danger small mt-1" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="file_upload" class="form-label fw-medium text-dark" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Unggah File ke Folder (Opsional)</label>
                                <div id="upload-area" class="file-upload-area p-4 rounded border border-2 border-dashed border-light-subtle text-center transition-all"
                                     role="button" onclick="document.getElementById('file_upload').click()">
                                    <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 2rem; color: #3699FF;"></i>
                                    <h5 class="mb-1" style="font-family: 'Poppins', sans-serif;">Klik atau tarik file ke sini</h5>
                                    <p class="mb-0 text-muted small" style="font-family: 'Poppins', sans-serif;">Format: PDF, DOC(X), PPT(X), JPG, PNG. Maks. 5MB</p>
                                    <input type="file" name="files[]" id="file_upload" class="d-none" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png" onchange="previewFile(this)" multiple>
                                </div>
                                <div id="file-preview-container" class="mt-3">
                                    @if($folder->files_save && $folder->files_save->isNotEmpty())
                                        @foreach($folder->files_save as $file)
                                            <div class="d-flex align-items-center justify-content-between bg-light rounded p-3 mb-2 file-preview" data-file-id="{{ $file->id }}">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file-alt me-3" style="font-size: 1.5rem; color: #3699FF;"></i>
                                                    <div>
                                                        <div class="fw-medium" style="font-family: 'Poppins', sans-serif;">{{ $file->name }}</div>
                                                        <small class="text-muted" style="font-family: 'Poppins', sans-serif;">{{ number_format($file->size / 1024, 2) }} KB</small>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-link text-danger remove-existing-file" data-file-id="{{ $file->id }}">
                                                    <i class="fas fa-times"></i> Hapus
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted" style="font-family: 'Poppins', sans-serif;">Tidak ada file yang terkait dengan folder ini.</p>
                                    @endif
                                </div>
                                @error('files.*')
                                <div class="text-danger small mt-1" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Learning Style (Dimensions 2 or 3) -->
                            @php
                                $selectedDimensions = $dimensions->whereIn('id', [2, 3]);
                                $selectedOptionId = $folder->options->pluck('id')->first();
                                $selectedDimensionId = $folder->options->first() ? $folder->options->first()->pivot->dimensi_opsi_id : null;
                            @endphp
                            <div class="col-12">
                                <label class="form-label fw-medium text-dark" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                <div id="dimension-container" class="mb-3">
                                    @if($selectedDimensions->isNotEmpty())
                                        @foreach($selectedDimensions as $dimension)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input dimension-radio" type="radio"
                                                       name="dimension[]"
                                                       value="{{ $dimension->id }}"
                                                       id="dimension-{{ $dimension->id }}"
                                                       data-options='@json($dimension->options)'
                                                       {{ old('dimension.0', $selectedDimensionId) == $dimension->id ? 'checked' : '' }}
                                                       required>
                                                <label class="form-check-label" for="dimension-{{ $dimension->id }}" style="font-family: 'Poppins', sans-serif;">
                                                    {{ $dimension->dimension }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted" style="font-family: 'Poppins', sans-serif;">Tidak ada dimensi tersedia</p>
                                    @endif
                                </div>
                                <div class="invalid-feedback d-block" id="dimension-error" style="font-family: 'Poppins', sans-serif;">
                                    Pilih satu dimensi.
                                </div>
                                @error('dimension')
                                <div class="text-danger small mt-1" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12" id="options-container" style="{{ $selectedDimensionId ? 'display: block;' : 'display: none;' }}">
                                <label class="form-label fw-medium text-dark" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Opsi Dimensi</label>
                                <div id="options-list" class="mb-3"></div>
                                <div class="invalid-feedback d-block" id="options-error" style="font-family: 'Poppins', sans-serif;">
                                    Pilih satu opsi dimensi.
                                </div>
                                @error('dimension_options.*')
                                <div class="text-danger small mt-1" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary px-4 py-2 fw-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Update Folder</button>
                                    <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}" class="btn btn-outline-secondary px-4 py-2" style="font-family: 'Poppins', sans-serif;">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Form validation
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity() || !validateFiles()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Maintain a list of selected files
        let selectedFiles = [];
        let filesToDelete = [];

        // File validation rules
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'image/jpeg',
            'image/png'
        ];
        const maxSize = 5 * 1024 * 1024; // 5MB

        // Validate all selected files
        function validateFiles() {
            let isValid = true;
            selectedFiles.forEach(file => {
                if (!allowedTypes.includes(file.type) || file.size > maxSize) {
                    isValid = false;
                }
            });
            if (!isValid) {
                const previewContainer = document.getElementById('file-preview-container');
                previewContainer.insertAdjacentHTML('beforeend', '<div class="text-danger small mt-1" style="font-family: \'Poppins\', sans-serif; font-size: 0.875rem;">Terdapat file dengan format atau ukuran tidak valid.</div>');
            }
            return isValid;
        }

        // Generate a unique identifier for a file
        function getFileId(file) {
            return `${file.name}-${file.size}-${file.lastModified}`;
        }

        // File preview with validation and sequential display
        function previewFile(input) {
            const previewContainer = document.getElementById('file-preview-container');
            // Do not clear existing previews to preserve existing files
            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    const fileId = getFileId(file);
                    if (!selectedFiles.some(f => getFileId(f) === fileId)) {
                        selectedFiles.push(file);
                    }
                });
            }

            selectedFiles.forEach((file) => {
                let error = '';
                if (!allowedTypes.includes(file.type)) {
                    error = 'Format file tidak didukung. Gunakan PDF, DOC(X), PPT(X), JPG, atau PNG.';
                } else if (file.size > maxSize) {
                    error = 'Ukuran file terlalu besar. Maksimum 5MB.';
                }

                const fileElement = document.createElement('div');
                fileElement.className = 'd-flex align-items-center justify-content-between bg-light rounded p-3 mb-2 file-preview';
                fileElement.setAttribute('data-file-id', getFileId(file));

                fileElement.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt me-3" style="font-size: 1.5rem; color: #3699FF;"></i>
                        <div>
                            <div class="fw-medium" style="font-family: 'Poppins', sans-serif;">${file.name}</div>
                            <small class="text-muted" style="font-family: 'Poppins', sans-serif;">${(file.size / 1024).toFixed(2)} KB</small>
                            ${error ? `<div class="text-danger small mt-1" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">${error}</div>` : ''}
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger remove-file" data-file-id="${getFileId(file)}">
                        <i class="fas fa-times"></i> Hapus
                    </button>
                `;

                previewContainer.appendChild(fileElement);
            });

            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-file').forEach(button => {
                button.addEventListener('click', () => removeFile(button.dataset.fileId));
            });

            updateFileInput();
        }

        // Update the file input with the current selectedFiles
        function updateFileInput() {
            const input = document.getElementById('file_upload');
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;

            // Update hidden input for files to delete
            const form = document.querySelector('form');
            let deleteInput = form.querySelector('input[name="files_to_delete"]');
            if (!deleteInput) {
                deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'files_to_delete';
                form.appendChild(deleteInput);
            }
            deleteInput.value = JSON.stringify(filesToDelete);
        }

        // Remove file from selectedFiles and refresh preview
        function removeFile(fileId) {
            const fileElement = document.querySelector(`.file-preview[data-file-id="${fileId}"]`);
            if (fileElement) {
                fileElement.style.transition = 'opacity 0.3s';
                fileElement.style.opacity = '0';
                setTimeout(() => {
                    selectedFiles = selectedFiles.filter(file => getFileId(file) !== fileId);
                    fileElement.remove();
                    updateFileInput();
                }, 300);
            }
        }

        // Remove existing file and mark for deletion
        document.querySelectorAll('.remove-existing-file').forEach(button => {
            button.addEventListener('click', () => {
                const fileId = button.dataset.fileId;
                const fileElement = document.querySelector(`.file-preview[data-file-id="${fileId}"]`);
                if (fileElement) {
                    fileElement.style.transition = 'opacity 0.3s';
                    fileElement.style.opacity = '0';
                    setTimeout(() => {
                        filesToDelete.push(fileId);
                        fileElement.remove();
                        updateFileInput();
                    }, 300);
                }
            });
        });

        // Drag and drop functionality
        const uploadArea = document.getElementById('upload-area');

        ['dragenter', 'dragover'].forEach(event => {
            uploadArea.addEventListener(event, e => {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.style.borderColor = '#3699FF';
                uploadArea.style.backgroundColor = 'rgba(54, 153, 255, 0.05)';
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            uploadArea.addEventListener(event, e => {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.style.borderColor = '#E4E6EF';
                uploadArea.style.backgroundColor = '';
            });
        });

        uploadArea.addEventListener('drop', e => {
            const input = document.getElementById('file_upload');
            input.files = e.dataTransfer.files;
            previewFile(input);
        });

        // Dimension and options handling
        document.addEventListener('DOMContentLoaded', function () {
            const dimensionRadios = document.querySelectorAll('.dimension-radio');
            const optionsContainer = document.getElementById('options-container');
            const optionsList = document.getElementById('options-list');
            const dimensionError = document.getElementById('dimension-error');
            const optionsError = document.getElementById('options-error');
            const selectedOptionId = '{{ $selectedOptionId }}';

            if (dimensionRadios.length === 0 || !optionsContainer || !optionsList) {
                console.error('Elemen dimensi atau opsi tidak ditemukan!');
            } else {
                dimensionRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        optionsList.innerHTML = '';
                        if (this.checked) {
                            const options = JSON.parse(this.getAttribute('data-options'));
                            options.forEach(opt => {
                                const div = document.createElement('div');
                                div.className = 'form-check mb-2';
                                div.innerHTML = `
                                    <input class="form-check-input option-radio" type="radio"
                                           name="dimension_options[]"
                                           value="${opt.id}"
                                           id="option-${opt.id}"
                                           ${opt.id == selectedOptionId || opt.id == '{{ old("dimension_options.0") }}' ? 'checked' : ''}
                                           required>
                                    <label class="form-check-label" for="option-${opt.id}" style="font-family: 'Poppins', sans-serif;">
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

                    // Trigger change event for pre-selected dimension
                    if (radio.checked) {
                        radio.dispatchEvent(new Event('change'));
                    }
                });

                // Form Validation for Learning Style
                const form = document.querySelector('form.needs-validation');
                form.addEventListener('submit', function (event) {
                    let isValid = true;
                    const checkedDimension = document.querySelector('.dimension-radio:checked');
                    const checkedOption = document.querySelector('.option-radio:checked');

                    if (!checkedDimension) {
                        dimensionError.style.display = 'block';
                        isValid = false;
                    } else {
                        dimensionError.style.display = 'none';
                    }

                    if (checkedDimension && !checkedOption) {
                        optionsError.style.display = 'block';
                        isValid = false;
                    } else {
                        optionsError.style.display = 'none';
                    }

                    if (!form.checkValidity() || !isValid) {
                        event.preventDefault();
                        event.stopPropagation();
                        console.log('Validasi gagal: Form tidak valid, dimensi atau opsi belum dipilih.');
                    } else {
                        console.log('Form valid, siap dikirim.');
                    }
                    form.classList.add('was-validated');
                }, false);
            }
        });
    </script>

    <!-- Custom CSS -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3699FF 0%, #1e88e5 100%);
        }
        .file-upload-area {
            transition: all 0.3s ease;
        }
        .file-upload-area:hover {
            border-color: #3699FF !important;
            background-color: rgba(54, 153, 255, 0.05) !important;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        .form-check-input:checked {
            background-color: #3699FF;
            border-color: #3699FF;
        }
        .form-label {
            font-family: 'Poppins', sans-serif;
            color: #3F4254;
        }
        .btn-primary {
            background-color: #3699FF;
            border-color: #3699FF;
            font-family: 'Poppins', sans-serif;
        }
        .btn-primary:hover {
            background-color: #1e88e5;
            border-color: #1e88e5;
        }
        .text-dark {
            color: #3F4254 !important;
        }
        .small {
            font-size: 0.875rem;
        }
    </style>
@endsection
