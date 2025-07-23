<div class="container mt-4">
    {{-- Selamat Datang & Gaya Belajar --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body text-center">
            <h2 class="fw-bold">👋 Selamat datang, {{ Auth::user()->name ?? 'Mahasiswa' }}!</h2>
            <h5 class="text-muted mt-2">Gaya Belajar Anda:</h5>
            <p class="fw-bold">
                {{ $scores['ACT/REF']['label'] ?? 'Active' }} ({{ $scores['ACT/REF']['category'] ?? 'Balanced' }}) –
                {{ $scores['SNS/INT']['label'] ?? 'Sensing' }} ({{ $scores['SNS/INT']['category'] ?? 'Balanced' }}) –
                {{ $scores['VIS/VRB']['label'] ?? 'Visual' }} ({{ $scores['VIS/VRB']['category'] ?? 'Balanced' }}) –
                {{ $scores['SEQ/GLO']['label'] ?? 'Sequential' }} ({{ $scores['SEQ/GLO']['category'] ?? 'Balanced' }})
            </p>
        </div>
    </div>

    <div class="row">
        {{-- Informasi Kursus --}}
        <div class="col-md-6 mb-4 d-flex">
            <div class="card shadow-sm h-100 w-100">
                <div class="card-header bg-primary text-white">📘 Informasi Kursus</div>
                <div class="card-body">
                    <p><strong>Nama Kursus:</strong> {{ $courses->first()->full_name ?? 'Nama Kursus Tidak Tersedia' }}</p>
                    <p><strong>Nama Kursus:</strong> {{ $courses->first()->full_name ?? 'Nama Kursus Tidak Tersedia' }}</p>
                    <p><strong>Total Materi & Quiz:</strong> 8 Bab, {{ $filteredQuizzes ?? 0 }} Quiz (Sesuai Gaya Belajar Anda)</p>
                    <p><strong>Status Kemajuan:</strong> ✔️ 5/8 Bab Selesai</p>
                    <p><strong>Skor Quiz Rata-rata:</strong> 85</p>
                </div>
            </div>
        </div>

        {{-- Materi yang Direkomendasikan --}}
        <div class="col-md-6 mb-4 d-flex">
            <div class="card shadow-sm h-100 w-100">
                <div class="card-header bg-success text-white">🧠 Materi yang Direkomendasikan</div>
                <div class="card-body">
                    <p>📺 <strong>Lanjutkan belajar:</strong> Video Sensor IoT</p>
                    <p>📄 <strong>Materi Sensing:</strong> PDF Panduan Praktikum</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">📂 Buka Materi Terakhir</a>
                </div>
            </div>
        </div>

        {{-- Quiz & Tugas Terbaru --}}
        <div class="col-md-6 mb-4 d-flex">
            <div class="card shadow-sm h-100 w-100">
                <div class="card-header bg-warning text-dark">📝 Tugas </div>
                <div class="card-body">
                    <ul class="list-group">
                        @php
                            $studentStyles = [];
                            foreach ($scores as $dimension => $score) {
                                $studentStyles[] = strtolower($score['label']);
                            }
                            $now = now();
                            $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
                            $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);
                        @endphp

                        @foreach ($assignments as $assignment)
                            @if(in_array(strtolower($assignment->learning_style), $studentStyles) || empty($assignment->learning_style))
                                @php
                                    // Extract numeric ID from topik (e.g., "topik5" → 5)
                                    $topicId = preg_replace('/[^0-9]/', '', $assignment->topik);
                                    $topicId = $topicId ?: '1'; // Default to 1 if no number found
                                @endphp

                                <a href="{{ route($styleSlug, [
                            'course_id' => $assignment->course_id,
                            'topik' => $topicId,
                            'section_id' => $topicId
                        ]) }}" class="text-decoration-none">
                                    <li class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>❗ {{ $assignment->name }}</strong>
                                                @if($assignment->topik)
                                                    <div class="text-muted small mt-1">Topik: {{ $assignment->topik }}</div>
                                                @endif
                                                @if($assignment->learning_style)
                                                    <div class="text-muted small">Gaya Belajar: {{ ucfirst($assignment->learning_style) }}</div>
                                                @endif
                                                <div class="small mt-1">
                                                    <strong>Batas Waktu:</strong>
                                                    {{ $assignment->due_date ? $assignment->due_date->format('d M Y H:i') : 'Tidak ada batas waktu' }}
                                                    @if($assignment->due_date && $assignment->due_date < $now)
                                                        <span class="badge bg-danger ms-2">Tidak bisa dikumpulkan</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-end">
                                        <span class="badge {{ $assignment->submission ? 'bg-success' : ($assignment->due_date && $assignment->due_date < $now ? 'bg-secondary' : 'bg-danger') }}">
                                            @if($assignment->submission)
                                                Sudah Dikumpulkan
                                            @elseif($assignment->due_date && $assignment->due_date < $now)
                                                Melewati Batas
                                            @else
                                                Belum Dikumpulkan
                                            @endif
                                        </span>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endif
                        @endforeach

                        @if(!$assignments->filter(function($item) use ($studentStyles) {
                            return in_array(strtolower($item->learning_style), $studentStyles) || empty($item->learning_style);
                        })->count())
                            <li class="list-group-item text-muted">Tidak ada tugas yang sesuai dengan gaya belajar Anda saat ini.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Quiz yang Tersedia --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">🧠 Quiz yang Tersedia (Sesuai Gaya Belajar Anda)</div>
                <div class="card-body p-0">
                    <ul class="list-group">
                        @php
                            // Get all quizzes that match the student's learning style or have no specific style
                            $quizzes = \App\Models\MDLQuiz::where(function($query) use ($studentStyles) {
                                $query->whereIn('learning_style', $studentStyles)
                                      ->orWhereNull('learning_style');
                            })->get();

                            // Get user's quiz attempts and grades
                            $userAttempts = \App\Models\MDLQuizAttempts::where('user_id', Auth::id())
                                ->pluck('quiz_id')
                                ->toArray();

                            $userGrades = \App\Models\MDLQuizGrades::where('user_id', Auth::id())
                                ->get()
                                ->groupBy('quiz_id');

                            // Get the user's learning style combination
                            $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
                            $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);
                        @endphp

                        @if($quizzes->count())
                            <div class="list-group list-group-flush">
                                @foreach($quizzes as $quiz)
                                    @php
                                        $hasAttempt = in_array($quiz->id, $userAttempts);
                                        $quizGrades = $userGrades->get($quiz->id, collect());
                                        $bestGrade = $quizGrades->max('grade');
                                        $now = now();
                                        $isAvailable = true;

                                        // Check time constraints
                                        if ($quiz->time_open && $now < $quiz->time_open) {
                                            $isAvailable = false;
                                        }
                                        if ($quiz->time_close && $now > $quiz->time_close) {
                                            $isAvailable = false;
                                        }

                                        // Check attempts
                                        $attemptsCount = $quizGrades->count();
                                        $canAttempt = $isAvailable && ($quiz->max_attempts == 0 || $attemptsCount < $quiz->max_attempts);

                                        // Extract topic number from quiz topic (e.g., "topik5" → 5)
                                        $topicId = preg_replace('/[^0-9]/', '', $quiz->topik);
                                        $topicId = $topicId ?: '1';
                                    @endphp

                                    <a href="{{ route($styleSlug, [
                            'course_id' => $quiz->course_id,
                            'topik' => $topicId,
                            'section_id' => $topicId
                        ]) }}#quiz-{{ $quiz->id }}" class="list-group-item list-group-item-action border-top-0 border-start-0 border-end-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $quiz->name }}</h6>
                                                @if($quiz->learning_style)
                                                    <small class="text-muted">Gaya Belajar: {{ ucfirst($quiz->learning_style) }}</small>
                                                @endif
                                                @if($quiz->topik)
                                                    <small class="text-muted d-block">Topik: {{ $quiz->topik }}</small>
                                                @endif
                                                @if($quiz->time_open || $quiz->time_close)
                                                    <small class="text-muted d-block">
                                                        Waktu:
                                                        @if($quiz->time_open)
                                                            {{ $quiz->time_open->format('d M H:i') }} -
                                                        @endif
                                                        @if($quiz->time_close)
                                                            {{ $quiz->time_close->format('d M H:i') }}
                                                        @else
                                                            Tidak ada batas waktu
                                                        @endif
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                @if($hasAttempt)
                                                    <span class="badge bg-success">Skor Terbaik: {{ round($bestGrade, 1) }}%</span>
                                                    <small class="d-block mt-1">{{ $attemptsCount }}/{{ $quiz->max_attempts == 0 ? '∞' : $quiz->max_attempts }} percobaan</small>
                                                @elseif($canAttempt)
                                                    <span class="badge bg-primary">Mulai Quiz</span>
                                                @elseif(!$isAvailable)
                                                    <span class="badge bg-secondary">Tidak tersedia</span>
                                                @else
                                                    <span class="badge bg-danger">Percobaan habis</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="p-3">
                                <p class="text-muted mb-0">Tidak ada quiz yang sesuai dengan gaya belajar Anda saat ini.</p>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>


        {{-- Forum Diskusi Terbaru --}}
        <div class="col-md-6 mb-4 d-flex">
            <div class="card shadow-sm h-100 w-100">
                <div class="card-header bg-info text-white">💬 Forum Diskusi (Sesuai Gaya Belajar Anda)</div>
                <div class="card-body">
                    @php
                        // Get student's learning style combination
                        $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
                        $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);

                        // Filter forums that match student's learning style or have no specific style
                        $filteredForums = $forums->filter(function($forum) use ($styleCombination) {
                            return empty($forum->learning_style) ||
                                   str_contains($styleCombination, strtolower($forum->learning_style));
                        });
                    @endphp

                    @if($filteredForums->count())
                        @foreach($filteredForums as $forum)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p>📢 <strong>Topik:</strong> {{ $forum->name }}</p>
                                        @if($forum->topik)
                                            <p class="text-muted small mb-1">Kategori: {{ $forum->topik }}</p>
                                        @endif
                                        @if($forum->learning_style)
                                            <p class="text-muted small">Gaya Belajar: {{ ucfirst($forum->learning_style) }}</p>
                                        @endif
                                    </div>
                                    @php
                                        // Extract numeric ID from topik if needed
                                        $topicId = $forum->section_id ?? preg_replace('/[^0-9]/', '', $forum->topik);
                                        $topicId = $topicId ?: '1';
                                    @endphp
                                    <a href="{{ route($styleSlug, [
                                'course_id' => $forum->course_id,
                                'topik' => $topicId,
                                'section_id' => $topicId
                            ]) }}#forum-{{ $forum->id }}" class="btn btn-outline-info btn-sm">💬 Lihat Forum</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Tidak ada forum yang sesuai dengan gaya belajar Anda.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Navigasi Cepat --}}
{{--        <div class="col-md-6 mb-4 d-flex">--}}
{{--            <div class="card shadow-sm h-100 w-100">--}}
{{--                <div class="card-header bg-dark text-white">🧭 Navigasi Cepat</div>--}}
{{--                <div class="card-body d-flex flex-wrap gap-2">--}}
{{--                    <a href="{{ route('course.index') }}" class="btn btn-outline-secondary w-100">📚 Materi</a>--}}
{{--                    <a href="#" class="btn btn-outline-secondary w-100">📝 Quiz</a>--}}
{{--                    <a href="#" class="btn btn-outline-secondary w-100">💬 Forum</a>--}}
{{--                    <a href="{{ route('profile') }}" class="btn btn-outline-secondary w-100">👤 Profil</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        {{-- Hasil Belajar / Progress --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">🧪 Hasil Belajar</div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-1">📘 Progress Materi: 62%</p>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: 62%">62%</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1">📊 Rata-rata Skor Quiz: 85%</p>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-info" style="width: 85%">85%</div>
                        </div>
                    </div>

                    <div>
                        <p class="mb-1">🕒 Aktivitas Terakhir:
                            @if(Auth::check() && Auth::user()->last_login_at)
                                {{ Auth::user()->last_login_at->setTimezone(config('app.timezone'))->format('d M Y H:i') }}
                            @else
                                Belum Pernah Login
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
