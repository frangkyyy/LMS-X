@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-gradient text-primary mb-3">Gaya Belajar (ILS)</h1>
                    <div class="d-flex justify-content-center">
                        <div class="border-bottom border-primary border-3" style="width: 100px;"></div>
                    </div>
                    <p class="lead text-muted mt-3">
                        Dimensi Pemrosesan: Bagaimana Anda memproses informasi?
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted">Dimensi Pemrosesan</small>
                        <small class="text-primary">1/4</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <h5 class="text-primary">Aktif vs Reflektif</h5>
                                <p class="mb-0">
                                    Dimensi ini menunjukkan bagaimana Anda memproses informasi:
                                    <span class="fw-bold">Aktif</span> (melakukan tindakan langsung) atau
                                    <span class="fw-bold">Reflektif</span> (merenung sebelum bertindak).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questionnaire Form -->
                <form id="kuesionerForm" action="{{ route('ils.submit_processing') }}" method="POST" class="mb-4">
                    @csrf

                    @php
                        $questions = [
                            1 => "Saya lebih memahami sesuatu setelah saya",
                            2 => "Saat mempelajari sesuatu yang baru, saya lebih terbantu jika saya",
                            3 => "Dalam kelompok belajar yang membahas materi sulit, saya lebih cenderung",
                            4 => "Dalam kelas yang pernah saya ambil",
                            5 => "Ketika mengerjakan tugas, saya lebih cenderung",
                            6 => "Saya lebih suka belajar",
                            7 => "Saya lebih suka terlebih dahulu",
                            8 => "Saya lebih mudah mengingat",
                            9 => "Saat bekerja dalam proyek kelompok, saya lebih suka",
                            10 => "Saya lebih cenderung dianggap sebagai orang yang",
                            11 => "Gagasan untuk mengerjakan tugas dalam kelompok dengan satu nilai untuk seluruh kelompok"
                        ];

                        $options = [
                            1 => ["A" => "Mencobanya langsung", "B" => "Memikirkannya dengan mendalam"],
                            2 => ["A" => "Membicarakannya", "B" => "Memikirkannya"],
                            3 => ["A" => "Langsung berkontribusi dengan ide-ide saya", "B" => "Duduk diam dan mendengarkan terlebih dahulu"],
                            4 => ["A" => "Saya biasanya mengenal banyak teman sekelas saya", "B" => "Saya jarang mengenal banyak teman sekelas saya"],
                            5 => ["A" => "Langsung mulai mengerjakan solusinya", "B" => "Memahami soal secara mendalam terlebih dahulu"],
                            6 => ["A" => "Dalam kelompok belajar", "B" => "Sendiri"],
                            7 => ["A" => "Mencoba langsung", "B" => "Memikirkan bagaimana saya akan melakukannya"],
                            8 => ["A" => "Sesuatu yang pernah saya lakukan", "B" => "Sesuatu yang sudah saya pikirkan dengan mendalam"],
                            9 => ["A" => "Memulai dengan sesi brainstorming bersama", "B" => "Berpikir sendiri terlebih dahulu, lalu berdiskusi dengan kelompok"],
                            10 => ["A" => "Supel dan mudah bergaul", "B" => "Pendiam dan tertutup"],
                            11 => ["A" => "Menarik bagi saya", "B" => "Tidak menarik bagi saya"],
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
            background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
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
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.05);
        }

        .custom-option .form-check-input:checked + .form-check-label .radio-circle {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .custom-option .form-check-label:hover {
            background-color: rgba(59, 130, 246, 0.05);
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
