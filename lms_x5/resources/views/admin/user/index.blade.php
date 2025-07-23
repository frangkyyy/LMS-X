<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h2 class="mb-0">{{$title}}</h2>
                <div class="d-flex flex-row-reverse">
                    <button class="btn btn-sm btn-primary font-weight-bold px-4" id="createNewUser">
                        <i class="fas fa-plus mr-2"></i>Add Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableUser">
                            <thead class="bg-light font-weight-bold text-center">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="width: 90px;">Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            {{-- Data akan terisi otomatis oleh DataTables --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Create/Edit User -->
<div class="modal fade" id="modal-user" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">User</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUser" name="formUser">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_role" class="form-label">Role</label>
                        <select name="id_role" class="form-control" id="id_role">
                            @foreach($roles as $role)
                                <option value="{{ $role->id_role }}">{{ $role->name_role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                            <option value="non-active">Non-Active</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for View User -->
<div class="modal fade" id="view-user-modal" tabindex="-1" role="dialog" aria-labelledby="viewUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="viewUserLabel">User Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><strong>Name:</strong> <span id="view-name"></span></div>
                <div class="mb-3"><strong>Email:</strong> <span id="view-email"></span></div>
                <div class="mb-3"><strong>Role:</strong> <span id="view-role"></span></div>
                <div class="mb-3"><strong>Status:</strong> <span id="view-status"></span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            // Success alert
            function swal_success() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1000
                });
            }

            // Error alert
            function swal_error(message) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: message || 'Terjadi kesalahan!',
                    showConfirmButton: true
                });
            }

            // Initialize DataTable
            var table = $('#tableUser').DataTable({
                processing: false,
                serverSide: true,
                ordering: false,
                dom: '<"d-flex justify-content-between mb-3"Bf>rtip',
                buttons: ['copy', 'excel', 'pdf'],
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
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'name_role',
                        name: 'name_role',
                        render: function(data, type, row) {
                            return row.role ? row.role.name_role : 'No Role';
                        }
                    },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Initialize button for adding new user
            $('#createNewUser').click(function () {
                $('#saveBtn').val("create-user");
                $('#user_id').val('');
                $('#formUser').trigger("reset");
                $('#exampleModalLabel').text('Tambah User');
                $('#modal-user').modal('show');
            });

            // Initialize button for editing user
            $('body').on('click', '.editUser', function () {
                var user_id = $(this).data('id');
                $.get("{{ route('users.edit', ':id') }}".replace(':id', user_id), function (data) {
                    $('#saveBtn').val("edit-user");
                    $('#exampleModalLabel').text('Edit User');
                    $('#modal-user').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#status').val(data.status);
                    $('#id_role').val(data.id_role);
                }).fail(function (xhr) {
                    console.error("Error fetching user data:", xhr);
                    swal_error('Gagal mengambil data user');
                });
            });

            // Initialize button for viewing user
            $('body').on('click', '.viewUser', function (e) {
                e.preventDefault();
                var user_id = $(this).data('id');
                $.get("{{ route('users.edit', ':id') }}".replace(':id', user_id), function (data) {
                    $('#view-name').text(data.name);
                    $('#view-email').text(data.email);
                    $('#view-role').text(data.role ? data.role.name_role : 'No Role');
                    $('#view-status').text(data.status);
                    $('#view-user-modal').modal('show');
                }).fail(function (xhr) {
                    console.error("Error fetching user data:", xhr);
                    swal_error('Gagal mengambil data user');
                });
            });

            // Initialize save button to create or update user
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Menyimpan...');

                var user_id = $('#user_id').val();
                var password = $('#password').val();

                // Validasi password untuk user baru
                if (!user_id && (!password || password.length < 5)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Dibutuhkan',
                        text: 'Password harus minimal 5 karakter untuk user baru!'
                    });
                    $(this).html('Save changes');
                    return;
                }

                var url = user_id ? "{{ route('users.update', ':id') }}".replace(':id', user_id) : "{{ route('users.store') }}";
                var method = user_id ? 'PUT' : 'POST';
                var data = $('#formUser').serializeArray();

                $.ajax({
                    data: $.param(data),
                    url: url,
                    type: method,
                    dataType: 'json',
                    success: function (data) {
                        $('#formUser').trigger("reset");
                        $('#modal-user').modal('hide');
                        $('#saveBtn').html('Save changes');
                        swal_success();
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        $('#saveBtn').html('Save changes');
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Terjadi kesalahan!';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        swal_error(errorMsg);
                        console.error(xhr.responseJSON);
                    }
                });
            });

            // Initialize button for deleting user
            $('body').on('click', '.deleteUser', function () {
                var user_id = $(this).data("id");

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('users.destroy', ':id') }}".replace(':id', user_id),
                            success: function (data) {
                                swal_success();
                                table.draw();
                            },
                            error: function (xhr) {
                                var errorMsg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Gagal menghapus user';
                                swal_error(errorMsg);
                            }
                        });
                    }
                });
            });

            // Optional: Keep row click for view, but exclude action column
            $('body').on('click', '#tableUser tbody tr', function (e) {
                var $clickedElement = $(e.target);
                var $clickedCell = $clickedElement.closest('td');

                // Prevent modal if clicking action column or specific buttons
                if (
                    $clickedCell.index() === 5 ||
                    $clickedElement.closest('button').length > 0 ||
                    $clickedElement.hasClass('editUser') ||
                    $clickedElement.hasClass('deleteUser') ||
                    $clickedElement.hasClass('viewUser') ||
                    $clickedElement.closest('a').hasClass('editUser') ||
                    $clickedElement.closest('a').hasClass('deleteUser') ||
                    $clickedElement.closest('a').hasClass('viewUser')
                ) {
                    return;
                }

                var user_id = table.row(this).data().id;
                $.get("{{ route('users.edit', ':id') }}".replace(':id', user_id), function (data) {
                    $('#view-name').text(data.name);
                    $('#view-email').text(data.email);
                    $('#view-role').text(data.role ? data.role.name_role : 'No Role');
                    $('#view-status').text(data.status);
                    $('#view-user-modal').modal('show');
                }).fail(function (xhr) {
                    console.error("Error fetching user data:", xhr);
                    swal_error('Gagal mengambil data user');
                });
            });
        });
    </script>
@endpush
