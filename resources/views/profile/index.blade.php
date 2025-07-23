<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">My Profile</div>

                    <div class="card-body">
                        <!-- Form Upload Foto Profil -->
                        <div class="text-center mb-4">
                            @if($user->image)
                                <!-- Modal for enlarged image -->
                                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/profile_images/'.$user->image) }}"
                                                     class="img-fluid" style="max-height: 80vh;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clickable profile image -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
                                    <img src="{{ asset('storage/profile_images/'.$user->image) }}"
                                         class="rounded-circle mb-2" width="150" height="150" id="profileImage"
                                         style="cursor: pointer; object-fit: cover;">
                                </a>
                                <div>
                                    <button class="btn btn-danger btn-sm" id="removePhotoBtn">
                                        <i class="fas fa-trash-alt mr-1"></i> Remove Photo
                                    </button>
                                </div>
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                     style="width:150px; height:150px; margin: 0 auto;">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Form Remove Photo (hidden) -->
                        <form id="removePhotoForm" action="{{ route('profile.remove') }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <form id="profileForm" action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image" name="profile_image" accept="image/*">
                                    <label class="custom-file-label" for="profile_image">Choose file</label>
                                </div>
                                <small class="form-text text-muted">
                                    Maximum file size: 2MB. Accepted file types: jpeg, png, jpg, gif
                                </small>
                                <div id="fileError" class="invalid-feedback" style="display:none;">
                                    Please select a profile image first.
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="uploadBtn">
                                    <i class="fas fa-upload mr-1"></i> Upload Photo
                                </button>
                            </div>
                        </form>

                        <!-- Informasi User -->
                        <div class="mt-4">
                            <h5>User Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Learning Style:</strong>
                                        {{ \App\Helpers\LearningStyleHelper::getFormattedLearningStyle() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add this to your scripts section if not already included -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        // Menampilkan nama file yang dipilih
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("profile_image").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
</script>
<script>
    // Validasi saat tombol upload diklik
    document.getElementById('uploadBtn').addEventListener('click', function() {
        const fileInput = document.getElementById('profile_image');
        const fileError = document.getElementById('fileError');

        if (!fileInput.files || fileInput.files.length === 0) {
            // Tampilkan pesan error
            fileInput.classList.add('is-invalid');
            fileError.style.display = 'block';

            // Animasi shake untuk efek visual
            fileInput.parentElement.classList.add('animate__animated', 'animate__headShake');
            setTimeout(() => {
                fileInput.parentElement.classList.remove('animate__animated', 'animate__headShake');
            }, 1000);

            // Tampilkan SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a profile image first!',
                confirmButtonColor: '#3085d6',
            });
        } else {
            // Jika file sudah dipilih, submit form
            document.getElementById('profileForm').submit();
        }
    });

    // Reset validasi ketika file dipilih
    document.getElementById('profile_image').addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            this.classList.remove('is-invalid');
            document.getElementById('fileError').style.display = 'none';

            // Update label nama file
            this.nextElementSibling.textContent = this.files[0].name;
        }
    });

    document.getElementById('removePhotoBtn')?.addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('removePhotoForm').submit();
            }
        });
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .custom-file-input.is-invalid ~ .custom-file-label {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
    }
    #removePhotoBtn {
        margin-top: 10px;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }

    #profileImage {
        transition: all 0.3s ease;
    }

    #profileImage:hover {
        opacity: 0.9;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
</style>

{{--@endsection--}}
