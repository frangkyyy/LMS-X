<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="participantModalLabel">Peserta {{ $course->full_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Nama</th>
{{--                            <th>Peran</th>--}}
{{--                            <th>Aksi</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($participants as $participant)
                            <tr>
                                <td>{{ $participant['name'] }}</td>
{{--                                <td>--}}
{{--                                    <form action="{{ route('participants.update', $participant['id']) }}"--}}
{{--                                          method="POST" class="role-form">--}}
{{--                                        @csrf--}}
{{--                                        @method('PUT')--}}
{{--                                        <select name="participant_role" class="form-select form-select-sm"--}}
{{--                                                data-participant-id="{{ $participant['id'] }}">--}}
{{--                                            <option value="Student"--}}
{{--                                                {{ $participant['participant_role'] == 'Student' ? 'selected' : '' }}>--}}
{{--                                                Student--}}
{{--                                            </option>--}}
{{--                                            <option value="Teacher"--}}
{{--                                                {{ $participant['participant_role'] == 'Teacher' ? 'selected' : '' }}>--}}
{{--                                                Teacher--}}
{{--                                            </option>--}}
{{--                                            <option value="Admin"--}}
{{--                                                {{ $participant['participant_role'] == 'Admin' ? 'selected' : '' }}>--}}
{{--                                                Admin--}}
{{--                                            </option>--}}
{{--                                        </select>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <form action="{{ route('participants.destroy', $participant['id']) }}"--}}
{{--                                          method="POST" class="delete-participant-form">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                        <button type="submit" class="btn btn-sm btn-danger">--}}
{{--                                            <i class="bi bi-trash"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addParticipantModal-{{ $course->id }}">
                    <i class="bi bi-person-plus"></i> Tambah Peserta
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Add Participant -->
<div class="modal fade" id="addParticipantModal-{{ $course->id }}" tabindex="-1"
     aria-labelledby="addParticipantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParticipantModalLabel">Tambah Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-participant-form-{{ $course->id }}"
                  action="{{ route('participantku.store', $course->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 d-flex align-items-center">
                        <input type="text" class="form-control me-2" id="participant-search-{{ $course->id }}"
                               placeholder="Cari pengguna berdasarkan ID atau nama" autocomplete="off">
                        <select class="form-select me-2" id="participant-role-{{ $course->id }}" style="width: 120px;">
                            <option value="Student">Student</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div id="search-results-{{ $course->id }}" class="dropdown-menu w-100 mt-1"
                         style="max-height: 200px; overflow-y: auto; display: none;"></div>
                    <div id="participant-warning-{{ $course->id }}" class="text-danger mt-2" style="display: none;">
                        Pengguna sudah ada di kursus ini atau daftar yang dipilih. Silakan pilih yang lain.
                    </div>
                    <div class="mb-3">
                        <ul id="selected-participants-{{ $course->id }}" class="list-group"
                            style="max-height: 150px; overflow-y: auto;">
                            <li class="list-group-item text-muted" id="no-participants-{{ $course->id }}">Belum ada peserta yang ditambahkan.</li>
                        </ul>
                    </div>
                    <input type="hidden" name="participants" id="participants-input-{{ $course->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="next-btn">Lanjut</button>
                </div>
            </form>
        </div>
    </div>
</div>
