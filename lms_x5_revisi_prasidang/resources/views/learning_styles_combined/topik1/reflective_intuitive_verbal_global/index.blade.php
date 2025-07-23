<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">

        <!-- Informasi Course -->
        <div class="card mb-4">
            <div class="card-header">
                <h1>{{ $course->full_name }}</h1>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $course->summary }}</p>
                <p class="card-text">{{ $course->cpmk }}</p>
            </div>
        </div>

        <!-- Informasi Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ $section->title }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $section->description }}</p>
                <p class="card-text">{{ $section->sub_cpmk }}</p>
            </div>
        </div>

        <!-- Learning Style Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Your Learning Style</h5>
            </div>
            <div class="card-body">
                @foreach($scores as $dimension => $score)
                    <div class="mb-3">
                        <h6>{{ $dimension }}: {{ $score['label'] }} ({{ $score['category'] }})</h6>
                        <p>{{ $descriptions[$dimension][$score['label']][$score['category']] ?? 'No description available' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sub Topics -->
        @if($section->sub_topic->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Sub Materi
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($section->sub_topic as $subTopic)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $subTopic->title }}</h6>
                                </div>
                                <div class="card-body">
                                    {{ $subTopic->content }}

                                    <!-- Reflective Materials for this sub-topic -->
                                    @if($reflectiveAssignments->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $reflectiveForum->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $reflectiveLesson->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $reflectiveQuiz->where('sub_topic_id', $subTopic->id)->count() > 0)
                                        <div class="card mb-3 mt-3">
                                            <div class="card-header bg-primary text-white">
                                                <h6>Reflective Learning Materials</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($reflectiveAssignments->where('sub_topic_id', $subTopic->id) as $assignment)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Assignment: {{ $assignment->name }}</h6>
                                                        <p>{{ $assignment->intro }}</p>
                                                        {{-- Uncomment and adjust route if needed --}}
                                                        {{-- <a href="{{ route('assignments.show', $assignment->id) }}" class="btn btn-sm btn-primary">View Assignment</a> --}}
                                                    </div>
                                                @endforeach

                                                @foreach($reflectiveForum->where('sub_topic_id', $subTopic->id) as $forum)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Forum: {{ $forum->name }}</h6>
                                                        <p>{{ $forum->intro }}</p>
                                                        <a href="{{ route('forums.show', $forum->id) }}" class="btn btn-sm btn-primary">View Forum</a>
                                                    </div>
                                                @endforeach

                                                @foreach($reflectiveLesson->where('sub_topic_id', $subTopic->id) as $lesson)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Lesson: {{ $lesson->name }}</h6>
                                                        <p>{{ $lesson->intro }}</p>
                                                        <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-sm btn-primary">View Lesson</a>
                                                    </div>
                                                @endforeach

                                                @foreach($reflectiveQuiz->where('sub_topic_id', $subTopic->id) as $quiz)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Quiz: {{ $quiz->name }}</h6>
                                                        <p>{{ $quiz->intro }}</p>
                                                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-sm btn-primary">Take Quiz</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Intuitive Materials for this sub-topic -->
                                    @if($intuitive_materials->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $intuitivePage->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $intuitiveFiles->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $intuitiveFolder->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $intuitiveUrl->where('sub_topic_id', $subTopic->id)->count() > 0)
                                        <div class="card mb-3 mt-3">
                                            <div class="card-header bg-info text-white">
                                                <h6>Intuitive Learning Materials</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($intuitive_materials->where('sub_topic_id', $subTopic->id) as $material)
                                                    <div class="mb-3 p-3 border rounded">
                                                        {!! $material->content !!}
                                                    </div>
                                                @endforeach

                                                @foreach($intuitivePage->where('sub_topic_id', $subTopic->id) as $page)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Page: {{ $page->name }}</h6>
                                                        <div>{!! $page->content !!}</div>
                                                    </div>
                                                @endforeach

                                                @foreach($intuitiveFiles->where('sub_topic_id', $subTopic->id) as $file)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank">
                                                            <i class="fas
                                                                @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf
                                                                @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word
                                                                @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint
                                                                @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image
                                                                @else fa-file-alt @endif
                                                                me-2"></i>
                                                            {{ $file->name }}
                                                        </a>
                                                    </div>
                                                @endforeach

                                                @foreach($intuitiveFolder->where('sub_topic_id', $subTopic->id) as $folder)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Folder: {{ $folder->name }}</h6>
                                                        <p>{{ $folder->intro }}</p>
                                                    </div>
                                                @endforeach

                                                @foreach($intuitiveUrl->where('sub_topic_id', $subTopic->id) as $url)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <a href="{{ $url->externalurl }}" target="_blank">
                                                            <i class="fas fa-link me-2"></i>
                                                            {{ $url->name }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Verbal Materials for this sub-topic -->
                                    @if($verbalLabel->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $verbalFiles->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $verbalFolder->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $verbalUrl->where('sub_topic_id', $subTopic->id)->count() > 0)
                                        <div class="card mb-3 mt-3">
                                            <div class="card-header bg-success text-white">
                                                <h6>Verbal Learning Materials</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($verbalLabel->where('sub_topic_id', $subTopic->id) as $label)
                                                    <div class="mb-3 p-3 border rounded">
                                                        {!! $label->konten !!}
                                                    </div>
                                                @endforeach

                                                @foreach($verbalFiles->where('sub_topic_id', $subTopic->id) as $file)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank">
                                                            <i class="fas
                                                                @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf
                                                                @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word
                                                                @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint
                                                                @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image
                                                                @else fa-file-alt @endif
                                                                me-2"></i>
                                                            {{ $file->name }}
                                                        </a>
                                                    </div>
                                                @endforeach

                                                @foreach($verbalFolder->where('sub_topic_id', $subTopic->id) as $folder)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Folder: {{ $folder->name }}</h6>
                                                        <p>{{ $folder->intro }}</p>
                                                    </div>
                                                @endforeach

                                                @foreach($verbalUrl->where('sub_topic_id', $subTopic->id) as $url)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <a href="{{ $url->externalurl }}" target="_blank">
                                                            <i class="fas fa-link me-2"></i>
                                                            {{ $url->name }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Global Materials for this sub-topic -->
                                    @if($globalFiles->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalFolder->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalLabel->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalPage->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalUrl->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalAssignments->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalLesson->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalForum->where('sub_topic_id', $subTopic->id)->count() > 0 ||
                                        $globalQuiz->where('sub_topic_id', $subTopic->id)->count() > 0)
                                        <div class="card mb-3 mt-3">
                                            <div class="card-header bg-warning text-dark">
                                                <h6>Global Learning Materials</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($globalLabel->where('sub_topic_id', $subTopic->id) as $label)
                                                    <div class="mb-3 p-3 border rounded">
                                                        {!! $label->konten !!}
                                                    </div>
                                                @endforeach

                                                @foreach($globalFiles->where('sub_topic_id', $subTopic->id) as $file)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank">
                                                            <i class="fas
                                                                @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf
                                                                @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word
                                                                @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint
                                                                @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image
                                                                @else fa-file-alt @endif
                                                                me-2"></i>
                                                            {{ $file->name }}
                                                        </a>
                                                    </div>
                                                @endforeach

                                                @foreach($globalFolder->where('sub_topic_id', $subTopic->id) as $folder)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Folder: {{ $folder->name }}</h6>
                                                        <p>{{ $folder->intro }}</p>
                                                    </div>
                                                @endforeach

                                                @foreach($globalPage->where('sub_topic_id', $subTopic->id) as $page)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Page: {{ $page->name }}</h6>
                                                        <div>{!! $page->content !!}</div>
                                                    </div>
                                                @endforeach

                                                @foreach($globalUrl->where('sub_topic_id', $subTopic->id) as $url)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <a href="{{ $url->externalurl }}" target="_blank">
                                                            <i class="fas fa-link me-2"></i>
                                                            {{ $url->name }}
                                                        </a>
                                                    </div>
                                                @endforeach

                                                @foreach($globalAssignments->where('sub_topic_id', $subTopic->id) as $assignment)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Assignment: {{ $assignment->name }}</h6>
                                                        <p>{{ $assignment->intro }}</p>
                                                        {{-- Uncomment and adjust route if needed --}}
                                                        {{-- <a href="{{ route('assignments.show', $assignment->id) }}" class="btn btn-sm btn-primary">View Assignment</a> --}}
                                                    </div>
                                                @endforeach

                                                @foreach($globalForum->where('sub_topic_id', $subTopic->id) as $forum)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Forum: {{ $forum->name }}</h6>
                                                        <p>{{ $forum->intro }}</p>
                                                        <a href="{{ route('forums.show', $forum->id) }}" class="btn btn-sm btn-primary">View Forum</a>
                                                    </div>
                                                @endforeach

                                                @foreach($globalLesson->where('sub_topic_id', $subTopic->id) as $lesson)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Lesson: {{ $lesson->name }}</h6>
                                                        <p>{{ $lesson->intro }}</p>
                                                        <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-sm btn-primary">View Lesson</a>
                                                    </div>
                                                @endforeach

                                                @foreach($globalQuiz->where('sub_topic_id', $subTopic->id) as $quiz)
                                                    <div class="mb-3 p-3 border rounded">
                                                        <h6>Quiz: {{ $quiz->name }}</h6>
                                                        <p>{{ $quiz->intro }}</p>
                                                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-sm btn-primary">Take Quiz</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="mt-4">
            <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-secondary">Back to Course</a>
            @can('update', $section)
                <a href="{{ route('sections.edit', [$course->id, $section->id]) }}" class="btn btn-primary">Edit Section</a>
            @endcan
        </div>
    </div>
</div>
