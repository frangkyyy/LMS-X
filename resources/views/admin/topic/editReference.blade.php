<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-outline-secondary btn-sm me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h4 class="fw-bold mb-0">Edit Referensi</h4>
                </div>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Referensi</li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ route('sections.referensi.update', [$course->id, $section->id, $reference->id]) }}" method="POST" id="referenceForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section_id" value="{{ $section->id }}">

                    <div class="mb-3">
                        <label for="content" class="form-label">Referensi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" required>{{ old('content', $reference->content) }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="visible" name="visible" value="1" {{ old('visible', $reference->visible) ? 'checked' : '' }}>
                        <label class="form-check-label" for="visible">Visible</label>
                        @error('visible')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-outline-secondary w-25">Cancel</a>
                        <button type="submit" class="btn btn-primary w-75">Update Reference</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.getElementById('referenceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST', // Laravel handles PUT via _method field
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success === false) {
                    alert(data.message);
                } else {
                    alert('Reference updated successfully!');
                    window.location.href = '{{ route('sections.show', [$course->id, $section->id]) }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update reference. Please try again.');
            });
    });
</script>
