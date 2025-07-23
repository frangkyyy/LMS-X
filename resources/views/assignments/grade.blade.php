<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h1 class="mb-1">Grade Assignment: {{ $assignment->name }}</h1>
                <div class="d-flex flex-wrap text-muted fs-6">
                    <div class="me-4">
                        <span class="fw-bold">Student:</span> {{ $submission->user->name }}
                    </div>
                    <div>
                        <span class="fw-bold">Submitted:</span>
                        {{ $submission->submitted_at ? $submission->submitted_at->format('d M Y, H:i') : 'Not submitted yet' }}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Submitted Files -->
                <div class="mb-4">
                    <h5 class="mb-3">Submitted Files</h5>
                    @php
                        $filePaths = is_array(json_decode($submission->file_path)) ?
                                    json_decode($submission->file_path) :
                                    [$submission->file_path];
                    @endphp

                    <div class="list-group">
                        @foreach($filePaths as $filePath)
                            @if($filePath)
                                <a href="{{ Storage::url($filePath) }}"
                                   target="_blank"
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-file me-2"></i> {{ basename($filePath) }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Grade Form -->
                <form action="{{ route('assignment.grade.store', ['assignment' => $assignment->id, 'submission' => $submission->id]) }}"
                      method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade (0-100)</label>
                        <input type="number"
                               class="form-control"
                               id="grade"
                               name="grade"
                               min="0"
                               max="100"
                               step="0.1"
                               value="{{ old('grade', $grade->grade ?? '') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="feedback" class="form-label">Feedback</label>
                        <textarea class="form-control"
                                  id="feedback"
                                  name="feedback"
                                  rows="5">{{ old('feedback', $grade->feedback ?? '') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('assignments.showAssignmentDosen', $assignment->id) }}"
                           class="btn btn-secondary me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Save Grade
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
