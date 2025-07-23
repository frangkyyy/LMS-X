@foreach($assignments as $assignment)
@php
    $userSubmission = null;
    $isLate = false;

    if ($assignment) {
        $userSubmission = \App\Models\MDLAssignSubmission::where('assign_id', $assignment->id)
            ->where('user_id', Auth::id())
            ->first();

        $isLate = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($assignment->due_date));
    }
@endphp

@if ($assignment)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="fw-bold text-primary">{{ $assignment->name }}</h4>
            <p>{!! $assignment->description !!}</p>
            <div class="mb-3">
<span class="badge bg-success me-2">
    <strong>Due Date:</strong>
    {{ \Carbon\Carbon::parse($assignment->due_date)->translatedFormat('l, d F Y, H:i') }}
</span>
            </div>

            @if ($userSubmission)
                <div class="alert alert-success">
                    Anda telah mengumpulkan tugas ini.
                    <br>
                    <strong>Status:</strong> {{ ucfirst($userSubmission->status) }} <br>
                    <strong>Waktu Submit:</strong> {{ \Carbon\Carbon::parse($userSubmission->created_at)->translatedFormat('d F Y, H:i') }} <br>
                    <a href="{{ asset($userSubmission->file_path) }}" target="_blank" class="btn btn-sm btn-info mt-2">Lihat File</a>

                    <form action="{{ route('assignment.cancel') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="submission_id" value="{{ $userSubmission->id }}">
                        <button type="submit" class="btn btn-sm btn-warning mt-2" onclick="return confirm('Yakin ingin membatalkan pengumpulan tugas?')">Batalkan Pengumpulan</button>
                    </form>
                </div>
            @elseif ($isLate)
                <div class="alert alert-danger">
                    Maaf, waktu pengumpulan tugas telah berakhir. Anda tidak dapat mengumpulkan tugas ini.
                </div>
            @else
                <form action="{{ route('assignment.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="assign_id" value="{{ $assignment->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="mb-3">
                        <label for="file_path" class="form-label">Upload Tugas (PDF/DOCX)</label>
                        <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Kumpulkan Tugas</button>
                </form>
            @endif
        </div>
    </div>
@endif
@endforeach