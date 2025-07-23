<!-- Tambahkan CDN untuk Bootstrap 5, jQuery, dan DataTables -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Judul dan Tombol Tambah Course -->
        <div class="card mt-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border border-primary p-3 rounded">
                    <h4 class="mb-0">Learning Management Dashboard</h4>
                    <a href="{{ route('course.create') }}" class="btn btn-primary" aria-label="Add New Course">
                        + Add Course
                    </a>
                </div>
            </div>
        </div>

        <!-- Row: Course List dan Statistik -->
        <div class="card mt-3">
            <div class="row">
                <!-- KIRI: Tabel Course -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold">Course List</h6>
                            <table class="table table-striped table-bordered table-hover table-responsive" id="courseTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" aria-label="Select All Courses"></th>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Instructor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($courses as $course)
                                    <tr>
                                        <td><input type="checkbox" checked aria-label="Select Course"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $course->full_name }}</td>
                                        <td>
                                            @php
                                                $teacher = $course->users->first(function ($user) {
                                                    return $user->pivot->participant_role === 'Teacher';
                                                });
                                            @endphp
                                            {{ $teacher ? $teacher->name : 'Tidak ada instruktur' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" data-bs Rheum-toggle="tooltip" title="View">
                                                <i class="fi-rr-eye"></i>
                                            </a>
                                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fi-rr-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse" data-id="{{ $course->id }}" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="fi-rr-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">Tidak ada kursus yang tersedia</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Statistik Card -->
                <div class="col-md-4">
                    <!-- Courses Card -->
                    <div class="card shadow-sm mb-3 hover-shadow">
                        <div class="card-body text-center">
                            <div>
                                <a href="{{ route('coursesadmin.index') }}" class="text-dark text-decoration-none hover-primary">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-2">Courses</h6>
                                    <p class="display-6 fw-bold mb-1 text-dark"> {{ $course_count }} </p>
                                    <small class="text-muted">Modules:  {{ $section_count }} </small>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Card -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body text-center">
                            <h6 class="text-muted text-uppercase fw-semibold mb-2">Instructor</h6>
                            <p class="display-6 fw-bold mb-1 text-dark">{{ $instructor_count }}</p>
                            <small class="text-muted">Active Instructors</small>
                        </div>
                    </div>

                    <!-- Students Card -->
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted text-uppercase fw-semibold mb-2">Students</h6>
                            <p class="display-6 fw-bold mb-1 text-dark">{{ $student_count }}</p>
                            <small class="text-muted">Enrolled</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- USERS Section -->
        <div class="card mt-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold">USERS</h6>
                        <a href="#" class="btn btn-primary btn-sm" aria-label="Add New User">+ Add User</a>
                    </div>
                    <table class="table table-striped table-bordered table-hover align-middle" id="userTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" aria-label="Select All Users"></th>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                            <tr>
                                <td><input type="checkbox" checked aria-label="Select User"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role->name_role }}</td>
                                <td>
                                    <form class="status-form" data-id="{{ $user->id }}">
                                        <select class="form-select form-select-sm" name="status" onchange="updateStatus(this)">
                                            <option value="pending" @if($user->status == 'pending') selected @endif>Pending</option>
                                            <option value="active" @if($user->status == 'active') selected @endif>Active</option>
                                            <option value="non-active" @if($user->status == 'non-active') selected @endif>Non-active</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="View" aria-label="View User">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Edit" aria-label="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline deleteUserForm" aria-label="Delete User">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi DataTables untuk Course Table
    $('#courseTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [0, 4] }, // Kolom checkbox dan action tidak dapat diurutkan
            { searchable: false, targets: [0, 1, 4] } // Kolom checkbox, No, dan action tidak dapat dicari
        ],
        language: {
            search: '<span class="input-group-text"><i class="fas fa-search"></i></span>',
            searchPlaceholder: 'Search courses...'
        }
    });

    // Inisialisasi DataTables untuk User Table
    $('#userTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [0, 5] }, // Kolom checkbox dan action tidak dapat diurutkan
            { searchable: false, targets: [0, 1, 5] } // Kolom checkbox, No, dan action tidak dapat dicari
        ],
        language: {
            search: '<span class="input-group-text"><i class="fas fa-search"></i></span>',
            searchPlaceholder: 'Search users...'
        }
    });

    // Inisialisasi tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    console.log('Tooltip elements found:', tooltipTriggerList.length);
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Inisialisasi tombol hapus untuk Course
    $('body').on('click', '.deleteCourse', function () {
        var course_id = $(this).data("id");
        console.log('Delete button clicked, course ID:', course_id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('courses.destroy', ':id') }}".replace(':id', course_id),
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log('Delete success:', data);
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                data.success,
                                'success'
                            );
                            $('#courseTable').DataTable().row($(`button[data-id="${course_id}"]`).closest('tr')).remove().draw();
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'Failed to delete course.',
                                'error'
                            );
                        }
                    },
                    error: function (xhr) {
                        console.error('Delete error:', xhr);
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred.';
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Event listener untuk form hapus user
    document.querySelectorAll('.deleteUserForm').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Delete user form submitted');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const userId = form.querySelector('button').closest('form').action.split('/').pop();
                    console.log('Deleting user ID:', userId);

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: $(form).serialize(),
                        dataType: 'json',
                        success: function (response) {
                            console.log('Delete user success:', response);
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.success,
                                    'success'
                                );
                                $('#userTable').DataTable().row(form.closest('tr')).remove().draw();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.error || 'Failed to delete user.',
                                    'error'
                                );
                            }
                        },
                        error: function (xhr) {
                            console.error('Delete user error:', xhr);
                            var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred.';
                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    // Pastikan jQuery dimuat
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
    }
});

// Fungsi untuk memperbarui status pengguna
function updateStatus(selectElement) {
    var userId = $(selectElement).closest('.status-form').data('id');
    var newStatus = $(selectElement).val();

    console.log('Updating status for user ID:', userId, 'to:', newStatus);

    $.ajax({
        url: '/users/approve/' + userId,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            status: newStatus
        },
        dataType: 'json',
        success: function (response) {
            console.log('Update status success:', response);
            if (response.success) {
                Swal.fire(
                    'Success!',
                    response.success,
                    'success'
                );
            } else {
                Swal.fire(
                    'Error!',
                    response.error || 'Failed to update status.',
                    'error'
                );
            }
        },
        error: function (xhr) {
            console.error('Update status error:', xhr);
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred.';
            Swal.fire(
                'Error!',
                errorMessage,
                'error'
            );
        }
    });
}
</script>
