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
                            <p class="card-text text-muted">{{ $course->summary ?? 'No summary available' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="bg-white p-3 rounded shadow-sm h-100">
                            <h5 class="text-primary mb-3"><i class="fas fa-bullseye me-2"></i>CPMK</h5>
                            <p class="card-text text-muted">{{ $course->cpmk ?? 'No CPMK available' }}</p>
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
                            <p class="card-text text-muted">{{ $section->description ?? 'No description available' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="bg-white p-3 rounded shadow-sm h-100">
                            <h5 class="text-secondary mb-3"><i class="fas fa-bullseye me-2"></i>Sub-CPMK</h5>
                            <p class="card-text text-muted">{{ $section->sub_cpmk ?? 'No sub-CPMK available' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Construction Mode Button -->
        <div class="text-center mb-5">
            <button id="modeKonstruksi" class="btn btn-lg btn-primary text-white rounded-pill px-5 py-3 shadow"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; transition: all 0.3s ease;">
                <i class="fas fa-tools me-2"></i>Construction Mode
            </button>
        </div>

        <!-- Subtopics Section -->
        @if(count($section->sub_topic) > 0)
            <div class="card mb-5 border-0 shadow-sm">
                <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h3 class="mb-0 text-dark"><i class="fas fa-layer-group me-2"></i>Subtopics</h3>
                    <button id="addSubTopicButton" class="btn btn-primary rounded-pill px-4 py-2 d-none">
                        <i class="fas fa-plus me-2"></i> Add Subtopic
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="accordion accordion-flush" id="subtopicsAccordion">
                        @foreach($section->sub_topic as $index => $subTopic)
                            <div class="accordion-item border-0 mb-3" data-sub-topic-id="{{ $subTopic->id }}">
                                <div class="accordion-header bg-white rounded shadow-sm">
                                    <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#subtopicCollapse{{ $subTopic->id }}"
                                            aria-expanded="false" aria-controls="subtopicCollapse{{ $subTopic->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h5 class="mb-0 fw-bold text-dark">{{ $subTopic->title }}</h5>
                                            <div id="constructionTools{{ $subTopic->id }}" class="d-flex align-items-center gap-2"></div>
                                        </div>
                                    </button>
                                </div>
                                <div id="subtopicCollapse{{ $subTopic->id }}" class="accordion-collapse collapse"
                                     aria-labelledby="subtopicHeading{{ $subTopic->id }}" data-bs-parent="#subtopicsAccordion">
                                    <div class="accordion-body pt-4">
                                        <!-- Subtopic Content -->
                                        <div class="mb-4 p-3 bg-light rounded">
                                            <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Content</h6>
                                            <div class="p-3 bg-white rounded shadow-sm">
                                                {!! nl2br(e($subTopic->content ?? '')) !!}
                                            </div>
                                        </div>

                                        <!-- Resources -->
                                        @if(count($subTopic->sorted_items) > 0)
                                            <div class="resources-container mb-4">
                                                <h6 class="text-muted mb-3"><i class="fas fa-file-alt me-2"></i>Resources</h6>
                                                <div class="list-group">
                                                    <!-- Input Dimension (Visual/Verbal) -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-eye me-2"></i>Input Dimension (Visual/Verbal)</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#inputDimension{{ $subTopic->id }}" aria-expanded="true" aria-controls="inputDimension{{ $subTopic->id }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="inputDimension{{ $subTopic->id }}">
                                                        @foreach($subTopic->sorted_items as $item)
                                                            @if(in_array(get_class($item), [
                                                                'App\Models\MDLFiles',
                                                                'App\Models\MDLFolder',
                                                                'App\Models\MDLUrl',
                                                                'App\Models\MDLInfografis',
                                                                'App\Models\MDLLabel'
                                                            ]))
                                                                @include('partials.resource_item', ['item' => $item])
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <!-- Perception Dimension (Sensing/Intuitive) -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-brain me-2"></i>Perception Dimension (Sensing/Intuitive)</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#perceptionDimension{{ $subTopic->id }}" aria-expanded="true" aria-controls="perceptionDimension{{ $subTopic->id }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="perceptionDimension{{ $subTopic->id }}">
                                                        @foreach($subTopic->sorted_items as $item)
                                                            @if(in_array(get_class($item), [
                                                                'App\Models\MDLPage',
                                                                'App\Models\MDLFiles',
                                                                'App\Models\MDLFolder',
                                                                'App\Models\MDLUrl'
                                                            ]))
                                                                @include('partials.resource_item', ['item' => $item])
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <!-- Processing Dimension (Active/Reflective) -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-cogs me-2"></i>Processing Dimension (Active/Reflective)</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#processingDimension{{ $subTopic->id }}" aria-expanded="true" aria-controls="processingDimension{{ $subTopic->id }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="processingDimension{{ $subTopic->id }}">
                                                        @foreach($subTopic->sorted_items as $item)
                                                            @if(in_array(get_class($item), [
                                                                'App\Models\MDLLesson',
                                                                'App\Models\MDLForum',
                                                                'App\Models\MDLAssign',
                                                                'App\Models\MDLQuiz'
                                                            ]))
                                                                @include('partials.resource_item', ['item' => $item])
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <!-- Other Resources -->
                                                    <div class="list-group-item border-0 rounded shadow-sm mb-2 bg-light mt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-question-circle me-2"></i>Other Resources</h6>
                                                            <button class="btn btn-link text-primary p-0" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#otherResources{{ $subTopic->id }}" aria-expanded="true" aria-controls="otherResources{{ $subTopic->id }}">
                                                                <i class="fas fa-chevron-down dimension-arrow"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="collapse show" id="otherResources{{ $subTopic->id }}">
                                                        @foreach($subTopic->sorted_items as $item)
                                                            @if(!in_array(get_class($item), [
                                                                'App\Models\MDLFiles',
                                                                'App\Models\MDLFolder',
                                                                'App\Models\MDLUrl',
                                                                'App\Models\MDLInfografis',
                                                                'App\Models\MDLLabel',
                                                                'App\Models\MDLPage',
                                                                'App\Models\MDLLesson',
                                                                'App\Models\MDLForum',
                                                                'App\Models\MDLAssign',
                                                                'App\Models\MDLQuiz'
                                                            ]))
                                                                @include('partials.resource_item', ['item' => $item])
                                                            @endif
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

                            <!-- Learning Style Modal -->
                            <div class="modal fade" id="learningStyleModal{{ $subTopic->id }}" tabindex="-1" aria-labelledby="learningStyleModalLabel{{ $subTopic->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="learningStyleModalLabel{{ $subTopic->id }}">
                                                <i class="fas fa-plus-circle me-2"></i>Add Resource to {{ $subTopic->title }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="nav nav-tabs nav-fill mb-4" id="myTab{{ $subTopic->id }}" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="activity-tab{{ $subTopic->id }}" data-bs-toggle="tab"
                                                            data-bs-target="#activity{{ $subTopic->id }}" type="button" role="tab"
                                                            aria-controls="activity{{ $subTopic->id }}" aria-selected="true">
                                                        <i class="fas fa-tasks me-2"></i>ACTIVITY
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="interactive-tab{{ $subTopic->id }}" data-bs-toggle="tab"
                                                            data-bs-target="#interactive{{ $subTopic->id }}" type="button" role="tab"
                                                            aria-controls="interactive{{ $subTopic->id }}" aria-selected="false">
                                                        <i class="fas fa-hand-pointer me-2"></i>INTERACTIVE
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="knowledge-tab{{ $subTopic->id }}" data-bs-toggle="tab"
                                                            data-bs-target="#knowledge{{ $subTopic->id }}" type="button" role="tab"
                                                            aria-controls="knowledge{{ $subTopic->id }}" aria-selected="false">
                                                        <i class="fas fa-book me-2"></i>KNOWLEDGE
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-3" id="myTabContent{{ $subTopic->id }}">
                                                <div class="tab-pane fade show active" id="activity{{ $subTopic->id }}" role="tabpanel" aria-labelledby="activity-tab{{ $subTopic->id }}">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <a href="{{ route('assignments.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-tasks fs-1 mb-2"></i>
                                                                <span>Assignment</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('quizs.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-question-circle fs-1 mb-2"></i>
                                                                <span>Quiz</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('forums.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-comments fs-1 mb-2"></i>
                                                                <span>Forum</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="interactive{{ $subTopic->id }}" role="tabpanel" aria-labelledby="interactive-tab{{ $subTopic->id }}">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <a href="{{ route('lessons.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-book-open fs-1 mb-2"></i>
                                                                <span>Lesson</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="knowledge{{ $subTopic->id }}" role="tabpanel" aria-labelledby="knowledge-tab{{ $subTopic->id }}">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <a href="{{ route('folders.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-folder fs-1 mb-2"></i>
                                                                <span>Folder</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('files.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-file fs-1 mb-2"></i>
                                                                <span>File</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('pages.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-file-alt fs-1 mb-2"></i>
                                                                <span>Page</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('url.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-link fs-1 mb-2"></i>
                                                                <span>URL</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('labels.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-tag fs-1 mb-2"></i>
                                                                <span>Label</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ route('infografis.create', ['sub_topic_id' => $subTopic->id]) }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center py-3">
                                                                <i class="fas fa-chart-pie fs-1 mb-2"></i>
                                                                <span>Infographic</span>
                                                            </a>
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
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- References Section -->
        @if(count($section->referensi) > 0)
            <div class="card mb-5 border-0 shadow-sm">
                <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h3 class="mb-0 text-dark"><i class="fas fa-bookmark me-2"></i>References</h3>
                    <button id="addReferenceButton" class="btn btn-primary rounded-pill px-4 py-2 d-none">
                        <i class="fas fa-plus me-2"></i> Add Reference
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($section->referensi as $referensi)
                            <div class="list-group-item list-group-item-action border-0 rounded shadow-sm mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-quote-left me-3 text-muted"></i>
                                        <p class="mb-0">{{ $referensi->content ?? 'No content available' }}</p>
                                    </div>
                                    <div id="referenceTools{{ $referensi->id }}" class="d-flex align-items-center gap-1"></div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modeButton = document.getElementById('modeKonstruksi');
        const addSubTopicButton = document.getElementById('addSubTopicButton');
        const addReferenceButton = document.getElementById('addReferenceButton');
        const constructionToolDivs = document.querySelectorAll('[id^="constructionTools"]');
        const labelToolDivs = document.querySelectorAll('[id^="labelTools"]');
        const fileToolDivs = document.querySelectorAll('[id^="fileTools"]');
        const infografisToolDivs = document.querySelectorAll('[id^="infografisTools"]');
        const assignmentToolDivs = document.querySelectorAll('[id^="assignmentTools"]');
        const forumToolDivs = document.querySelectorAll('[id^="forumTools"]');
        const lessonToolDivs = document.querySelectorAll('[id^="lessonTools"]');
        const urlToolDivs = document.querySelectorAll('[id^="urlTools"]');
        const folderToolDivs = document.querySelectorAll('[id^="folderTools"]');
        const pageToolDivs = document.querySelectorAll('[id^="pageTools"]');
        const quizToolDivs = document.querySelectorAll('[id^="quizTools"]');
        const referenceToolDivs = document.querySelectorAll('[id^="referenceTools"]');
        let isConstructionMode = false;

        // Set the onclick handler for the Add Subtopic button
        if (addSubTopicButton) {
            addSubTopicButton.setAttribute('onclick', `window.location.href='{{ route('sections.subtopics.create', ['course' => $course->id, 'section_id' => $section->id]) }}'`);
        }

        // Set the onclick handler for the Add Reference button
        if (addReferenceButton) {
            addReferenceButton.setAttribute('onclick', `window.location.href='{{ route('sections.referensi.create', ['course' => $course->id, 'section_id' => $section->id]) }}'`);
        }

        // Function to create construction tools for subtopics
        function createConstructionTools(container, subTopicId) {
            const toolsDiv = document.createElement('div');
            toolsDiv.className = 'd-flex align-items-center gap-2';

            // Add Resource Button
            const addButton = document.createElement('button');
            addButton.className = 'btn btn-sm btn-primary rounded-pill';
            addButton.setAttribute('data-bs-toggle', 'modal');
            addButton.setAttribute('data-bs-target', `#learningStyleModal${subTopicId}`);
            addButton.setAttribute('title', 'Add Resource');
            addButton.innerHTML = '<i class="fas fa-plus me-1"></i> Add';
            toolsDiv.appendChild(addButton);

            // Edit Button
            const editButton = document.createElement('a');
            editButton.className = 'btn btn-sm btn-outline-success rounded-pill';
            editButton.setAttribute('title', 'Edit Subtopic');
            editButton.href = '{{ route('sections.subtopics.edit', [$course->id, $section->id, ':subTopicId']) }}'.replace(':subTopicId', subTopicId);
            editButton.innerHTML = '<i class="fas fa-edit me-1"></i> Edit';
            toolsDiv.appendChild(editButton);

            // Delete Button
            const deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-sm btn-outline-danger rounded-pill';
            deleteButton.setAttribute('title', 'Delete Subtopic');
            deleteButton.innerHTML = '<i class="fas fa-trash me-1"></i> Delete';
            deleteButton.addEventListener('click', function () {
                if (confirm('Are you sure you want to delete this subtopic?')) {
                    fetch('{{ route('sections.subtopics.destroy', [$course->id, $section->id, ':subTopicId']) }}'.replace(':subTopicId', subTopicId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Subtopic deleted successfully!');
                                window.location.href = '{{ route('courses.topics', $course->id) }}';
                            } else {
                                alert(data.message || 'Deletion failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to delete subtopic. Please try again.');
                        });
                }
            });
            toolsDiv.appendChild(deleteButton);

            container.appendChild(toolsDiv);
        }

        // Function to create tools for items (label, file, infografis, etc.)
        function createItemTools(container, itemId, type, editRoute, deleteRoute) {
            const toolsDiv = document.createElement('div');
            toolsDiv.className = 'd-flex align-items-center gap-2';

            // Edit Button
            const editButton = document.createElement('a');
            editButton.className = 'btn btn-sm btn-outline-success rounded-circle';
            editButton.setAttribute('title', `Edit ${type}`);
            editButton.href = editRoute.replace('ITEM_ID', itemId);
            editButton.innerHTML = '<i class="fas fa-edit"></i>';
            toolsDiv.appendChild(editButton);

            // Delete Button
            const deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-sm btn-outline-danger rounded-circle';
            deleteButton.setAttribute('title', `Delete ${type}`);
            deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
            deleteButton.addEventListener('click', function () {
                if (confirm(`Are you sure you want to delete this ${type.toLowerCase()}?`)) {
                    fetch(deleteRoute.replace('ITEM_ID', itemId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(`${type} deleted successfully!`);
                                window.location.reload();
                            } else {
                                alert(data.message || `Failed to delete ${type.toLowerCase()}`);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert(`Failed to delete ${type.toLowerCase()}. Please try again.`);
                        });
                }
            });
            toolsDiv.appendChild(deleteButton);

            container.appendChild(toolsDiv);
        }

        // Function to remove tools from a container
        function removeTools(container) {
            while (container.firstChild) {
                container.removeChild(container.firstChild);
            }
        }

        // Toggle construction mode
        if (modeButton) {
            modeButton.addEventListener('click', function () {
                isConstructionMode = !isConstructionMode;
                modeButton.innerHTML = isConstructionMode
                    ? '<i class="fas fa-times me-2"></i>Exit Construction Mode'
                    : '<i class="fas fa-tools me-2"></i>Construction Mode';
                modeButton.classList.toggle('btn-primary', !isConstructionMode);
                modeButton.classList.toggle('btn-danger', isConstructionMode);

                // Toggle Add Subtopic button visibility
                if (addSubTopicButton) {
                    addSubTopicButton.classList.toggle('d-none', !isConstructionMode);
                }

                // Toggle Add Reference button visibility
                if (addReferenceButton) {
                    addReferenceButton.classList.toggle('d-none', !isConstructionMode);
                }

                // Toggle construction tools for subtopics
                constructionToolDivs.forEach(div => {
                    if (isConstructionMode) {
                        createConstructionTools(div, div.id.replace('constructionTools', ''));
                    } else {
                        removeTools(div);
                    }
                });

                // Toggle tools for all item types
                const toolDivs = [
                    { divs: labelToolDivs, type: 'Label', editRoute: '/labels/ITEM_ID/edit', deleteRoute: '/labels/ITEM_ID' },
                    { divs: fileToolDivs, type: 'File', editRoute: '/files/ITEM_ID/edit', deleteRoute: '/files/ITEM_ID' },
                    { divs: infografisToolDivs, type: 'Infografis', editRoute: '/infografis/ITEM_ID/edit', deleteRoute: '/infografis/ITEM_ID' },
                    { divs: assignmentToolDivs, type: 'Assignment', editRoute: '/assignments/ITEM_ID/edit', deleteRoute: '/assignments/ITEM_ID' },
                    { divs: forumToolDivs, type: 'Forum', editRoute: '/forums/ITEM_ID/edit', deleteRoute: '/forums/ITEM_ID' },
                    { divs: lessonToolDivs, type: 'Lesson', editRoute: '/lessons/ITEM_ID/edit', deleteRoute: '/lessons/ITEM_ID' },
                    { divs: urlToolDivs, type: 'URL', editRoute: '/urls/ITEM_ID/edit', deleteRoute: '/urls/ITEM_ID' },
                    { divs: folderToolDivs, type: 'Folder', editRoute: '/folders/ITEM_ID/edit', deleteRoute: '/folders/ITEM_ID' },
                    { divs: pageToolDivs, type: 'Page', editRoute: '/pages/ITEM_ID/edit', deleteRoute: '/pages/ITEM_ID' },
                    { divs: quizToolDivs, type: 'Quiz', editRoute: '/quizs/ITEM_ID/edit', deleteRoute: '/quizs/ITEM_ID' },
                    { divs: referenceToolDivs, type: 'Reference', editRoute: '{{ route("sections.referensi.edit", [$course->id, $section->id, "ITEM_ID"]) }}', deleteRoute: '/referensi/ITEM_ID' }
                ];

                toolDivs.forEach(({ divs, type, editRoute, deleteRoute }) => {
                    divs.forEach(div => {
                        if (isConstructionMode) {
                            createItemTools(div, div.id.replace(`${type.toLowerCase()}Tools`, ''), type, editRoute, deleteRoute);
                        } else {
                            removeTools(div);
                        }
                    });
                });
            });
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

        // Custom styling for better visual hierarchy
        const style = document.createElement('style');
        style.innerHTML = `
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
            .btn-outline-purple {
                color: #6f42c1;
                border-color: #6f42c1;
            }
            .btn-outline-purple:hover {
                color: white;
                background-color: #6f42c1;
            }
            .text-purple {
                color: #6f42c1;
            }
            .badge {
                font-weight: 500;
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
                .btn-sm {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.8rem;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
