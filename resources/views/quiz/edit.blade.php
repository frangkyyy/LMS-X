@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-4">
        <h2>Editing Quiz: {{ $quiz->name }}</h2>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('quizs.update', $quiz->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

            <!-- General Section -->
            <div class="card mb-3">
                <div class="card-header">General</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $quiz->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please provide a quiz name.</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $quiz->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="learning_style_id" class="form-label">Dimensi Gaya Belajar</label>
                        <select class="form-select @error('learning_style_id') is-invalid @enderror" id="learning_style_id" name="learning_style_id" required>
                            <option value="" disabled>Select a dimension</option>
                            @forelse($dimensions as $dimension)
                                <option value="{{ $dimension->id }}" {{ old('learning_style_id', $quiz->learning_style_id) == $dimension->id ? 'selected' : '' }} {{ \App\Models\MDLQuiz::where('sub_topic_id', $subTopic->id)->where('learning_style_id', $dimension->id)->where('id', '!=', $quiz->id)->exists() ? 'disabled' : '' }}>
                                    {{ $dimension->dimension ?? $dimension->style_name ?? 'Unnamed Dimension' }}
                                </option>
                            @empty
                                <option value="" disabled>No dimensions available</option>
                            @endforelse
                        </select>
                        @error('learning_style_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a dimension.</div>
                            @enderror
                    </div>
                </div>
            </div>

            <!-- Timing Section -->
            <div class="card mb-3">
                <div class="card-header">Timing</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="time_open" class="form-label">Open the Quiz</label>
                        <input type="datetime-local" class="form-control @error('time_open') is-invalid @enderror" id="time_open" name="time_open" value="{{ old('time_open', $quiz->time_open ? $quiz->time_open->format('Y-m-d\TH:i') : '') }}">
                        @error('time_open')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank for no opening time restriction.</small>
                    </div>
                    <div class="mb-3">
                        <label for="time_close" class="form-label">Close the Quiz</label>
                        <input type="datetime-local" class="form-control @error('time_close') is-invalid @enderror" id="time_close" name="time_close" value="{{ old('time_close', $quiz->time_close ? $quiz->time_close->format('Y-m-d\TH:i') : '') }}">
                        @error('time_close')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank for no closing time restriction.</small>
                    </div>
                    <div class="mb-3">
                        <label for="time_limit" class="form-label">Time Limit (minutes)</label>
                        <input type="number" class="form-control @error('time_limit') is-invalid @enderror" id="time_limit" name="time_limit" value="{{ old('time_limit', $quiz->time_limit ? $quiz->time_limit / 60 : 0) }}" min="0" max="180" step="1">
                        @error('time_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a time limit between 0 and 180 minutes.</div>
                            @enderror
                            <small class="form-text text-muted">Enter 0 for no time limit.</small>
                    </div>
                </div>
            </div>

            <!-- Grade Section -->
            <div class="card mb-3">
                <div class="card-header">Grade</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="max_attempts" class="form-label">Attempts Allowed</label>
                        <input type="number" class="form-control @error('max_attempts') is-invalid @enderror" id="max_attempts" name="max_attempts" value="{{ old('max_attempts', $quiz->max_attempts) }}" min="1" step="1">
                        @error('max_attempts')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a number of attempts (minimum 1).</div>
                            @enderror
                            <small class="form-text text-muted">Number of attempts allowed.</small>
                    </div>
                    <div class="mb-3">
                        <label for="grade_to_pass" class="form-label">Grade to Pass</label>
                        <input type="number" class="form-control @error('grade_to_pass') is-invalid @enderror" id="grade_to_pass" name="grade_to_pass" value="{{ old('grade_to_pass', $quiz->grade_to_pass) }}" min="0" max="100" step="0.01">
                        @error('grade_to_pass')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a grade between 0 and 100.</div>
                            @enderror
                            <small class="form-text text-muted">Minimum grade to pass.</small>
                    </div>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="action" value="save_return">Save and Return to Course</button>
                <button type="submit" class="btn btn-secondary" name="action" value="save_display">Save and Display</button>
                <a href="{{ route('sections.show', [$subTopic->section->course_id, $subTopic->section->id]) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize TinyMCE
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE not loaded!');
                alert('Failed to load the text editor. Please contact the administrator.');
            } else {
                tinymce.init({
                    selector: '#description',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                    height: 300,
                    tinycomments: false,
                    setup: function (editor) {
                        editor.on('init', function () {
                            console.log('TinyMCE initialized for quiz edit');
                        });
                        editor.on('error', function (e) {
                            console.error('TinyMCE error:', e);
                        });
                    }
                });
            }

            // Form validation
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function (e) {
                const timeOpen = document.getElementById('time_open').value;
                const timeClose = document.getElementById('time_close').value;

                // Client-side validation for time_close
                if (timeOpen && timeClose && new Date(timeClose) <= new Date(timeOpen)) {
                    e.preventDefault();
                    e.stopPropagation();
                    document.getElementById('time_close').classList.add('is-invalid');
                    document.getElementById('time_close').nextElementSibling.textContent = 'Close time must be after open time.';
                }

                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>
@endsection
