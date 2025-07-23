<div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2 ps-5">
    @if($item instanceof App\Models\MDLLabel)
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-tag me-3 text-primary"></i>
                <span>{!! $item->konten !!}</span>
            </div>
            <div id="labelTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLFiles)
        <div class="d-flex justify-content-between align-items-center">
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
            <div id="fileTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLInfografis)
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas
                @if(Str::endsWith($item->file_path, ['.jpg', '.jpeg', '.png', '.drawio'])) fa-file-image text-success
                @else fa-file-alt @endif
                me-3 fs-4"></i>
                <div>
                    {{-- Nama file dihilangkan --}}
                    {{-- <h6 class="mb-1">{{ $item->name ?? basename($item->file_path) }}</h6> --}}
                    <small class="text-muted mb-2">Infographic</small>
                    <div class="mt-2">
                        <img src="{{ Storage::url('infografis/' . basename($item->file_path)) }}"
                             alt="{{ $item->name ?? basename($item->file_path) }}"
                             class="img-fluid rounded"
                             style="max-width: 300px;">
                    </div>
                </div>
            </div>
            <div id="infografisTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLAssign)
        <div class="assignment-content">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-start">
                    <i class="fas fa-tasks me-3 text-warning fs-4 mt-1"></i>
                    <div>
                        <a href="{{ route('assignments.showAssignmentDosen', $item->id) }}" class="text-decoration-none">
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
                <div id="assignmentTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
            </div>
        </div>
    @elseif($item instanceof App\Models\MDLForum)
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-start">
                <i class="fas fa-comments me-3 text-info fs-4 mt-1"></i>
                <div>
                    <a href="{{ route('forums.show', $item->id) }}" class="text-decoration-none">
                        <h6 class="mb-1">{!! $item->name !!}</h6>
                    </a>
                    <p class="mb-0 text-muted">{!! $item->description !!}</p>
                </div>
            </div>
            <div id="forumTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLLesson)
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-start">
                <i class="fas fa-book-open me-3 text-purple fs-4 mt-1"></i>
                <div>
                    <h6 class="mb-1">{!! $item->name !!}</h6>
                    <p class="mb-0 text-muted">{!! $item->description !!}</p>
                </div>
            </div>
            <div id="lessonTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLUrl)
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-start">
                <i class="fas fa-link me-3 text-danger fs-4 mt-1"></i>
                <div>
                    <h6 class="mb-1">{!! $item->name !!}</h6>
                    <p class="mb-0 text-muted">{!! $item->description !!}</p>
                    <a href="{{ asset($item->url_link) }}" target="_blank" class="d-block text-truncate text-muted">
                        {!! $item->url_link !!}
                    </a>
                </div>
            </div>
            <div id="urlTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLFolder)
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('folders.show', $item->id) }}" class="text-decoration-none d-flex align-items-center">
                <i class="fas fa-folder me-3 text-warning fs-4"></i>
                <div>
                    <h6 class="mb-0">{!! $item->name !!}</h6>
                    <small class="text-muted">Folder</small>
                </div>
            </a>
            <div id="folderTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLPage)
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('pages.show', $item->id) }}" class="text-decoration-none d-flex align-items-center">
                <i class="fas fa-file-alt me-3 text-primary fs-4"></i>
                <div>
                    <h6 class="mb-0">{!! $item->name !!}</h6>
                    <p class="mb-0 text-muted">{!! $item->description !!}</p>
                    <small class="text-muted">Page</small>
                </div>
            </a>
            <div id="pageTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @elseif($item instanceof App\Models\MDLQuiz)
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-start">
                <i class="fas fa-question-circle me-3 text-danger fs-4 mt-1"></i>
                <div>
                    <a href="{{ route('quizs.show', $item->id) }}" class="text-decoration-none">
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
            <div id="quizTools{{ $item->id }}" class="d-flex align-items-center gap-1 d-none"></div>
        </div>
    @endif
</div>
