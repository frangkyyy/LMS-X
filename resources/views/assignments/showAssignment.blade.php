<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $subTopic->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="assignment">{{ $assignment->name }}</li>
            </ol>
        </nav>

        <!-- Pesan Error atau Sukses -->
        @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors')->first() }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Assignment Header -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h1 class="mb-1">{{ $assignment->name }}</h1>
                <div class="d-flex flex-wrap text-muted fs-6">
                    <div class="me-4">
                        <span class="fw-bold">Created:</span>
                        {{ $assignment->created_at->format('d/m/Y h:i A') }}
                    </div>
                    <div>
                        <span class="fw-bold">Due Date:</span>
                        {{ $assignment->due_date ? $assignment->due_date->format('d/m/Y h:i A') : 'No due date' }}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Assignment Description -->
                <div class="mb-4">
                    <p class="mb-2">{!! $assignment->description !!}</p>
                    @if($assignment->content)
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0 fst-italic">{!! $assignment->content !!}</p>
                        </div>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Submission Status -->
                <h5 class="mb-3">Submission status</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row" class="w-25 bg-light">Submission status</th>
                                <td>{{ $submission ? 'Submitted' : 'No attempt' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="bg-light">Grading status</th>
                                <td>
                                    @php
                                        // Cek grade melalui relasi submission jika ada
                                        $grade = $submission->grade ?? null;

                                        // Jika tidak ada, cari grade berdasarkan assignment_id dan user_id
                                        if (!$grade && $submission) {
                                            $grade = \App\Models\MDLAssignGrades::where('assign_id', $assignment->id)
                                                ->where('user_id', $submission->user_id)
                                                ->first();
                                        }
                                    @endphp

                                    @if($grade)
                                        <div class="d-flex flex-column">
                                            <span>Graded: <strong>{{ $grade->grade }}</strong></span>
                                        </div>
                                    @else
                                        <span class="text-muted">Not graded yet</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="bg-light">Time remaining</th>
                                <td>
                                    @if($assignment->due_date && $assignment->created_at)
                                        @php
                                            $createdAt = \Carbon\Carbon::parse($assignment->created_at);
                                            $dueDate = \Carbon\Carbon::parse($assignment->due_date);
                                            $diffInSeconds = $dueDate->diffInSeconds($createdAt, false);

                                            if ($diffInSeconds < 0) {
                                                $overdue = $createdAt->diff($dueDate);
                                                $overdueText = '';
                                                if ($overdue->d > 0) $overdueText .= $overdue->d . ' days ';
                                                if ($overdue->h > 0) $overdueText .= $overdue->h . ' hours ';
                                                if ($overdue->i > 0) $overdueText .= $overdue->i . ' mins';
                                                $remaining = " " . ($overdueText ?: 'less than 1 minute');
                                            } else {
                                                $remainingTime = $createdAt->diff($dueDate);
                                                $remaining = '';
                                                if ($remainingTime->d > 0) $remaining .= $remainingTime->d . ' days ';
                                                if ($remainingTime->h > 0) $remaining .= $remainingTime->h . ' hours ';
                                                if ($remainingTime->i > 0) $remaining .= $remainingTime->i . ' mins';
                                                $remaining = $remaining ?: 'Less than 1 minute';
                                            }
                                        @endphp
                                        {{ $remaining }}
                                    @else
                                        No due date
                                    @endif
                                </td>
                            </tr>

                            {{-- <tr>
                                <th scope="row" class="bg-light">Last modified</th>
                                <td>{{ $submission ? $submission->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr> --}}
                            <tr>
                                <th scope="row" class="bg-light">Submission comments</th>
                                <td>
                                    @php
                                        // Cek grade melalui relasi submission jika ada
                                        $grade = $submission->grade ?? null;

                                        // Jika tidak ada, cari grade berdasarkan assignment_id dan user_id
                                        if (!$grade && $submission) {
                                            $grade = \App\Models\MDLAssignGrades::where('assign_id', $assignment->id)
                                                ->where('user_id', $submission->user_id)
                                                ->first();
                                        }
                                    @endphp

                                    @if($grade)
                                        <div class="d-flex flex-column">
                                            <span><strong>{{ $grade->feedback }}</strong></span>
                                        </div>
                                    @else
                                        <span class="text-muted">Not graded yet</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Submission Form -->
                @if(!$submission || $assignment->allow_resubmission)
                    <div class="mt-5">
                        <h5 class="mb-3">Submission</h5>
                        <form action="{{ route('assignment.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="assign_id" value="{{ $assignment->id }}">
                            <div class="mb-3">
                                <label for="file_path" class="form-label">Upload files</label>
                                <input
                                    class="form-control"
                                    type="file"
                                    id="file_path"
                                    name="file_path[]"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.bmp"
                                    multiple
                                    required
                                >
                                <div class="form-text">
                                    Maximum file size per file: 50MB. Accepted formats: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG, GIF, BMP
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="submission_text" class="form-label">Additional comments</label>
                                <textarea class="form-control" id="submission_text" name="submission_text" rows="3">{{ old('submission_text') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirm_submission" name="confirm_submission" required>
                                    <label class="form-check-label" for="confirm_submission">
                                        I confirm this is my original work
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-upload me-1"></i> Submit assignment
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i> You have already submitted this assignment.

                    @php
                        $filePaths = is_array(json_decode($submission->file_path)) ? json_decode($submission->file_path) : [$submission->file_path];
                    @endphp

                    @if(!empty($filePaths))
                        <div class="mt-3">
                            <strong>Uploaded Files:</strong>
                            <ul class="list-unstyled">
                                @foreach($filePaths as $path)
                                    <li class="mb-2">
                                        <!-- Menggunakan Storage::url() untuk akses file yang benar -->
                                        <a href="{{ Storage::url($path) }}" class="btn btn-sm btn-outline-primary me-2" download>
                                            <i class="fas fa-file-download me-1"></i> {{ basename($path) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <!-- Cancel submission -->
                    <form action="{{ route('assignment.cancel') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel your submission?');">
                            <i class="fas fa-times me-1"></i> Cancel Submission
                        </button>
                    </form>
                </div>

                @endif
            </div>
        </div>

        <!-- Tombol Navigasi -->
        <div class="mt-4">
            <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Section
            </a>
        </div>
    </div>
</div>

@section('styles')
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .table th {
        font-weight: 500;
        background-color: #f8f9fa;
    }
    .bg-light {
        background-color: #f8f9fa!important;
    }
</style>
@endsection
