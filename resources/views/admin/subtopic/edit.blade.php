
<div class="container">
    <h2>Edit Subtopic: {{ $subtopic->title }}</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subtopic</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form id="editSubtopicForm" action="{{ route('sections.subtopics.update', [$course->id, $section->id, $subtopic->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="mb-3">
                    <label for="title" class="form-label">Subtopic Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $subtopic->title) }}" required>
                    @error('title')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="visible" name="visible" value="1" {{ old('visible', $subtopic->visible) ? 'checked' : '' }}>
                    <label class="form-check-label" for="visible">Visible</label>
                    @error('visible')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="sortorder" value="{{ old('sortorder', $subtopic->sortorder) }}">
                @error('sortorder')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-primary">Update Subtopic</button>
                <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('editSubtopicForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST', // Laravel menerima PUT via POST dengan _method=PUT
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
                    alert('Subtopic updated successfully!');
                    window.location.href = '{{  route('courses.topics', [$course->id, $section->id]) }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update subtopic. Please try again.');
            });
    });
</script>

