<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="fw-bold">Quiz Results: {{ $quiz->name }}</h2>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h4 class="mt-4">Your Attempts:</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Attempt</th>
                            <th>Score</th>
                            <th>Completed At</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>Attempt {{ $grade->attempt_number }}</td>
                                <td>{{ round($grade->grade, 2) }}%</td>
                                <td>{{ $grade->completed_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($grade->attempt)
                                        <a href="{{ route('quiz.attempt.details', [
                    'quiz_id' => $quiz->id,
                    'attempt_id' => $grade->attempt->id
                ]) }}" class="btn btn-sm btn-info">
                                            View Details
                                        </a>
                                    @else
                                        <span class="text-muted">Details not available</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if($quiz->max_attempts == 0 || $grades->count() < $quiz->max_attempts)
                        <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-primary">
                            Try Again
                        </a>
                    @endif

                    @isset($styleSlug)
                        <a href="{{ route($styleSlug, [
                            'course_id' => $quiz->course_id,
                            'topik' => $topicId,
                            'section_id' => $topicId
                        ]) }}" class="btn btn-secondary">
                            Back to Course Material
                        </a>
                    @endisset
                </div>
            </div>
        </div>
    </div>
