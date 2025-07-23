<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Container untuk notifikasi -->
        <div id="alert-container"></div>

        <!-- Judul dan Tombol Tambah Course -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Courses</h4>
                    <div class="d-flex">
                        <a href="{{ route('courses.management') }}" class="btn btn-outline-primary btn-sm me-2">Manage Courses</a>
                        <a href="{{ route('course.create') }}" class="btn btn-primary btn-sm">+ Create Course</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Courses -->
        <div class="card mt-3">
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
                                        <a HOA href="{{ route('courses.topics', $course->id) }}" class="btn btn-sm btn-light me-2" title="View Course">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <button class="btn btn-sm btn-light me-2 view-participants-btn"
                                                title="View Participants"
                                                data-bs-toggle="modal"
                                                data-bs-target="#participantModal"
                                                data-course-id="{{ $course->id }}"
                                                aria-label="View participants for {{ $course->full_name }}">
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
                @endforeach

                <!-- Card untuk Tambah Course -->
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

    <!-- Include Participant Modal -->
    @include('admin.course.participant')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Store the current course ID when opening the participant modal
    let currentCourseId = null;

    document.querySelectorAll('.view-participants-btn').forEach(button => {
        button.addEventListener('click', function () {
            currentCourseId = this.getAttribute('data-course-id');
            const participantTableBody = document.querySelector('#participant-table-body');

            // Tampilkan loading state
            participantTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';

            // Fetch participants via AJAX
            fetch(`/participants/by-course/${currentCourseId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    participantTableBody.innerHTML = ''; // Clear loading state

                    if (data.length === 0) {
                        participantTableBody.innerHTML = '<tr><td colspan="4" class="text-center">No participants found.</td></tr>';
                    } else {
                        data.forEach(participant => {
                            const row = `
                            <tr>
                                <td>${participant.course_id}</td>
                                <td>${participant.name}</td>
                                <td>${participant.participant_role || 'N/A'}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-participant" data-id="${participant.id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-participant" data-id="${participant.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                            participantTableBody.innerHTML += row;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching participants:', error);
                    participantTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Error loading participants.</td></tr>';
                });
        });
    });

    // Event listener for Add Participant button
    document.getElementById('addParticipantBtn').addEventListener('click', function () {
        // Set the course ID in the add participant form
        if (currentCourseId) {
            document.getElementById('course_id').value = currentCourseId;
        } else {
            console.error('No course ID available');
            alert('Error: No course selected. Please try again.');
            return;
        }

        // Show the add participant modal
        const addParticipantModal = new bootstrap.Modal(document.getElementById('addParticipantModal'));
        addParticipantModal.show();
    });

    // Handle form submission for adding a participant
    document.getElementById('addParticipantForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const participantTableBody = document.querySelector('#participant-table-body');

        // Show loading state in participant modal
        participantTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Adding participant...</td></tr>';

        // Submit form data via AJAX
        fetch('/participants/store', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Close the add participant modal
                const addParticipantModal = bootstrap.Modal.getInstance(document.getElementById('addParticipantModal'));
                addParticipantModal.hide();

                // Refresh participant list
                fetch(`/participants/by-course/${currentCourseId}`)
                    .then(response => response.json())
                    .then(participants => {
                        participantTableBody.innerHTML = ''; // Clear loading state

                        if (participants.length === 0) {
                            participantTableBody.innerHTML = '<tr><td colspan="4" class="text-center">No participants found.</td></tr>';
                        } else {
                            participants.forEach(participant => {
                                const row = `
                            <tr>
                                <td>${participant.course_id}</td>
                                <td>${participant.name}</td>
                                <td>${participant.participant_role || 'N/A'}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-participant" data-id="${participant.id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-participant" data-id="${participant.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                                participantTableBody.innerHTML += row;
                            });
                        }
                    });
            })
            .catch(error => {
                console.error('Error adding participant:', error);
                participantTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Error adding participant.</td></tr>';
            });
    });

    // Handle course deletion via AJAX
    document.querySelectorAll('.delete-course-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to delete this course?')) return;

            const courseCard = this.closest('.col'); // Dapatkan elemen card course
            const alertContainer = document.querySelector('#alert-container');

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: new FormData(this)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete course');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Hapus card course dari DOM
                        courseCard.remove();
                        // Tampilkan notifikasi sukses
                        alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Course deleted successfully
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                        // Hapus notifikasi setelah 3 detik
                        setTimeout(() => {
                            alertContainer.innerHTML = '';
                        }, 3000);
                    } else {
                        throw new Error('Deletion not successful');
                    }
                })
                .catch(error => {
                    console.error('Error deleting course:', error);
                    alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error deleting course
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
                    setTimeout(() => {
                        alertContainer.innerHTML = '';
                    }, 3000);
                });
        });
    });
</script>
