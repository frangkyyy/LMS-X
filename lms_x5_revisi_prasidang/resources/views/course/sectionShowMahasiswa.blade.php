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

        <!-- Progress Tracker Card -->
        <div class="card mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Progress Pembelajaran</h5>
                <div class="progress" style="width: 200px; height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%;"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
        </div>

        <!-- Sequential Subtopic Content -->
        <div id="subtopic-container">
            @if($section->sub_topic->count() > 0)
                <!-- First subtopic (always visible) -->
                <div class="subtopic-item" data-subtopic-id="{{ $section->sub_topic[0]->id }}" data-sequence="1">
                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 font-weight-bold">Sub Materi 1: {{ $section->sub_topic[0]->title }}</h6>
                            <div class="form-check">
                                <input class="form-check-input subtopic-checkbox" type="checkbox"
                                       id="subtopic-check-{{ $section->sub_topic[0]->id }}"
                                       data-next-subtopic="{{ $section->sub_topic[1]->id ?? '' }}">
                                <label class="form-check-label" for="subtopic-check-{{ $section->sub_topic[0]->id }}">
                                    Tandai Selesai
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                {{ $section->sub_topic[0]->content }}
                            </div>

                            @if($section->sub_topic[0]->labels->count() > 0 ||
                                $section->sub_topic[0]->files->count() > 0 ||
                                $section->sub_topic[0]->assignments->count() > 0 ||
                                $section->sub_topic[0]->forums->count() > 0 ||
                                $section->sub_topic[0]->lessons->count() > 0 ||
                                $section->sub_topic[0]->urls->count() > 0)
                                <div class="resources-container mb-3">
                                    <ul class="list-group">
                                        @foreach($section->sub_topic[0]->labels as $label)
                                            <li class="list-group-item">{!! $label->konten !!}</li>
                                        @endforeach

                                        @foreach($section->sub_topic[0]->files as $file)
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
                                        @foreach($section->sub_topic[0]->infografis as $infografis)
                                            <li class="list-group-item">
                                                <a href="{{ asset($infografis->file_path) }}" target="_blank">
                                                    <i class="bi bi-file-earmark-text me-2"></i> {{ $infografis->name }}
                                                </a>
                                            </li>
                                        @endforeach

                                        @foreach($section->sub_topic[0]->assignments as $assignment)
                                            <li class="list-group-item">
                                                <div class="assignment-content">
                                                    <a href="{{ route('assignments.showAssignment', $assignment->id) }}', $assignment->id) }}"><strong>{!! $assignment->name !!}</strong></a>
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

                                        @foreach($section->sub_topic[0]->forums as $forum)
                                            <li class="list-group-item">
                                                <strong>{!! $forum->name !!}</strong>
                                                <p>{!! $forum->description !!}</p>
                                            </li>
                                        @endforeach

                                        @foreach($section->sub_topic[0]->lessons as $lesson)
                                            <li class="list-group-item">
                                                <strong>{!! $lesson->name !!}</strong>
                                                <p>{!! $lesson->description !!}</p>
                                            </li>
                                        @endforeach

                                        @foreach($section->sub_topic[0]->urls as $url)
                                            <li class="list-group-item">
                                                <strong>{!! $url->name !!}</strong>
                                                <a href="{{ asset($url->url_link) }}" target="_blank" class="d-block text-truncate">
                                                    {!! $url->url_link !!}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($section->sub_topic[0]->pages->count() > 0)
                                <div class="pages-section mb-3">
                                    <h6 class="text-muted mb-2">Pages</h6>
                                    <ul class="list-group">
                                        @foreach($section->sub_topic[0]->pages as $page)
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

                            @if($section->sub_topic[0]->quizs->count() > 0)
                                <div class="quizzes-section mb-3">
                                    <h6 class="text-muted mb-2">Quizzes</h6>
                                    <ul class="list-group">
                                        @foreach($section->sub_topic[0]->quizs as $quiz)
                                            <li class="list-group-item">
                                                <a href="{{ route('quiz.showMahasiswa', $quiz->id) }}" class="text-decoration-none">
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
                        </div>
                    </div>
                </div>

                <!-- Hidden subtopics (will be shown sequentially) -->
                @for($i = 1; $i < $section->sub_topic->count(); $i++)
                    <div class="subtopic-item d-none" data-subtopic-id="{{ $section->sub_topic[$i]->id }}" data-sequence="{{ $i+1 }}">
                        <div class="card mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 font-weight-bold">Sub Materi {{ $i+1 }}: {{ $section->sub_topic[$i]->title }}</h6>
                                <div class="form-check">
                                    <input class="form-check-input subtopic-checkbox" type="checkbox"
                                           id="subtopic-check-{{ $section->sub_topic[$i]->id }}"
                                           data-next-subtopic="{{ $section->sub_topic[$i+1]->id ?? '' }}">
                                    <label class="form-check-label" for="subtopic-check-{{ $section->sub_topic[$i]->id }}">
                                        Tandai Selesai
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    {{ $section->sub_topic[$i]->content }}
                                </div>

                                @if($section->sub_topic[$i]->labels->count() > 0 ||
                                    $section->sub_topic[$i]->files->count() > 0 ||
                                    $section->sub_topic[$i]->assignments->count() > 0 ||
                                    $section->sub_topic[$i]->forums->count() > 0 ||
                                    $section->sub_topic[$i]->lessons->count() > 0 ||
                                    $section->sub_topic[$i]->urls->count() > 0)
                                    <div class="resources-container mb-3">
                                        <ul class="list-group">
                                            @foreach($section->sub_topic[$i]->labels as $label)
                                                <li class="list-group-item">{!! $label->konten !!}</li>
                                            @endforeach

                                            @foreach($section->sub_topic[$i]->files as $file)
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
                                            @foreach($section->sub_topic[$i]->infografis as $infografis)
                                                <li class="list-group-item">
                                                    <a href="{{ asset('storage/' . $infografis->file_path) }}" target="_blank">
                                                        <i class="bi bi-file-earmark-text me-2"></i> {{ $infografis->name }}
                                                    </a>
                                                </li>
                                            @endforeach

                                            @foreach($section->sub_topic[$i]->assignments as $assignment)
                                                <li class="list-group-item">
                                                    <div class="assignment-content">
                                                        <a href="/', $assignment->id) }}"><strong>{!! $assignment->name !!}</strong></a>
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

                                            @foreach($section->sub_topic[$i]->forums as $forum)
                                                <li class="list-group-item">
                                                    <strong>{!! $forum->name !!}</strong>
                                                    <p>{!! $forum->description !!}</p>
                                                </li>
                                            @endforeach

                                            @foreach($section->sub_topic[$i]->lessons as $lesson)
                                                <li class="list-group-item">
                                                    <strong>{!! $lesson->name !!}</strong>
                                                    <p>{!! $lesson->description !!}</p>
                                                </li>
                                            @endforeach

                                            @foreach($section->sub_topic[$i]->urls as $url)
                                                <li class="list-group-item">
                                                    <strong>{!! $url->name !!}</strong>
                                                    <a href="{{ asset($url->url_link) }}" target="_blank" class="d-block text-truncate">
                                                        {!! $url->url_link !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if($section->sub_topic[$i]->pages->count() > 0)
                                    <div class="pages-section mb-3">
                                        <h6 class="text-muted mb-2">Pages</h6>
                                        <ul class="list-group">
                                            @foreach($section->sub_topic[$i]->pages as $page)
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

                                @if($section->sub_topic[$i]->quizs->count() > 0)
                                    <div class="quizzes-section mb-3">
                                        <h6 class="text-muted mb-2">Quizzes</h6>
                                        <ul class="list-group">
                                            @foreach($section->sub_topic[$i]->quizs as $quiz)
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
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>

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

<!-- JavaScript for Sequential Subtopic Display -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtopicItems = document.querySelectorAll('.subtopic-item');
        const progressBar = document.querySelector('.progress-bar');
        const totalSubtopics = subtopicItems.length;
        let completedSubtopics = 0;
        let visibleSubtopics = 1; // Start with first subtopic visible

        // Initialize progress bar
        updateProgressBar();

        // Add event listeners to all checkboxes
        document.querySelectorAll('.subtopic-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const currentSubtopicId = this.closest('.subtopic-item').dataset.subtopicId;
                const currentSequence = parseInt(this.closest('.subtopic-item').dataset.sequence);
                const nextSubtopicId = this.dataset.nextSubtopic;

                if (this.checked) {
                    // Marking as complete
                    completedSubtopics++;

                    // Show next subtopic if exists
                    if (nextSubtopicId) {
                        const nextSubtopic = document.querySelector(`.subtopic-item[data-subtopic-id="${nextSubtopicId}"]`);
                        if (nextSubtopic) {
                            nextSubtopic.classList.add('animate__animated', 'animate__fadeIn');
                            setTimeout(() => {
                                nextSubtopic.classList.remove('d-none');
                                visibleSubtopics++;
                            }, 100);

                            // Scroll to next subtopic
                            setTimeout(() => {
                                nextSubtopic.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 500);
                        }
                    }
                } else {
                    // Unchecking
                    completedSubtopics--;

                    // Hide all subsequent subtopics if this was the last completed one
                    if (currentSequence === visibleSubtopics - 1) {
                        hideSubsequentSubtopics(currentSequence);
                    }
                }

                updateProgressBar();
            });
        });

        function updateProgressBar() {
            const progressPercentage = Math.round((completedSubtopics / totalSubtopics) * 100);
            progressBar.style.width = `${progressPercentage}%`;
            progressBar.setAttribute('aria-valuenow', progressPercentage);
            progressBar.textContent = `${progressPercentage}%`;

            // Change color based on progress
            if (progressPercentage < 30) {
                progressBar.classList.remove('bg-success', 'bg-warning');
                progressBar.classList.add('bg-danger');
            } else if (progressPercentage < 70) {
                progressBar.classList.remove('bg-danger', 'bg-success');
                progressBar.classList.add('bg-warning');
            } else {
                progressBar.classList.remove('bg-danger', 'bg-warning');
                progressBar.classList.add('bg-success');
            }
        }

        function hideSubsequentSubtopics(currentSequence) {
            const allSubtopics = document.querySelectorAll('.subtopic-item');
            allSubtopics.forEach(subtopic => {
                const sequence = parseInt(subtopic.dataset.sequence);
                if (sequence > currentSequence) {
                    subtopic.classList.add('d-none');
                    // Also uncheck any checked boxes in hidden subtopics
                    const checkbox = subtopic.querySelector('.subtopic-checkbox');
                    if (checkbox) checkbox.checked = false;
                }
            });
            visibleSubtopics = currentSequence;
        }
    });
</script>

<!-- Add Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

<!-- Add some custom styles -->
<style>
    .subtopic-item {
        transition: all 0.3s ease;
    }

    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    .card-header {
        padding: 1rem 1.5rem;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .subtopic-checkbox {
        transform: scale(1.3);
        cursor: pointer;
    }

    .animate__fadeIn {
        animation-duration: 0.5s;
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
</style>
