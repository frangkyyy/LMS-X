<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">

{{--        @include('components.mode_konstruksi')--}}

        <!-- IoT Introduction Image -->
        <div class="card mt-3">
            <div class="card-body text-center">
                <img src="{{ asset('iot/iot.jpg') }}" class="img-fluid w-100" style="height: auto; max-height: 457px; object-fit: cover;" alt="Pengenalan IoT">
            </div>
        </div>

        <!-- Card untuk Nama Mata Kuliah -->
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="fw-bold">{{ $course->short_name ?? 'No Course Code' }} - {{ $course->full_name ?? 'No Course Name' }}</h2>
            </div>
        </div>

        <!-- Header Selamat Datang -->
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="fw-bold">Selamat Datang {{ Auth::user()->name ?? 'Mahasiswa' }}</h2>
            </div>
        </div>

        <style>
            .card-body i.fas.fa-book-open {
                font-size: 24px;
                margin-right: 15px;
                flex-shrink: 0;
                color: #28a745;
            }

            /* Style untuk hover */
            .section-title a {
                color: #000; /* Warna default hitam */
                text-decoration: none;
                transition: color 0.3s ease-in-out;
            }

            .section-title a:hover {
                color: #007bff; /* Warna biru saat hover */
            }
        </style>

        <!-- Card Deskripsi Mata Kuliah -->
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="text-primary fw-bold">General</h4>
                <br>
                <h5 class="fw-bold">Selamat Datang di {{ $course->short_name ?? 'No Course' }} {{ $course->full_name ?? 'No Course Name' }}</h5>
                <br>
                <p><strong>Mata Kuliah</strong> : {{ $course->full_name ?? 'No Course' }}</p>
                <p><strong>Kode</strong> : {{ $course->short_name ?? 'No Course Code' }}</p>
                <p><strong>Semester</strong> : {{ $course->semester ?? '-' }}</p>

                <p class="mt-3"><strong>Deskripsi Mata Kuliah</strong> : {{ $course->summary ?? '-' }}</p>
            </div>
        </div>

        <!-- Course Topics -->
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="fw-bold text-primary">Topik</h4>
                <div class="row">
                    @if($course->sections->isEmpty())
                        <p>Tidak ada topik yang tersedia untuk saat ini.</p>
                    @else
                        @foreach($course->sections as $section)
                            <div class="col-md-6 mb-4 d-flex">
                                <div class="card border rounded shadow-sm h-100 w-100">
                                    <div class="card-body d-flex align-items-center">
                                        <i class="fas fa-book-open text-success me-3" style="font-size: 24px;"></i>
                                        <div class="section-title">
                                            <h6 class="fw-bold">
                                                @if(Auth::check())
                                                    @if(Auth::user()->id_role == 2 || Auth::user()->id_role == 1)
                                                        <a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a>
                                                    @else
                                                        <a href="{{ route('topik.redirect', ['section_id' => $section->id]) }}">{{ $section->title }}</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}">Login untuk mengakses</a>
                                                @endif

                                            </h6>
                                            <p class="text-muted small mb-0">{{ $section->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
