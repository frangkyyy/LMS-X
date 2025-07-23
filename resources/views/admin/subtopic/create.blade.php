
<div class="container">
    <h2> Tambah Sub Materi Untuk {{ $section->title }}</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Sub Materi</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <form id="createSubtopicForm" action="{{ route('sections.subtopics.store', [$course->id, $section->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="mb-3">
                    <label for="title" class="form-label">Subtopic Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
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

                <input type="hidden" name="sortorder" value="{{ old('sortorder', $section->sub_topic->count() + 1) }}">
                @error('sortorder')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-primary">Save Subtopic</button>
                <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('createSubtopicForm').addEventListener('submit', function(e) {
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
                    alert('Subtopic created successfully!');
                    window.location.href = '{{ route('courses.topics', [$course->id, $section->id]) }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to create subtopic. Please try again.');
            });
    });
</script>
