<div class="container mt-5">
    <h2 class="mb-4">{{ $quiz->name }} </h2>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($quiz->questions->isEmpty())
        <div class="alert alert-warning" role="alert">
            No questions have been added to this quiz yet.
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Questions</h5>
                @foreach ($quiz->questions as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Question {{ $index + 1 }} ({{ $question->poin }} points)</h6>
                            <p class="card-text">{!! $question->question_text !!}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">A: {{ $question->options_a }}</li>
                                <li class="list-group-item">B: {{ $question->options_b }}</li>
                                <li class="list-group-item">C: {{ $question->options_c }}</li>
                                <li class="list-group-item">D: {{ $question->options_d }}</li>
                            </ul>
                            <div class="mt-3">
                                <strong>Correct Answer:</strong> {{ $question->correct_answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('questions.create', $quiz->id) }}" class="btn btn-primary">Add More Questions</a>
        <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Back to Quizzes</a>
        <a href="" class="btn btn-secondary">Back to Quizzes</a>
    </div>
</div>
