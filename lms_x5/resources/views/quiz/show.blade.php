<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container mt-4">
        <h3 class="fw-bold text-primary mb-4">
            <i class="fas fa-file-alt text-info me-2"></i>
            Quiz Active 1: Pengenalan IoT
        </h3>

        {{-- Info Opened dan Due --}}
        @if ($quiz->time_open && $quiz->time_close)
            <div class="mb-4">
            <span class="badge bg-success me-2">
                <strong>Opened:</strong>
                {{ $quiz->time_open->translatedFormat('l, d F Y, H.i A') }}
            </span>
                <span class="badge bg-success">
                <strong>Due:</strong>
                {{ $quiz->time_close->translatedFormat('l, d F Y, H.i A') }}
            </span>
            </div>
        @endif

        {{-- Form Quiz --}}
        <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
            @csrf

            @foreach ($questions as $index => $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>Pertanyaan {{ $index + 1 }}:</strong> {{ $question->question_text }}</p>

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
    </div>
</div>
