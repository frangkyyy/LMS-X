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
            <i class="fas fa-trophy text-info me-2"></i>
            Hasil Kuis: {{ $quiz->name }}
        </h3>

        {{-- Quiz Information --}}
        <div class="alert alert-light mb-4">
            <strong>Total Poin: </strong> {{ $totalPoin }} / {{ $quiz->questions->sum('poin') }}
            @if ($quiz->grade_to_pass)
                <br>
                <strong>Nilai Minimum Lulus: </strong> {{ $quiz->grade_to_pass }}
                @if ($totalPoin >= $quiz->grade_to_pass)
                    <span class="badge bg-success ms-2">Lulus</span>
                @else
                    <span class="badge bg-danger ms-2">Tidak Lulus</span>
                @endif
            @endif
        </div>

        {{-- Attempt Information --}}
        @php
            $attemptCount = $quiz->attempts()->where('user_id', auth()->id())->count();
        @endphp
        <div class="mb-4">
            <span class="badge bg-info me-2">
                <strong>Percobaan: </strong> {{ $attempt->attempt_number }} / {{ $quiz->max_attempts }}
            </span>
        </div>

        {{-- Reattempt Button --}}
        @if ($attemptCount < $quiz->max_attempts)
            <div class="mb-4">
                <a href="{{ route('quiz.showMahasiswa', $quiz->id) }}" class="btn btn-warning">
                    <i class="fas fa-redo me-2"></i> Coba Lagi Kuis
                </a>
                <span class="text-muted ms-2">Percobaan tersisa: {{ $quiz->max_attempts - $attemptCount }}</span>
            </div>
        @endif

        {{-- Question Results --}}
        <h4 class="fw-bold mb-3">Detail Jawaban</h4>
        @foreach ($attempt->answers as $index => $answer)
            @php
                $question = $answer->question;
            @endphp
            <div class="card mb-3">
                <div class="card-body">
                    <p>
                        <strong>Pertanyaan {{ $index + 1 }}:</strong> {!! $question->question_text !!}
                        <span class="badge bg-secondary float-end">{{ $answer->poin }} / {{ $question->poin }} poin</span>
                    </p>
                    <div>
                        <strong>Jawaban Anda: </strong> {{ $answer->answer }}. {{ $question->{'options_' . strtolower($answer->answer)} }}
                        @if ($answer->answer === $question->correct_answer)
                            <span class="badge bg-success ms-2">Benar</span>
                        @else
                            <span class="badge bg-danger ms-2">Salah</span>
                            <br>
                            <strong>Jawaban Benar: </strong> {{ $question->correct_answer }}. {{ $question->{'options_' . strtolower($question->correct_answer)} }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Navigation Buttons --}}
        <div class="mt-4">
            <a href="{{ route('topik.showtopicmahasiswa', [$course->id, $section->id]) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
