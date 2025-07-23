@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-4">
        <h2>Edit Assignment for {{ $subTopic->title }}</h2>
        <form method="POST" action="{{ route('assignments.update', $assignment->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

            <!-- General Section -->
            <div class="card mb-3">
                <div class="card-body">
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

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                               value="{{ old('name', $assignment->name) }}" required>
                        <div class="invalid-feedback">Please provide an assignment name.</div>
                        @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $assignment->description) }}</textarea>
                        @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date"
                               value="{{ old('due_date', \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d\TH:i')) }}" required>
                        <div class="invalid-feedback">Please provide a due date.</div>
                        @error('due_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Learning Style (Processing, ID 1) -->
                    @php
                        $processingDimension = $dimensions->firstWhere('id', 1);
                        $selectedOption = $assignment->dimension_option_id ?? null;
                    @endphp
                    @if($processingDimension)
                        <input type="hidden" name="dimension[]" value="{{ $processingDimension->id }}">
                        <div class="mb-3">
                            <label class="form-label">Dimensi Learning Style: Processing <span class="text-danger">*</span></label>
                            <div id="options-container">
                                <label class="form-label">Pilih Opsi</label>
                                <div id="options-list">
                                    @foreach($processingDimension->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input option-radio" type="radio"
                                                   name="dimension_options[]"
                                                   value="{{ $option->id }}"
                                                   id="option-{{ $option->id }}"
                                                   {{ $selectedOption == $option->id ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label" for="option-{{ $option->id }}">
                                                {{ $option->nama_opsi_dimensi }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="invalid-feedback d-block" id="options-error" style="display: none;">
                                    Pilih satu opsi dimensi.
                                </div>
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
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize TinyMCE
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE tidak dimuat!');
            } else {
                tinymce.init({
                    selector: '#description',
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount emoticons',
                    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | removeformat',
                    menubar: false,
                    height: 200,
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

                if (!form.checkValidity() || !checkedOption) {
                    event.preventDefault();
                    event.stopPropagation();
                    optionsError.style.display = checkedOption ? 'none' : 'block';
                }
                form.classList.add('was-validated');
            });
        });
    </script>
@endsection
