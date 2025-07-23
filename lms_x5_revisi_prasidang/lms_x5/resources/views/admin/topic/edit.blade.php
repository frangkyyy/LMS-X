<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="container my-4">
    <div class="card p-4 shadow-sm">
        <h1 class="text-center mb-4">Edit  {{ $section->title }}</h1>
        <div id="alert-placeholder"></div>
        <form action="{{ route('sections.update', [$course->id, $section->id]) }}" method="POST" id="topic-form">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="type" class="form-label fw-bold">Tipe:</label>
                <select class="form-select" id="type" name="type" required aria-describedby="typeHelp">
                    <option value="Perkuliahan" {{ $section->type === 'Perkuliahan' ? 'selected' : '' }}>Perkuliahan</option>
                    <option value="Project" {{ $section->type === 'Project' ? 'selected' : '' }}>Project</option>
                    <option value="Studi Kasus" {{ $section->type === 'Studi Kasus' ? 'selected' : '' }}>Studi Kasus</option>
                    <option value="Ujian Sumatif" {{ $section->type === 'Ujian Sumatif' ? 'selected' : '' }}>Ujian Sumatif</option>
                </select>
                <small id="typeHelp" class="form-text text-muted">Pilih tipe topik yang sesuai.</small>
                @error('type')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Judul Topik:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $section->title) }}" required aria-describedby="titleHelp">
                <small id="titleHelp" class="form-text text-muted">Masukkan judul topik yang jelas dan singkat.</small>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi_topik" class="form-label fw-bold">Deskripsi Topik:</label>
                <textarea class="form-control" id="deskripsi_topik" name="deskripsi_topik" rows="4" placeholder="Masukkan deskripsi topik..." required aria-describedby="deskripsiHelp">{{ old('deskripsi_topik', $section->description ?? '') }}</textarea>
                <small id="deskripsiHelp" class="form-text text-muted">Jelaskan isi topik secara singkat.</small>
                @error('deskripsi_topik')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="sub_cpmk" class="form-label fw-bold">Sub CPMK:</label>
                <textarea class="form-control" id="sub_cpmk" name="sub_cpmk" rows="4" placeholder="Masukkan Sub CPMK..." required aria-describedby="subCpmkHelp">{{ old('sub_cpmk', $section->sub_cpmk ?? '') }}</textarea>
                <small id="subCpmkHelp" class="form-text text-muted">Masukkan Sub CPMK yang relevan.</small>
                @error('sub_cpmk')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sub Topik:</label>
                <div id="sub-topic-list">
                    @foreach (old('sub_topic', $section->sub_topic ?? []) as $index => $sub_topic)
                        <div class="card p-3 mb-2 position-relative" id="sub-topic-{{ $index + 1 }}">
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteSubTopic('{{ $course->id }}', '{{ $section->id }}', '{{ $sub_topic->id ?? '' }}', 'sub-topic-{{ $index + 1 }}')" aria-label="Hapus Sub Topik"></button>
                            <div class="mb-2">
                                <label for="sub_topic_{{ $index + 1 }}" class="form-label">Judul Sub Topik:</label>
                                <input type="text" class="form-control" id="sub_topic_{{ $index + 1 }}" name="sub_topic[{{ $index }}][title]" value="{{ old('sub_topic.' . $index . '.title', $sub_topic->title ?? '') }}" placeholder="Masukkan sub topik..." required>
                                <input type="hidden" name="sub_topic[{{ $index }}][id]" value="{{ old('sub_topic.' . $index . '.id', $sub_topic->id ?? '') }}">
                                <input type="hidden" name="sub_topic[{{ $index }}][sortorder]" value="{{ old('sub_topic.' . $index . '.sortorder', $sub_topic->sortorder ?? ($index + 1)) }}">
                                <input type="hidden" name="sub_topic[{{ $index }}][visible]" value="{{ old('sub_topic.' . $index . '.visible', $sub_topic->visible ?? 1) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addSubTopic()">Tambah Sub Topik</button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Referensi:</label>
                <div id="referensi-list">
                    @foreach (old('referensi', $section->referensi ?? []) as $index => $referensi)
                        <div class="card p-3 mb-2 position-relative" id="referensi-{{ $index + 1 }}">
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteReferensi('{{ $course->id }}', '{{ $section->id }}', '{{ $referensi->id ?? '' }}', 'referensi-{{ $index + 1 }}')" aria-label="Hapus Referensi"></button>
                            <div class="mb-2">
                                <label for="referensi_{{ $index + 1 }}" class="form-label">Referensi:</label>
                                <textarea class="form-control" id="referensi_{{ $index + 1 }}" name="referensi[{{ $index }}][content]" rows="3" placeholder="Masukkan referensi..." required>{{ old('referensi.' . $index . '.content', $referensi->content ?? '') }}</textarea>
                                <input type="hidden" name="referensi[{{ $index }}][id]" value="{{ old('referensi.' . $index . '.id', $referensi->id ?? '') }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addReferensi()">Tambah Referensi</button>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Perubahan</button>
                <a href="{{ route('courses.topics', $course->id) }}" class="btn btn-secondary btn-lg w-100" onclick="return confirm('Apakah Anda yakin ingin membatalkan perubahan?')">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    let subTopicCount = {{ count(old('sub_topic', $section->sub_topic ?? [])) }};
    let referensiCount = {{ count(old('referensi', $section->referensi ?? [])) }};

    function showAlert(message, type = 'success') {
        const alertPlaceholder = document.getElementById('alert-placeholder');
        alertPlaceholder.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        setTimeout(() => {
            alertPlaceholder.innerHTML = '';
        }, 3000);
    }

    function addSubTopic() {
        subTopicCount++;
        const newSubTopic = document.createElement('div');
        newSubTopic.className = 'card p-3 mb-2 position-relative';
        newSubTopic.id = `sub-topic-${subTopicCount}`;
        newSubTopic.innerHTML = `
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteSubTopic('{{ $course->id }}', '{{ $section->id }}', '', 'sub-topic-${subTopicCount}')" aria-label="Hapus Sub Topik"></button>
            <div class="mb-2">
                <label for="sub_topic_${subTopicCount}" class="form-label">Judul Sub Topik:</label>
                <input type="text" class="form-control" id="sub_topic_${subTopicCount}" name="sub_topic[${subTopicCount - 1}][title]" placeholder="Masukkan sub topik..." required>
                <input type="hidden" name="sub_topic[${subTopicCount - 1}][id]" value="">
                <input type="hidden" name="sub_topic[${subTopicCount - 1}][sortorder]" value="${subTopicCount}">
                <input type="hidden" name="sub_topic[${subTopicCount - 1}][visible]" value="1">
            </div>
        `;
        document.getElementById('sub-topic-list').appendChild(newSubTopic);
        showAlert('Sub topik ditambahkan ke form!');
    }

    function addReferensi() {
        referensiCount++;
        const newReferensi = document.createElement('div');
        newReferensi.className = 'card p-3 mb-2 position-relative';
        newReferensi.id = `referensi-${referensiCount}`;
        newReferensi.innerHTML = `
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteReferensi('{{ $course->id }}', '{{ $section->id }}', '', 'referensi-${referensiCount}')" aria-label="Hapus Referensi"></button>
            <div class="mb-2">
                <label for="referensi_${referensiCount}" class="form-label">Referensi:</label>
                <textarea class="form-control" id="referensi_${referensiCount}" name="referensi[${referensiCount - 1}][content]" rows="3" placeholder="Masukkan referensi..." required></textarea>
                <input type="hidden" name="referensi[${referensiCount - 1}][id]" value="">
            </div>
        `;
        document.getElementById('referensi-list').appendChild(newReferensi);
        showAlert('Referensi ditambahkan ke form!');
    }

    async function deleteSubTopic(courseId, sectionId, subtopicId, elementId) {
        if (!subtopicId) {
            document.getElementById(elementId).remove();
            showAlert('Sub topik dihapus dari form.');
            return;
        }

        if (!confirm('Apakah Anda yakin ingin menghapus sub topik ini?')) return;

        try {
            const response = await fetch(`/courses/${courseId}/sections/${sectionId}/subtopics/${subtopicId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Gagal menghapus sub topik.');
            }

            document.getElementById(elementId).remove();
            showAlert('Sub topik dihapus!');
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    async function deleteReferensi(courseId, sectionId, referensiId, elementId) {
        if (!referensiId) {
            document.getElementById(elementId).remove();
            showAlert('Referensi dihapus dari form.');
            return;
        }

        if (!confirm('Apakah Anda yakin ingin menghapus referensi ini?')) return;

        try {
            const response = await fetch(`/courses/${courseId}/sections/${sectionId}/referensi/${referensiId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Gagal menghapus referensi.');
            }

            document.getElementById(elementId).remove();
            showAlert('Referensi dihapus!');
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    // Menampilkan alert setelah submit atau error
    @if (session('success'))
        window.onload = () => {
            showAlert('{{ session('success') }}');
        };
    @endif

    @if ($errors->any())
        window.onload = () => {
            showAlert('Terdapat kesalahan dalam form. Silakan periksa kembali.', 'danger');
        };
    @endif
</script>
