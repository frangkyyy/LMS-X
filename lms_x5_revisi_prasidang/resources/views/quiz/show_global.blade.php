@extends('layouts.v_template')

@section('content')
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Quiz: {{ $quiz->name }}</h2>
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
                <p class="text-warning">Quiz tidak memiliki jadwal buka/tutup yang ditentukan.</p>
            @endif
        </div>

        <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
            @csrf
            <div class="card shadow">
                <div class="card-body">
                    @foreach ($questions as $index => $question)
                        <div class="mb-4 border-bottom pb-3">
                            <h5 class="fw-semibold">{{ $index + 1 }}. {{ $question->question_text }}</h5>
                            @php
                                $options = [
                                    'A' => $question->options_a,
                                    'B' => $question->options_b,
                                    'C' => $question->options_c,
                                    'D' => $question->options_d,
                                ];
                            @endphp
                            @foreach ($options as $key => $option)
                                <div class="form-check">
                                    <input
                                        type="radio"
                                        id="option_{{ $key }}_{{ $question->id }}"
                                        name="answers[{{ $question->id }}]"
                                        value="{{ $key }}"
                                        class="form-check-input"
                                        required
                                    >
                                    <label class="form-check-label" for="option_{{ $key }}_{{ $question->id }}">
                                        {{ $key }}. {{ $option }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-success mt-3">Kirim Jawaban</button>
                </div>
            </div>
        </form>
    </div>
@endsection
