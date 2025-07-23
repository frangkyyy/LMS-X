@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit File untuk {{ $subTopic->title }}</h2>
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('files.update', $file->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

            <!-- General Section -->
            <div class="card mb-3">
                <div class="card-header">Informasi Umum</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama File</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $file->name) }}" required>
                        <div class="invalid-feedback">Nama file wajib diisi.</div>
                        @error('name')
                        <div class="text-danger" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $file->description) }}</textarea>
                        <div class="invalid-feedback">Deskripsi wajib diisi.</div>
                        @error('description')
                        <div class="text-danger" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file_upload" class="form-label">Upload File (Kosongkan jika tidak ingin mengganti)</label>
                        <div class="mb-2">
                            <small class="text-muted">File saat ini: {{ $file->original_filename }}</small>
                            <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank" class="text-primary ms-2">Lihat file</a>
                        </div>
                        <input type="file" class="form-control" id="file_upload" name="file_upload[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png,.zip,.rar">
                        <div class="invalid-feedback">File tidak valid.</div>
                        <small class="form-text text-muted">Format: PDF, DOC(X), PPT(X), JPG, PNG, ZIP, RAR. Maks. 5MB</small>
                        <div id="file-preview-container" class="mt-2"></div>
                        @error('file_upload.*')
                        <div class="text-danger" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Learning Style (Dimensions 2 or 3) -->
                    @php
                        $selectedDimensions = $dimensions->whereIn('id', [2, 3]);
                        $selectedOptionId = $file->options->pluck('id')->first();
                        $selectedDimensionId = $file->options->pluck('pivot.dimension_id')->first();
                    @endphp
                    @if($selectedDimensions->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Dimensi Learning Style</label>
                            <div id="dimension-container">
                                @foreach($selectedDimensions as $dimension)
                                    <div class="form-check">
                                        <input class="form-check-input dimension-radio" type="radio"
                                               name="dimension"
                                               value="{{ $dimension->id }}"
                                               id="dimension-{{ $dimension->id }}"
                                               data-options='@json($dimension->options)'
                                               {{ old('dimension', $selectedDimensionId) == $dimension->id ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label" for="dimension-{{ $dimension->id }}">
                                            {{ $dimension->dimension }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="invalid-feedback d-block" id="dimension-error" style="display: none;">
                                Pilih satu dimensi.
                            </div>
                            @error('dimension')
                            <div class="text-danger" style="font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="options-container" style="display: none;">
                            <label class="form-label">Pilih Opsi</label>
                            <div id="options-list"></div>
                            <div class="invalid-feedback d-block" id="options-error" style="display: none;">
                                Pilih satu opsi dimensi.
                            </div>
                            @error('dimension_options.*')
                            <div class="text-danger" style="font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="alert alert-warning">Dimensi dengan ID 2 atau 3 tidak ditemukan.</div>
                    @endif
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="action" value="save_return">Simpan dan kembali ke kursus</button>
                <button type="submit" class="btn btn-secondary" name="action" value="save_display">Simpan dan tampilkan</button>
                <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // TinyMCE Initialization (preserved from original)
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

            // File Preview and Validation
            const fileInput = document.getElementById('file_upload');
            const previewContainer = document.getElementById('file-preview-container');

            if (fileInput && previewContainer) {
                fileInput.addEventListener('change', function () {
                    previewContainer.innerHTML = '';
                    const maxFileSize = 5 * 1024 * 1024; // 5MB
                    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'image/jpeg', 'image/png', 'application/zip', 'application/x-rar-compressed'];

                    if (fileInput.files && fileInput.files.length > 0) {
                        for (let i = 0; i < fileInput.files.length; i++) {
                            const file = fileInput.files[i];
                            if (!allowedTypes.includes(file.type) || file.size > maxFileSize) {
                                alert(`File ${file.name} tidak valid. Pastikan format adalah PDF, DOC, DOCX, PPT, PPTX, JPG, PNG, ZIP, atau RAR dan ukuran kurang dari 5MB.`);
                                fileInput.value = '';
                                return;
                            }

                            const fileElement = document.createElement('div');
                            fileElement.className = 'd-flex align-items-center justify-content-between bg-light rounded p-2 mb-1';
                            fileElement.innerHTML = `
                                <div>
                                    <small class="text-muted">${file.name} (${(file.size / 1024).toFixed(2)} KB)</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeFile(${i})">
                                    <i class="fas fa-times"></i>
                                </button>
                            `;
                            previewContainer.appendChild(fileElement);
                        }
                    }
                });
            }

            window.removeFile = function (index) {
                if (!fileInput) return;
                const newFiles = new DataTransfer();
                for (let i = 0; i < fileInput.files.length; i++) {
                    if (i !== index) {
                        newFiles.items.add(fileInput.files[i]);
                    }
                }
                fileInput.files = newFiles.files;
                fileInput.dispatchEvent(new Event('change'));
            };

            // Dimension and Options Handling
            const dimensionRadios = document.querySelectorAll('.dimension-radio');
            const optionsContainer = document.getElementById('options-container');
            const optionsList = document.getElementById('options-list');
            const selectedOptionId = '{{ $selectedOptionId }}';

            if (dimensionRadios.length > 0 && optionsContainer && optionsList) {
                dimensionRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        optionsList.innerHTML = '';
                        if (this.checked) {
                            const options = JSON.parse(this.getAttribute('data-options'));
                            options.forEach(opt => {
                                const div = document.createElement('div');
                                div.className = 'form-check';
                                div.innerHTML = `
                                    <input class="form-check-input option-radio" type="radio"
                                           name="dimension_options[]"
                                           value="${opt.id}"
                                           id="option-${opt.id}"
                                           ${opt.id == selectedOptionId || opt.id == '{{ old("dimension_options.0") }}' ? 'checked' : ''}
                                           required>
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

                    if (radio.checked) {
                        radio.dispatchEvent(new Event('change'));
                    }
                });
            }

            // Form Validation
            const form = document.querySelector('.needs-validation');
            if (form) {
                form.addEventListener('submit', function (event) {
                    let isValid = true;
                    const checkedDimension = document.querySelector('.dimension-radio:checked');
                    const checkedOption = document.querySelector('.option-radio:checked');
                    const dimensionError = document.getElementById('dimension-error');
                    const optionsError = document.getElementById('options-error');

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
                    }
                    form.classList.add('was-validated');
                }, false);
            }
        });
    </script>
@endsection
