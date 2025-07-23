<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">

        {{-- Info Mata Kuliah --}}
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="fw-bold">{{ $course->short_name ?? 'No Course Code' }} - {{ $course->full_name ?? 'No Course Name' }}</h2>
            </div>
        </div>

        {{-- Welcome --}}
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="fw-bold">Selamat Datang {{ Auth::user()->name ?? 'Mahasiswa' }}</h2>

                <div class="alert alert-info mt-2">
                    <h5 class="fw-bold">Profil Gaya Belajar Anda:</h5>
                    <ul>
                        {{-- Reflective --}}
                        <li>
                            {{ $scores['ACT/REF']['label'] ?? 'Reflective' }}
                            <strong>({{ $scores['ACT/REF']['category'] ?? 'Balanced' }})</strong> -
                            {{ $descriptions['ACT/REF']['Reflective'][$scores['ACT/REF']['category'] ?? 'Balanced'] ?? '' }}
                        </li>

                        {{-- Intuitive --}}
                        <li>
                            {{ $scores['SNS/INT']['label'] ?? 'Intuitive' }}
                            <strong>({{ $scores['SNS/INT']['category'] ?? 'Balanced' }})</strong> -
                            {{ $descriptions['SNS/INT']['Intuitive'][$scores['SNS/INT']['category'] ?? 'Balanced'] ?? '' }}
                        </li>

                        {{-- Visual --}}
                        <li>
                            {{ $scores['VIS/VRB']['label'] ?? 'Visual' }}
                            <strong>({{ $scores['VIS/VRB']['category'] ?? 'Balanced' }})</strong> -
                            {{ $descriptions['VIS/VRB']['Visual'][$scores['VIS/VRB']['category'] ?? 'Balanced'] ?? '' }}
                        </li>

                        {{-- Sequential --}}
                        <li>
                            {{ $scores['SEQ/GLO']['label'] ?? 'Sequential' }}
                            <strong>({{ $scores['SEQ/GLO']['category'] ?? 'Balanced' }})</strong> -
                            {{ $descriptions['SEQ/GLO']['Sequential'][$scores['SEQ/GLO']['category'] ?? 'Balanced'] ?? '' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Deskripsi Mata Kuliah --}}
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="text-primary fw-bold">Deskripsi Mata Kuliah</h4>
                <p><strong>Mata Kuliah</strong>: {{ $course->full_name ?? '-' }}</p>
                <p><strong>Kode</strong>: {{ $course->short_name ?? '-' }}</p>
                <p><strong>Semester</strong>: {{ $course->semester ?? '-' }}</p>
                <p class="mt-3"><strong>Deskripsi Mata Kuliah</strong> : {{ $course->summary ?? '-' }}</p>
            </div>
        </div>

        {{-- Materi Utama --}}
        <div class="card mt-3">
            <div class="card-body">

                @if ($section)
                    <h3 class="text-xl font-semibold mb-4 text-center text-indigo-700">
                        {{ $section->name }}
                    </h3>
                @endif

                {{-- === Materi Gabungan === --}}
                @if ($intuitive_materials->isNotEmpty())
                    @foreach ($intuitive_materials as $material)
                        <h4 class="fw-bold text-primary text-center">{{ $material->title }}</h4>
                        <p>{{ $material->description }}</p>
                    @endforeach
                @endif

                {{-- === Forum Diskusi === --}}
                @if ($forums)
                    @foreach ($forums as $forum)
                        <div class="mt-4">
                            <h4 class="fw-bold text-primary">{{ $forum->name }}</h4>
                            <p>{{ $forum->description }}</p>

                            @foreach ($forum->posts as $post)
                                <div class="border p-3 rounded mb-2">
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
                            @endforeach

                            <hr>
                            <form action="{{ route('forum.post.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="mb-3">
                                    <textarea name="content" class="form-control" rows="3" placeholder="Tulis komentar di sini..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    @endforeach
                @endif

                    {{-- === Files Reflective === --}}
                    @if ($reflective_files->count() > 0)
                        @foreach ($reflective_files as $file)
                            @if ($file->type === 'reflective-link')
                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-link text-primary mr-3"></i>
                                        <a href="{{ $file->file_path }}" target="_blank" class="btn btn-outline-info mt-2">
                                            🔗 {{ $file->name }}
                                        </a>
                                    </div>
                                    @if (!empty($file->description))
                                        <p class="text-start fw-bold">{{ $file->description }}</p>
                                    @endif
                                </div>
                            @elseif ($file->type === 'reflective-pdf')
                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-book text-primary mr-3"></i>
                                        <a href="{{ $file->file_path }}" target="_blank" class="btn btn-outline-info mt-2">
                                            🔗 Buka Materi: {{ $file->name }}
                                        </a>
                                    </div>

                                    @if (!empty($file->description))
                                        <p class="text-start fw-bold">{{ $file->description }}</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        {{--                @else--}}
                        {{--                    <p class="text-muted">Tidak ada materi yang tersedia untuk saat ini.</p>--}}
                    @endif

                    {{-- === Page Files Reflective === --}}
                    @if ($page_files_reflective->count() > 0)
                        <div class="card mt-4">
                            <div class="card-body">

                                @foreach ($page_files_reflective as $page)
                                    <div class="mb-4">
                                        <h5>{{ $page->name }}</h5>
                                        @if($page->description)
                                            <p class="mb-3">{!! nl2br(e($page->description)) !!}</p>
                                        @endif

                                        @if($page->file_path)
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset($page->file_path) }}"
                                                     alt="{{ $page->name }}"
                                                     class="img-fluid rounded shadow"
                                                     style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif

                                        @if($page->content)
                                            <div class="mt-3">
                                                {!! $page->content !!}
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- === Image Reflective === --}}
                    @if ($reflective_images->count() > 0)
                        @foreach ($reflective_images->groupBy(fn($item) => $item->name . '||' . $item->description) as $key => $group)
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
                                            <img src="{{ asset($imageFile->file_path) }}" alt="{{ $name }}" class="img-fluid" style="max-width: 300px;" />
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        {{--                @else--}}
                        {{--                    <p class="text-muted text-center">Tidak ada gambar untuk topik ini.</p>--}}
                    @endif

                    {{-- === Video Reflective === --}}
                    @if ($reflective_videos->count() > 0)
                        <div class="mt-3">
                            <h5 class="fw-bold text-primary">Video Materi</h5>
                            <p class="fw-bold">{{ $reflective_videos->first()->name ?? '-' }}</p>
                            <p class="fw-bold">{{ $reflective_videos->first()->description ?? '-' }}</p>

                            <div class="d-flex flex-wrap justify-content-start gap-3">
                                @foreach ($reflective_videos as $file)
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

                    {{-- === Assignment Reflective === --}}
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

                    {{-- === Forum Reflective === --}}
                    @if ($forums)
                        @foreach ($forums as $forum)
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h4 class="fw-bold text-primary">{{ $forum->name }}</h4>
                                    <p>{{ $forum->description }}</p>

                                    <hr>
                                    @forelse ($forum->posts as $post)
                                        <div class="border p-3 rounded mb-3">
                                            <strong>{{ $post->user->name ?? 'User Tidak Diketahui' }}</strong>
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
                        @endforeach
                    @endif

                    {{-- === Quiz Reflective === --}}
                    @if ($quiz)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $quiz->name }}</h4>
                                <p>{{ $quiz->description }}</p>

                                @if ($quiz->time_open && $quiz->time_close)
                                    <div class="mb-3">
                                    <span class="badge bg-success me-2">
                                        <strong>Opened:</strong> {{ \Carbon\Carbon::parse($quiz->time_open)->translatedFormat('l, d F Y, H.i A') }}
                                    </span>
                                        <span class="badge bg-success">
                                        <strong>Due:</strong> {{ \Carbon\Carbon::parse($quiz->time_close)->translatedFormat('l, d F Y, H.i A') }}
                                    </span>
                                    </div>
                                @endif

                                <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-success">Mulai Quiz</a>
                            </div>
                        </div>
                    @endif


                {{-- === PDF Materi Intuitive === --}}
                @if ($intuitive_files->count())
                    <div class="mt-4">
                        <h5 class="fw-bold text-primary">Materi PDF</h5>
                        @foreach ($intuitive_files as $pdf)
                            @if ($pdf->type === 'intuitive-link')
                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-link text-primary mr-3"></i>
                                        <a href="{{ $pdf->file_path }}" target="_blank" class="btn btn-outline-info mt-2">
                                            🔗 {{ $pdf->name }}
                                        </a>
                                    </div>
                                    @if (!empty($pdf->description))
                                        <p class="text-start fw-bold">{{ $pdf->description }}</p>
                                    @endif
                                </div>
                            @elseif ($pdf->type === 'intuitive-pdf')
                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-book text-primary mr-3"></i>
                                        <a href="{{ $pdf->file_path }}" target="_blank" class="btn btn-outline-info mt-2">
                                            🔗 Buka Materi: {{ $pdf->name }}
                                        </a>
                                    </div>

                                    @if (!empty($pdf->description))
                                        <p class="text-start fw-bold">{{ $pdf->description }}</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                    @if ($page_files_intuitive->count() > 0)
                        <div class="card mt-4">
                            <div class="card-body">

                                @foreach ($page_files_intuitive as $page)
                                    <div class="mb-4">
                                        <h5>{{ $page->name }}</h5>
                                        @if($page->description)
                                            <p class="mb-3">{!! nl2br(e($page->description)) !!}</p>
                                        @endif

                                        @if($page->file_path)
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset($page->file_path) }}"
                                                     alt="{{ $page->name }}"
                                                     class="img-fluid rounded shadow"
                                                     style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif

                                        @if($page->content)
                                            <div class="mt-3">
                                                {!! $page->content !!}
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @if ($intuitive_image->count() > 0)
                    @foreach ($intuitive_image->groupBy(fn($item) => $item->name . '||' . $item->description) as $key => $group)
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
                                        <img src="{{ asset($imageFile->file_path) }}" alt="{{ $name }}" class="img-fluid" style="max-width: 500px;" />
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    {{--                @else--}}
                    {{--                    <p class="text-muted text-center">Tidak ada gambar untuk topik ini.</p>--}}
                @endif

                @if ($intuitive_video->count() > 0)
                    <div class="mt-3">
                        <h5 class="fw-bold text-primary">Video Materi</h5>
                        <p class="fw-bold">{{ $intuitive_video->first()->name ?? '-' }}</p>
                        <p class="fw-bold">{{ $intuitive_video->first()->description ?? '-' }}</p>

                        <div class="d-flex flex-wrap justify-content-start gap-3">
                            @foreach ($intuitive_video as $file)
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

                @foreach($intuitive_assignments as $assignment)
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

                @if ($intuitive_forums)
                    @foreach ($intuitive_forums as $intuitive_forum)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $intuitive_forum->name }}</h4>
                                <p>{{ $intuitive_forum->description }}</p>

                                <hr>
                                @forelse ($intuitive_forum->posts as $post)
                                    <div class="border p-3 rounded mb-3">
                                        <strong>{{ $post->user->name ?? 'User Tidak Diketahui' }}</strong>
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
                    @endforeach
                @endif

                @if ($quiz_intuitives)
                    @foreach ($quiz_intuitives as $quiz_intuitive)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $quiz_intuitive->name }}</h4>
                                <p>{{ $quiz_intuitive->description }}</p>
                                @if ($quiz_intuitive->time_open && $quiz_intuitive->time_close)
                                    <div class="mb-3">
                                        <span class="badge bg-success me-2">
                                            <strong>Opened:</strong>
                                            {{ \Carbon\Carbon::parse($quiz_intuitive->time_open)->translatedFormat('l, d F Y, H.i A') }}
                                        </span>
                                        <span class="badge bg-success">
                                            <strong>Due:</strong>
                                            {{ \Carbon\Carbon::parse($quiz_intuitive->time_close)->translatedFormat('l, d F Y, H.i A') }}
                                        </span>
                                    </div>
                                @endif
                                <a href="{{ route('quiz.show', $quiz_intuitive->id) }}" class="btn btn-success">Mulai Quiz</a>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- === PDF Visual === --}}
                @if ($visual_pdfs->count())
                    <div class="card mt-3">
                        <div class="card-body">
                            @foreach ($visual_pdfs as $pdf)
                                @if ($pdf->type === 'visual-link')
                                    <div class="d-flex flex-column mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-link text-primary mr-3"></i>
                                            <a href="{{ $pdf->file_path }}" target="_blank" class="btn btn-outline-info mt-2">
                                                🔗 {{ $pdf->name }}
                                            </a>
                                        </div>
                                        @if (!empty($pdf->description))
                                            <p class="text-start fw-bold">{{ $pdf->description }}</p>
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
                                @elseif ($pdf->type === 'visual-pdf')
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">{{ $pdf->name }}</h5>
                                            @if (!empty($pdf->description))
                                                <p class="text-start fw-bold">{{ $pdf->description }}</p>
                                            @endif
                                            <embed src="{{ asset($pdf->file_path) }}" type="application/pdf" width="100%" height="600px">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                    @if ($page_files_visual->count() > 0)
                        <div class="card mt-4">
                            <div class="card-body">

                                @foreach ($page_files_visual as $page)
                                    <div class="mb-4">
                                        <h5>{{ $page->name }}</h5>
                                        @if($page->description)
                                            <p class="mb-3">{!! nl2br(e($page->description)) !!}</p>
                                        @endif

                                        @if($page->file_path)
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset($page->file_path) }}"
                                                     alt="{{ $page->name }}"
                                                     class="img-fluid rounded shadow"
                                                     style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif

                                        @if($page->content)
                                            <div class="mt-3">
                                                {!! $page->content !!}
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    @endif

                {{-- === Gambar Ilustrasi (Visual) === --}}
                @if ($visual_image->count() > 0)
                    @foreach ($visual_image->groupBy(fn($item) => $item->name . '||' . $item->description) as $key => $group)
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
                                        <img src="{{ asset($imageFile->file_path) }}" alt="{{ $name }}" class="img-fluid" style="max-width: 300px;" />
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    {{--                @else--}}
                    {{--                    <p class="text-muted text-center">Tidak ada gambar untuk topik ini.</p>--}}
                @endif

                {{-- === Video Pembelajaran (Visual) === --}}
                @if ($youtube_videos->count())
                    <h5 class="fw-bold text-primary mt-4">Video Pembelajaran</h5>
                    <p class="fw-bold">{{ $youtube_videos->first()->description ?? '-' }}</p>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($youtube_videos as $file)
                            <div style="flex: 1 1 300px; max-width: 350px;">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $file->file_path }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @foreach($visual_assignment as $assignment)
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

                    {{-- === Assignment (Visual) === --}}
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

                {{-- === Forum (Visual) === --}}
                @if ($visual_forums)
                    @foreach ($visual_forums as $visual_forum)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $visual_forum->name }}</h4>
                                <p>{!! nl2br(e($visual_forum->description)) !!}</p>
                                {{--                                <p>{{ $forum->description }}</p>--}}

                                <hr>
                                @forelse ($visual_forum->posts as $post)
                                    <div class="border p-3 rounded mb-3">
                                        <strong>{{ $post->user->name ?? 'User Tidak Diketahui' }}</strong>
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
                    @endforeach
                @endif

                {{-- === Quiz (Visual) === --}}
                @if ($quiz_visuals)
                    @foreach ($quiz_visuals as $quiz_visual)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $quiz_visual->name }}</h4>
                                <p>{{ $quiz_visual->description }}</p>
                                @if ($quiz_visual->time_open && $quiz_visual->time_close)
                                    <div class="mb-3">
                                        <span class="badge bg-success me-2">
                                            <strong>Opened:</strong>
                                            {{ \Carbon\Carbon::parse($quiz_visual->time_open)->translatedFormat('l, d F Y, H.i A') }}
                                        </span>
                                        <span class="badge bg-success">
                                            <strong>Due:</strong>
                                            {{ \Carbon\Carbon::parse($quiz_visual->time_close)->translatedFormat('l, d F Y, H.i A') }}
                                        </span>
                                    </div>
                                @endif
                                <a href="{{ route('quiz.show', $quiz_visual->id) }}" class="btn btn-success">Mulai Quiz</a>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- === Materi Sequential PDF === --}}
                @if ($sequential_pdfs->count())
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="fw-bold text-primary">Modul PDF</h4>
                            @foreach ($sequential_pdfs as $pdf)
                                <div class="mt-4">
                                    <h6 class="fw-bold">{{ $pdf->name ?? 'Modul' }}</h6>
                                    <a href="{{ asset($pdf->folder_path) }}" target="_blank" class="btn btn-outline-primary mt-2">
                                        📄 Buka PDF: {{ $pdf->name ?? 'Lihat File' }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                    {{-- === Page Files Sequential === --}}
                    @if ($page_files_sequential->count() > 0)
                        <div class="card mt-4">
                            <div class="card-body">

                                @foreach ($page_files_sequential as $page)
                                    <div class="mb-4">
                                        <h5>{{ $page->name }}</h5>
                                        @if($page->description)
                                            <p class="mb-3">{!! nl2br(e($page->description)) !!}</p>
                                        @endif

                                        @if($page->file_path)
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset($page->file_path) }}"
                                                     alt="{{ $page->name }}"
                                                     class="img-fluid rounded shadow"
                                                     style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif

                                        @if($page->content)
                                            <div class="mt-3">
                                                {!! $page->content !!}
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    @endif

                {{-- === Image Sequential === --}}
                @if ($sequential_image->count() > 0)
                    @foreach ($sequential_image->groupBy(fn($item) => $item->name . '||' . $item->description) as $key => $group)
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

                    {{-- === Page Files Sequential === --}}
                    @if ($page_files_sequential->count() > 0)
                        <div class="card mt-4">
                            <div class="card-body">

                                @foreach ($page_files_sequential as $page)
                                    <div class="mb-4">
                                        <h5>{{ $page->name }}</h5>
                                        @if($page->description)
                                            <p class="mb-3">{!! nl2br(e($page->description)) !!}</p>
                                        @endif

                                        @if($page->file_path)
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset($page->file_path) }}"
                                                     alt="{{ $page->name }}"
                                                     class="img-fluid rounded shadow"
                                                     style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif

                                        @if($page->content)
                                            <div class="mt-3">
                                                {!! $page->content !!}
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    @endif

                {{-- === Video Sequential === --}}
                @if ($sequential_video->count() > 0)
                    <div class="mt-3">
                        <h5 class="fw-bold text-primary">Video Materi</h5>
                        <p class="fw-bold">{{ $sequential_video->first()->name ?? '-' }}</p>
                        <p>{!! nl2br(e($sequential_video->first()->description ?? '-')) !!}</p>
                        {{--                        <p class="fw-bold">{{ $videoFiles->first()->description ?? '-' }}</p>--}}

                        <div class="d-flex flex-wrap justify-content-start gap-3">
                            @foreach ($sequential_video as $file)
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

                {{-- === Assignment Sequential === --}}
                @foreach($sequential_assignment as $assignment)
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

                {{-- === Forum Sequential === --}}
                @if ($sequential_forums)
                    @foreach ($sequential_forums as $sequential_forum)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">{{ $sequential_forum->name }}</h4>
                                <p>{!! nl2br(e($sequential_forum->description)) !!}</p>
                                {{--                                <p>{{ $forum->description }}</p>--}}

                                <hr>
                                @forelse ($sequential_forum->posts as $post)
                                    <div class="border p-3 rounded mb-3">
                                        <strong>{{ $post->user->name ?? 'User Tidak Diketahui' }}</strong>
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
                    @endforeach
                @endif

                {{-- === Quiz Sequential + Nilai === --}}
                @if ($quiz_sequential)
                    {{--                    @foreach ($quiz_sequentials as $quiz_sequential)--}}
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4 class="fw-bold text-primary">{{ $quiz_sequential->name }}</h4>
                            <p>{{ $quiz_sequential->description }}</p>

                            @if ($quiz_sequential->time_open && $quiz_sequential->time_close)
                                <div class="mb-3">
                                    <span class="badge bg-success me-2">
                                        <strong>Opened:</strong> {{ \Carbon\Carbon::parse($quiz_sequential->time_open)->translatedFormat('l, d F Y, H.i A') }}
                                    </span>
                                    <span class="badge bg-success">
                                        <strong>Due:</strong> {{ \Carbon\Carbon::parse($quiz_sequential->time_close)->translatedFormat('l, d F Y, H.i A') }}
                                    </span>
                                </div>
                            @endif

                            <a href="{{ route('quiz.sequential', $quiz_sequential->id) }}" class="btn btn-success">Mulai Quiz</a>

                            {{-- Attempt & Grade --}}
                            @if ($quiz_attempt || $quiz_grade)
                                <hr>
                                <h5 class="fw-bold mt-4">Hasil Quiz Anda</h5>
                                <ul class="list-group list-group-flush">
                                    @if ($quiz_attempt)
                                        <li class="list-group-item">
                                            <strong>Attempt ke-{{ $quiz_attempt->attempt }}</strong><br>
                                            Mulai: {{ \Carbon\Carbon::parse($quiz_attempt->start_time)->translatedFormat('d F Y H:i') }}<br>
                                            Selesai: {{ \Carbon\Carbon::parse($quiz_attempt->end_time)->translatedFormat('d F Y H:i') }}<br>
                                            Nilai: {{ $quiz_attempt->score ?? '-' }}
                                        </li>
                                    @endif

                                    @if ($quiz_grade)
                                        <li class="list-group-item">
                                            <strong>Grade Final:</strong> {{ $quiz_grade->grade ?? '-' }}<br>
                                            Attempt: {{ $quiz_grade->attempt_number ?? '-' }}<br>
                                            Diselesaikan: {{ \Carbon\Carbon::parse($quiz_grade->completed_at)->translatedFormat('d F Y H:i') }}
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                    {{--                    @endforeach--}}
                @endif

            </div>
        </div>
    </div>
</div>
