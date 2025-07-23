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
                                    {{--                                    <button class="btn btn-outline-primary btn-sm gaya-belajar-btn" data-bs-toggle="modal" data-bs-target="#learningStyleModal{{ $subTopic->id }}" style="display: none;">Activity or Knowledge or Interactive</button>--}}
                                </div>
                                <div class="card-body">
                                    {{ $subTopic->content }}
                                    @if($subTopic->labels->count() > 0)
                                        <div class="card-body">

                                            <ul class="list-group">
                                                @foreach($subTopic->labels as $label)
                                                    <li class="list-group-item">{!!  $label->konten  !!}</li>
                                                @endforeach

                                                @foreach($subTopic->files as $file)
                                                    <li class="list-group-item">
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
                                                    </li>
                                                @endforeach
                                                @foreach($subTopic->infografis as $infografis)
                                                    <a href="{{ asset('storage/' . $infografis->file_path) }}" target="_blank">
                                                        <i class="bi bi-file-earmark-text me-2"></i> {{ $infografis->name }}
                                                    </a>
                                                @endforeach
                                                @foreach($subTopic->assignments as $assignment)
                                                    <li class="list-group-item">
                                                        <div class="assignment-content">
                                                            <a href="{{ route('assignments.showAssignment', $assignment->id) }}"><strong>{!! $assignment->name !!}</strong></a>

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

                                                @foreach($subTopic->forums as $forum)
                                                    <li class="list-group-item">
                                                        <strong>{!! $forum->name !!}</strong><br>
                                                        {!! $forum->description !!}
                                                    </li>
                                                @endforeach

                                                @foreach($subTopic->lessons as $lesson)
                                                    <li class="list-group-item">
                                                        <strong>{!! $lesson->name !!}</strong><br>
                                                        {!! $lesson->description !!}
                                                    </li>
                                                @endforeach

                                                    @forelse($subTopic->folders as $folder)
                                                        <li class="list-group-item">
                                                            <a href="{{ route('folders.show', $folder->id) }}"><i class="bi bi-file-text me-2"></i> {!! $folder->name !!}</a>
                                                        </li>
                                                    @empty
                                                        <li class="list-group-item">No folder available.</li>
                                                    @endforelse

                                                @foreach($subTopic->urls as $url)
                                                    <li class="list-group-item">
                                                        <strong>{!! $url->name !!}</strong><br>
                                                        <a href="{{ asset($url->url_link) }}" target="_blank">
                                                            <i class="bi bi-link me-2 text-primary">    {!! $url->url_link !!}</i>

                                                        </a>
                                                    </li>
                                                @endforeach

                                                @forelse($subTopic->pages as $page)
                                                    <li class="list-group-item">
                                                        <a href="{{ route('pages.show', $page->id) }}"><i class="bi bi-file-text me-2"></i> {!! $page->name !!}</a>
                                                    </li>
                                                @empty
                                                    <li class="list-group-item">No pages available.</li>
                                                @endforelse

                                                <ul class="list-group">
                                                    @foreach($subTopic->quizs as $quiz)
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





                                            </ul>
                                        </div>
                                    @else
                                        <div class="card-body">
                                            <p>No labels available for this subtopic.</p>
                                        </div>
                                    @endif
                                </div>


                                <!-- Modal for Gaya Belajar -->
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
                                                                    <i class="bi bi-file-earmark-text fs-3"></i><br>Assignment
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-danger w-100">
                                                                    <i class="bi bi-list-check fs-3"></i><br>Quiz
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-purple w-100">
                                                                    <i class="bi bi-people fs-3"></i><br>Forum
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="interactive{{ $subTopic->id }}" role="tabpanel" aria-labelledby="interactive-tab{{ $subTopic->id }}">
                                                        <div class="row">
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-success w-100">
                                                                    <i class="bi bi-boxes fs-3"></i><br>H5P
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-success w-100">
                                                                    <i class="bi bi-easel fs-3"></i><br>Lesson
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="knowledge{{ $subTopic->id }}" role="tabpanel" aria-labelledby="knowledge-tab{{ $subTopic->id }}">
                                                        <div class="row">
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <i class="bi bi-folder fs-3"></i><br>Folder
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('files.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-file-earmark fs-3"></i><br>File
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <a href={{ route('pages.create', ['sub_topic_id' => $subTopic->id]) }}><i class="bi bi-file-earmark-richtext fs-3"></i><br>Page
                                                                </button>
                                                            </div>
                                                            <div class="col-4 text-center mb-3">
                                                                <button class="btn btn-outline-primary w-100">
                                                                    <i class="bi bi-link fs-3"></i><br>URL
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

        <!-- Referensi -->
        @if($section->referensi->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    References
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($section->referensi as $referensi)
                            <li class="list-group-item">
                                <p class="mt-2">{{ $referensi->content }}</p>
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

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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
