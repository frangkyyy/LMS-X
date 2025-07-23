<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Course Information Card -->
        <div class="card mb-5 border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0 fs-2 fw-bold">{{ $course->full_name }}</h1>
                    <span class="badge bg-white text-primary fs-6">{{ $course->code ?? '' }}</span>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="bg-white p-3 rounded shadow-sm h-100">
                            <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Course Summary</h5>
                            <p class="card-text text-muted">{{ $course->summary }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="bg-white p-3 rounded shadow-sm h-100">
                            <h5 class="text-primary mb-3"><i class="fas fa-bullseye me-2"></i>CPMK</h5>
                            <p class="card-text text-muted">{{ $course->cpmk }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Information Card -->
        <div class="card mb-5 border-0 shadow-sm">
            <div class="card-header bg-gradient-secondary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-3 fw-bold"><i class="fas fa-book-open me-2"></i>{{ $section->title }}</h2>
                    <span class="badge bg-white text-secondary fs-6">Section</span>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="bg-white p-3 rounded shadow-sm h-100">
                            <h5 class="text-secondary mb-3"><i class="fas fa-align-left me-2"></i>Description</h5>
                            <p class="card-text text-muted">{{ $section->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="bg-white p-3 rounded shadow-sm h-100">
                            <h5 class="text-secondary mb-3"><i class="fas fa-bullseye me-2"></i>Sub-CPMK</h5>
                            <p class="card-text text-muted">{{ $section->sub_cpmk }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Tracker Card -->
        <div class="card mb-5 border-0 shadow-sm">
            <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-bottom">
                <h3 class="mb-0 text-dark"><i class="fas fa-chart-line me-2"></i>Learning Progress</h3>
                <div class="progress" style="width: 200px; height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
        </div>

        <!-- Subtopics Section -->
        @if($section->sub_topic->count() > 0)
            <div class="card mb-5 border-0 shadow-sm">
                <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h3 class="mb-0 text-dark"><i class="fas fa-layer-group me-2"></i>Subtopics</h3>
                </div>
                <div class="card-body p-0">
                    <div class="accordion accordion-flush" id="subtopicsAccordion">
                        <!-- First subtopic (always visible) -->
                        <div class="accordion-item border-0 mb-3 subtopic-item" data-subtopic-id="{{ $section->sub_topic[0]->id }}" data-sequence="1">
                            <div class="accordion-header bg-white rounded shadow-sm">
                                <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#subtopicCollapse{{ $section->sub_topic[0]->id }}"
                                        aria-expanded="true" aria-controls="subtopicCollapse{{ $section->sub_topic[0]->id }}">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <h5 class="mb-0 fw-bold text-dark">Sub Materi 1: {{ $section->sub_topic[0]->title }}</h5>
                                        <div class="form-check me-3 subtopic-checkbox-container d-none">
                                            <input class="form-check-input subtopic-checkbox" type="checkbox"
                                                   id="subtopic-check-{{ $section->sub_topic[0]->id }}"
                                                   data-next-subtopic="{{ $section->sub_topic[1]->id ?? '' }}">
                                            <label class="form-check-label" for="subtopic-check-{{ $section->sub_topic[0]->id }}">
                                                Mark as Complete
                                            </label>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div id="subtopicCollapse{{ $section->sub_topic[0]->id }}" class="accordion-collapse collapse show"
                                 aria-labelledby="subtopicHeading{{ $section->sub_topic[0]->id }}" data-bs-parent="#subtopicsAccordion">
                                <div class="accordion-body pt-4">
                                    <!-- Subtopic Content -->
                                    <div class="mb-4 p-3 bg-light rounded">
                                        <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Content</h6>
                                        <div class="p-3 bg-white rounded shadow-sm">
                                            {!! nl2br(e($section->sub_topic[0]->content)) !!}
                                        </div>
                                    </div>

                                    <!-- Resources -->
                                    @if($section->sub_topic[0]->labels->count() > 0 ||
                                        $section->sub_topic[0]->files->count() > 0 ||
                                        $section->sub_topic[0]->infografis->count() > 0 ||
                                        $section->sub_topic[0]->assignments->count() > 0 ||
                                        $section->sub_topic[0]->forums->count() > 0 ||
                                        $section->sub_topic[0]->lessons->count() > 0 ||
                                        $section->sub_topic[0]->urls->count() > 0 ||
                                        $section->sub_topic[0]->pages->count() > 0 ||
                                        $section->sub_topic[0]->quizs->count() > 0)
                                        <div class="resources-container mb-4">
                                            <h6 class="text-muted mb-3"><i class="fas fa-file-alt me-2"></i>Resources</h6>
                                            <div class="list-group">
                                                <!-- Input Dimension (Visual/Verbal) -->
                                                <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-eye me-2"></i>Input Dimension (Visual/Verbal)</h6>
                                                        <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#inputDimension0" aria-expanded="true" aria-controls="inputDimension0">
                                                            <i class="fas fa-chevron-down dimension-arrow"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="collapse show" id="inputDimension0">
                                                    @foreach($section->sub_topic[0]->files as $file)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank"
                                                               class="text-decoration-none d-flex align-items-center">
                                                                <i class="fas
                                                                    @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf text-danger
                                                                    @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word text-primary
                                                                    @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint text-warning
                                                                    @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image text-success
                                                                    @else fa-file-alt @endif
                                                                    me-3 fs-4"></i>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $file->name }}</h6>
                                                                    <small class="text-muted">{{ basename($file->file_path) }}</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->infografis as $infografis)
                                                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded shadow-sm bg-white">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas
                                                                    @if(Str::endsWith($infografis->file_path, ['.jpg', '.jpeg', '.png', '.drawio'])) fa-file-image text-success
                                                                    @else fa-file-alt @endif
                                                                    me-3 fs-4"></i>
                                                                <div>
                                                                    <small class="text-muted mb-2">Infographic</small>
                                                                    <div class="mt-2">
                                                                        <img src="{{ Storage::url('infografis/' . basename($infografis->file_path)) }}"
                                                                             alt="Infographic"
                                                                             class="img-fluid rounded"
                                                                             style="max-width: 300px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="infografisTools{{ $infografis->id }}" class="d-flex align-items-center gap-1 d-none"></div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->urls as $url)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="fas fa-link me-3 text-danger fs-4 mt-1"></i>
                                                                    <div>
                                                                        <h6 class="mb-1">{!! $url->name !!}</h6>
                                                                        <a href="{{ $url->url_link }}" target="_blank"
                                                                           class="d-block text-truncate text-muted">
                                                                            {!! $url->url_link !!}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->labels as $label)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-tag me-3 text-primary"></i>
                                                                    <span>{!! $label->konten !!}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->folders as $folder)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <a href="{{ route('folders.show', $folder->id) }}" class="text-decoration-none d-flex align-items-center">
                                                                <i class="fas fa-folder me-3 text-warning fs-4"></i>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $folder->name }}</h6>
                                                                    <small class="text-muted">Folder ({{ $folder->files_save->count() }} files)</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Perception Dimension (Sensing/Intuitive) -->
                                                <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-brain me-2"></i>Perception Dimension (Sensing/Intuitive)</h6>
                                                        <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#perceptionDimension0" aria-expanded="true" aria-controls="perceptionDimension0">
                                                            <i class="fas fa-chevron-down dimension-arrow"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="collapse show" id="perceptionDimension0">
                                                    @foreach($section->sub_topic[0]->pages as $page)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <a href="{{ route('pages.show', $page->id) }}"
                                                               class="text-decoration-none d-flex align-items-center">
                                                                <i class="fas fa-file-alt me-3 text-primary fs-4"></i>
                                                                <div>
                                                                    <h6 class="mb-0">{!! $page->name !!}</h6>
                                                                    <small class="text-muted">Page</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->files as $file)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank"
                                                               class="text-decoration-none d-flex align-items-center">
                                                                <i class="fas
                                                                    @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf text-danger
                                                                    @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word text-primary
                                                                    @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint text-warning
                                                                    @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image text-success
                                                                    @else fa-file-alt @endif
                                                                    me-3 fs-4"></i>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $file->name }}</h6>
                                                                    <small class="text-muted">{{ basename($file->file_path) }}</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->urls as $url)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="fas fa-link me-3 text-danger fs-4 mt-1"></i>
                                                                    <div>
                                                                        <h6 class="mb-1">{!! $url->name !!}</h6>
                                                                        <a href="{{ $url->url_link }}" target="_blank"
                                                                           class="d-block text-truncate text-muted">
                                                                            {!! $url->url_link !!}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->folders as $folder)
                                                        @if($folder->options->contains('mdl_learning_styles_id', 2))
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <a href="{{ route('folders.show', $folder->id) }}" class="text-decoration-none d-flex align-items-center">
                                                                    <i class="fas fa-folder me-3 text-warning fs-4"></i>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $folder->name }}</h6>
                                                                        <small class="text-muted">Folder ({{ $folder->files_save->count() }} files)</small>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <!-- Processing Dimension (Active/Reflective) -->
                                                <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-cogs me-2"></i>Processing Dimension (Active/Reflective)</h6>
                                                        <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#processingDimension0" aria-expanded="true" aria-controls="processingDimension0">
                                                            <i class="fas fa-chevron-down dimension-arrow"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="collapse show" id="processingDimension0">
                                                    @foreach($section->sub_topic[0]->lessons as $lesson)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="fas fa-book-open me-3 text-purple fs-4 mt-1"></i>
                                                                    <div>
                                                                        <h6 class="mb-1">{!! $lesson->name !!}</h6>
                                                                        <p class="mb-0 text-muted">{!! $lesson->description !!}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->forums as $forum)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="fas fa-comments me-3 text-info fs-4 mt-1"></i>
                                                                    <div>
                                                                        <a href="{{ route('forums.show', $forum->id) }}"
                                                                           class="text-decoration-none">
                                                                            <h6 class="mb-1">{!! $forum->name !!}</h6>
                                                                        </a>
                                                                        <p class="mb-0 text-muted">{!! $forum->description !!}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->assignments as $assignment)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="fas fa-tasks me-3 text-warning fs-4 mt-1"></i>
                                                                    <div>
                                                                        <a href="{{ route('assignments.showAssignment', $assignment->id) }}"
                                                                           class="text-decoration-none">
                                                                            <h6 class="mb-1">{!! $assignment->name !!}</h6>
                                                                        </a>
                                                                        <p class="mb-2 text-muted">{!! $assignment->description !!}</p>
                                                                        @if($assignment->due_date)
                                                                            <div class="due-date-badge">
                                                                                <span class="badge bg-warning text-dark p-2">
                                                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                                                    Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach($section->sub_topic[0]->quizs as $quiz)
                                                        <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2" data-quiz-id="{{ $quiz->id }}" data-completed="{{ $quiz->attempts()->where('user_id', Auth::id())->exists() ? 'true' : 'false' }}">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="fas fa-question-circle me-3 text-danger fs-4 mt-1"></i>
                                                                    <div>
                                                                        <a href="{{ route('quiz.showMahasiswa', $quiz->id) }}"
                                                                           class="text-decoration-none">
                                                                            <h6 class="mb-1">{!! $quiz->name !!}</h6>
                                                                        </a>
                                                                        <div class="d-flex gap-2 mt-2">
                                                                            <span class="badge bg-success">
                                                                                <i class="fas fa-door-open me-1"></i>
                                                                                {{ \Carbon\Carbon::parse($quiz->time_open)->format('d M Y, H:i') }}
                                                                            </span>
                                                                            <span class="badge bg-warning text-dark">
                                                                                <i class="fas fa-door-closed me-1"></i>
                                                                                {{ \Carbon\Carbon::parse($quiz->time_close)->format('d M Y, H:i') }}
                                                                            </span>
                                                                        </div>
                                                                        @if($quiz->attempts()->where('user_id', Auth::id())->exists())
                                                                            <span class="badge bg-success mt-2">
                                                                                <i class="fas fa-check-circle me-1"></i>
                                                                                Completed
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-danger mt-2">
                                                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                                                Not Completed
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info mb-3">
                                            <i class="fas fa-info-circle me-2"></i>No resources available for this subtopic.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Hidden subtopics -->
                        @for($i = 1; $i < $section->sub_topic->count(); $i++)
                            <div class="accordion-item border-0 mb-3 subtopic-item d-none" data-subtopic-id="{{ $section->sub_topic[$i]->id }}"
                                 data-sequence="{{ $i+1 }}">
                                <div class="accordion-header bg-white rounded shadow-sm">
                                    <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#subtopicCollapse{{ $section->sub_topic[$i]->id }}"
                                            aria-expanded="false" aria-controls="subtopicCollapse{{ $section->sub_topic[$i]->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h5 class="mb-0 fw-bold text-dark">Sub Materi {{ $i+1 }}: {{ $section->sub_topic[$i]->title }}</h5>
                                            <div class="form-check me-3 subtopic-checkbox-container d-none">
                                                <input class="form-check-input subtopic-checkbox" type="checkbox"
                                                       id="subtopic-check-{{ $section->sub_topic[$i]->id }}"
                                                       data-next-subtopic="{{ $section->sub_topic[$i+1]->id ?? '' }}">
                                                <label class="form-check-label" for="subtopic-check-{{ $section->sub_topic[$i]->id }}">
                                                    Mark as Complete
                                                </label>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <div id="subtopicCollapse{{ $section->sub_topic[$i]->id }}" class="accordion-collapse collapse"
                                     aria-labelledby="subtopicHeading{{ $section->sub_topic[$i]->id }}" data-bs-parent="#subtopicsAccordion">
                                    <div class="accordion-body pt-4">
                                        <!-- Subtopic Content -->
                                        <div class="mb-4 p-3 bg-light rounded">
                                            <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Content</h6>
                                            <div class="p-3 bg-white rounded shadow-sm">
                                                {!! nl2br(e($section->sub_topic[$i]->content)) !!}
                                            </div>
                                        </div>

                                        <!-- Resources -->
                                        @if($section->sub_topic[$i]->labels->count() > 0 ||
                                            $section->sub_topic[$i]->files->count() > 0 ||
                                            $section->sub_topic[$i]->infografis->count() > 0 ||
                                            $section->sub_topic[$i]->assignments->count() > 0 ||
                                            $section->sub_topic[$i]->forums->count() > 0 ||
                                            $section->sub_topic[$i]->lessons->count() > 0 ||
                                            $section->sub_topic[$i]->urls->count() > 0 ||
                                            $section->sub_topic[$i]->pages->count() > 0 ||
                                            $section->sub_topic[$i]->quizs->count() > 0)
                                            <div class="resources-container mb-4">
                                                <h6 class="text-muted mb-3"><i class="fas fa-file-alt me-2"></i>Resources</h6>
                                                <div class="list-group">
                                                    <!-- Input Dimension (Visual/Verbal) -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-eye me-2"></i>Input Dimension (Visual/Verbal)</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#inputDimension{{ $i }}" aria-expanded="true" aria-controls="inputDimension{{ $i }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="inputDimension{{ $i }}">
                                                        @foreach($section->sub_topic[$i]->files as $file)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank"
                                                                   class="text-decoration-none d-flex align-items-center">
                                                                    <i class="fas
                                                                        @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf text-danger
                                                                        @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word text-primary
                                                                        @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint text-warning
                                                                        @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image text-success
                                                                        @else fa-file-alt @endif
                                                                        me-3 fs-4"></i>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $file->name }}</h6>
                                                                        <small class="text-muted">{{ basename($file->file_path) }}</small>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->infografis as $infografis)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <i class="fas
                                                                                @if(Str::endsWith($infografis->file_path, ['.jpg', '.jpeg', '.png', '.drawio']))
                                                                                    fa-file-image text-success
                                                                                @else
                                                                                    fa-file-alt
                                                                                @endif
                                                                                me-3 fs-4">
                                                                </i>
                                                                <div class="w-100">
                                                                    <small class="text-muted mb-2">Infographic</small>
                                                                    <div class="mt-2">
                                                                        <img src="{{ Storage::url('infografis/' . basename($infografis->file_path)) }}"
                                                                             alt="{{ $infografis->name ?? basename($infografis->file_path) }}"
                                                                             class="img-fluid rounded"
                                                                             style="max-width: 300px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->urls as $url)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-link me-3 text-danger fs-4 mt-1"></i>
                                                                        <div>
                                                                            <h6 class="mb-1">{!! $url->name !!}</h6>
                                                                            <a href="{{ $url->url_link }}" target="_blank"
                                                                               class="d-block text-truncate text-muted">
                                                                                {!! $url->url_link !!}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->labels as $label)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="fas fa-tag me-3 text-primary"></i>
                                                                        <span>{!! $label->konten !!}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Perception Dimension (Sensing/Intuitive) -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-brain me-2"></i>Perception Dimension (Sensing/Intuitive)</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#perceptionDimension{{ $i }}" aria-expanded="true" aria-controls="perceptionDimension{{ $i }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="perceptionDimension{{ $i }}">
                                                        @foreach($section->sub_topic[$i]->pages as $page)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <a href="{{ route('pages.show', $page->id) }}"
                                                                   class="text-decoration-none d-flex align-items-center">
                                                                    <i class="fas fa-file-alt me-3 text-primary fs-4"></i>
                                                                    <div>
                                                                        <h6 class="mb-0">{!! $page->name !!}</h6>
                                                                        <small class="text-muted">Page</small>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->files as $file)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <a href="{{ Storage::url('files/'.basename($file->file_path)) }}" target="_blank"
                                                                   class="text-decoration-none d-flex align-items-center">
                                                                    <i class="fas
                                                                        @if(Str::endsWith($file->file_path, '.pdf')) fa-file-pdf text-danger
                                                                        @elseif(Str::endsWith($file->file_path, ['.doc', '.docx'])) fa-file-word text-primary
                                                                        @elseif(Str::endsWith($file->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint text-warning
                                                                        @elseif(Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image text-success
                                                                        @else fa-file-alt @endif
                                                                        me-3 fs-4"></i>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $file->name }}</h6>
                                                                        <small class="text-muted">{{ basename($file->file_path) }}</small>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->urls as $url)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-link me-3 text-danger fs-4 mt-1"></i>
                                                                        <div>
                                                                            <h6 class="mb-1">{!! $url->name !!}</h6>
                                                                            <a href="{{ $url->url_link }}" target="_blank"
                                                                               class="d-block text-truncate text-muted">
                                                                                {!! $url->url_link !!}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Processing Dimension (Active/Reflective) -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-cogs me-2"></i>Processing Dimension (Active/Reflective)</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#processingDimension{{ $i }}" aria-expanded="true" aria-controls="processingDimension{{ $i }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="processingDimension{{ $i }}">
                                                        @foreach($section->sub_topic[$i]->lessons as $lesson)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-book-open me-3 text-purple fs-4 mt-1"></i>
                                                                        <div>
                                                                            <h6 class="mb-1">{!! $lesson->name !!}</h6>
                                                                            <p class="mb-0 text-muted">{!! $lesson->description !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->forums as $forum)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-comments me-3 text-info fs-4 mt-1"></i>
                                                                        <div>
                                                                            <a href="{{ route('forums.show', $forum->id) }}"
                                                                               class="text-decoration-none">
                                                                                <h6 class="mb-1">{!! $forum->name !!}</h6>
                                                                            </a>
                                                                            <p class="mb-0 text-muted">{!! $forum->description !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->assignments as $assignment)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-tasks me-3 text-warning fs-4 mt-1"></i>
                                                                        <div>
                                                                            <a href="{{ route('assignments.showAssignment', $assignment->id) }}"
                                                                               class="text-decoration-none">
                                                                                <h6 class="mb-1">{!! $assignment->name !!}</h6>
                                                                            </a>
                                                                            <p class="mb-2 text-muted">{!! $assignment->description !!}</p>
                                                                            @if($assignment->due_date)
                                                                                <div class="due-date-badge">
                                                                                    <span class="badge bg-warning text-dark p-2">
                                                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                                                        Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}
                                                                                    </span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @foreach($section->sub_topic[$i]->quizs as $quiz)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2" data-quiz-id="{{ $quiz->id }}" data-completed="{{ $quiz->attempts()->where('user_id', Auth::id())->exists() ? 'true' : 'false' }}">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-question-circle me-3 text-danger fs-4 mt-1"></i>
                                                                        <div>
                                                                            <a href="{{ route('quiz.showMahasiswa', $quiz->id) }}"
                                                                               class="text-decoration-none">
                                                                                <h6 class="mb-1">{!! $quiz->name !!}</h6>
                                                                            </a>
                                                                            <div class="d-flex gap-2 mt-2">
                                                                                <span class="badge bg-success">
                                                                                    <i class="fas fa-door-open me-1"></i>
                                                                                    {{ \Carbon\Carbon::parse($quiz->time_open)->format('d M Y, H:i') }}
                                                                                </span>
                                                                                <span class="badge bg-warning text-dark">
                                                                                    <i class="fas fa-door-closed me-1"></i>
                                                                                    {{ \Carbon\Carbon::parse($quiz->time_close)->format('d M Y, H:i') }}
                                                                                </span>
                                                                            </div>
                                                                            @if($quiz->attempts()->where('user_id', Auth::id())->exists())
                                                                                <span class="badge bg-success mt-2">
                                                                                    <i class="fas fa-check-circle me-1"></i>
                                                                                    Completed
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-danger mt-2">
                                                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                                                    Not Completed
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info mb-3">
                                                <i class="fas fa-info-circle me-2"></i>No resources available for this subtopic.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endif

        <!-- References Section -->
        @if($section->referensi->count() > 0)
            <div class="card mb-5 border-0 shadow-sm">
                <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h3 class="mb-0 text-dark"><i class="fas fa-bookmark me-2"></i>References</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($section->referensi as $referensi)
                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-quote-left me-2 text-muted"></i>
                                        <p class="mb-0">{{ $referensi->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Course
            </a>
            @can('update', $section)
                <a href="{{ route('sections.edit', [$course->id, $section->id]) }}" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="fas fa-edit me-2"></i>Edit Section
                </a>
            @endcan
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- JavaScript for Sequential Subtopic Display and Dimension Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtopicItems = document.querySelectorAll('.subtopic-item');
        const progressBar = document.querySelector('.progress-bar');
        const totalSubtopics = subtopicItems.length;
        let completedSubtopics = 0;
        let visibleSubtopics = 1;

        // Initialize progress bar
        updateProgressBar();

        // Function to check quiz completion status for a subtopic
        function checkSubtopicQuizzesCompleted(subtopicId) {
            const subtopicElement = document.querySelector(`.subtopic-item[data-subtopic-id="${subtopicId}"]`);
            const quizItems = subtopicElement.querySelectorAll('[data-quiz-id]');
            let hasQuizzes = quizItems.length > 0;
            let allQuizzesCompleted = true;

            if (hasQuizzes) {
                quizItems.forEach(quizItem => {
                    if (quizItem.dataset.completed !== 'true') {
                        allQuizzesCompleted = false;
                    }
                });
            } else {
                // If no quizzes, don't show the checkbox
                allQuizzesCompleted = false;
            }

            return { hasQuizzes, allQuizzesCompleted };
        }

        // Toggle dimension arrow
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const arrow = this.querySelector('.dimension-arrow');
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                if (target.classList.contains('show')) {
                    arrow.classList.remove('fa-chevron-up');
                    arrow.classList.add('fa-chevron-down');
                } else {
                    arrow.classList.remove('fa-chevron-down');
                    arrow.classList.add('fa-chevron-up');
                }
            });
        });

        // Add event listeners to all checkboxes
        document.querySelectorAll('.subtopic-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const currentSubtopicId = this.closest('.subtopic-item').dataset.subtopicId;
                const currentSequence = parseInt(this.closest('.subtopic-item').dataset.sequence);
                const nextSubtopicId = this.dataset.nextSubtopic;

                if (this.checked) {
                    completedSubtopics++;
                    if (nextSubtopicId) {
                        const nextSubtopic = document.querySelector(`.subtopic-item[data-subtopic-id="${nextSubtopicId}"]`);
                        if (nextSubtopic) {
                            nextSubtopic.classList.add('animate__animated', 'animate__fadeIn');
                            setTimeout(() => {
                                nextSubtopic.classList.remove('d-none');
                                visibleSubtopics++;
                                const accordionButton = nextSubtopic.querySelector('.accordion-button');
                                if (accordionButton) {
                                    const collapseTarget = accordionButton.getAttribute('data-bs-target');
                                    const collapseElement = document.querySelector(collapseTarget);
                                    if (collapseElement) {
                                        new bootstrap.Collapse(collapseElement, { toggle: true });
                                    }
                                }
                            }, 100);
                            setTimeout(() => {
                                nextSubtopic.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 500);
                        }
                    }
                } else {
                    completedSubtopics--;
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
                    const checkbox = subtopic.querySelector('.subtopic-checkbox');
                    if (checkbox) checkbox.checked = false;
                }
            });
            visibleSubtopics = currentSequence;
        }

        // Periodically check quiz completion status for visible subtopics
        setInterval(() => {
            const visibleSubtopics = document.querySelectorAll('.subtopic-item:not(.d-none)');
            visibleSubtopics.forEach(subtopic => {
                const subtopicId = subtopic.dataset.subtopicId;
                const checkboxContainer = subtopic.querySelector('.subtopic-checkbox-container');
                const { hasQuizzes, allQuizzesCompleted } = checkSubtopicQuizzesCompleted(subtopicId);

                // Show checkbox only if there are quizzes AND all are completed
                if (hasQuizzes && allQuizzesCompleted) {
                    checkboxContainer.classList.remove('d-none');
                } else {
                    checkboxContainer.classList.add('d-none');
                    const checkbox = checkboxContainer.querySelector('.subtopic-checkbox');
                    if (checkbox) checkbox.checked = false;
                }
            });
        }, 3000); // Check every 3 seconds
    });
</script>

<!-- Custom Styles -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #212529;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .list-group-item {
        transition: all 0.2s ease;
    }
    .list-group-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .text-purple {
        color: #6f42c1;
    }
    .badge {
        font-weight: 500;
    }
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-bar {
        transition: width 0.6s ease;
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
    .due-date-badge {
        margin-top: 0.5rem;
    }
    .dimension-arrow {
        transition: transform 0.3s ease;
    }
    .dimension-arrow.fa-chevron-up {
        transform: rotate(180deg);
    }
    @media (max-width: 768px) {
        .accordion-button {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
