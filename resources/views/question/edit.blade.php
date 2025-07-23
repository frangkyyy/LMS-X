@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Question for {{ $quiz->name }}</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('questions.update', [$quiz->id, $question->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="question_text" class="form-label">Question Text</label>
                        <textarea class="form-control @error('question_text') is-invalid @enderror" id="question_text" name="question_text" rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="poin" class="form-label">Points</label>
                        <input type="number" class="form-control @error('poin') is-invalid @enderror" id="poin" name="poin" value="{{ old('poin', $question->poin) }}" min="0" required>
                        @error('poin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="options_a" class="form-label">Option A</label>
                        <input type="text" class="form-control @error('options_a') is-invalid @enderror" id="options_a" name="options_a" value="{{ old('options_a', $question->options_a) }}" required>
                        @error('options_a')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="options_b" class="form-label">Option B</label>
                        <input type="text" class="form-control @error('options_b') is-invalid @enderror" id="options_b" name="options_b" value="{{ old('options_b', $question->options_b) }}" required>
                        @error('options_b')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="options_c" class="form-label">Option C</label>
                        <input type="text" class="form-control @error('options_c') is-invalid @enderror" id="options_c" name="options_c" value="{{ old('options_c', $question->options_c) }}" required>
                        @error('options_c')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="options_d" class="form-label">Option D</label>
                        <input type="text" class="form-control @error('options_d') is-invalid @enderror" id="options_d" name="options_d" value="{{ old('options_d', $question->options_d) }}" required>
                        @error('options_d')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <select class="form-select @error('correct_answer') is-invalid @enderror" id="correct_answer" name="correct_answer" required>
                            <option value="A" {{ old('correct_answer', $question->correct_answer) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('correct_answer', $question->correct_answer) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('correct_answer', $question->correct_answer) == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('correct_answer', $question->correct_answer) == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        @error('correct_answer')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('quizs.show', $quiz->id) }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
