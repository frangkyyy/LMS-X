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

        <!-- Subtopics Section -->
        @if($section->sub_topic->count() > 0)
            <div class="card mb-5 border-0 shadow-sm">
                <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h3 class="mb-0 text-dark"><i class="fas fa-layer-group me-2"></i>Subtopics</h3>
                </div>
                <div class="card-body p-0">
                    <div class="accordion accordion-flush" id="subtopicsAccordion">
                        @foreach($section->sub_topic as $index => $subTopic)
                            <div class="accordion-item border-0 mb-3" data-subtopic-id="{{ $subTopic->id }}">
                                <div class="accordion-header bg-white rounded shadow-sm">
                                    <button class="accordion-button bg-light {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#subtopicCollapse{{ $subTopic->id }}"
                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="subtopicCollapse{{ $subTopic->id }}">
                                        <h5 class="mb-0 fw-bold text-dark">Sub Materi {{ $index + 1 }}: {{ $subTopic->title }}</h5>
                                    </button>
                                </div>
                                <div id="subtopicCollapse{{ $subTopic->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                     aria-labelledby="subtopicHeading{{ $subTopic->id }}" data-bs-parent="#subtopicsAccordion">
                                    <div class="accordion-body pt-4">
                                        <!-- Subtopic Content -->
                                        <div class="mb-4 p-3 bg-light rounded">
                                            <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Content</h6>
                                            <div class="p-3 bg-white rounded shadow-sm">
                                                {!! nl2br(e($subTopic->content)) !!}
                                            </div>
                                        </div>

                                        <!-- Resources -->
                                        @if($subTopic->sorted_items->isNotEmpty())
                                            <div class="resources-container mb-4">
                                                <h6 class="text-muted mb-3"><i class="fas fa-file-alt me-2"></i>Resources</h6>
                                                <div class="list-group">
                                                    <!-- Non-Quiz Items -->
                                                    @foreach($subTopic->sorted_items as $item)
                                                        @if(!$item instanceof App\Models\MDLQuiz)
                                                            <!-- Label -->
                                                            @if($item instanceof App\Models\MDLLabel)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-tag me-3 text-primary"></i>
                                                                            <span>{!! $item->konten !!}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- File -->
                                                            @elseif($item instanceof App\Models\MDLFiles)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <a href="{{ Storage::url('files/'.basename($item->file_path)) }}" target="_blank"
                                                                       class="text-decoration-none d-flex align-items-center">
                                                                        <i class="fas
                                                                            @if(Str::endsWith($item->file_path, '.pdf')) fa-file-pdf text-danger
                                                                            @elseif(Str::endsWith($item->file_path, ['.doc', '.docx'])) fa-file-word text-primary
                                                                            @elseif(Str::endsWith($item->file_path, ['.ppt', '.pptx'])) fa-file-powerpoint text-warning
                                                                            @elseif(Str::endsWith($item->file_path, ['.jpg', '.jpeg', '.png'])) fa-file-image text-success
                                                                            @else fa-file-alt @endif
                                                                            me-3 fs-4"></i>
                                                                        <div>
                                                                            <h6 class="mb-0">{{ $item->name }}</h6>
                                                                            <small class="text-muted">{{ basename($item->file_path) }}</small>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <!-- Infografis -->
                                                            @elseif($item instanceof App\Models\MDLInfografis)
                                                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded shadow-sm bg-white">
                                                                    <div class="d-flex align-items-center w-100">
                                                                            <i class="fas
                                                                                @if(Str::endsWith($item->file_path, ['.jpg', '.jpeg', '.png', '.drawio']))
                                                                                    fa-file-image text-success
                                                                                @else
                                                                                    fa-file-alt
                                                                                @endif
                                                                                me-3 fs-4">
                                                                            </i>
                                                                            <div class="w-100">
                                                                                <small class="text-muted mb-2">Infographic</small>
                                                                                <div class="mt-2">
                                                                                    <img src="{{ Storage::url('infografis/' . basename($item->file_path)) }}"
                                                                                         alt="Infographic Preview"
                                                                                         class="img-fluid rounded"
                                                                                         style="max-width: 300px;">
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    <div id="infografisTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
                                                                </div>
                                                                <!-- Assignment -->
                                                            @elseif($item instanceof App\Models\MDLAssign)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="fas fa-tasks me-3 text-warning fs-4 mt-1"></i>
                                                                            <div>
                                                                                <a href="{{ route('assignments.showAssignment', $item->id) }}"
                                                                                   class="text-decoration-none">
                                                                                    <h6 class="mb-1">{!! $item->name !!}</h6>
                                                                                </a>
                                                                                <p class="mb-2 text-muted">{!! $item->description !!}</p>
                                                                                @if($item->due_date)
                                                                                    <div class="due-date-badge">
                                                                                        <span class="badge bg-warning text-dark p-2">
                                                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                                                            Due: {{ \Carbon\Carbon::parse($item->due_date)->format('d M Y, H:i') }}
                                                                                        </span>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Forum -->
                                                            @elseif($item instanceof App\Models\MDLForum)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="fas fa-comments me-3 text-info fs-4 mt-1"></i>
                                                                            <div>
                                                                                <a href="{{ route('forums.show', $item->id) }}"
                                                                                   class="text-decoration-none">
                                                                                    <h6 class="mb-1">{!! $item->name !!}</h6>
                                                                                </a>
                                                                                <p class="mb-0 text-muted">{!! $item->description !!}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Lesson -->
                                                            @elseif($item instanceof App\Models\MDLLesson)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="fas fa-book-open me-3 text-purple fs-4 mt-1"></i>
                                                                            <div>
                                                                                <h6 class="mb-1">{!! $item->name !!}</h6>
                                                                                <p class="mb-0 text-muted">{!! $item->description !!}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- URL -->
                                                            @elseif($item instanceof App\Models\MDLUrl)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="fas fa-link me-3 text-danger fs-4 mt-1"></i>
                                                                            <div>
                                                                                <h6 class="mb-1">{!! $item->name !!}</h6>
                                                                                <a href="{{ asset($item->url_link) }}" target="_blank"
                                                                                   class="d-block text-truncate text-muted">
                                                                                    {!! $item->url_link !!}
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Page -->
                                                            @elseif($item instanceof App\Models\MDLPage)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <a href="{{ route('pages.show', $item->id) }}"
                                                                       class="text-decoration-none d-flex align-items-center">
                                                                        <i class="fas fa-file-alt me-3 text-primary fs-4"></i>
                                                                        <div>
                                                                            <h6 class="mb-0">{!! $item->name !!}</h6>
                                                                            <small class="text-muted">Page</small>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <!-- Folder -->
                                                            @elseif($item instanceof App\Models\MDLFolder)
                                                                <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                    <a href="{{ route('folders.show', $item->id) }}"
                                                                       class="text-decoration-none d-flex align-items-center">
                                                                        <i class="fas fa-folder me-3 text-warning fs-4"></i>
                                                                        <div>
                                                                            <h6 class="mb-0">{!! $item->name !!}</h6>
                                                                            <small class="text-muted">Folder</small>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                    <!-- Quiz Items (Rendered at the Bottom) -->
                                                    @foreach($subTopic->sorted_items as $item)
                                                        @if($item instanceof App\Models\MDLQuiz)
                                                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="fas fa-question-circle me-3 text-danger fs-4 mt-1"></i>
                                                                        <div>
                                                                            <a href="{{ route('quiz.showMahasiswa', $item->id) }}"
                                                                               class="text-decoration-none">
                                                                                <h6 class="mb-1">{!! $item->name !!}</h6>
                                                                            </a>
                                                                            <div class="d-flex gap-2 mt-2">
                                                                                <span class="badge bg-success">
                                                                                    <i class="fas fa-door-open me-1"></i>
                                                                                    {{ \Carbon\Carbon::parse($item->time_open)->format('d M Y, H:i') }}
                                                                                </span>
                                                                                <span class="badge bg-warning text-dark">
                                                                                    <i class="fas fa-door-closed me-1"></i>
                                                                                    {{ \Carbon\Carbon::parse($item->time_close)->format('d M Y, H:i') }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
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
                        @endforeach
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
                                        <i class="fas fa-quote-left me-3 text-muted"></i>
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
    .resources-container {
        border: 1px solid #eee;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .due-date-badge {
        margin-top: 0.5rem;
    }
    @media (max-width: 768px) {
        .accordion-button {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
