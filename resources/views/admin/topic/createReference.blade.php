<div class="container">
    <h2>Tambah Referensi Untuk {{ $section->title }}</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Referensi</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <form id="createReferenceForm" action="{{ route('sections.referensi.store', [$course->id, $section->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="mb-3">
                    <label for="content" class="form-label">Referensi</label>
                    <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                    @error('content')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="visible" name="visible" value="1" {{ old('visible', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="visible">Visible</label>
                    @error('visible')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Reference</button>
                <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('createReferenceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
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
                    alert('Reference created successfully!');
                    window.location.href = '{{ route('sections.show', [$course->id, $section->id]) }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to create reference. Please try again.');
            });
    });
</script>
