<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Assignment Header -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h1 class="mb-1">{{ $assignment->name }}</h1>
                <div class="d-flex flex-wrap text-muted fs-6">
                    <div class="me-4">
                        <span class="fw-bold">Created:</span>
                        {{ $assignment->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <hr class="my-4">

                <!-- Grading Summary -->
                <h5 class="mb-3">Grading summary</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th scope="row" class="w-25 bg-light">Hidden from students</th>
                            <td>No</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Participants</th>
                            <td>{{ $participants }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Submitted</th>
                            <td>{{ $submitted }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Time Remaining -->
                <div class="mt-4">
                    <h5>Time remaining</h5>
                    <td>
                        @if($assignment->due_date && $assignment->created_at)
                            @php
                                $createdAt = \Carbon\Carbon::parse($assignment->created_at);
                                $dueDate = \Carbon\Carbon::parse($assignment->due_date);
                                $diffInSeconds = $dueDate->diffInSeconds($createdAt, true);

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
                </div>

                <!-- List of Student Submissions -->
                <div class="mt-5">
                    <h5 class="mb-3">Student Submissions</h5>

                    @if($submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Student Name</th>
                                    <th>Submission Time</th>
                                    <th>Files</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($submissions as $index => $submission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $submission->user->name }}</td>
                                        <td>
                                            @php
                                                // Gunakan submitted_at jika ada, jika tidak gunakan created_at
                                                $submitTime = $submission->submitted_at ?? $submission->created_at;
                                            @endphp

                                            @if($submitTime)
                                                {{ $submitTime->format('d M Y, H:i') }}
                                                <small class="text-muted d-block">
                                                    ({{ $submitTime->diffForHumans() }})
                                                </small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $filePaths = is_array(json_decode($submission->file_path)) ?
                                                            json_decode($submission->file_path) :
                                                            [$submission->file_path];
                                            @endphp

                                            @foreach($filePaths as $filePath)
                                                @if($filePath)
                                                    <div class="mb-2">
                                                        <a href="{{ Storage::url($filePath) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-file-download me-1"></i> {{ basename($filePath) }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($submission->grade)
                                                {{ $submission->grade->grade }}
                                                @if($submission->grade->feedback)
                                                    <button class="btn btn-sm btn-link" data-bs-toggle="tooltip"
                                                            title="{{ $submission->grade->feedback }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                @endif
                                            @else
                                                {{-- Cek grade berdasarkan assignment_id jika submission_id NULL --}}
                                                @php
                                                    $alternativeGrade = \App\Models\MDLAssignGrades::where('assign_id', $assignment->id)
                                                        ->where('user_id', $submission->user_id)
                                                        ->first();
                                                @endphp

                                                @if($alternativeGrade)
                                                    {{ $alternativeGrade->grade }}
                                                    @if($alternativeGrade->feedback)
                                                        <button class="btn btn-sm btn-link" data-bs-toggle="tooltip"
                                                                title="{{ $alternativeGrade->feedback }}">
                                                            <i class="fas fa-info-circle"></i>
                                                        </button>
                                                    @endif
                                                @else
                                                    Not graded
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('assignment.grade', ['assignment' => $assignment->id, 'submission' => $submission->id]) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Grade
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No submissions yet.
                        </div>
                    @endif
                </div>
            </div>
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
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.02);
        }
    </style>
@endsection
{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function(){--}}
{{--            $('[data-bs-toggle="tooltip"]').tooltip();--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}

