<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container mt-4">
        <h3 class="fw-bold text-primary mb-4">
            <i class="fas fa-file-alt text-info me-2"></i>
            {{ $quiz->name }}
        </h3>

        {{-- Info Quiz --}}
        @if ($quiz->description)
            <div class="alert alert-light mb-4">
                <strong>Deskripsi:</strong> {!! nl2br(e($quiz->description)) !!}
            </div>
        @endif

        {{-- Info Opened dan Due --}}
        @if ($quiz->time_open && $quiz->time_close)
            <div class="mb-4">
                <span class="badge bg-success me-2">
                    <strong>Opened:</strong>
                    {{ $quiz->time_open->translatedFormat('l, d F Y, H:i A') }}
                </span>
                <span class="badge bg-success">
                    <strong>Due:</strong>
                    {{ $quiz->time_close->translatedFormat('l, d F Y, H:i A') }}
                </span>
            </div>
        @endif

        {{-- Info Time Limit, Max Attempts, dan Grade to Pass --}}
        <div class="mb-4">
            @if ($quiz->time_limit)
                <span class="badge bg-info me-2">
                    <strong>Time Limit:</strong> {{ $quiz->time_limit }} menit
                </span>
            @endif
            @if ($quiz->max_attempts)
                <span class="badge bg-info me-2">
                    <strong>Max Attempts:</strong> {{ $quiz->max_attempts }}
                </span>
            @endif
            @if ($quiz->Grade_to_pass)
                <span class="badge bg-info">
                    <strong>Grade to Pass:</strong> {{ $quiz->Grade_to_pass }}
                </span>
            @endif
        </div>

        {{-- Status Submission --}}
        @php
            $hasSubmitted = $quiz->attempts()->where('user_id', auth()->id())->exists();
            $attemptCount = $quiz->attempts()->where('user_id', auth()->id())->count();
        @endphp

        @if ($hasSubmitted && $attemptCount >= $quiz->max_attempts)
            <div class="alert alert-info mb-4">
                <strong>Info:</strong> Anda telah mencapai batas maksimum percobaan ({{ $quiz->max_attempts }}) untuk kuis ini LIMAT
            </div>
        @else
            {{-- Form Quiz --}}
            <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                @csrf

                @foreach ($quiz->questions as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <p>
                                <strong>Pertanyaan {{ $index + 1 }}:</strong> {{ $question->question_text }}
                                <span class="badge bg-secondary float-end">{{ $question->poin }} poin</span>
                            </p>

                            <div class="form-check">
                                <input type="radio" name="answers[{{ $question->id }}]" value="A" class="form-check-input" required>
                                <label class="form-check-label">A. {{ $question->options_a }}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="answers[{{ $question->id }}]" value="B" class="form-check-input">
                                <label class="form-check-label">B. {{ $question->options_b }}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="answers[{{ $question->id }}]" value="C" class="form-check-input">
                                <label class="form-check-label">C. {{ $question->options_c }}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="answers[{{ $question->id }}]" value="D" class="form-check-input">
                                <label class="form-check-label">D. {{ $question->options_d }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
            </form>
        @endif
    </div>
</div>
