@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-gradient text-primary mb-3">Hasil Gaya Belajar Anda</h1>
                    <div class="d-flex justify-content-center">
                        <div class="border-bottom border-primary border-3" style="width: 100px;"></div>
                    </div>
                    <p class="lead text-muted mt-3">
                        Index of Learning Styles (ILS) - Hasil Analisis
                    </p>
                </div>

                <!-- Score Summary Cards -->
                <div class="row mb-5">
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Active/Reflective</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-around mb-3">
                                    <div>
                                        <h6 class="text-muted">Active</h6>
                                        <h3 class="fw-bold">{{ $scores['ACT/REF']['a_count'] ?? 0 }}</h3>
                                    </div>
                                    <div>
                                        <h6 class="text-muted">Reflective</h6>
                                        <h3 class="fw-bold">{{ $scores['ACT/REF']['b_count'] ?? 0 }}</h3>
                                    </div>
                                </div>
                                <span class="badge bg-primary-subtle text-primary fs-6">{{ $scores['ACT/REF']['final_score'] ?? '0A' }}</span>
                                <p class="mt-2 mb-0 fw-bold text-success">{{ $scores['ACT/REF']['category'] ?? 'Balanced' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Sensing/Intuitive</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-around mb-3">
                                    <div>
                                        <h6 class="text-muted">Sensing</h6>
                                        <h3 class="fw-bold">{{ $scores['SNS/INT']['a_count'] ?? 0 }}</h3>
                                    </div>
                                    <div>
                                        <h6 class="text-muted">Intuitive</h6>
                                        <h3 class="fw-bold">{{ $scores['SNS/INT']['b_count'] ?? 0 }}</h3>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fs-6">{{ $scores['SNS/INT']['final_score'] ?? '0A' }}</span>
                                <p class="mt-2 mb-0 fw-bold text-success">{{ $scores['SNS/INT']['category'] ?? 'Balanced' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Visual/Verbal</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-around mb-3">
                                    <div>
                                        <h6 class="text-muted">Visual</h6>
                                        <h3 class="fw-bold">{{ $scores['VIS/VRB']['a_count'] ?? 0 }}</h3>
                                    </div>
                                    <div>
                                        <h6 class="text-muted">Verbal</h6>
                                        <h3 class="fw-bold">{{ $scores['VIS/VRB']['b_count'] ?? 0 }}</h3>
                                    </div>
                                </div>
                                <span class="badge bg-info-subtle text-info fs-6">{{ $scores['VIS/VRB']['final_score'] ?? '0A' }}</span>
                                <p class="mt-2 mb-0 fw-bold text-success">{{ $scores['VIS/VRB']['category'] ?? 'Balanced' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0">Sequential/Global</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-around mb-3">
                                    <div>
                                        <h6 class="text-muted">Sequential</h6>
                                        <h3 class="fw-bold">{{ $scores['SEQ/GLO']['a_count'] ?? 0 }}</h3>
                                    </div>
                                    <div>
                                        <h6 class="text-muted">Global</h6>
                                        <h3 class="fw-bold">{{ $scores['SEQ/GLO']['b_count'] ?? 0 }}</h3>
                                    </div>
                                </div>
                                <span class="badge bg-warning-subtle text-warning fs-6">{{ $scores['SEQ/GLO']['final_score'] ?? '0A' }}</span>
                                <p class="mt-2 mb-0 fw-bold text-success">{{ $scores['SEQ/GLO']['category'] ?? 'Balanced' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Interpretation -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Interpretasi Gaya Belajar Anda</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach(['ACT/REF', 'SNS/INT', 'VIS/VRB', 'SEQ/GLO'] as $dimension)
                                <div class="col-md-6 mb-4">
                                    <div class="p-3 border rounded h-100">
                                        <h6 class="fw-bold text-uppercase mb-3">
                                            @switch($dimension)
                                                @case('ACT/REF') Active / Reflective @break
                                                @case('SNS/INT') Sensing / Intuitive @break
                                                @case('VIS/VRB') Visual / Verbal @break
                                                @case('SEQ/GLO') Sequential / Global @break
                                            @endswitch
                                        </h6>
                                        <p class="mb-2">
                                            <span class="fw-bold">Skor Anda:</span>
                                            <span class="badge bg-primary-subtle text-primary">{{ $scores[$dimension]['final_score'] ?? '0A' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <span class="fw-bold">Kategori:</span>
                                            <span class="badge bg-success-subtle text-success">{{ $scores[$dimension]['category'] ?? 'Balanced' }}</span>
                                        </p>
                                        <div class="progress mb-3" style="height: 10px;">
                                            @php
                                                $a = $scores[$dimension]['a_count'] ?? 0;
                                                $b = $scores[$dimension]['b_count'] ?? 0;
                                                $total = $a + $b;
                                                $a_percent = $total > 0 ? round(($a/$total)*100) : 50;
                                                $b_percent = $total > 0 ? round(($b/$total)*100) : 50;
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $a_percent }}%"
                                                 aria-valuenow="{{ $a_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $b_percent }}%"
                                                 aria-valuenow="{{ $b_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="small text-muted mb-0">
                                            @php
                                                $finalScore = $scores[$dimension]['final_score'] ?? '0A';
                                                preg_match('/\d+([A-Za-z]+)/', $finalScore, $matches);
                                                $style = $matches[1] ?? '';
                                            @endphp
                                            @switch($dimension)
                                                @case('ACT/REF')
                                                    @if (strtolower($style) === 'active')
                                                        <strong>Active:</strong> Anda cenderung belajar dengan mencoba langsung, berdiskusi, atau terlibat dalam aktivitas praktik. Anda suka belajar melalui pengalaman langsung dan kerja kelompok.
                                                    @else
                                                        <strong>Reflective:</strong> Anda lebih suka berpikir terlebih dahulu sebelum bertindak, merenung, dan memahami konsep sebelum mencobanya. Anda belajar lebih baik melalui waktu tenang dan refleksi pribadi.
                                                    @endif
                                                    @break

                                                @case('SNS/INT')
                                                    @if (strtolower($style) === 'sensing')
                                                        <strong>Sensing:</strong> Anda menyukai fakta konkret, detail, dan prosedur yang telah terbukti. Anda lebih nyaman dengan pembelajaran berbasis realita dan pengalaman praktis.
                                                    @else
                                                        <strong>Intuitive:</strong> Anda tertarik pada ide-ide baru, konsep, dan teori. Anda suka menemukan pola, memecahkan masalah abstrak, dan sering menyukai tantangan intelektual.
                                                    @endif
                                                    @break

                                                @case('VIS/VRB')
                                                    @if (strtolower($style) === 'visual')
                                                        <strong>Visual:</strong> Anda belajar lebih baik dengan gambar, diagram, grafik, atau video. Representasi visual membantu Anda memahami dan mengingat informasi dengan lebih mudah.
                                                    @else
                                                        <strong>Verbal:</strong> Anda lebih nyaman dengan penjelasan dalam bentuk tulisan atau lisan. Anda menyukai bacaan, diskusi verbal, dan penjelasan yang naratif.
                                                    @endif
                                                    @break

                                                @case('SEQ/GLO')
                                                    @if (strtolower($style) === 'sequential')
                                                        <strong>Sequential:</strong> Anda lebih suka belajar langkah demi langkah secara sistematis. Anda menyukai struktur yang jelas dan proses pembelajaran yang berurutan.
                                                    @else
                                                        <strong>Global:</strong> Anda memahami materi secara keseluruhan terlebih dahulu sebelum masuk ke detail. Anda belajar dalam lompatan besar dan terkadang tiba-tiba "menyadari" pemahaman menyeluruh.
                                        @endif
                                        @break
                                        @endswitch
                                        {{-- Tambahkan penjelasan kategori --}}
                                        @php
                                            $category = $scores[$dimension]['category'] ?? 'Balanced';
                                        @endphp
                                        @switch(strtolower($category))
                                            @case('balanced')
                                                <p class="mt-2 text-muted"><em>Kategori Balanced</em>: Anda memiliki preferensi yang seimbang di antara kedua gaya belajar pada dimensi ini. Anda dapat beradaptasi dengan berbagai metode pembelajaran.</p>
                                                @break

                                            @case('moderate')
                                                <p class="mt-2 text-muted"><em>Kategori Moderate</em>: Anda memiliki kecenderungan yang cukup jelas terhadap salah satu gaya belajar. Metode pembelajaran yang sesuai dengan gaya ini akan lebih efektif.</p>
                                                @break

                                            @case('strong')
                                                <p class="mt-2 text-muted"><em>Kategori Strong</em>: Anda memiliki preferensi yang sangat kuat terhadap salah satu gaya belajar. Pendekatan pembelajaran yang tidak sesuai mungkin terasa kurang nyaman.</p>
                                                @break

                                            @default
                                                <p class="mt-2 text-muted"><em>Kategori</em>: Informasi tidak tersedia.</p>
                                                @endswitch
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-home me-2"></i> Pergi ke Dashboard
                    </a>
{{--                    <button class="btn btn-outline-primary px-4 py-2 ms-2">--}}
{{--                        <i class="fas fa-download me-2"></i> Unduh Hasil--}}
{{--                    </button>--}}
                </div>
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

        .card-header {
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }

        .progress-bar:first-child {
            border-radius: 5px 0 0 5px;
        }

        .progress-bar:last-child {
            border-radius: 0 5px 5px 0;
        }
    </style>
@endsection
