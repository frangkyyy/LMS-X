@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                            <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Tambah Folder untuk {{ $subTopic->title }}</h2>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('folders.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf


                                <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="name" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Nama Folder</label>
                                        <input type="text" name="name" id="name" class="form-control rounded" style="border-color: #E4E6EF;" value="{{ old('name') }}" required>
                                        @error('name')
                                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Nama folder wajib diisi.</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Deskripsi</label>
                                        <textarea name="description" id="description" rows="4" class="form-control rounded" style="border-color: #E4E6EF;">{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="file_upload" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Unggah File ke Folder (Opsional)</label>
                                        <div id="upload-area" class="file-upload-area p-4 rounded border text-center"
                                             style="border-color: #E4E6EF; border-style: dashed; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer;"
                                             onclick="document.getElementById('file_upload').click()">
                                            <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 2rem; color: #3699FF;"></i>
                                            <h5 class="mb-1" style="font-family: 'Poppins', sans-serif;">Klik atau tarik file ke sini</h5>
                                            <p class="mb-0 text-muted" style="font-family: 'Poppins', sans-serif;">Format: PDF, DOC(X), PPT(X), JPG, PNG. Maks. 5MB</p>
                                            <input type="file" name="files[]" id="file_upload" class="d-none" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png" onchange="previewFile(this)" multiple>
                                        </div>
                                        <div id="file-preview-container" class="mt-3"></div>
                                        @error('files.*')
                                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="learning_style_id" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Gaya Belajar</label>
                                        <select name="learning_style_id" id="learning_style_id" class="form-control rounded" style="border-color: #E4E6EF;" required>
                                            <option value="" disabled selected>Pilih Gaya Belajar</option>
                                            @foreach($learningStyles as $style)
                                                <option value="{{ $style->id }}" {{ old('learning_style_id') == $style->id ? 'selected' : '' }}>{{ $style->nama_opsi_dimensi }}</option>
                                            @endforeach
                                        </select>
                                        @error('learning_style_id')
                                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Gaya belajar wajib dipilih.</div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Buat Folder</button>
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
                previewContainer.insertAdjacentHTML('beforeend', '<div class="text-danger" style="font-family: \'Poppins\', sans-serif; font-size: 0.875rem;">Terdapat file dengan format atau ukuran tidak valid.</div>');
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
            previewContainer.innerHTML = ''; // Clear existing previews

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
                        <i class="fas fa-file-alt mr-3" style="font-size: 1.5rem; color: #3699FF;"></i>
                        <div>
                            <div style="font-family: 'Poppins', sans-serif; font-weight: 500;">${file.name}</div>
                            <small class="text-muted" style="font-family: 'Poppins', sans-serif;">${(file.size / 1024).toFixed(2)} KB</small>
                            ${error ? `<div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">${error}</div>` : ''}
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
        }

        // Remove file from selectedFiles and refresh preview
        function removeFile(fileId) {
            const fileElement = document.querySelector(`.file-preview[data-file-id="${fileId}"]`);
            if (fileElement) {
                fileElement.style.transition = 'opacity 0.3s';
                fileElement.style.opacity = '0';
                setTimeout(() => {
                    // Remove file from selectedFiles based on fileId
                    selectedFiles = selectedFiles.filter(file => getFileId(file) !== fileId);
                    // Remove the element from the DOM
                    fileElement.remove();
                    // Update file input to reflect changes
                    updateFileInput();
                }, 300);
            }
        }

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
    </script>
@endsection
