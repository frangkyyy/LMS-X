@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-gradient text-primary mb-3">Gaya Belajar Anda</h1>
                    <div class="d-flex justify-content-center">
                        <div class="border-bottom border-primary border-3" style="width: 100px;"></div>
                    </div>
                    <p class="lead text-muted mt-3">
                        Dimensi Input: Bagaimana Anda menerima informasi?
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted">Dimensi Input</small>
                        <small class="text-primary">3/4</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card bg-light border-0 mb-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-primary">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="text-primary">Visual vs Verbal</h5>
                                <p class="mb-0">
                                    Dimensi ini menjelaskan cara Anda menerima informasi:
                                    <span class="fw-bold">Visual</span> (grafik, diagram) atau
                                    <span class="fw-bold">Verbal</span> (penjelasan tertulis/lisan).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questionnaire Form -->
                <form id="kuesionerForm" action="{{ route('ils.submit_input') }}" method="POST" class="mb-4">
                    @csrf

                    @php
                        $questions = [
                            23 => "Saat memikirkan apa yang saya lakukan kemarin, saya lebih cenderung mengingat",
                            24 => "Saya lebih suka menerima informasi baru dalam bentuk",
                            25 => "Dalam buku yang berisi banyak gambar dan grafik, saya cenderung",
                            26 => "Saya lebih suka guru yang",
                            27 => "Saya lebih mudah mengingat",
                            28 => "Saat diberi petunjuk ke tempat baru, saya lebih suka",
                            29 => "Ketika melihat diagram atau sketsa di kelas, saya lebih mungkin mengingat",
                            30 => "Saat seseorang menunjukkan data kepada saya, saya lebih suka",
                            31 => "Saat bertemu orang baru di sebuah acara, saya lebih cenderung mengingat",
                            32 => "Untuk hiburan, saya lebih suka",
                            33 => "Saya membayangkan tempat yang pernah saya kunjungi dengan"
                        ];

                        $options = [
                            23 => ["A" => "Gambar atau visual", "B" => "Kata-kata atau narasi"],
                            24 => ["A" => "Gambar, diagram, grafik, atau peta", "B" => "Petunjuk tertulis atau informasi lisan"],
                            25 => ["A" => "Melihat gambar dan grafiknya dengan saksama", "B" => "Fokus pada teks tertulis"],
                            26 => ["A" => "Sering menggambar diagram di papan tulis", "B" => "Menghabiskan banyak waktu menjelaskan sesuatu"],
                            27 => ["A" => "Apa yang saya lihat", "B" => "Apa yang saya dengar"],
                            28 => ["A" => "Peta", "B" => "Instruksi tertulis"],
                            29 => ["A" => "Gambarnya", "B" => "Apa yang dikatakan oleh instruktur tentang diagram itu"],
                            30 => ["A" => "Diagram atau grafik", "B" => "Teks yang merangkum hasilnya"],
                            31 => ["A" => "Penampilan mereka", "B" => "Apa yang mereka katakan tentang diri mereka"],
                            32 => ["A" => "Menonton televisi", "B" => "Membaca buku"],
                            33 => ["A" => "Mudah dan cukup akurat", "B" => "Sulit dan kurang detail"]
                        ];
                    @endphp

                    @foreach ($questions as $key => $text)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title text-primary mb-4">
                                    <span class="text-primary fw-bold me-2">{{ $key }}.</span>
                                    {{ $text }}
                                </h5>

                                <div class="form-check custom-option mb-3">
                                    <input class="form-check-input" type="radio" name="q{{ $key }}" value="A" id="q{{ $key }}a">
                                    <label class="form-check-label w-100 p-3 rounded border" for="q{{ $key }}a">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="radio-circle"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <strong class="d-block">Opsi A</strong>
                                                {{ $options[$key]['A'] }}
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="form-check custom-option">
                                    <input class="form-check-input" type="radio" name="q{{ $key }}" value="B" id="q{{ $key }}b">
                                    <label class="form-check-label w-100 p-3 rounded border" for="q{{ $key }}b">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="radio-circle"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <strong class="d-block">Opsi B</strong>
                                                {{ $options[$key]['B'] }}
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" id="submitButton" class="btn btn-primary btn-lg px-4 py-2 shadow" disabled>
                            <i class="fas fa-arrow-right me-2"></i> Selanjutnya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(90deg, #6d28d9 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-option .form-check-input {
            opacity: 0;
            position: absolute;
        }

        .custom-option .form-check-label {
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-option .form-check-input:checked + .form-check-label {
            border-color: #6d28d9;
            background-color: rgba(109, 40, 217, 0.05);
        }

        .custom-option .form-check-input:checked + .form-check-label .radio-circle {
            background-color: #6d28d9;
            border-color: #6d28d9;
        }

        .custom-option .form-check-label:hover {
            background-color: rgba(109, 40, 217, 0.05);
        }

        .radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            transition: all 0.2s;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("kuesionerForm");
            const submitButton = document.getElementById("submitButton");
            const radioInputs = form.querySelectorAll("input[type='radio']");

            // Validate form on each change
            radioInputs.forEach(input => {
                input.addEventListener("change", validateForm);
            });

            // Initial validation
            validateForm();

            function validateForm() {
                const questionNames = new Set(
                    Array.from(radioInputs).map(input => input.name)
                );

                const allAnswered = Array.from(questionNames).every(name => {
                    return form.querySelector(`input[name="${name}"]:checked`);
                });

                submitButton.disabled = !allAnswered;

                if (allAnswered) {
                    submitButton.classList.remove("btn-secondary");
                    submitButton.classList.add("btn-primary");
                } else {
                    submitButton.classList.remove("btn-primary");
                    submitButton.classList.add("btn-secondary");
                }
            }
        });
    </script>
@endsection
