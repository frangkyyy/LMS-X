<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Manajemen Course</h2>
                <div class="d-flex flex-row-reverse">
                    <a href="{{ route('course.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Course
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tableCourse">
                            <thead class="font-weight-bold text-center">
                                <tr>
                                    <th>Kode Kursus</th>
                                    <th>Judul</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Instruktur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($courses as $course)
                                    <tr>
                                        <td>{{ $course->short_name }}</td>
                                        <td>{{ $course->full_name }}</td>
                                        <td>{{ $course->semester }}</td>
                                        <td>{{ $course->visible ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            @php
                                            $teacher = $course->users->first(function ($user) {
                                                return $user->pivot->participant_role === 'Teacher';
                                            });
                                        @endphp
                                        {{ $teacher ? $teacher->name : 'Tidak ada instruktur' }}                                        </td>
                                        <td>
                                            <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" data-bs-toggle="tooltip" title="Lihat Topik">
                                                <i class="fi-rr-eye"></i>
                                            </a>
                                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fi-rr-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse" data-bs-toggle="tooltip" data-id="{{ $course->id }}" title="Hapus">
                                                <i class="fi-rr-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Tidak ada kursus yang tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center">
                            @if($courses instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $courses->links() }}
                            @else
                                <p>Pagination not available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-course" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Modal Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCourse" name="formCourse">
                    <div class="form-group">
                        <input type="text" name="short_name" class="form-control" id="short_name" placeholder="Kode Kursus">
                        <br>
                        <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Judul Kursus">
                        <br>
                        <input type="number" name="semester" class="form-control" id="semester" placeholder="Semester">
                        <br>
                        <select name="visible" class="form-control" id="visible">
                            <option value="-">Pilih Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <br>
                        <input type="hidden" name="course_id" id="course_id" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    // Success alert
    function swal_success() {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1000
        });
    }

    // Error alert
    function swal_error(message) {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Something went wrong!',
            text: message || 'An error occurred.',
            showConfirmButton: true
        });
    }

    // CSRF token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize btn delete
    $('body').on('click', '.deleteCourse', function () {
        var course_id = $(this).data("id");

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
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            swal_success();
                            window.location.reload();
                        } else {
                            swal_error(data.message);
                        }
                    },
                    error: function (xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred.';
                        swal_error(errorMessage);
                    }
                });
            }
        });
    });
});
</script>
@endpush
