<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="fw-bold">Quiz Attempt Details: {{ $quiz->name }}</h2>
                <h4>Attempt {{ $attempt->attempt }}</h4>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <p><strong>Score:</strong>
                            @if($grade)
                                {{ round($grade->grade, 2) }}%
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Started:</strong>
                            @if($attempt->start_time)
                                {{ \Carbon\Carbon::parse($attempt->start_time)->format('d M Y H:i') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Completed:</strong>
                            @if($grade && $grade->completed_at)
                                {{ \Carbon\Carbon::parse($grade->completed_at)->format('d M Y H:i') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>

                <h4 class="mt-4">Question Review:</h4>
                <div class="list-group">
                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $attempt->answers->where('question_id', $question->id)->first();
                            $userAnswerText = $userAnswer ? $question->{'options_'.$userAnswer->answer} : null;
                            $isCorrect = $userAnswerText && $userAnswerText === $question->correct_answer;
                        @endphp
                        <div class="list-group-item mb-3">
                            <h5>Question {{ $index + 1 }}: {{ $question->question_text }}</h5>

                            <div class="mb-2">
                                @if($userAnswer)
                                    <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
                        Your Answer: {{ strtoupper($userAnswer->answer) }}. {{ $userAnswerText }}
                                        @if($isCorrect)
                                            (Correct)
                                        @else
                                            (Incorrect)
                                        @endif
                    </span>
                                    <span class="badge bg-primary ms-2">
                        Correct Answer: {{ $question->correct_answer }}
                    </span>
                                @else
                                    <span class="badge bg-secondary">Not answered</span>
                                    <span class="badge bg-primary ms-2">
                        Correct Answer: {{ $question->correct_answer }}
                    </span>
                                @endif
                            </div>

                            @foreach(['a', 'b', 'c', 'd'] as $option)
                                @php
                                    $optionText = $question->{'options_'.$option};
                                    $isUserAnswer = $userAnswer && $userAnswer->answer === $option;
                                    $isCorrectOption = $optionText === $question->correct_answer;
                                @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" disabled
                                        {{ $isUserAnswer ? 'checked' : '' }}>
                                    <label class="form-check-label
                        {{ $isCorrectOption ? 'text-success fw-bold' : '' }}
                        {{ $isUserAnswer && !$isCorrect ? 'text-danger' : '' }}">
                                        {{ strtoupper($option) }}. {{ $optionText }}
                                        @if($isCorrectOption)
                                            <i class="fas fa-check-circle ms-2 text-success"></i>
                                        @endif
                                        @if($isUserAnswer && !$isCorrect)
                                            <i class="fas fa-times-circle ms-2 text-danger"></i>
                                        @endif
                                    </label>
                                </div>
                            @endforeach

                            @if(!$isCorrect && $question->explanation)
                                <div class="alert alert-warning mt-2">
                                    <strong>Explanation:</strong> {{ $question->explanation }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('quiz.results', $quiz->id) }}" class="btn btn-secondary">
                        Back to Results
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
