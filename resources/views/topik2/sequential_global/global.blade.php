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

        <!-- Materi Reflective -->
        <div class="card mt-3">
            <div class="card-body">

                @if ($material)
                    <h4 class="fw-bold text-primary text-center">{{ $material->title ?? 'No Title' }}</h4>
                    <p>{{ $material->description ?? 'No Description' }}</p>
                @endif

                <hr>

                @php
                    $folderFiles = \App\Models\MDLFolder::where('course_id', $course->id)
                        ->where('learning_style', 'global')
                        ->where('topik', 'topik2')
                        ->where('type', 'global-folder')
                        ->get();

                    $shownInfo = []; // Menyimpan kombinasi name + description yang sudah ditampilkan
                @endphp

                @if ($folderFiles->count())
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="fw-bold text-primary">File</h4>
                            @foreach ($folderFiles as $pdf)
                                <div class="mt-4">
                                    <p>{!! nl2br(e($pdf->description ?? '-')) !!}</p>
                                    <h6 class="fw-bold">{{ $pdf->name ?? 'Modul' }}</h6>
                                    <a href="{{ asset($pdf->folder_path) }}" target="_blank" class="btn btn-outline-primary mt-2">
                                        📄 {{ $pdf->name ?? 'Lihat File' }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @endif

                @if ($course && $course->id)
                    @php
                        $globalFiles = \App\Models\MDLFiles::where('course_id', $course->id)
                            ->where('learning_style', 'global')
                            ->where('topik', 'topik2')
                            ->whereIn('type', ['global-pdf', 'global-link'])
                            ->get();
                    @endphp

                    {{--                        @if ($reflectiveFiles->count() > 0)--}}
                    {{--                            <div class="card mt-4">--}}
                    {{--                                <div class="card-body">--}}
                    {{--                                    <h4 class="fw-bold text-primary">Materi Tambahan (Reflective)</h4>--}}

                    {{--                                    <ul class="list-group">--}}
                    {{--                                        @foreach ($reflectiveFiles as $file)--}}
                    {{--                                            <li class="list-group-item">--}}
                    {{--                                                <strong>{{ $file->title ?? 'Untitled' }}</strong><br>--}}
                    {{--                                                <span class="text-dark">Nama File:</span> <em>{{ $file->name ?? '-' }}</em><br>--}}
                    {{--                                                <small class="text-muted">{{ $file->description ?? '-' }}</small><br>--}}

                    {{--                                                @if ($file->type === 'reflective-pdf')--}}
                    {{--                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">--}}
                    {{--                                                        Lihat PDF--}}
                    {{--                                                    </a>--}}
                    {{--                                                @elseif ($file->type === 'reflective-link')--}}
                    {{--                                                    <a href="{{ $file->file_path }}" target="_blank" class="btn btn-sm btn-outline-success mt-2">--}}
                    {{--                                                        Kunjungi Link--}}
                    {{--                                                    </a>--}}
                    {{--                                                @endif--}}
                    {{--                                            </li>--}}
                    {{--                                        @endforeach--}}
                    {{--                                    </ul>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        @else--}}
                    {{--                            <p class="text-muted mt-3">Tidak ada file reflective untuk topik ini.</p>--}}
                    {{--                        @endif--}}
                @endif

                @if ($globalFiles->count() > 0)
                    @foreach ($globalFiles as $file)
                        @if ($file->type === 'global-link')
                            <div class="mt-4">
                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-link text-primary mr-3"></i>
                                        <a href="{{ $file->file_path }}" target="_blank" class="btn btn-outline-info mt-2">
                                            🔗 {{ $file->name }}
                                        </a>
                                    </div>
                                </div>
                                @if (!empty($file->description))
                                    <p class="text-start fw-bold">{{ $file->description }}</p>
                                @endif
                            </div>
                            {{--                        @elseif ($file->type === 'visual-pdf')--}}
                            {{--                            <div class="d-flex flex-column mb-3">--}}
                            {{--                                <div class="d-flex align-items-center mb-2">--}}
                            {{--                                    <i class="fas fa-book text-primary mr-3"></i>--}}
                            {{--                                    <a href="{{ $file->file_path }}" target="_blank" class="btn btn-outline-info mt-2">--}}
                            {{--                                        🔗 Buka Materi: {{ $file->name }}--}}
                            {{--                                    </a>--}}
                            {{--                                </div>--}}

                            {{--                                @if (!empty($file->description))--}}
                            {{--                                    <p class="text-start fw-bold">{{ $file->description }}</p>--}}
                            {{--                                @endif--}}
                            {{--                            </div>--}}
                            {{--                        @endif--}}
                        @elseif ($file->type === 'global-pdf')
                            <div class="mt-4">
                                <h6 class="fw-bold">{{ $file->name ?? '' }}</h6>
                                <p class="text-start fw-bold">{{ $file->description ?? '' }}</p>
                                <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-outline-primary mt-2">
                                    📄 Buka PDF: {{ $file->name ?? 'Lihat File' }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                    {{--                @else--}}
                    {{--                    <p class="text-muted">Tidak ada materi yang tersedia untuk saat ini.</p>--}}
                @endif

                @php
                    $imageFiles = \App\Models\MDLFiles::where('course_id', $course->id)
                        ->where('learning_style', 'global')
                        ->where('topik', 'topik2')
                        ->where('type', 'global-image')
                        ->get();

                    $shownInfo = []; // Menyimpan kombinasi name + description yang sudah ditampilkan
                @endphp

                @if ($imageFiles->count() > 0)
                    @foreach ($imageFiles->groupBy(fn($item) => $item->name . '||' . $item->description) as $key => $group)
                        @php
                            [$name, $description] = explode('||', $key);
                        @endphp
                        <div class="mb-3">
                            @if (!empty($name))
                                <p class="text-start mt-2"><strong>{{ $name }}</strong></p>
                            @endif
                            @if (!empty($description))
                                <p>{!! nl2br(e($description)) !!}</p>
                            @endif

                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($group as $imageFile)
                                    @if (!empty($imageFile->file_path))
                                        <img src="{{ asset($imageFile->file_path) }}" alt="{{ $name }}" class="img-fluid" style="max-width: 250px;" />
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    {{--                @else--}}
                    {{--                    <p class="text-muted text-center">Tidak ada gambar untuk topik ini.</p>--}}
                @endif

                @php
                    // Mengambil file gambar dari mdl_files
                    $videoFiles = \App\Models\MDLFiles::where('course_id', $course->id)
                    ->where('learning_style', 'global')
                    ->where('topik', 'topik2')
                    ->where('type', 'global-video')
                    ->get();
                @endphp
                @if ($videoFiles->count() > 0)
                    <div class="mt-3">
                        <h5 class="fw-bold text-primary">Video Materi</h5>
                        <p class="fw-bold">{{ $videoFiles->first()->name ?? '-' }}</p>
                        <p>{!! nl2br(e($videoFiles->first()->description ?? '-')) !!}</p>
                        {{--                        <p class="fw-bold">{{ $videoFiles->first()->description ?? '-' }}</p>--}}

                        <div class="d-flex flex-wrap justify-content-start gap-3">
                            @foreach ($videoFiles as $file)
                                <div style="flex: 1 1 300px; max-width: 350px;">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $file->file_path }}" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{--                @else--}}
                    {{--                    <p class="text-muted">Tidak ada materi video untuk saat ini.</p>--}}
                @endif


                @php
                    $assignments = \App\Models\MDLAssign::where('course_id', $course->id)
                        ->where('learning_style', 'global')
                        ->where('topik', 'topik2')
                        ->get();
                @endphp
                @foreach($assignments as $assignment)
                    @php
                        $userSubmission = null;
                        $isLate = false;

                        if ($assignment) {
                            $userSubmission = \App\Models\MDLAssignSubmission::where('assign_id', $assignment->id)
                                ->where('user_id', Auth::id())
                                ->first();

                            $isLate = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($assignment->due_date));
                        }
                    @endphp

                    @if ($assignment)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $assignment->name }}</h4>
                                <p>{!! nl2br(e($assignment->description)) !!}</p>
                                <div class="mb-3">
                    <span class="badge bg-success me-2">
                        <strong>Due Date:</strong>
                        {{ \Carbon\Carbon::parse($assignment->due_date)->translatedFormat('l, d F Y, H:i') }}
                    </span>
                                </div>

                                @if ($userSubmission)
                                    <div class="alert alert-success">
                                        Anda telah mengumpulkan tugas ini.
                                        <br>
                                        <strong>Status:</strong> {{ ucfirst($userSubmission->status) }} <br>
                                        <strong>Waktu Submit:</strong> {{ \Carbon\Carbon::parse($userSubmission->created_at)->translatedFormat('d F Y, H:i') }} <br>
                                        <a href="{{ asset($userSubmission->file_path) }}" target="_blank" class="btn btn-sm btn-info mt-2">Lihat File</a>

                                        <form action="{{ route('assignment.cancel') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="submission_id" value="{{ $userSubmission->id }}">
                                            <button type="submit" class="btn btn-sm btn-warning mt-2" onclick="return confirm('Yakin ingin membatalkan pengumpulan tugas?')">Batalkan Pengumpulan</button>
                                        </form>
                                    </div>
                                @elseif ($isLate)
                                    <div class="alert alert-danger">
                                        Maaf, waktu pengumpulan tugas telah berakhir. Anda tidak dapat mengumpulkan tugas ini.
                                    </div>
                                @else
                                    <form action="{{ route('assignment.submit') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="assign_id" value="{{ $assignment->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                        <div class="mb-3">
                                            <label for="file_path" class="form-label">Upload Tugas (PDF/DOCX)</label>
                                            <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.docx" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kumpulkan Tugas</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach

                @if ($course && $course->id)
                        @php
                            $forum = \App\Models\MDLForum::where('course_id', $course->id)
                                ->where('learning_style', 'global')
                                ->where('topik', 'topik2')
                                ->with(['posts.user'])
                                ->first();
                        @endphp
                    @if ($forum)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $forum->name }}</h4>
                                <p>{!! nl2br(e($forum->description)) !!}</p>
                                {{--                                <p>{{ $forum->description }}</p>--}}

                                <hr>
                                @forelse ($forum->posts as $post)
                                    <div class="border p-3 rounded mb-3">
                                        <strong>{{ $post->user->first()->name ?? 'User Tidak Diketahui' }}</strong>
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

                    {{-- Quiz --}}
                    @php
                        $quiz = \App\Models\MDLQuiz::where('course_id', $course->id)
                            ->where('learning_style', 'global')
                            ->where('topik', 'topik2')
                            ->first();
                    @endphp

                    @if ($quiz)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $quiz->name }}</h4>
                                <p>{{ $quiz->description }}</p>
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
                                <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-success">Mulai Quiz</a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
