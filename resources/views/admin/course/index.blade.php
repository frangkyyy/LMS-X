<!-- CSS Bootstrap dan SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Notifikasi -->
        <div id="alert-container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Judul dan Tombol Tambah courses -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Courses</h4>
                    <div class="d-flex">
                        <a href="{{ route('courses.management') }}" class="btn btn-outline-primary btn-sm me-2">Manage Course</a>
                        <a href="{{ route('course.create') }}" class="btn btn-primary btn-sm">+ New Course</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Course -->
        <div class="card border-0 mt-3 shadow-sm bg-light">
            <div class="row row-cols-1 row-cols-md-2 g-4 p-4">
                @foreach ($courses as $course)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $course->course_image ? asset('storage/' . $course->course_image) : 'https://mdbcdn.b-cdn.net/img/new/standard/city/041.webp' }}"
                                 class="card-img-top"
                                 alt="{{ $course->full_name }}" />
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ $course->full_name }}</h5>
                                    <div class="d-flex">
                                        <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-sm btn-light me-2" title="Lihat Kursus">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <button class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#participantModal-{{ $course->id }}" title="Lihat Peserta">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </button>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-gear-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('courses.edit', $course->id) }}">
                                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="delete-course-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Include Modal Peserta untuk Kursus Ini -->
                    @php
                        $participants = $course->users->map(function ($user) {
                            return [
                                'id' => $user->pivot->id,
                                'course_id' => $user->pivot->course_id,
                                'name' => $user->name,
                                'participant_role' => $user->pivot->participant_role ?? 'N/A',
                            ];
                        })->all();
                    @endphp
                    @include('admin.course.participant', ['course' => $course, 'participants' => $participants, 'modalId' => 'participantModal-' . $course->id])
                @endforeach

                <!-- Card untuk Tambah Kursus -->
                <div class="col">
                    <a href="{{ route('course.create') }}" class="text-decoration-none">
                        <div class="card h-100 text-primary dotted">
                            <img src="https://via.placeholder.com/300x180/ffffff/ffffff" class="card-img-top" alt="Placeholder" style="visibility: hidden;" />
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <i class="bi bi-plus fs-1 text-primary" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS dan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- JavaScript untuk Handle Modals -->
<script>
    // Define existing participants for all courses
    const allParticipants = @json($courses->mapWithKeys(function ($course) {
        return [$course->id => $course->users->pluck('id')->toArray()];
    })->toArray());

    document.addEventListener('DOMContentLoaded', function () {
        // Handle konfirmasi penghapusan peserta
        document.querySelectorAll('.delete-participant-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const participantName = form.closest('tr').querySelector('td:first-child').textContent;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda akan menghapus peserta ' + participantName + ' dari kelas ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Handle semua modal "Add Participant"
        document.querySelectorAll('.modal[id^="addParticipantModal-"]').forEach(modal => {
            const courseId = modal.id.replace('addParticipantModal-', '');
            const searchInput = document.getElementById('participant-search-' + courseId);
            const searchResults = document.getElementById('search-results-' + courseId);
            const selectedParticipantsList = document.getElementById('selected-participants-' + courseId);
            const participantsInput = document.getElementById('participants-input-' + courseId);
            const addParticipantForm = document.getElementById('add-participant-form-' + courseId);
            const warningMessage = document.getElementById('participant-warning-' + courseId);
            const roleSelect = document.getElementById('participant-role-' + courseId);
            let selectedParticipants = [];
            let isSelecting = false;

            // Get existing participants for this course
            const existingParticipants = allParticipants[courseId] || [];

            // Fungsi untuk memeriksa apakah peserta sudah ada di kursus atau di daftar yang dipilih
            function isParticipantExists(userId) {
                return selectedParticipants.some(p => p.id === userId) || existingParticipants.includes(Number(userId));
            }

            // Fungsi untuk menambahkan peserta
            function addParticipant(user, courseId) {
                if (isParticipantExists(user.id)) {
                    if (warningMessage) warningMessage.style.display = 'block';
                    return;
                }

                const role = roleSelect ? roleSelect.value : 'Student';
                selectedParticipants.push({
                    id: user.id,
                    name: user.name,
                    role: role
                });

                updateSelectedParticipantsList(courseId);
                if (warningMessage) warningMessage.style.display = 'none';
            }

            // Fungsi untuk menghapus peserta
            function removeParticipant(userId, courseId) {
                selectedParticipants = selectedParticipants.filter(p => p.id !== userId);
                updateSelectedParticipantsList(courseId);
                if (warningMessage) warningMessage.style.display = 'none';
            }

            // Perbarui daftar peserta yang dipilih
            function updateSelectedParticipantsList(courseId) {
                selectedParticipantsList.innerHTML = '';

                if (selectedParticipants.length === 0) {
                    const li = document.createElement('li');
                    li.className = 'list-group-item text-muted';
                    li.id = 'no-participants-' + courseId;
                    li.textContent = 'Belum ada peserta yang ditambahkan.';
                    selectedParticipantsList.appendChild(li);
                } else {
                    selectedParticipants.forEach(user => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item d-flex justify-content-between align-items-center';
                        li.innerHTML = `
                            ${user.name}
                            <div>
                                <select class="form-select form-select-sm d-inline-block w-auto"
                                        onchange="updateParticipantRole(${user.id}, this.value, ${courseId})">
                                    <option value="Student" ${user.role === 'Student' ? 'selected' : ''}>Student</option>
                                    <option value="Teacher" ${user.role === 'Teacher' ? 'selected' : ''}>Teacher</option>
                                    <option value="Admin" ${user.role === 'Admin' ? 'selected' : ''}>Admin</option>
                                </select>
                                <button class="btn btn-sm btn-danger ms-2"
                                        onclick="removeParticipant(${user.id}, ${courseId})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                        selectedParticipantsList.appendChild(li);
                    });
                }

                participantsInput.value = JSON.stringify(selectedParticipants);
            }

            // Perbarui peran peserta
            window.updateParticipantRole = function (userId, role, courseId) {
                const participant = selectedParticipants.find(p => p.id === userId);
                if (participant) {
                    participant.role = role;
                    updateSelectedParticipantsList(courseId);
                }
            };

            // Expose removeParticipant to global scope
            window.removeParticipant = removeParticipant;

            // Handle pencarian peserta
            if (searchInput) {
                searchInput.addEventListener('input', debounce(async function () {
                    if (isSelecting) return;

                    const query = searchInput.value.trim();
                    if (query.length < 2) {
                        searchResults.innerHTML = '';
                        searchResults.style.display = 'none';
                        if (warningMessage) warningMessage.style.display = 'none';
                        return;
                    }

                    try {
                        const response = await fetch('/users/search?term=' + encodeURIComponent(query), {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (!response.ok) throw new Error('HTTP error! Status: ' + response.status);
                        const users = await response.json();

                        searchResults.innerHTML = '';
                        if (users.length === 0) {
                            searchResults.innerHTML = '<div class="dropdown-item text-muted">Tidak ada pengguna ditemukan</div>';
                            searchResults.style.display = 'block';
                            return;
                        }

                        users.forEach(user => {
                            const isSelected = isParticipantExists(user.id);
                            const item = document.createElement('div');
                            item.className = 'dropdown-item';
                            item.innerHTML = `${user.id} - ${user.name}`;
                            item.style.cursor = isSelected ? 'not-allowed' : 'pointer';
                            item.style.opacity = isSelected ? '0.5' : '1';

                            if (!isSelected) {
                                item.addEventListener('click', () => {
                                    isSelecting = true;
                                    addParticipant({
                                        id: user.id,
                                        name: user.name
                                    }, courseId);
                                    searchInput.value = user.name;
                                    searchResults.style.display = 'none';
                                    setTimeout(() => { isSelecting = false; }, 100);
                                });
                            }
                            searchResults.appendChild(item);
                        });
                        searchResults.style.display = 'block';
                    } catch (error) {
                        console.error('Error:', error);
                        searchResults.innerHTML = '<div class="dropdown-item text-danger">Error searching</div>';
                        searchResults.style.display = 'block';
                    }
                }, 300));
            }

            // Handle pengiriman form
            if (addParticipantForm) {
                addParticipantForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if (selectedParticipants.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Ada Peserta',
                            text: 'Silakan pilih setidaknya satu peserta untuk ditambahkan.',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Konfirmasi Penambahan',
                        text: 'Apakah Anda yakin ingin menambahkan peserta ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tambahkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(addParticipantForm.action, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || ''
                                },
                                body: JSON.stringify({
                                    participants: selectedParticipants.map(p => ({
                                        id: p.id,
                                        role: p.role
                                    }))
                                })
                            })
                                .then(response => {
                                    if (!response.ok) throw new Error('HTTP error! Status: ' + response.status);
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: data.message,
                                            timer: 2000
                                        }).then(() => {
                                            // Get modal instances
                                            const addModalElement = document.getElementById('addParticipantModal-' + courseId);
                                            const participantModalElement = document.getElementById('participantModal-' + courseId);

                                            // Hide the add participant modal
                                            if (addModalElement) {
                                                const addModal = bootstrap.Modal.getInstance(addModalElement) || new bootstrap.Modal(addModalElement);
                                                addModal.hide();
                                            }

                                            // Show the participant modal
                                            if (participantModalElement) {
                                                const participantModal = bootstrap.Modal.getInstance(participantModalElement) || new bootstrap.Modal(participantModalElement);
                                                participantModal.show();
                                            }

                                            // Reset form state
                                            selectedParticipants = [];
                                            updateSelectedParticipantsList(courseId);
                                            searchInput.value = '';
                                            searchResults.innerHTML = '';
                                            searchResults.style.display = 'none';
                                            if (warningMessage) warningMessage.style.display = 'none';

                                            // Optional: Reload page to refresh participant list
                                            setTimeout(() => {
                                                window.location.reload();
                                            }, 500); // Delay to ensure modals have transitioned
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Kesalahan!',
                                            text: data.message || 'Gagal menambahkan peserta.',
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Kesalahan saat menambahkan peserta:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Kesalahan!',
                                        text: 'Gagal menambahkan peserta: ' + error.message,
                                    });
                                });
                        }
                    });
                });
            }

            // Sembunyikan hasil pencarian saat klik di luar
            document.addEventListener('click', function (e) {
                if (searchInput && !searchInput.contains(e.target) && searchResults && !searchResults.contains(e.target)) {
                    searchResults.style.display = 'none';
                    if (warningMessage) warningMessage.style.display = 'none';
                }
            });

            // Reset modal saat ditutup
            modal.addEventListener('hidden.bs.modal', function () {
                if (searchInput) searchInput.value = '';
                if (selectedParticipantsList) selectedParticipantsList.innerHTML = '';
                if (participantsInput) participantsInput.value = '';
                if (searchResults) {
                    searchResults.innerHTML = '';
                    searchResults.style.display = 'none';
                }
                if (warningMessage) warningMessage.style.display = 'none';
                selectedParticipants = [];
            });

            // Cegah autocomplete browser
            if (searchInput) searchInput.setAttribute('autocomplete', 'off');
        });
    });

    // Fungsi debounce untuk mengurangi frekuensi pencarian
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
</script>

<style>
    .dropdown-menu {
        display: none;
        position: absolute;
        z-index: 1000;
    }
    .dropdown-menu.show {
        display: block;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .list-group-item {
        font-size: 0.9rem;
    }
</style>
