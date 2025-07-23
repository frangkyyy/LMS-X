<div class="container my-4">
    <div class="card p-4">
        <h1 class="text-center mb-4"> {{ $course->full_name }} </h1>
        <div class="list-group" id="section-list">
            @if ($sections->isEmpty())
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled" aria-disabled="true">
                    <span>Topik 1: Judul Topik 1</span>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm me-2" disabled>Lihat Topik</button>
                        <button class="btn btn-outline-primary btn-sm me-2" disabled>Edit Materi</button>
                        <button class="btn btn-outline-danger btn-sm" disabled>Hapus</button>
                    </div>
                </div>
            @else
                @foreach ($sections as $section)
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="viewSection({{ $course->id }}, {{ $section->id }})">
                        <span>Topik {{ $loop->iteration }}: {{ $section->title }}</span>
                        <div>
                            <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-outline-secondary btn-sm me-2" onclick="event.stopPropagation();">Lihat Topik</a>
                            <a href="{{ route('sections.edit', [$course->id, $section->id]) }}" class="btn btn-outline-primary btn-sm me-2" onclick="event.stopPropagation();">Edit Materi</a>
                            <form action="{{ route('sections.destroy', [$course->id, $section->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus topik ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="event.stopPropagation();">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button class="btn btn-outline-primary mt-3" onclick="addSection()">Tambah Topik</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function viewSection(course_id, sectionId) {
        window.location.href = '{{ route("sections.show", [":course_id", ":sectionId"]) }}'
            .replace(':course_id', course_id)
            .replace(':sectionId', sectionId);
    }

    function addSection() {
        const sectionList = document.getElementById('section-list');
        const topicCount = sectionList.querySelectorAll('.list-group-item:not(.disabled)').length + 1;
        const course_id = {{ $course->id }};

        fetch('{{ route("sections.store", $course->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                course_id: course_id,
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Perbarui tampilan hanya setelah section tersimpan
                    alert('Topik berhasil ditambahkan');
                    const placeholder = sectionList.querySelector('.disabled');
                    if (placeholder && sectionList.children.length === 1) {
                        sectionList.innerHTML = '';
                    }

                    const newSection = document.createElement('div');
                    newSection.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                    newSection.setAttribute('onclick', `viewSection(${course_id}, ${data.section.id})`);
                    newSection.innerHTML = `
                    <span>Topik ${topicCount}: ${data.section.title}</span>
                    <div>
                        <a href="{{ route('sections.show', [$course->id, ':sectionId']) }}".replace(':sectionId', ${data.section.id}) class="btn btn-outline-secondary btn-sm me-2" onclick="event.stopPropagation();">Lihat Topik</a>
                        <a href="{{ route('sections.edit', [$course->id, ':sectionId']) }}".replace(':sectionId', ${data.section.id}) class="btn btn-outline-primary btn-sm me-2" onclick="event.stopPropagation();">Edit Materi</a>
                        <form action="{{ route('sections.destroy', [$course->id, ':sectionId']) }}".replace(':sectionId', ${data.section.id}) method="POST" style="display:inline;" onsubmit="return confirm('Hapus topik ini?');">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="event.stopPropagation();">Hapus</button>
                        </form>
                    </div>
                `;
                    sectionList.appendChild(newSection);
                } else {
                    alert('Gagal menambahkan topik: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan topik: ' + error.message);
            });
    }
</script>
