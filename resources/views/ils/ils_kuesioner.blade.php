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
                        Kuesioner Index of Learning Styles (ILS) - 44 Pertanyaan
                    </p>
                </div>

                <!-- Info Card -->
                <div class="card bg-light border-0 mb-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-primary">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="text-primary">Petunjuk Pengisian</h5>
                                <p class="mb-0">
                                    Pilihlah salah satu opsi (A atau B) yang paling menggambarkan cara belajar Anda.
                                    Tidak ada jawaban yang benar atau salah. Jawablah dengan jujur sesuai dengan
                                    kebiasaan belajar Anda yang sebenarnya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questionnaire Form -->
                <form id="kuesionerForm" action="{{ route('ils.submit_all') }}" method="POST" class="mb-4">
                    @csrf

                    @php
                        // Gabungkan semua pertanyaan dari 4 dimensi
                        $allQuestions = [
                            // Dimensi Pemrosesan (1-11)
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
                            11 => "Gagasan untuk mengerjakan tugas dalam kelompok dengan satu nilai untuk seluruh kelompok",

                            // Dimensi Persepsi (12-22)
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

                            // Dimensi Input (23-33)
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
                            33 => "Saya membayangkan tempat yang pernah saya kunjungi dengan",

                            // Dimensi Pemahaman (34-44)
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
                            44 => "Saat menyelesaikan masalah dalam kelompok, saya lebih cenderung",
                        ];

                        // Opsi jawaban untuk semua pertanyaan
                        $allOptions = [
                            // Dimensi Pemrosesan (1-11)
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

                            // Dimensi Persepsi (12-22)
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

                            // Dimensi Input (23-33)
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
                            33 => ["A" => "Mudah dan cukup akurat", "B" => "Sulit dan kurang detail"],

                            // Dimensi Pemahaman (34-44)
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
                            44 => ["A" => "Memikirkan langkah-langkah penyelesaiannya", "B" => "Memikirkan konsekuensi atau penerapan solusi dalam berbagai situasi"],
                        ];

                        // Acak urutan pertanyaan dengan seed berdasarkan user ID
                        $userId = auth()->id();
                        $shuffledQuestions = $allQuestions;

                        // Gunakan user ID sebagai seed untuk randomizer agar konsisten
                        srand($userId);
                        uasort($shuffledQuestions, function() { return rand() - getrandmax() / 2; });
                    @endphp

                    @foreach ($shuffledQuestions as $key => $text)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title text-primary mb-4">
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
                                                {{ $allOptions[$key]['A'] }}
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
                                                {{ $allOptions[$key]['B'] }}
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" id="submitButton" class="btn btn-primary btn-lg px-4 py-2 shadow" disabled>
                            <i class="fas fa-check-circle me-2"></i> Kirim Jawaban
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
