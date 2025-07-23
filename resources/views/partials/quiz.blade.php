@if ($quiz)
<div class="card mt-4">
    <div class="card-body">
        <h4 class="fw-bold text-primary">{{ $quiz->name }}</h4>
        <p>{{ $quiz->description }}</p>

        @if ($quiz->time_open && $quiz->time_close)
            <div class="mb-3">
                <span class="badge bg-success me-2">
                    <strong>Opened:</strong> {{ \Carbon\Carbon::parse($quiz->time_open)->translatedFormat('l, d F Y, H.i A') }}
                </span>
                <span class="badge bg-success">
                    <strong>Due:</strong> {{ \Carbon\Carbon::parse($quiz->time_close)->translatedFormat('l, d F Y, H.i A') }}
                </span>
            </div>
        @endif

        <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-success">Mulai Quiz</a>
    </div>
</div>
@endif