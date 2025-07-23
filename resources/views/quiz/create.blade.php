@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-4">
        <h2>Adding a new Quiz for {{ $subTopic->title }}</h2>
        <form method="POST" action="{{ route('quiz.store') }}" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

            <!-- General Section -->
            <div class="card mb-3">
                <div class="card-header">General</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback">Please provide a quiz name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="learning_style_id" class="form-label">Dimensi gaya belajar</label>
                        <select class="form-select" id="learning_style_id" name="learning_style_id" required>

                            @forelse($dimensions as $dimension)
                                <option value="{{ $dimension->id }}">{{ $dimension->dimension }}</option>
                            @empty
                                <option value="" disabled>No learning styles available</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback">Please select a dimension learning style.</div>
                    </div>
                </div>
            </div>

            <!-- Timing Section -->
            <div class="card mb-3">
                <div class="card-header">Timing</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="time_open" class="form-label">Open the quiz</label>
                        <input type="datetime-local" class="form-control" id="time_open" name="time_open">
                    </div>
                    <div class="mb-3">
                        <label for="time_close" class="form-label">Close the quiz</label>
                        <input type="datetime-local" class="form-control" id="time_close" name="time_close">
                    </div>
                    <div class="mb-3">
                        <label for="time_limit" class="form-label">Time limit (seconds)</label>
                        <input type="number" class="form-control" id="time_limit" name="time_limit" min="0">
                    </div>
                </div>
            </div>

            <!-- Grade Section -->
            <div class="card mb-3">
                <div class="card-header">Grade</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="max_attempts" class="form-label">Attempts allowed</label>
                        <input type="number" class="form-control" id="max_attempts" name="max_attempts" min="1">
                    </div>
                    <div class="mb-3">
                        <label for="grade_to_pass" class="form-label">Grade to pass</label>
                        <input type="number" class="form-control" id="grade_to_pass" name="grade_to_pass" min="0" max="100">
                    </div>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="action" value="save_return">Save and return to course</button>
                <button type="submit" class="btn btn-secondary" name="action" value="save_display">Save and display</button>
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">Cancel</button>
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
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>
@endsection
