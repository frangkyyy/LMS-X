<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Step -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('coursesadmin.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h4 class="fw-bold mb-0">Edit Course</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 position-relative">
                    <!-- Step 1: General -->
                    <div class="text-center">
                        <span class="badge rounded-pill bg-success text-white step-circle" data-step="general">1</span>
                        <div class="mt-1 text-muted small">General</div>
                    </div>
                    <!-- Step 2: Summary -->
                    <div class="text-center">
                        <span class="badge rounded-pill bg-secondary text-white step-circle" data-step="summary">2</span>
                        <div class="mt-1 text-muted small">Summary</div>
                    </div>
                    <!-- Step 3: Participants -->
                    <div class="text-center">
                        <span class="badge rounded-pill bg-secondary text-white step-circle" data-step="participants">3</span>
                        <div class="mt-1 text-muted small">Participants</div>
                    </div>
                    <!-- Step 4: Settings -->
                    <div class="text-center">
                        <span class="badge rounded-pill bg-secondary text-white step-circle" data-step="settings">4</span>
                        <div class="mt-1 text-muted small">Settings</div>
                    </div>
                    <!-- Step 5: Final Step -->
                    <div class="text-center">
                        <span class="badge rounded-pill bg-secondary text-white step-circle" data-step="summary2">5</span>
                        <div class="mt-1 text-muted small">Final Step</div>
                    </div>
                    <!-- Connecting line -->
                    <div class="position-absolute top-50 start-0 end-0 bg-secondary" style="height: 2px; z-index: -1;"></div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" id="courseForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- General Section -->
                    <div id="general-section">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Course Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $course->full_name) }}">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_name" class="form-label">Course Short Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('short_name') is-invalid @enderror" id="short_name" name="short_name" value="{{ old('short_name', $course->short_name) }}">
                            @error('short_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Course Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $course->category) }}" placeholder="Enter category (e.g., Technology, Science)">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('coursesadmin.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                            <button type="button" class="btn btn-primary w-75" onclick="validateGeneralSection()">Next</button>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div id="summary-section" style="display: none;">
                        <div class="mb-3">
                            <label for="summary" class="form-label">Course Summary <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="5">{{ old('summary', $course->summary) }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpmk" class="form-label">CPMK (Course Learning Outcomes)</label>
                            <textarea class="form-control @error('cpmk') is-invalid @enderror" id="cpmk" name="cpmk" rows="3">{{ old('cpmk', $course->cpmk) }}</textarea>
                            @error('cpmk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="course_image" class="form-label">Course Image</label>
                            <input type="file" class="form-control @error('course_image') is-invalid @enderror" id="course_image" name="course_image" accept="image/*">
                            @error('course_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-3">
                                @if($course->course_image)
                                    <img id="image_preview" src="{{ Storage::url($course->course_image) }}" alt="Current Course Image" style="max-height: 200px;" class="img-thumbnail">
                                @else
                                    <img id="image_preview" src="#" alt="Preview" style="display: none; max-height: 200px;" class="img-thumbnail">
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('coursesadmin.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                            <div class="d-flex gap-2 w-75">
                                <button type="button" class="btn btn-secondary w-50" onclick="showSection('general')">Previous</button>
                                <button type="button" class="btn btn-primary w-50" onclick="showSection('participants')">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- Participants Section -->
                    <div id="participants-section" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Add Participants</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="participant_input" placeholder="Search user by name">
                                <input type="hidden" id="participant_id">
                                <select class="form-select" id="participant_role" style="max-width: 150px;">
                                    <option value="student">Student</option>
                                    <option value="teacher">Instructor</option>
                                    <option value="admin">Assistant</option>
                                </select>
                                <button type="button" class="btn btn-outline-primary" onclick="addParticipant()">Add</button>
                            </div>
                            <input type="hidden" name="participants" id="participants_hidden">
                            <div id="participant_list" class="mt-3">
                                <!-- Participants will be dynamically added here -->
                            </div>
                        </div>

                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('coursesadmin.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                            <div class="d-flex gap-2 w-75">
                                <button type="button" class="btn btn-secondary w-50" onclick="showSection('summary')">Previous</button>
                                <button type="button" class="btn btn-primary w-50" onclick="showSection('settings')">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div id="settings-section" style="display: none;">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester">
                                <option value="">Select Semester</option>
                                <option value="1" {{ old('semester', $course-> seminary) == '1' ? 'selected' : '' }}>Semester 1</option>
                                <option value="2" {{ old('semester', $course->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                                <option value="3" {{ old('semester', $course->semester) == '3' ? 'selected' : '' }}>Semester 3</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="visible" class="form-label">Course Visibility <span class="text-danger">*</span></label>
                            <select class="form-select @error('visible') is-invalid @enderror" id="visible" name="visible">
                                <option value="1" {{ old('visible', $course->visible) == '1' ? 'selected' : '' }}>Show</option>
                                <option value="0" {{ old('visible', $course->visible) == '0' ? 'selected' : '' }}>Hide</option>
                            </select>
                            @error('visible')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Course Start Date <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                <select class="form-select @error('start_day') is-invalid @enderror" name="start_day" id="start_day">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('start_day', optional($course->start_date)->day ?? '1') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <select class="form-select @error('start_month') is-invalid @enderror" name="start_month" id="start_month">
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}" {{ old('start_month', optional($course->start_date)->format('F') ?? 'January') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                                <select class="form-select @error('start_year') is-invalid @enderror" name="start_year" id="start_year">
                                    @for ($i = 2023; $i <= 2030; $i++)
                                        <option value="{{ $i }}" {{ old('start_year', optional($course->start_date)->year ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" id="start_time" value="{{ old('start_time', optional($course->start_date)->format('H:i') ?? '00:00') }}">
                                @error('start_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('start_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('start_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Course End Date</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="enable_end_date" name="enable_end_date" {{ old('enable_end_date', $course->end_date ? '1' : '') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_end_date">Enable</label>
                                </div>
                                <select class="form-select @error('end_day') is-invalid @enderror" name="end_day" id="end_day" {{ $course->end_date ? '' : 'disabled' }}>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('end_day', optional($course->end_date)->day ?? '1') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <select class="form-select @error('end_month') is-invalid @enderror" name="end_month" id="end_month" {{ $course->end_date ? '' : 'disabled' }}>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}" {{ old('end_month', optional($course->end_date)->format('F') ?? 'January') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                                <select class="form-select @error('end_year') is-invalid @enderror" name="end_year" id="end_year" {{ $course->end_date ? '' : 'disabled' }}>
                                    @for ($i = 2023; $i <= 2030; $i++)
                                        <option value="{{ $i }}" {{ old('end_year', optional($course->end_date)->year ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" id="end_time" value="{{ old('end_time', optional($course->end_date)->format('H:i') ?? '00:00') }}" {{ $course->end_date ? '' : 'disabled' }}>
                                @error('end_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('end_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('end_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('coursesadmin.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                            <div class="d-flex gap-2 w-75">
                                <button type="button" class="btn btn-secondary w-50" onclick="showSection('participants')">Previous</button>
                                <button type="button" class="btn btn-primary w-50" onclick="showSection('summary2')">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- Final Step -->
                    <div id="summary2-section" style="display: none;">
                        <div class="mb-4">
                            <h5 class="text-center fw-bold mb-3">Review Your Course Details</h5>
                            <div class="p-3 border rounded bg-light">
                                <h6 class="fw-bold">General</h6>
                                <p><strong>Course Full Name:</strong> <span id="review_full_name"></span></p>
                                <p><strong>Course Short Name:</strong> <span id="review_short_name"></span></p>
                                <p><strong>Course Category:</strong> <span id="review_category"></span></p>
                                <hr>
                                <h6 class="fw-bold">Summary</h6>
                                <p><strong>Course Summary:</strong> <span id="review_summary"></span></p>
                                <p><strong>CPMK (Course Learning Outcomes):</strong> <span id="review_cpmk"></span></p>
                                <p><strong>Course Image:</strong></p>
                                <img id="review_image" src="#" alt="Course Image Preview" style="display: none;" class="img-thumbnail">
                                <p id="review_no_image" style="display: none;">No image uploaded</p>
                                <hr>
                                <h6 class="fw-bold">Participants</h6>
                                <div id="review_participants"></div>
                                <hr>
                                <h6 class="fw-bold">Settings</h6>
                                <p><strong>Semester:</strong> <span id="review_semester"></span></p>
                                <p><strong>Course Visibility:</strong> <span id="review_visible"></span></p>
                                <p><strong>Course Start Date:</strong> <span id="review_start_date"></span></p>
                                <p><strong>Course End Date:</strong> <span id="review_end_date"></span></p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('coursesadmin.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                            <div class="d-flex gap-2 w-75">
                                <button type="button" class="btn btn-secondary w-50" onclick="showSection('settings')">Previous</button>
                                <button type="submit" class="btn btn-primary w-50" onclick="submitForm()">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    // Initialize participants array with existing course participants
    let participants = @json($course->users->map(function($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->pivot->participant_role
        ];
    })->toArray());

    // Autocomplete for participant search
    $("#participant_input").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{ route('users.search') }}",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    console.log('Autocomplete data received:', data);
                    response(data.map(user => ({
                        label: user.name,
                        value: user.name,
                        id: user.id
                    })));
                },
                error: function (xhr, status, error) {
                    console.error('Autocomplete error:', error);
                    alert('Error fetching users. Please try again.');
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            console.log('User selected:', ui.item);
            $("#participant_id").val(ui.item.id);
            $("#participant_input").val(ui.item.value);
            return false;
        }
    });

    // Participant Functions
    function addParticipant() {
        const participantId = document.getElementById('participant_id').value;
        const participantName = document.getElementById('participant_input').value.trim();
        const role = document.getElementById('participant_role').value;

        console.log('Adding participant:', { id: participantId, name: participantName, role });

        if (!participantId || !participantName) {
            alert('Please select a valid user from the search.');
            return;
        }

        // Check for duplicate participants
        if (participants.some(p => p.id === participantId)) {
            alert('This user is already added as a participant.');
            return;
        }

        participants.push({ id: participantId, name: participantName, role });
        console.log('Participants updated:', participants);
        document.getElementById('participant_input').value = '';
        document.getElementById('participant_id').value = '';
        updateParticipantList();
    }

    function removeParticipant(index) {
        console.log('Removing participant at index:', index);
        participants.splice(index, 1);
        updateParticipantList();
    }

    function updateParticipantList() {
        const listContainer = document.getElementById('participant_list');
        listContainer.innerHTML = '';

        if (participants.length === 0) {
            listContainer.innerHTML = '<p class="text-muted">No participants added.</p>';
        } else {
            const ul = document.createElement('ul');
            ul.className = 'list-group';
            participants.forEach((participant, index) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    ${participant.name} (${participant.role.charAt(0).toUpperCase() + participant.role.slice(1)})
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeParticipant(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                ul.appendChild(li);
            });
            listContainer.appendChild(ul);
        }

        // Update hidden input for form submission
        const participantsJson = JSON.stringify(participants);
        document.getElementById('participants_hidden').value = participantsJson;
        console.log('Participants JSON:', participantsJson);
    }

    function submitForm() {
        console.log('Form submitted with participants:', participants);
        document.getElementById('courseForm').submit();
    }

    function showSection(section) {
        // Hide all sections
        document.getElementById('general-section').style.display = 'none';
        document.getElementById('summary-section').style.display = 'none';
        document.getElementById('participants-section').style.display = 'none';
        document.getElementById('settings-section').style.display = 'none';
        document.getElementById('summary2-section').style.display = 'none';

        // Show the selected section
        document.getElementById(section + '-section').style.display = 'block';

        // Update progress indicator
        document.querySelectorAll('.step-circle').forEach(circle => {
            circle.classList.remove('bg-success');
            circle.classList.add('bg-secondary');
        });
        document.querySelector(`.step-circle[data-step="${section}"]`).classList.remove('bg-secondary');
        document.querySelector(`.step-circle[data-step="${section}"]`).classList.add('bg-success');

        // If moving to the final step, populate the review section
        if (section === 'summary2') {
            populateReviewSection();
        }
    }

    function validateGeneralSection() {
        const full_name = document.getElementById('full_name').value.trim();
        const short_name = document.getElementById('short_name').value.trim();
        const category = document.getElementById('category').value.trim();

        if (!full_name || !short_name || !category) {
            alert('Please fill in all required fields: Course Full Name, Course Short Name, and Course Category.');
            return;
        }

        showSection('summary');
    }

    function populateReviewSection() {
        // General Section
        document.getElementById('review_full_name').textContent = document.getElementById('full_name').value || 'Not provided';
        document.getElementById('review_short_name').textContent = document.getElementById('short_name').value || 'Not provided';
        document.getElementById('review_category').textContent = document.getElementById('category').value || 'Not provided';

        // Summary Section
        document.getElementById('review_summary').textContent = document.getElementById('summary').value || 'Not provided';
        document.getElementById('review_cpmk').textContent = document.getElementById('cpmk').value || 'Not provided';
        const imagePreview = document.getElementById('image_preview');
        const reviewImage = document.getElementById('review_image');
        const reviewNoImage = document.getElementById('review_no_image');
        if (imagePreview.src && imagePreview.style.display !== 'none') {
            reviewImage.src = imagePreview.src;
            reviewImage.style.display = 'block';
            reviewNoImage.style.display = 'none';
        } else {
            reviewImage.style.display = 'none';
            reviewNoImage.style.display = 'block';
        }

        // Participants Section
        const reviewParticipants = document.getElementById('review_participants');
        reviewParticipants.innerHTML = '';
        if (participants.length === 0) {
            reviewParticipants.innerHTML = '<p class="text-muted">No participants added.</p>';
        } else {
            const ul = document.createElement('ul');
            ul.className = 'list-group mb-2';
            participants.forEach(participant => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = `${participant.name} (${participant.role.charAt(0).toUpperCase() + participant.role.slice(1)})`;
                ul.appendChild(li);
            });
            reviewParticipants.appendChild(ul);
        }

        // Settings Section
        document.getElementById('review_semester').textContent = document.getElementById('semester').options[document.getElementById('semester').selectedIndex].text || 'Not provided';
        document.getElementById('review_visible').textContent = document.getElementById('visible').options[document.getElementById('visible').selectedIndex].text || 'Not provided';

        const startDay = document.getElementById('start_day').value;
        const startMonth = document.getElementById('start_month').value;
        const startYear = document.getElementById('start_year').value;
        const startTime = document.getElementById('start_time').value;
        document.getElementById('review_start_date').textContent = `${startDay} ${startMonth} ${startYear}, ${startTime}` || 'Not provided';

        const endDateEnabled = document.getElementById('enable_end_date').checked;
        if (endDateEnabled) {
            const endDay = document.getElementById('end_day').value;
            const endMonth = document.getElementById('end_month').value;
            const endYear = document.getElementById('end_year').value;
            const endTime = document.getElementById('end_time').value;
            document.getElementById('review_end_date').textContent = `${endDay} ${endMonth} ${endYear}, ${endTime}`;
        } else {
            document.getElementById('review_end_date').textContent = 'Not enabled';
        }
    }

    // Step circle click
    document.querySelectorAll('.step-circle').forEach(circle => {
        circle.addEventListener('click', () => {
            const section = circle.getAttribute('data-step');
            if (section !== 'general') {
                const full_name = document.getElementById('full_name').value.trim();
                const short_name = document.getElementById('short_name').value.trim();
                const category = document.getElementById('category').value.trim();

                if (!full_name || !short_name || !category) {
                    alert('Please fill in all required fields in the General section before proceeding.');
                    return;
                }
            }
            showSection(section);
        });
    });

    // Image preview logic
    document.getElementById('course_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image_preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            // Revert to original image or hide preview
            @if($course->course_image)
                preview.src = "{{ Storage::url($course->course_image) }}";
                preview.style.display = 'block';
            @else
                preview.src = '#';
                preview.style.display = 'none';
            @endif
        }
    });

    // Enable/disable end date fields
    document.getElementById('enable_end_date').addEventListener('change', function () {
        const endDateFields = document.querySelectorAll('select[name="end_day"], select[name="end_month"], select[name="end_year"], input[name="end_time"]');
        endDateFields.forEach(field => {
            field.disabled = !this.checked;
        });
    });

    // Initialize participant list on page load
    updateParticipantList();
</script>
