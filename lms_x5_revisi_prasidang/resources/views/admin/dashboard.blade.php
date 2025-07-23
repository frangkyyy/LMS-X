<!-- Tambahkan CDN untuk Bootstrap 5, jQuery, dan DataTables -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





<div class="content d-flex flex-column flex-column-fluid mt-0" id="kt_content">
    <div class="container-fluid">
        <!-- Judul dan Tombol Tambah Course -->
        <div class="card  mb-4 shadow-sm bg-light">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center ">
                    <h4 class="mb-0 fw-bold">Learning Management Dashboard</h4>
                    <a href="{{ route('course.create') }}" class="btn btn-primary" aria-label="Add New Course">
                        + Add Course
                    </a>
                </div>
            </div>
        </div>

        <!-- Row: Course List dan Statistik -->
        <div class="row">
            <div class="col-lg-10 mb-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Course List</h5>
                        <!-- Adding row for export buttons and search -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="btn-group" role="group" id="exportButtons">
                                    <!-- Buttons will be appended here by DataTables -->
                                </div>
                            </div>
                        </div>
                        <!-- Course Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="courseTable">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Instructor</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($courses as $course)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $course->full_name}}</td>
                                        <td>
                                            @php
                                                $teacher = $course->users && $course->users->count() > 0
                                                    ? $course->users->first(function ($user) {
                                                        return $user->pivot->participant_role === 'Teacher';
                                                    })
                                                    : null;
                                            @endphp
                                            {{ $teacher ? $teacher->name : 'No Instructor' }}
                                        </td>
                                        <td>{{ $course->visible ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" data-bs-toggle="tooltip" title="View">
                                                    <i class="fi-rr-eye"></i>
                                                </a>
                                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fi-rr-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse" data-id="{{ $course->id }}" data-bs-toggle="tooltip" title="Delete">
                                                    <i class="fi-rr-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No courses available</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: Statistik Cards -->
            <div class="col-lg-2">
                <!-- Courses Card -->
                <div class="card border-0 mt-4 shadow-sm bg-light" data-hover="true">
                    <div class="card-body text-center">
                        <a href="{{ route('coursesadmin.index') }}" class="text-decoration-none">
                            <h6 class="text-muted text-uppercase fw-semibold mb-2">Courses</h6>
                            <h3 class="fw-bold mb-1 text-dark">{{ $course_count }}</h3>
                            <small class="text-muted">Modules: {{ $section_count }}</small>
                        </a>
                    </div>
                </div>

                <!-- Instructor Card -->
                <div class="card border-0 mt-4 shadow-sm bg-light" data-hover="true">
                    <div class="card-body text-center">
                        <h6 class="text-muted text-uppercase fw-semibold mb-2">Instructors</h6>
                        <h3 class="fw-bold mb-1 text-dark">{{ $instructor_count }}</h3>
                        <small class="text-muted">Active Instructors</small>
                    </div>
                </div>

                <!-- Students Card -->
                <div class="card border-0 mt-4 shadow-sm bg-light" data-hover="true">
                    <div class="card-body text-center">
                        <h6 class="text-muted text-uppercase fw-semibold mb-2">Students</h6>
                        <h3 class="fw-bold mb-1 text-dark">{{ $student_count }}</h3>
                        <small class="text-muted">Enrolled</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- USERS Section -->
        <div class="card border-0 mb-4 shadow-sm bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 ">
                    <h5 class="fw-bold mb-0">User List</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-primary " aria-label="Add New User">Manage User</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle" id="tableUser">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>NRP/NIP/NIK</th>
                            <th>NAME</th>
                            <th>Email</th>
                            <th>ROLE</th>
                            <th>STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Data will be populated by DataTable -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable untuk tableUser
        var table = $('#tableUser').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
            buttons: [
                { extend: 'copy', text: 'Copy', className: 'btn btn-outline-secondary btn-sm me-2' },
                { extend: 'excel', text: 'Excel', className: 'btn btn-outline-secondary btn-sm me-2' },
                { extend: 'pdf', text: 'PDF', className: 'btn btn-outline-secondary btn-sm' }
            ],
            ajax: "{{ route('users.index') }}",
            columns: [
                {
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                {
                    data: 'name_role',
                    name: 'name_role',
                    render: function(data, type, row) {
                        return row.role ? row.role.name_role : 'No Role';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        const statuses = ['pending', 'active', 'non-active'];
                        let badges = '';
                        statuses.forEach(status => {
                            let badgeClass = '';
                            let textClass = '';
                            const capitalizedStatus = status.charAt(0).toUpperCase() + status.slice(1);

                            if (status === data) {
                                switch (status) {
                                    case 'pending':
                                        badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'active':
                                        badgeClass = 'bg-success text-white';
                                        break;
                                    case 'non-active':
                                        badgeClass = 'bg-danger text-white';
                                        break;
                                }
                            } else {
                                switch (status) {
                                    case 'pending':
                                        badgeClass = 'border-warning';
                                        textClass = 'text-warning';
                                        break;
                                    case 'active':
                                        badgeClass = 'border-success';
                                        textClass = 'text-success';
                                        break;
                                    case 'non-active':
                                        badgeClass = 'border-danger';
                                        textClass = 'text-danger';
                                        break;
                                }
                            }

                            badges += `
                            <span class="badge status-badge ${badgeClass} ${textClass} me-1"
                                  data-id="${row.id}"
                                  data-status="${status}"
                                  style="cursor: pointer; padding: 6px 10px;"
                                  data-bs-toggle="tooltip"
                                  data-bs-title="Set to ${capitalizedStatus}">
                                ${capitalizedStatus}
                            </span>
                        `;
                        });

                        return `<div class="d-flex">${badges}</div>`;
                    }
                }
            ],
            language: {
                search: 'Search:',
                searchPlaceholder: ''
            }
        });

        // Event listener untuk klik badge
        $('#tableUser').on('click', '.status-badge', function() {
            const userId = $(this).data('id');
            const newStatus = $(this).data('status');
            updateStatus(userId, newStatus, $(this));
        });

        // Inisialisasi DataTable untuk courseTable
        const courseTable = $('#courseTable').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip', // Sama dengan tableUser
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-outline-secondary btn-sm me-2',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-secondary btn-sm me-2',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-secondary btn-sm',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ],
            language: {
                search: 'Search:', // Label pencarian
                searchPlaceholder: 'Search courses...'
            },
            columnDefs: [
                { orderable: false, targets: 4 }
            ]
        });

        // Move buttons to custom container
        courseTable.buttons().container().appendTo('#exportButtons');

        // Inisialisasi tooltips untuk semua elemen
        $('[data-bs-toggle="tooltip"]').tooltip();
        // Tambahkan efek hover menggunakan JavaScript
        $('[data-hover="true"]').hover(
            function () {
                $(this).removeClass('shadow-sm').addClass('shadow');
                $(this).removeClass('bg-light').addClass('bg-white');
            },
            function () {
                $(this).removeClass('shadow').addClass('shadow-sm');
                $(this).removeClass('bg-white').addClass('bg-light');
            }
        );

// Event listener untuk tombol delete course
        $('#courseTable').on('click', '.deleteCourse', function () {
            const courseId = $(this).data('id');
            const row = $(this).closest('tr'); // Get the row for DataTable manipulation

            // Validasi courseId
            if (!courseId) {
                Swal.fire('Error!', 'Invalid course ID.', 'error');
                return;
            }

            // Konfirmasi sebelum hapus
            Swal.fire({
                title: 'Are you sure?',
                text: 'This course will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim AJAX DELETE request
                    $.ajax({
                        url: `/courses/${courseId}`, // Adjust the URL to match your Laravel route (e.g., route('courses.destroy', $courseId))
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function (response) {
                            if (response.success) {
                                // Hapus baris dari DataTable
                                courseTable.row(row).remove().draw(false);
                                Swal.fire('Deleted!', response.message || 'Course deleted successfully.', 'success');
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete course.', 'error');
                            }
                        },
                        error: function (xhr) {
                            const errorMessage = xhr.responseJSON?.message || 'An error occurred while deleting the course.';
                            Swal.fire('Error!', errorMessage, 'error');
                        }
                    });
                }
            });
        });
    });

    // Fungsi untuk memperbarui status pengguna
    function updateStatus(userId, newStatus, badgeElement) {
        // Validasi input
        if (!userId || !newStatus || !badgeElement) {
            Swal.fire('Error!', 'Invalid parameters provided.', 'error');
            return;
        }

        // Konfirmasi sebelum update (opsional, tambahkan jika diperlukan)
        Swal.fire({
            title: 'Are you sure?',
            text: `Change status to ${newStatus}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/users/approve/${userId}`, // Pastikan URL sesuai dengan route Laravel
                    type: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // Ambil CSRF token secara dinamis
                        status: newStatus
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message || 'Status updated successfully.', 'success');

                            // Perbarui badge di UI
                            const row = badgeElement.closest('tr');
                            const statusCell = $(row).find('td.status-column'); // Ganti dengan selector kolom status
                            statusCell.html(`<span class="badge badge-${newStatus === 'approved' ? 'success' : 'danger'}">${newStatus}</span>`);

                            // Perbarui tabel DataTables
                            if (typeof table !== 'undefined' && table.row) {
                                table.row(row).invalidate().draw(false);
                            }
                        } else {
                            Swal.fire('Error!', response.message || 'Failed to update status.', 'error');
                        }
                    },
                    error: function (xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'An error occurred while updating status.';
                        Swal.fire('Error!', errorMessage, 'error');
                    }
                });
            }
        });
    }
</script>
