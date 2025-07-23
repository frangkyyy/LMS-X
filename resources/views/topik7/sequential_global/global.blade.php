<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">

        <div class="card mt-3">
            <div class="card-body">
                <h2 class="fw-bold">{{ $course->short_name ?? 'No Course Code' }} - {{ $course->full_name ?? 'No Course Name' }}</h2>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h2 class="fw-bold">Selamat Datang {{ Auth::user()->name ?? 'Mahasiswa' }}</h2>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h4 class="text-primary fw-bold">Deskripsi Mata Kuliah</h4>
                <p><strong>Mata Kuliah</strong>: {{ $course->full_name ?? '-' }}</p>
                <p><strong>Kode</strong>: {{ $course->short_name ?? '-' }}</p>
                <p><strong>Semester</strong>: {{ $course->semester ?? '-' }}</p>
                <p class="mt-3">{{ $course->summary ?? '-' }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @if ($material)
                    <h4 class="fw-bold text-primary text-center">{{ $material->title ?? 'No Title' }}</h4>
                    <p>{{ $material->description ?? 'No Description' }}</p>
                @endif

                <hr>

{{--                @if ($pdfs->count())--}}
{{--                    <div class="card mt-3">--}}
{{--                        <div class="card-body">--}}
{{--                            --}}{{--                                <h5 class="fw-bold text-primary">Materi PDF (Visual)</h5>--}}

{{--                            @foreach ($pdfs as $pdf)--}}
{{--                                <div class="mt-4">--}}
{{--                                    <h6 class="fw-bold">{{ $pdf->name ?? '' }}</h6>--}}
{{--                                    <p class="text-start fw-bold">{{ $pdf->description ?? '' }}</p>--}}
{{--                                    <iframe src="{{ asset($pdf->file_path) }}" width="100%" height="600px" style="border: none;" allowfullscreen></iframe>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}

                    @if ($videos->count() > 0)
                        <h5 class="fw-bold text-primary">Video Materi</h5>
                        @php
                            $description = $videos->first()->description ?? '-';
                        @endphp
                        <div class="mb-3">
                            @if ($description !== '-')
                                @php
                                    // Menghapus tanda tanya ganda dan karakter berlebihan
                                    $description = str_replace('??', '?', $description);
                                    $description = nl2br(e($description)); // Menambahkan breakline untuk baris baru
                                @endphp

                                <p>{!! $description !!}</p>
                            @else
                                <p class="text-muted">Deskripsi tidak tersedia.</p>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap justify-content-start gap-3">
                            @foreach ($videos as $video)
                                <div style="flex: 1 1 300px; max-width: 350px;">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $video->file_path }}" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada materi video untuk saat ini.</p>
                    @endif

                    @if ($files->count() > 0)
                        @foreach ($files as $file)
                            <div class="mt-4">
                                <h6 class="fw-bold">{{ $file->name ?? '' }}</h6>
                                <p class="text-start fw-bold">{{ $file->description ?? '' }}</p>
                                <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-outline-primary mt-2">
                                    📄 Buka Materi: {{ $file->name ?? 'Lihat File' }}
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Tidak ada materi yang tersedia untuk saat ini.</p>
                    @endif

                    {{-- Tampilkan Gambar jika ada --}}
                    @if ($image)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="fw-bold text-primary">{{ $image->name ?? '' }}</h5>
                                <img src="{{ asset($image->file_path) }}" alt="Ilustrasi Global"
                                     class="img-fluid rounded shadow w-75 mx-auto d-block">

                                <div class="text-start mt-3 fw-bold">
                                    @php
                                        $parts = preg_split('/(?=\s*\d+\.)|(?=Gambar ini)/', $image->description);
                                    @endphp

                                    @foreach ($parts as $part)
                                        <p>{{ trim($part) }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($forum)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $forum->name }}</h4>
                                <p>{{ $forum->description }}</p>

                                <hr>
                                @forelse ($forum->posts as $post)
                                    <div class="border p-3 rounded mb-3">
                                        <strong>{{ $post->user->name ?? 'User Tidak Diketahui' }}</strong> berkata:
                                        <p>{{ $post->content }}</p>

                                        @if ($post->user_id == auth()->id())
                                            <div class="mt-2">
                                                <a href="{{ route('forum-posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                                <form action="{{ route('forum-posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus komentar ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p>Belum ada postingan dalam forum ini.</p>
                                @endforelse
                            </div>
                        </div>

                        <hr>
                        <h5 class="fw-bold mt-4">Tulis Komentar Anda</h5>
                        <form action="{{ route('forum.post.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <div class="mb-3">
                                <textarea name="content" class="form-control" rows="3" placeholder="Tulis komentar di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    @endif

                    @if ($course && $course->id)
                        @php
                            $quiz = \App\Models\MDLQuiz::where('course_id', $course->id)
                                ->where('learning_style', 'global')
                                ->first();
                        @endphp

                        @if ($quiz)
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h4 class="fw-bold text-primary">{{ $quiz->name }}</h4>
                                    <p>{{ $quiz->description }}</p>

                                    {{-- Info waktu buka dan tutup quiz --}}
                                    @if ($quiz->time_open && $quiz->time_close)
                                        <div class="mb-3">
                    <span class="badge bg-success me-2">
                        <strong>Opened:</strong>
                        {{ \Carbon\Carbon::parse($quiz->time_open)->translatedFormat('l, d F Y, H.i A') }}
                    </span>
                                            <span class="badge bg-success">
                        <strong>Due:</strong>
                        {{ \Carbon\Carbon::parse($quiz->time_close)->translatedFormat('l, d F Y, H.i A') }}
                    </span>
                                        </div>
                                    @endif

                                    {{-- Tombol Mulai Quiz --}}
                                    <a href="{{ route('quiz.global', $quiz->id) }}" class="btn btn-success">Mulai Quiz</a>

                                    {{-- Menampilkan Data Attempt & Grade --}}
                                    @php
                                        $attempt = \App\Models\MDLQuizAttempts::where('quiz_id', $quiz->id)
                                            ->where('user_id', Auth::id())
                                            ->latest()
                                            ->first();

                                        $grade = \App\Models\MDLQuizGrades::where('quiz_id', $quiz->id)
                                            ->where('user_id', Auth::id())
                                            ->latest()
                                            ->first();
                                    @endphp

                                    @if ($attempt || $grade)
                                        <hr>
                                        <h5 class="fw-bold mt-4">Hasil Quiz Anda</h5>
                                        <ul class="list-group list-group-flush">
                                            @if ($attempt)
                                                <li class="list-group-item">
                                                    <strong>Attempt ke-{{ $attempt->attempt }}</strong><br>
                                                    Mulai: {{ \Carbon\Carbon::parse($attempt->start_time)->translatedFormat('d F Y H:i') }}<br>
                                                    Selesai: {{ \Carbon\Carbon::parse($attempt->end_time)->translatedFormat('d F Y H:i') }}<br>
                                                    Nilai: {{ $attempt->score ?? '-' }}
                                                </li>
                                            @endif

                                            @if ($grade)
                                                <li class="list-group-item">
                                                    <strong>Grade Final:</strong> {{ $grade->grade ?? '-' }}<br>
                                                    Attempt: {{ $grade->attempt_number ?? '-' }}<br>
                                                    Diselesaikan: {{ \Carbon\Carbon::parse($grade->completed_at)->translatedFormat('d F Y H:i') }}
                                                </li>
                                            @endif
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
            </div>
        </div>

    </div>
</div>
