<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-2"></i>
                            Peserta Kursus: {{ $course->full_name }}
                            <span class="badge bg-primary ml-2">{{ $students->count() }} Orang</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
{{--                                    <th>Bergabung Pada</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
{{--                                        <td>{{ $student->created_at->format('d/m/Y') }}</td>--}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Tidak ada peserta</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--@push('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#participantsTable').DataTable({--}}
{{--                processing: true,--}}
{{--                serverSide: true,--}}
{{--                ajax: {--}}
{{--                    url: "{{ route('course.participants', ['course' => $course->id]) }}",--}}
{{--                    type: "GET",--}}
{{--                    error: function(jqXHR, textStatus, errorThrown) {--}}
{{--                        console.error("DataTables Error:", textStatus, errorThrown);--}}
{{--                        // Tampilkan pesan error yang lebih user-friendly--}}
{{--                        alert('Gagal memuat data peserta. Silakan refresh halaman atau coba lagi nanti.');--}}
{{--                    }--}}
{{--                },--}}
{{--                columns: [--}}
{{--                    {--}}
{{--                        data: 'DT_RowIndex',--}}
{{--                        name: 'DT_RowIndex',--}}
{{--                        orderable: false,--}}
{{--                        searchable: false--}}
{{--                    },--}}
{{--                    { data: 'name', name: 'name' },--}}
{{--                    { data: 'email', name: 'email' },--}}
{{--                    {--}}
{{--                        data: 'created_at',--}}
{{--                        name: 'created_at',--}}
{{--                        render: function(data) {--}}
{{--                            return new Date(data).toLocaleDateString('id-ID', {--}}
{{--                                day: 'numeric',--}}
{{--                                month: 'short',--}}
{{--                                year: 'numeric'--}}
{{--                            });--}}
{{--                        }--}}
{{--                    }--}}
{{--                ],--}}
{{--                language: {--}}
{{--                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memproses...</span>',--}}
{{--                    emptyTable: 'Tidak ada peserta yang terdaftar',--}}
{{--                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ peserta',--}}
{{--                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 peserta',--}}
{{--                    infoFiltered: '(disaring dari _MAX_ total peserta)',--}}
{{--                    lengthMenu: 'Tampilkan _MENU_ peserta',--}}
{{--                    search: 'Cari:',--}}
{{--                    zeroRecords: 'Tidak ditemukan peserta yang sesuai'--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
