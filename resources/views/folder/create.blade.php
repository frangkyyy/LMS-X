@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <div class="container mt-4">
        <h2>Tambah Folder untuk {{ $subTopic->title }}</h2>
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if($errors->has('error'))
            <div class="alert alert-danger mb-3">{{ $errors->first('error') }}</div>
        @endif
        <form method="POST" action="{{ route('folders.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

            <!-- General Section -->
            <div class="card mb-3">
                <div class="card-header">Informasi Umum</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Nama Folder <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required aria-describedby="name-error">
                        <div id="name-error" class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Nama folder wajib diisi.</div>
                        @error('name')
                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Deskripsi</label>
                        <textarea class="form-control rounded @error('description') is-invalid @enderror" id="description" name="description" rows="4" style="border-color: #E4E6EF;">{{ old('description') }}</textarea>
                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Deskripsi wajib diisi.</div>
                        @error('description')
                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file_upload" class="form-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Unggah File ke Folder (Opsional)</label>
                        <div id="upload-area" class="file-upload-area p-4 rounded border text-center"
                             style="border-color: #E4E6EF; border-style: dashed; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer;"
                             onclick="document.getElementById('file_upload').click()">
                            <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 2rem; color: #3699FF;"></i>
                            <h5 class="mb-1" style="font-family: 'Poppins', sans-serif;">Klik atau tarik file ke sini</h5>
                            <p class="mb-0 text-muted" style="font-family: 'Poppins', sans-serif;">Format: PDF, DOC(X), PPT(X), JPG, PNG, ZIP, RAR. Maks. 5MB</p>
                            <input type="file" name="files[]" id="file_upload" class="d-none" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar" onchange="previewFile(this)" multiple>
                        </div>
                        <div id="file-preview-container" class="mt-3"></div>
                        <small class="form-text text-muted" style="font-family: 'Poppins', sans-serif;">Format: PDF, DOC(X), PPT(X), JPG, PNG, ZIP, RAR. Maks. 5MB</small>
                        @error('files.*')
                        <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Learning Style (Dimensions 2 or 3) -->
                    @php
                        $selectedDimensions = $dimensions->whereIn('id', [2, 3]);
                    @endphp
                    @if($selectedDimensions->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Dimensi Learning Style <span class="text-danger">*</span></label>
                            <div id="dimension-container" class="@error('dimension') is-invalid @enderror">
                                @foreach($selectedDimensions as $dimension)
                                    <div class="form-check">
                                        <input class="form-check-input dimension-radio" type="radio"
                                               name="dimension"
                                               value="{{ $dimension->id }}"
                                               id="dimension-{{ $dimension->id }}"
                                               data-options='@json($dimension->options)'
                                               {{ old('dimension') == $dimension->id ? 'checked' : '' }}
                                               required
                                               aria-describedby="dimension-error">
                                        <label class="form-check-label" for="dimension-{{ $dimension->id }}" style="font-family: 'Poppins', sans-serif;">
                                            {{ $dimension->dimension }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="invalid-feedback d-block" id="dimension-error" style="display: none; font-family: 'Poppins', sans-serif;">
                                Pilih satu dimensi.
                            </div>
                            @error('dimension')
                            <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="options-container" style="display: none;">
                            <label class="form-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Pilih Opsi <span class="text-danger">*</span></label>
                            <div id="options-list" class="@error('dimension_options.*') is-invalid @enderror"></div>
                            <div class="invalid-feedback d-block" id="options-error" style="display: none; font-family: 'Poppins', sans-serif;">
                                Pilih satu opsi dimensi.
                            </div>
                            @error('dimension_options.*')
                            <div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="alert alert-warning" style="font-family: 'Poppins', sans-serif;">Dimensi dengan ID 2 atau 3 tidak ditemukan.</div>
                    @endif
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="action" value="save_return" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Simpan dan kembali ke kursus</button>
                <button type="submit" class="btn btn-secondary" name="action" value="save_display" style="font-family: 'Poppins', sans-serif;">Simpan dan tampilkan</button>
                <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}"
                   class="btn btn-outline-secondary" style="font-family: 'Poppins', sans-serif;">Batal</a>
            </div>
        </form>
    </div>

    <!-- Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // File Preview and Validation
            const fileInput = document.getElementById('file_upload');
            const previewContainer = document.getElementById('file_upload') ? document.getElementById('file-preview-container') : null;
            const allowedTypes = walkers = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'image/jpeg',
                'image/png',
                'application/zip',
                'application/x-rar-compressed',
                'application/x-zip-compressed',
                'application/octet-stream'
            ];
            const maxSize = 5 * 1024 * 1024; // 5MB
            let selectedFiles = [];

            function getFileId(file) {
                return `${file.name}-${file.size}-${file.lastModified}`;
            }

            function validateFiles() {
                let isValid = true;
                const existingErrors = previewContainer ? previewContainer.querySelectorAll('.text-danger') : [];
                existingErrors.forEach(error => error.remove());

                selectedFiles.forEach(file => {
                    let error = '';
                    if (!allowedTypes.includes(file.type)) {
                        error = 'Format file tidak didukung. Gunakan PDF, DOC(X), PPT(X), JPG, PNG, ZIP, atau RAR.';
                        isValid = false;
                    } else if (file.size > maxSize) {
                        error = 'Ukuran file terlalu besar. Maksimum 5MB.';
                        isValid = false;
                    }
                    if (error && previewContainer) {
                        const fileElement = previewContainer.querySelector(`.file-preview[data-file-id="${getFileId(file)}"]`);
                        if (fileElement) {
                            fileElement.insertAdjacentHTML('beforeend', `<div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">${error}</div>`);
                        }
                    }
                });

                if (!isValid && previewContainer) {
                    previewContainer.insertAdjacentHTML('beforeend', `<div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">Terdapat file dengan format atau ukuran tidak valid.</div>`);
                }
                return isValid;
            }

            function previewFile(input) {
                if (!previewContainer) {
                    console.error('file-preview-container tidak ditemukan!');
                    return;
                }
                previewContainer.innerHTML = '';

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
                        error = 'Format file tidak didukung. Gunakan PDF, DOC(X), PPT(X), JPG, PNG, ZIP, atau RAR.';
                    } else if (file.size > maxSize) {
                        error = 'Ukuran file terlalu besar. Maksimum 5MB.';
                    }

                    const fileElement = document.createElement('div');
                    fileElement.className = 'd-flex align-items-center justify-content-between bg-light rounded p-2 mb-1 file-preview';
                    fileElement.setAttribute('data-file-id', getFileId(file));

                    fileElement.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt me-2" style="font-size: 1.5rem; color: #3699FF;"></i>
                            <div>
                                <small class="text-muted" style="font-family: 'Poppins', sans-serif;">${file.name} (${(file.size / 1024).toFixed(2)} KB)</small>
                                ${error ? `<div class="text-danger" style="font-family: 'Poppins', sans-serif; font-size: 0.875rem;">${error}</div>` : ''}
                            </div>
                        </div>
                        button type="button" class="btn btn-sm btn-link text-danger remove-file" data-file-id="${getFileId(file)}">
                            <i class="fas fa-times"></i>
                        </button>
                    `;

                    previewContainer.appendChild(fileElement);
                });

                // Add event listeners for remove buttons
                document.querySelectorAll('.remove-file').forEach(button => {
                    button.removeEventListener('click', removeFileHandler); // Remove existing listeners to prevent duplicates
                    button.addEventListener('click', removeFileHandler);
                });

                updateFileInput();
            }

            function removeFileHandler() {
                const fileId = this.dataset.fileId;
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

            function updateFileInput() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
                validateFiles();
            }

            if (fileInput) {
                fileInput.addEventListener('change', () => previewFile(fileInput));

                // Drag and drop functionality
                const uploadArea = document.getElementById('upload-area');
                if (uploadArea) {
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
                        fileInput.files = e.dataTransfer.files;
                        previewFile(fileInput);
                    });
                }
            }

            // Dimension and Options Handling
            const dimensionRadios = document.querySelectorAll('.dimension-radio');
            const optionsContainer = document.getElementById('options-container');
            const optionsList = document.getElementById('options-list');
            const dimensionError = document.getElementById('dimension-error');
            const optionsError = document.getElementById('options-error');

            if (!dimensionRadios.length || !optionsContainer || !optionsList) {
                console.error('Elemen dimensi atau opsi tidak ditemukan!');
            } else {
                dimensionRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        optionsList.innerHTML = '';
                        if (this.checked) {
                            try {
                                const options = JSON.parse(this.getAttribute('data-options') || '[]');
                                if (options.length === 0) {
                                    optionsList.innerHTML = '<div class="text-muted" style="font-family: \'Poppins\', sans-serif;">Tidak ada opsi tersedia untuk dimensi ini.</div>';
                                    optionsContainer.style.display = 'block';
                                    return;
                                }
                                options.forEach(opt => {
                                    const div = document.createElement('div');
                                    div.className = 'form-check';
                                    div.innerHTML = `
                                        <input class="form-check-input option-radio" type="radio"
                                               name="dimension_options[]"
                                               value="${opt.id}"
                                               id="option-${opt.id}"
                                               ${opt.id == '{{ old("dimension_options.0") }}' ? 'checked' : ''}
                                               required
                                               aria-describedby="options-error">
                                        <label class="form-check-label" for="option-${opt.id}" style="font-family: 'Poppins', sans-serif;">
                                            ${opt.nama_opsi_dimensi}
                                        </label>
                                    `;
                                    optionsList.appendChild(div);
                                });
                                optionsContainer.style.display = 'block';
                            } catch (e) {
                                console.error('Gagal mem-parsing data-options:', e);
                                optionsList.innerHTML = '<div class="text-danger" style="font-family: \'Poppins\', sans-serif;">Gagal memuat opsi dimensi.</div>';
                                optionsContainer.style.display = 'block';
                            }
                        } else {
                            optionsContainer.style.display = 'none';
                        }
                    });

                    // Trigger change event for pre-selected dimension
                    if (radio.checked) {
                        radio.dispatchEvent(new Event('change'));
                    }
                });
            }

            // Form Validation
            const form = document.querySelector('.needs-validation');
            if (!form) {
                console.error('Form dengan kelas needs-validation tidak ditemukan!');
                return;
            }
            form.addEventListener('submit', function (event) {
                let isValid = true;
                const checkedDimension = document.querySelector('.dimension-radio:checked');
                const checkedOption = document.querySelector('.option-radio:checked');

                if (!checkedDimension) {
                    dimensionError.style.display = 'block';
                    dimensionContainer.classList.add('is-invalid');
                    isValid = false;
                } else {
                    dimensionError.style.display = 'none';
                    dimensionContainer.classList.remove('is-invalid');
                }

                if (checkedDimension && !checkedOption) {
                    optionsError.style.display = 'block';
                    optionsList.classList.add('is-invalid');
                    isValid = false;
                } else {
                    optionsError.style.display = 'none';
                    optionsList.classList.remove('is-invalid');
                }

                if (!form.checkValidity() || !isValid || !validateFiles()) {
                    event.preventDefault();
                    event.stopPropagation();
                    console.log('Validasi gagal: Form tidak valid, dimensi, opsi, atau file belum dipilih.');
                } else {
                    console.log('Form valid, siap dikirim.');
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>
@endsection
