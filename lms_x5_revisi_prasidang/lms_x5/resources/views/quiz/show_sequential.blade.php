@extends('layouts.v_template')

@section('content')
    <div class="container mt-4">
        <h2 class="fw-bold">Quiz: {{ $quiz->name }}</h2>
        <p><strong>Deskripsi:</strong> {{ $quiz->description ?? 'Tidak ada deskripsi' }}</p>

        <div class="mb-4">
            @if ($quiz->time_open && $quiz->time_close)
                <span class="badge bg-success me-2">
                <strong>Opened:</strong> {{ \Carbon\Carbon::parse($quiz->time_open)->translatedFormat('l, d F Y, H.i A') }}
            </span>
                <span class="badge bg-danger">
                <strong>Due:</strong> {{ \Carbon\Carbon::parse($quiz->time_close)->translatedFormat('l, d F Y, H.i A') }}
            </span>
            @else
                <p>Quiz tidak memiliki jadwal buka/tutup yang ditentukan.</p>
            @endif
        </div>

        <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    @foreach ($questions as $index => $question)
                        <div class="mb-4">
                            <h5>{{ $index + 1 }}. {{ $question->question_text }}</h5>
                            <div class="form-check">
                                <input type="radio" id="option_a_{{ $question->id }}" name="answers[{{ $question->id }}]" value="A" class="form-check-input">
                                <label class="form-check-label" for="option_a_{{ $question->id }}">
                                    {{ $question->options_a }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="option_b_{{ $question->id }}" name="answers[{{ $question->id }}]" value="B" class="form-check-input">
                                <label class="form-check-label" for="option_b_{{ $question->id }}">
                                    {{ $question->options_b }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="option_c_{{ $question->id }}" name="answers[{{ $question->id }}]" value="C" class="form-check-input">
                                <label class="form-check-label" for="option_c_{{ $question->id }}">
                                    {{ $question->options_c }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="option_d_{{ $question->id }}" name="answers[{{ $question->id }}]" value="D" class="form-check-input">
                                <label class="form-check-label" for="option_d_{{ $question->id }}">
                                    {{ $question->options_d }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-success mt-4">Kirim Jawaban</button>
                </div>
            </div>
        </form>
    </div>
@endsection
