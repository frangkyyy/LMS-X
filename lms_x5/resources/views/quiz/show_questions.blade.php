<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="fw-bold">{{ $quiz->name }}</h2>
                    <p>{{ $quiz->description }}</p>

                    <div class="alert alert-info">
                        <p><strong>Attempts:</strong> {{ $attemptsCount }} of {{ $maxAttempts == 0 ? 'Unlimited' : $maxAttempts }}</p>
                        @if($quiz->time_open || $quiz->time_close)
                            <p><strong>Time:</strong>
                                @if($quiz->time_open)
                                    {{ $quiz->time_open->format('d M Y H:i') }}
                                @else
                                    Immediately available
                                @endif
                                to
                                @if($quiz->time_close)
                                    {{ $quiz->time_close->format('d M Y H:i') }}
                                @else
                                    No time limit
                                @endif
                            </p>
                        @endif
                    </div>

                    @if(!$canAttempt)
                        <div class="alert alert-danger">
                            @if($attemptsCount >= $maxAttempts && $maxAttempts > 0)
                                You have reached the maximum number of attempts for this quiz.
                            @elseif($quiz->time_open && now() < $quiz->time_open)
                                This quiz is not yet available.
                            @elseif($quiz->time_close && now() > $quiz->time_close)
                                The time for this quiz has expired.
                            @endif
                        </div>
                    @else
                        <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                            @csrf

                            @foreach($questions as $index => $question)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {{ $question->question_text }}</h5>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_a" value="a" required>
                                        <label class="form-check-label" for="q{{ $question->id }}_a">
                                            A. {{ $question->options_a }}
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_b" value="b">
                                        <label class="form-check-label" for="q{{ $question->id }}_b">
                                            B. {{ $question->options_b }}
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_c" value="c">
                                        <label class="form-check-label" for="q{{ $question->id }}_c">
                                            C. {{ $question->options_c }}
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_d" value="d">
                                        <label class="form-check-label" for="q{{ $question->id }}_d">
                                            D. {{ $question->options_d }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Submit Answers</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
