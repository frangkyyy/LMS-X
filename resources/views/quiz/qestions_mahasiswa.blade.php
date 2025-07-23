<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container mt-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $subTopic->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="quiz">{{ $quiz->name }}</li>
            </ol>
        </nav>
        <h3 class="fw-bold text-primary mb-4">
            <i class="fas fa-file-alt text-info me-2"></i>
            {{ $quiz->name }}
        </h3>

        {{-- Info Quiz --}}
        @if ($quiz->description)
            <div class="alert alert-light mb-4">
                <strong>Deskripsi:</strong> {!! (($quiz->description)) !!}
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
            @if ($quiz->grade_to_pass)
                <span class="badge bg-info">
                    <strong>Grade to Pass:</strong> {{ $quiz->grade_to_pass }}
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
                <strong>Info:</strong> Anda telah mencapai batas maksimum percobaan ({{ $quiz->max_attempts }}) untuk kuis ini.
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @else
            {{-- Reattempt Button --}}
            @if ($hasSubmitted && $attemptCount < $quiz->max_attempts)
                <div class="mb-4">
                    <a href="{{ route('quiz.showMahasiswa', $quiz->id) }}" class="btn btn-warning">
                        <i class="fas fa-redo me-2"></i> Coba Lagi Kuis
                    </a>
                    <span class="text-muted ms-2">Percobaan tersisa: {{ $quiz->max_attempts - $attemptCount }}</span>
                </div>
            @endif

            {{-- Form Quiz --}}
            <form id="quizForm" action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                @csrf

                @foreach ($quiz->questions as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <p>
                                <strong>Pertanyaan {{ $index + 1 }}:</strong> {!! $question->question_text !!}
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

                <button type="submit" class="btn btn-primary me-2" id="submitQuiz">Kirim Jawaban</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </form>

            <script>
                document.getElementById('quizForm').addEventListener('submit', async function(event) {
                    event.preventDefault(); // Prevent default form submission

                    const form = event.target;
                    const formData = new FormData(form);
                    const actionUrl = form.action;

                    try {
                        const response = await fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            const data = await response.json(); // Expect JSON response
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url; // Follow backend redirect
                            } else {
                                // Fallback: Construct result page URL
                                window.location.href = '{{ route("quiz.result", [$quiz->id, "ATTEMPT_ID"]) }}'.replace('ATTEMPT_ID', data.attempt_id || 'latest');
                            }
                        } else {
                            alert('Terjadi kesalahan saat mengirim kuis. Silakan coba lagi.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim kuis. Silakan coba lagi.');
                    }
                });
            </script>
        @endif
    </div>
</div>
