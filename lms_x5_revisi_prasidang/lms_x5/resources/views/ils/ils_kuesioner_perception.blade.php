@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-gradient text-success mb-3">Gaya Belajar (ILS)</h1>
                    <div class="d-flex justify-content-center">
                        <div class="border-bottom border-success border-3" style="width: 100px;"></div>
                    </div>
                    <p class="lead text-muted mt-3">
                        Dimensi Persepsi: Bagaimana Anda menerima informasi?
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted">Dimensi Persepsi</small>
                        <small class="text-success">2/4</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card bg-light border-0 mb-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="text-success">Sensing vs Intuitive</h5>
                                <p class="mb-0">
                                    Dimensi ini menggambarkan bagaimana Anda menerima informasi:
                                    <span class="fw-bold">Sensing</span> (fakta konkret) atau
                                    <span class="fw-bold">Intuitive</span> (ide dan konsep abstrak).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questionnaire Form -->
                <form id="kuesionerForm" action="{{ route('ils.submit_perception') }}" method="POST" class="mb-4">
                    @csrf

                    @php
                        $questions = [
                            12 => "Saya lebih suka dianggap sebagai orang yang",
                            13 => "Jika saya menjadi seorang pengajar, saya lebih suka mengajar mata kuliah yang",
                            14 => "Saya merasa lebih mudah untuk",
                            15 => "Saat membaca buku nonfiksi, saya lebih suka",
                            16 => "Saya lebih suka konsep",
                            17 => "Saya lebih sering dianggap sebagai orang yang",
                            18 => "Saat membaca untuk hiburan, saya lebih suka penulis yang",
                            19 => "Ketika harus melakukan suatu tugas, saya lebih suka",
                            20 => "Saya lebih suka seseorang disebut sebagai",
                            21 => "Saya lebih suka mata kuliah yang menekankan",
                            22 => "Saat melakukan perhitungan panjang, saya lebih cenderung",
                        ];

                        $options = [
                            12 => ["A" => "Realistis", "B" => "Inovatif"],
                            13 => ["A" => "Berkaitan dengan fakta dan situasi nyata", "B" => "Berkaitan dengan ide dan teori"],
                            14 => ["A" => "Mempelajari fakta", "B" => "Mempelajari konsep"],
                            15 => ["A" => "Buku yang mengajarkan saya fakta baru atau cara melakukan sesuatu", "B" => "Buku yang memberikan saya ide-ide baru untuk dipikirkan"],
                            16 => ["A" => "Kepastian", "B" => "Teori"],
                            17 => ["A" => "Teliti terhadap detail pekerjaan saya", "B" => "Kreatif dalam menyelesaikan pekerjaan saya"],
                            18 => ["A" => "Menjelaskan sesuatu secara jelas dan langsung", "B" => "Menulis dengan cara yang kreatif dan menarik"],
                            19 => ["A" => "Menguasai satu cara untuk melakukannya", "B" => "Mencari cara-cara baru untuk melakukannya"],
                            20 => ["A" => "Masuk akal", "B" => "Imajinatif"],
                            21 => ["A" => "Materi konkret (fakta, data)", "B" => "Materi abstrak (konsep, teori)"],
                            22 => ["A" => "Mengulangi semua langkah dan memeriksa pekerjaan saya dengan saksama", "B" => "Merasa bosan memeriksa pekerjaan saya dan harus memaksakan diri untuk melakukannya"],
                        ];
                    @endphp

                    @foreach ($questions as $key => $text)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title text-success mb-4">
                                    <span class="text-success fw-bold me-2">{{ $key }}.</span>
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
                        <button type="submit" id="submitButton" class="btn btn-success btn-lg px-4 py-2 shadow" disabled>
                            <i class="fas fa-arrow-right me-2"></i> Selanjutnya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
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
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
        }

        .custom-option .form-check-input:checked + .form-check-label .radio-circle {
            background-color: #10b981;
            border-color: #10b981;
        }

        .custom-option .form-check-label:hover {
            background-color: rgba(16, 185, 129, 0.05);
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
                    submitButton.classList.add("btn-success");
                } else {
                    submitButton.classList.remove("btn-success");
                    submitButton.classList.add("btn-secondary");
                }
            }
        });
    </script>
@endsection
