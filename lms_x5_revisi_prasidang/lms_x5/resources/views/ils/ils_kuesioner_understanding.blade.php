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
                        Dimensi Pemahaman: Bagaimana Anda mengorganisasikan informasi?
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted">Dimensi Pemahaman</small>
                        <small class="text-primary">4/4</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <h5 class="text-primary">Sequential vs Global</h5>
                                <p class="mb-0">
                                    Dimensi ini menunjukkan bagaimana Anda memahami informasi:
                                    <span class="fw-bold">Sequential</span> (langkah demi langkah) atau
                                    <span class="fw-bold">Global</span> (gambaran besar terlebih dahulu).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questionnaire Form -->
                <form id="kuesionerForm" action="{{ route('ils.submit_understanding') }}" method="POST" class="mb-4">
                    @csrf

                    @php
                        $questions = [
                            34 => "Saya cenderung",
                            35 => "Saya akan lebih memahami sesuatu jika",
                            36 => "Ketika saya menyelesaikan soal matematika",
                            37 => "Saat menganalisis cerita atau novel",
                            38 => "Bagi saya, lebih penting jika seorang instruktur",
                            39 => "Saya belajar",
                            40 => "Saat mempertimbangkan informasi, saya lebih cenderung",
                            41 => "Ketika menulis sebuah esai atau makalah, saya lebih cenderung",
                            42 => "Ketika belajar subjek baru, saya lebih suka",
                            43 => "Beberapa dosen memulai kuliah mereka dengan membuat garis besar materi. Garis besar tersebut",
                            44 => "Saat menyelesaikan masalah dalam kelompok, saya lebih cenderung"
                        ];

                        $options = [
                            34 => ["A" => "Memahami detail suatu subjek tetapi mungkin bingung dengan gambaran keseluruhannya", "B" => "Memahami gambaran keseluruhan tetapi mungkin bingung dengan detailnya"],
                            35 => ["A" => "Saya memahami bagian-bagiannya terlebih dahulu, lalu melihat keseluruhannya", "B" => "Saya memahami keseluruhan terlebih dahulu, lalu melihat bagaimana bagian-bagiannya cocok"],
                            36 => ["A" => "Saya mengerjakan langkah-langkahnya satu per satu hingga menemukan jawaban", "B" => "Saya sering langsung melihat jawabannya tetapi harus berjuang untuk memahami langkah-langkahnya"],
                            37 => ["A" => "Saya berpikir tentang kejadian-kejadian dalam cerita dan mencoba menyusunnya untuk menemukan tema utama", "B" => "Saya langsung memahami tema utama saat selesai membaca, lalu harus kembali mencari kejadian yang mendukungnya"],
                            38 => ["A" => "Menjelaskan materi dalam langkah-langkah yang jelas dan berurutan", "B" => "Memberikan gambaran umum dan menghubungkannya dengan mata pelajaran lain"],
                            39 => ["A" => "Dengan ritme yang cukup teratur. Jika saya belajar dengan giat, saya akan memahaminya", "B" => "Secara tidak teratur. Awalnya saya bingung, lalu tiba-tiba semuanya terasa masuk akal"],
                            40 => ["A" => "Fokus pada detail tetapi melewatkan gambaran besar", "B" => "Mencoba memahami gambaran besar sebelum masuk ke detailnya"],
                            41 => ["A" => "Menulis dari awal hingga akhir secara berurutan", "B" => "Menulis bagian yang berbeda-beda terlebih dahulu, lalu menyusunnya nanti"],
                            42 => ["A" => "Fokus pada subjek tersebut dan mendalaminya", "B" => "Menghubungkannya dengan subjek lain yang terkait"],
                            43 => ["A" => "Cukup membantu saya", "B" => "Sangat membantu saya"],
                            44 => ["A" => "Memikirkan langkah-langkah penyelesaiannya", "B" => "Memikirkan konsekuensi atau penerapan solusi dalam berbagai situasi"]
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
                            <i class="fas fa-check-circle me-2"></i> Selesai
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
