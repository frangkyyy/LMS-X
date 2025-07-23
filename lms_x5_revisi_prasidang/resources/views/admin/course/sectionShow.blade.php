<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Course Information Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h1 class="mb-0">{{ $course->full_name }}</h1>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h5 class="text-muted">Summary</h5>
                    <p class="card-text">{{ $course->summary }}</p>
                </div>
                <div>
                    <h5 class="text-muted">CPMK</h5>
                    <p class="card-text">{{ $course->cpmk }}</p>
                </div>
            </div>
        </div>

        <!-- Section Information Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $section->title }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted">Description</h6>
                    <p class="card-text">{{ $section->description }}</p>
                </div>
                <div>
                    <h6 class="text-muted">Sub-CPMK</h6>
                    <p class="card-text">{{ $section->sub_cpmk }}</p>
                </div>
            </div>
        </div>

        <!-- Construction Mode Button -->
        <button id="modeKonstruksi" class="btn btn-primary mb-4 text-white rounded-pill px-4 py-2" style="background: linear-gradient(90deg, #4b6cb7, #182848); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">Mode Konstruksi</button>

        <!-- Subtopics Section -->
        @if($section->sub_topic->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Sub Materi</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($section->sub_topic as $subTopic)
                            <li class="list-group-item">
                                <!-- Subtopic Header -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 font-weight-bold">{{ $subTopic->title }}</h6>
                                    <div>
{{--                                        <!-- Edit Button -->--}}
{{--                                        <button class="btn btn-outline-warning btn-sm me-2"--}}
{{--                                                data-bs-toggle="modal"--}}
{{--                                                data-bs-target="#editSubTopicModal{{ $subTopic->id }}"--}}
{{--                                                title="Edit Subtopic">--}}
{{--                                            <i class="bi bi-pencil"></i>--}}
{{--                                        </button>--}}
{{--                                        <!-- Delete Button -->--}}
{{--                                        <button class="btn btn-outline-danger btn-sm"--}}
{{--                                                data-bs-toggle="modal"--}}
{{--                                                data-bs-target="#deleteSubTopicModal{{ $subTopic->id }}"--}}
{{--                                                title="Delete Subtopic">--}}
{{--                                            <i class="bi bi-trash"></i>--}}
{{--                                        </button>--}}
                                        <!-- Existing Button -->
                                        <button class="btn btn-outline-primary btn-sm gaya-belajar-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#learningStyleModal{{ $subTopic->id }}"
                                                style="display: none;">
                                            <i class="bi bi-plus"></i> Activity or Knowledge or Interactive
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtopic Content -->
                                <div class="mb-3">
                                    {{ $subTopic->content }}
                                </div>

                                <!-- Resources -->
                                @if($subTopic->labels->count() > 0 ||
                                    $subTopic->files->count() > 0 ||
                                    $subTopic->assignments->count() > 0 ||
                                    $subTopic->forums->count() > 0 ||
                                    $subTopic->lessons->count() > 0 ||
                                    $subTopic->urls->count() > 0)
                                    <div class="resources-container mb-3">

                                        <ul class="list-group">
                                            <!-- Labels -->
                                            @foreach($subTopic->labels as $label)
                                                <li class="list-group-item">{!! $label->konten !!}</li>
                                            @endforeach

                                            <!-- Files -->
                                            @foreach($subTopic->files as $file)
                                                <li class="list-group-item">
                                                    <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank" class="text-decoration-none">
                                                        <i class="fas
                                            @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf text-danger
                                            @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word text-primary
                                            @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint text-warning
                                            @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image text-success
                                            @else fa-file-alt @endif
                                            me-2"></i>
                                                        {{ $file->name }}
                                                    </a>
                                                </li>
                                            @endforeach

                                            <!-- Infografis -->
                                            @foreach($subTopic->infografis as $infografis)
                                                <a href="{{ asset($infografis->file_path) }}" target="_blank">
                                                    <i class="bi bi-file-earmark-text me-2"></i> {{ $infografis->name }}
                                                </a>
                                            @endforeach

                                            <!-- Assignments -->
                                            @foreach($subTopic->assignments as $assignment)
                                                <li class="list-group-item">
                                                    <div class="assignment-content">
                                                        <a href="{{ route('assignments.showAssignmentDosen', $assignment->id) }}"><strong>{!! $assignment->name !!}</strong></a>

                                                        <p class="mb-2">{!! $assignment->description !!}</p>
                                                        @if($assignment->due_date)
                                                            <div class="due-date-badge">
                                                    <span class="badge bg-warning text-dark p-2">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}
                                                    </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach

                                            <!-- Forums -->
                                            @foreach($subTopic->forums as $forum)
                                                <li class="list-group-item">
                                                    <strong>{!! $forum->name !!}</strong>
                                                    <p>{!! $forum->description !!}</p>
                                                </li>
                                            @endforeach

                                            <!-- Lessons -->
                                            @foreach($subTopic->lessons as $lesson)
                                                <li class="list-group-item">
                                                    <strong>{!! $lesson->name !!}</strong>
                                                    <p>{!! $lesson->description !!}</p>
                                                </li>
                                            @endforeach

                                            <!-- URLs -->
                                            @foreach($subTopic->urls as $url)
                                                <li class="list-group-item">
                                                    <strong>{!! $url->name !!}</strong>
                                                    <a href="{{ asset($url->url_link) }}" target="_blank" class="d-block text-truncate">
                                                        {!! $url->url_link !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="alert alert-info mb-3">
                                        No resources available for this subtopic.
                                    </div>
                                @endif

                                <!-- Pages -->
                                @if($subTopic->pages->count() > 0)
                                    <div class="pages-section mb-3">
                                        <h6 class="text-muted mb-2">Pages</h6>
                                        <ul class="list-group">
                                            @foreach($subTopic->pages as $page)
                                                <li class="list-group-item">
                                                    <a href="{{ route('pages.show', $page->id) }}" class="text-decoration-none">
                                                        <i class="bi bi-file-text me-2 text-primary"></i>
                                                        {!! $page->name !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Folders -->
                                @if($subTopic->folders->count() > 0)
                                    <div class="folders-section mb-3">
                                        <h6 class="text-muted mb-2">Folder</h6>
                                        <ul class="list-group">
                                            @foreach($subTopic->folders as $folder)
                                                <li class="list-group-item">
                                                    <a href="{{ route('folders.show', $folder->id) }}" class="text-decoration-none">
                                                        <i class="bi bi-folder me-2 text-primary"></i>
                                                        {!! $folder->name !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Quizzes -->
                                @if($subTopic->quizs->count() > 0)
                                    <div class="quizzes-section mb-3">
                                        <h6 class="text-muted mb-2">Quizzes</h6>
                                        <ul class="list-group">

                                            @foreach($subTopic->quizs as $quiz)
                                                <li class="list-group-item">
                                                    <a href="{{ route('quizs.show', $quiz->id) }}" class="text-decoration-none">
                                                        <i class="bi bi-tag me-2 text-danger"></i>
                                                        {!! $quiz->name !!}
                                                    </a>
                                                    <div class="d-flex gap-2">
                                                    <span class="badge bg-success">
                                                        Open: {{ \Carbon\Carbon::parse($quiz->time_open)->format('d M Y, H:i') }}
                                                    </span>
                                                        <span class="badge bg-warning text-dark">
                                                        Close: {{ \Carbon\Carbon::parse($quiz->time_close)->format('d M Y, H:i') }}
                                                    </span>
                                                    </div>
                                                </li>
                                            @endforeach


                                        </ul>
                                    </div>
                                @endif

                                <!-- Learning Style Modal -->
                                <div class="modal fade" id="learningStyleModal{{ $subTopic->id }}" tabindex="-1" aria-labelledby="learningStyleModalLabel{{ $subTopic->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="learningStyleModalLabel{{ $subTopic->id }}">Add an Activity or Resource for {{ $subTopic->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <ul class="nav nav-tabs mb-3" id="myTab{{ $subTopic->id }}" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="activity-tab{{ $subTopic->id }}" data-bs-toggle="tab" data-bs-target="#activity{{ $subTopic->id }}" type="button" role="tab" aria-controls="activity{{ $subTopic->id }}" aria-selected="true">ACTIVITY</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="interactive-tab{{ $subTopic->id }}" data-bs-toggle="tab" data-bs-target="#interactive{{ $subTopic->id }}" type="button" role="tab" aria-controls="interactive{{ $subTopic->id }}" aria-selected="false">INTERACTIVE</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="knowledge-tab{{ $subTopic->id }}" data-bs-toggle="tab" data-bs-target="#knowledge{{ $subTopic->id }}" type="button" role="tab" aria-controls="knowledge{{ $subTopic->id }}" aria-selected="false">KNOWLEDGE</button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent{{ $subTopic->id }}">
                                                    <div class="tab-pane fade show active" id="activity{{ $subTopic->id }}" role="tabpanel" aria-labelledby="activity-tab{{ $subTopic->id }}">
                                                        <div class="row">
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('assignments.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-file-earmark-text fs-3"></i><br>Assignment</a>
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-danger w-100">
                                                                    <a href={{ route('quizs.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-tag fs-3"></i><br>Quiz</a>
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-purple w-100">
                                                                    <a href={{ route('forums.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-people fs-3"></i><br>Forum</a>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="interactive{{ $subTopic->id }}" role="tabpanel" aria-labelledby="interactive-tab{{ $subTopic->id }}">
                                                        <div class="row">
{{--                                                            <div class="col-4 text-center mb-3">--}}
{{--                                                                <button class="btn btn-outline-success w-100">--}}
{{--                                                                    <i class="bi bi-boxes fs-3"></i><br>H5P--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-success w-100">
                                                                    <a href={{ route('lessons.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-easel fs-3"></i><br>Lesson</a>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="knowledge{{ $subTopic->id }}" role="tabpanel" aria-labelledby="knowledge-tab{{ $subTopic->id }}">
                                                        <div class="row">
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('folders.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-file-earmark fs-3"></i><br>Folder</a>
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('files.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-file-earmark fs-3"></i><br>File</a>
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('pages.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-file-earmark-richtext fs-3"></i><br>Page</a>
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('url.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-link fs-3"></i><br>URL</a>
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('labels.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-tag fs-3"></i><br>Label</a>
                                                                </button>
                                                            </div>

                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('infografis.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi-pie-chart"></i><br>Infografis</a>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- References Section -->
        @if($section->referensi->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">References</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($section->referensi as $referensi)
                            <li class="list-group-item">
                                <p class="mb-0">{{ $referensi->content }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Course
            </a>
            @can('update', $section)
                <a href="{{ route('sections.edit', [$course->id, $section->id]) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit Section
                </a>
            @endcan
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<!-- Keep the existing JavaScript exactly the same -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modeButton = document.getElementById('modeKonstruksi');
        const gayaBelajarButtons = document.querySelectorAll('.gaya-belajar-btn');
        const tambahResourceButtons = document.querySelectorAll('.tambah-resource-btn');
        let isEditMode = false;

        modeButton.addEventListener('click', function () {
            isEditMode = !isEditMode;
            modeButton.textContent = isEditMode ? 'Tutup Mode' : 'Mode Konstruksi';
            modeButton.style.transform = isEditMode ? 'scale(1.05)' : 'scale(1)';
            modeButton.style.boxShadow = isEditMode ? '0 6px 15px rgba(0, 0, 0, 0.3)' : '0 4px 12px rgba(0, 0, 0, 0.2)';

            gayaBelajarButtons.forEach(button => {
                button.style.display = isEditMode ? 'inline-block' : 'none';
            });

            tambahResourceButtons.forEach(button => {
                button.style.display = isEditMode ? 'inline-block' : 'none';
                button.style.transform = isEditMode ? 'scale(1.05)' : 'scale(1)';
                button.style.boxShadow = isEditMode ? '0 6px 15px rgba(0, 0, 0, 0.3)' : '0 4px 12px rgba(0, 0, 0, 0.2)';
            });
        });

        // Debugging untuk memastikan tombol Gaya Belajar diklik
        gayaBelajarButtons.forEach(button => {
            button.addEventListener('click', function () {
                console.log('Tombol Gaya Belajar diklik:', button.getAttribute('data-bs-target'));
            });
        });

        // Add hover effect for Forum button
        const forumButtons = document.querySelectorAll('.btn-outline-purple');
        forumButtons.forEach(button => {
            button.addEventListener('mouseover', function () {
                this.classList.remove('btn-outline-purple');
                this.classList.add('btn-purple', 'text-white');
                this.style.backgroundColor = '#6f42c1';
                this.style.borderColor = '#6f42c1';
            });
            button.addEventListener('mouseout', function () {
                this.classList.remove('btn-purple', 'text-white');
                this.classList.add('btn-outline-purple');
                this.style.backgroundColor = '';
                this.style.borderColor = '';
            });
        });
    });
</script>

<style>
    /* Additional styling for better organization */
    .card-header {
        padding: 1rem 1.5rem;
    }

    .list-group-item {
        padding: 1rem 1.5rem;
        border-left: 0;
        border-right: 0;
    }

    .resources-container {
        border: 1px solid #eee;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .assignment-content {
        padding: 0.5rem 0;
    }

    .due-date-badge {
        margin-top: 0.5rem;
    }

    .pages-section, .quizzes-section {
        margin-top: 1.5rem;
    }

    #modeKonstruksi {
        transition: all 0.3s ease;
    }

    #modeKonstruksi:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
</style>
