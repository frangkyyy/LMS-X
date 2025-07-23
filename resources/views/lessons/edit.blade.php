@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-4">
        <h2>Edit Lesson untuk {{ $subTopic->title }}</h2>
        <form method="POST" action="{{ route('lessons.update', $lesson->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

            <!-- General Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lesson <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                               value="{{ old('name', $lesson->name) }}" required aria-describedby="name-error">
                        <div id="name-error" class="invalid-feedback">Nama Lesson wajib diisi.</div>
                        @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $lesson->description) }}</textarea>
                        @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Learning Style (Processing, ID 1) -->
                    @php
                        $processingDimension = $dimensions->firstWhere('id', 1);
                        $selectedOption = $lesson->dimension_option_id ?? null;
                    @endphp
                    @if($processingDimension)
                        <input type="hidden" name="dimension[]" value="{{ $processingDimension->id }}">
                        <div class="mb-3">
                            <label class="form-label">Dimensi Learning Style: Processing <span class="text-danger">*</span></label>
                            <div id="options-container" class="@error('dimension_options') is-invalid @enderror">
                                <label class="form-label">Pilih Opsi</label>
                                <div id="options-list">
                                    @foreach($processingDimension->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input option-radio" type="radio"
                                                   name="dimension_options[]"
                                                   value="{{ $option->id }}"
                                                   id="option-{{ $option->id }}"
                                                   {{ old('dimension_options.0', $selectedOption) == $option->id ? 'checked' : '' }}
                                                   required
                                                   aria-describedby="options-error">
                                            <label class="form-check-label" for="option-{{ $option->id }}">
                                                {{ $option->nama_opsi_dimensi }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="invalid-feedback d-block" id="options-error" style="display: none;">
                                    Pilih satu opsi dimensi.
                                </div>
                                @error('dimension_options')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">Dimensi 'Processing' (ID: 1) tidak ditemukan.</div>
                    @endif
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="action" value="save_return">Save and return to course</button>
                <button type="submit" class="btn btn-secondary" name="action" value="save_display">Save and display</button>
                <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}"
                   class="btn btn-outline-secondary" onclick="return confirm('Apakah Anda yakin ingin membatalkan perubahan?')">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize TinyMCE
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE tidak dimuat!');
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger mt-3';
                alert.textContent = 'Gagal memuat editor teks. Silakan coba lagi atau hubungi dukungan.';
                document.querySelector('.card-body').prepend(alert);
            } else {
                tinymce.init({
                    selector: '#description',
                    plugins: [
                        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    setup: function (editor) {
                        editor.on('init', function () {
                            console.log('TinyMCE initialized');
                        });
                        editor.on('error', function (e) {
                            console.error('TinyMCE error:', e);
                        });
                    }
                });
            }

            // Form validation
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function (event) {
                const checkedOption = document.querySelector('.option-radio:checked');
                const optionsError = document.getElementById('options-error');
                const optionsContainer = document.getElementById('options-container');

                if (!form.checkValidity() || !checkedOption) {
                    event.preventDefault();
                    event.stopPropagation();
                    if (!checkedOption) {
                        optionsError.style.display = 'block';
                        optionsContainer.classList.add('is-invalid');
                    } else {
                        optionsError.style.display = 'none';
                        optionsContainer.classList.remove('is-invalid');
                    }
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>
@endsection
