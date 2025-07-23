<div class="flex justify-end mb-4">
    <button id="toggleEditMode" class="btn btn-primary">
        Mode Konstruksi
    </button>
</div>

<div id="learningDimensions" style="display: none;">
    <!-- Gaya Belajar -->
    <div class="mb-3">
        <label for="learningStyle" class="form-label fw-bold">Gaya Belajar</label>
        <select id="learningStyle" name="learning_style" class="form-select" required>
            <option value="">-- Pilih Gaya Belajar --</option>
            <option value="visual">Visual</option>
            <option value="verbal">Verbal</option>
        </select>
    </div>

    <!-- Dimensi Persepsi -->
    <div class="mb-3">
        <label for="perception" class="form-label fw-bold">Dimensi Persepsi</label>
        <select id="perception" name="perception" class="form-select" required>
            <option value="">-- Pilih Dimensi Persepsi --</option>
            <option value="sensitif">Sensitif</option>
            <option value="intuitif">Intuitif</option>
        </select>
    </div>

    <!-- Dimensi Pemrosesan -->
    <div class="mb-3">
        <label for="processing" class="form-label fw-bold">Dimensi Pemrosesan</label>
        <select id="processing" name="processing" class="form-select" required>
            <option value="">-- Pilih Dimensi Pemrosesan --</option>
            <option value="aktif">Aktif</option>
            <option value="reflektif">Reflektif</option>
        </select>
    </div>

    <!-- Hidden untuk menyimpan gabungan -->
    <input type="hidden" name="gaya_belajar_dimensi" id="gayaBelajarDimensi">

</div>


<!-- Modal Tambah Resource -->
<div class="modal fade" id="addResourceModal" tabindex="-1" aria-labelledby="addResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResourceModalLabel">Tambah Resource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="menuTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="knowledge-tab" data-bs-toggle="pill" href="#knowledge" role="tab" aria-controls="knowledge" aria-selected="true">Knowledge</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="activity-tab" data-bs-toggle="pill" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Activity</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="interactivity-tab" data-bs-toggle="pill" href="#interactivity" role="tab" aria-controls="interactivity" aria-selected="false">Interactivity</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="menuTabsContent">
                    <!-- Knowledge Tab -->
                    <div class="tab-pane fade show active" id="knowledge" role="tabpanel" aria-labelledby="knowledge-tab">
                        <ul class="list-group">
                            <li class="list-group-item" data-type="label">Label</li>
                            <li class="list-group-item" data-type="page">Page</li>
                            <li class="list-group-item" data-type="file">File</li>
                            <li class="list-group-item" data-type="folder">Folder</li>
                            <li class="list-group-item" data-type="url">URL</li>
                        </ul>
                    </div>

                    <!-- Activity Tab -->
                    <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                        <ul class="list-group">
                            <li class="list-group-item" data-type="form">Form</li>
                            <li class="list-group-item" data-type="quiz">Quiz</li>
                            <li class="list-group-item" data-type="assignment">Assignment</li>
                        </ul>
                    </div>

                    <!-- Interactivity Tab -->
                    <div class="tab-pane fade" id="interactivity" role="tabpanel" aria-labelledby="interactivity-tab">
                        <ul class="list-group">
                            <li class="list-group-item" data-type="lesson">Lesson</li>
                            <li class="list-group-item" data-type="h5p">H5P</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveResource">Save</button>
            </div>
        </div>
    </div>
</div>

<style>

    .edit-mode #materi-utama .card-body > *:not(.card-body > p, .card-body > h3, .card-body > h4, .card-body > .btn, .card-body > form, .card-body > .d-flex) {
        border: 2px dashed #ffc107; /* yellow border */
        margin-bottom: 1rem;
        padding: 1rem;
        position: relative;
    }

    /* Icon for draggable element */
    .edit-mode #materi-utama .card-body > *:not(.card-body > p, .card-body > h3, .card-body > h4, .card-body > .btn, .card-body > form, .card-body > .d-flex)::before {
        content: "\f0b2"; /* icon fa-arrows-alt */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        top: 8px;
        left: 8px;
        color: #ffc107;
        font-size: 1.2rem;
    }


    .edit-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 10;
        background-color: white;
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
        border: 1px solid #ccc;
    }

    .edit-dropdown {
        position: absolute;
        top: 35px;
        right: 8px;
        background-color: white;
        border: 1px solid #ccc;
        z-index: 20;
        border-radius: 5px;
        display: none;
        flex-direction: column;
        width: 120px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .edit-dropdown button {
        border: none;
        background: none;
        padding: 8px 12px;
        text-align: left;
        width: 100%;
        cursor: pointer;
    }

    .edit-dropdown button:hover {
        background-color: #f1f1f1;
    }


</style>




<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let editMode = false;
        let sectionSort;
        const toggleButton = document.getElementById('toggleEditMode');
        const container = document.getElementById('contentSections') || document.querySelector('.container');
        const saveResourceButton = document.getElementById('saveResource');
        const learningDimensions = document.getElementById('learningDimensions');


        let addButtonContainer = null;

        if (!container) {
            if (toggleButton) toggleButton.style.display = 'none';
            return;
        }

        if (!toggleButton) return;

        toggleButton.addEventListener('click', function () {
            editMode = !editMode;
            this.textContent = editMode ? 'Tutup Mode Konstruksi' : 'Mode Konstruksi';
            if (editMode) {
                enableDragDrop();
                showAddResourceButton();
                document.body.classList.add('edit-mode');
            } else {
                disableDragDrop();
                hideAddResourceButton();
                document.body.classList.remove('edit-mode');
            }

            if (editMode) {
                enableDragDrop();
                showAddResourceButton();
                document.body.classList.add('edit-mode');
                addEditIconsToCards(); //
                learningDimensions.style.display = 'block';
            } else {
                disableDragDrop();
                hideAddResourceButton();
                document.body.classList.remove('edit-mode');
                learningDimensions.style.display = 'none';

                // Bersihkan icon edit saat keluar dari edit mode
                container.querySelectorAll('.edit-icon, .edit-dropdown').forEach(el => el.remove());
            }

        });

        const learningStyle = document.getElementById('learningStyle');
        const perception = document.getElementById('perception');
        const processing = document.getElementById('processing');
        const hiddenField = document.getElementById('gayaBelajarDimensi');

        function updateHiddenValue() {
            const style = learningStyle.value;
            const persepsi = perception.value;
            const proses = processing.value;

            if (style && persepsi && proses) {
                hiddenField.value = `${style}-${persepsi}-${proses}`;
            } else {
                hiddenField.value = '';
            }
        }

        [learningStyle, perception, processing].forEach(select => {
            select.addEventListener('change', updateHiddenValue);
        });

        function addEditIconsToCards() {
            container.querySelectorAll('.card').forEach(card => {
                // Hapus dulu jika sudah ada
                const existing = card.querySelector('.edit-icon');
                if (existing) existing.remove();

                // Tambah icon
                const editIcon = document.createElement('div');
                editIcon.className = 'edit-icon';
                editIcon.innerHTML = '<i class="fas fa-ellipsis-v"></i>';

                // Dropdown
                const dropdown = document.createElement('div');
                dropdown.className = 'edit-dropdown';

                dropdown.innerHTML = `
                    <button class="edit-settings">Edit Setting</button>
                    <button class="hide-card">Hide</button>
                    <button class="delete-card">Delete</button>
                `;

                dropdown.querySelector('.edit-settings').addEventListener('click', () => {
                    const cardId = card.dataset.id;
                    const cardType = card.dataset.type || 'page';
                    const sectionId = {{ $section->id ?? 'null' }};
                    const topik = '{{ $topikKey ?? 'topik1' }}';

                    let editUrl = '';

                    switch(cardType) {
                        case 'page':
                            editUrl = `/pages/${cardId}/edit?section_id=${sectionId}&topik=${topik}`;
                            break;
                        // Tambahkan case lain untuk tipe content lainnya
                        default:
                            editUrl = `/pages/${cardId}/edit?section_id=${sectionId}&topik=${topik}`;
                    }

                    window.location.href = editUrl;
                });

                dropdown.querySelector('.hide-card').addEventListener('click', () => {
                    card.style.display = 'none';
                });

                dropdown.querySelector('.delete-card').addEventListener('click', () => {
                    card.remove();
                });

                // Toggle dropdown
                editIcon.addEventListener('click', (e) => {
                    e.stopPropagation(); // supaya klik tidak kena document
                    dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
                });

                // Tutup dropdown saat klik di luar
                document.addEventListener('click', () => {
                    dropdown.style.display = 'none';
                });

                card.style.position = 'relative';
                card.appendChild(editIcon);
                card.appendChild(dropdown);
            });
        }



        function enableDragDrop() {
            const materiUtama = document.querySelector('#materi-utama .card-body');

            if (!materiUtama) {
                console.error('Materi Utama section not found!');
                return;
            }

            Sortable.create(materiUtama, {
                animation: 150,
                draggable: '> *',  // Semua elemen langsung di dalam .card-body
                handle: undefined, // Seluruh elemen bisa drag (atau nanti tambahkan handle opsional)
                ghostClass: 'sortable-ghost'
            });
        }

        function disableDragDrop() {
            if (sectionSort) sectionSort.destroy();

            // Hapus efek konstruksi dari semua card
            container.querySelectorAll('.card').forEach(card => {
                card.classList.remove('construction-mode');

                const dragIcon = card.querySelector('.drag-icon');
                if (dragIcon) dragIcon.remove();
            });
        }


        // Menyimpan urutan section
        function saveSectionOrder() {
            const order = [];
            container.querySelectorAll('.card').forEach((el, index) => {
                order.push({ position: index + 1 });
            });

            fetch('/sections/update-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: order })
            });
        }

        // Menampilkan tombol tambah resource di bawah kontainer
        function showAddResourceButton() {
            if (addButtonContainer) return; // Jangan menambahkan lebih dari satu tombol

            const addButton = document.createElement('button');
            addButton.textContent = 'Tambah Resource';
            addButton.classList.add('btn', 'btn-primary', 'mt-4', 'w-full');
            addButton.addEventListener('click', function () {
                const myModal = new bootstrap.Modal(document.getElementById('addResourceModal'));
                myModal.show(); // Menampilkan modal pop-up
            });

            addButtonContainer = document.createElement('div');
            addButtonContainer.classList.add('text-center');
            addButtonContainer.appendChild(addButton);
            container.appendChild(addButtonContainer); // Menambahkan tombol ke bagian bawah kontainer
        }

        // Menghapus tombol tambah resource
        function hideAddResourceButton() {
            if (addButtonContainer) {
                addButtonContainer.remove();
                addButtonContainer = null; // Menghapus referensi
            }
        }

        // Menangani klik pada submenu
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('click', function () {
                const resourceType = this.getAttribute('data-type');
                addResourceToPage(resourceType);
                const myModal = new bootstrap.Modal(document.getElementById('addResourceModal'));
                myModal.hide(); // Menutup modal setelah menambah resource
            });
        });

        // Menambahkan resource pada halaman berdasarkan jenis resource
        function addResourceToPage(resourceType) {
            const newResource = document.createElement('div');
            newResource.classList.add('card', 'mt-3');

            switch (resourceType) {
                case 'label':
                    newResource.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Label Baru</h5>
                            <p class="card-text">Klik untuk menambahkan label baru.</p>
                            <a href="{{ route('labels.create') }}" class="btn btn-primary">Buat Label</a>
                        </div>`;
                    break;
                case 'page':
                    newResource.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Page Baru</h5>
                            <p class="card-text">Klik untuk menambahkan page baru.</p>
                            <a href="{{ route('pages.create') }}" class="btn btn-primary">Buat Page</a>
                        </div>`;
                    break;
                case 'file':
                    newResource.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">File Baru</h5>
                            <p class="card-text">Klik untuk menambahkan file baru.</p>
                            <a href="{{ route('files.create') }}" class="btn btn-primary">Buat File</a>
                        </div>`;
                    break;
                case 'folder':
                    newResource.innerHTML = `<div class="card-body"><h5 class="card-title">Folder Baru</h5><p class="card-text">Ini adalah folder baru yang ditambahkan.</p></div>`;
                    break;
                case 'url':
                newResource.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">URL Baru</h5>
                            <p class="card-text">Klik untuk menambahkan url baru.</p>
                            <a href="{{ route('url.create') }}" class="btn btn-primary">Buat Url</a>
                        </div>`;
                    break;
                case 'form':
                    newResource.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Forum Baru</h5>
                            <p class="card-text">Klik untuk menambahkan forum baru.</p>
                            <a href="{{ route('forums.create') }}" class="btn btn-primary">Buat Forum</a>
                        </div>`;
                    break;
                case 'quiz':
                    newResource.innerHTML = `<div class="card-body"><h5 class="card-title">Quiz Baru</h5><p class="card-text">Ini adalah quiz baru yang ditambahkan.</p></div>`;
                    break;
                case 'assignment':
                    newResource.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Assignment Baru</h5>
                            <p class="card-text">Klik untuk menambahkan assignment baru.</p>
                            <a href="{{ route('assignments.create') }}" class="btn btn-primary">Buat Assignment</a>
                        </div>`;
                    break;
                case 'lesson':
                    newResource.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title">Lesson Baru</h5>
                                <p class="card-text">Klik untuk menambahkan lesson baru.</p>
                                <a href="{{ route('lessons.create') }}" class="btn btn-primary">Buat Lesson</a>
                            </div>`;
                        break;
                case 'h5p':
                    newResource.innerHTML = `<div class="card-body"><h5 class="card-title">H5P Baru</h5><p class="card-text">Ini adalah H5P baru yang ditambahkan.</p></div>`;
                    break;
            }


            // Menambahkan resource ke container
            container.appendChild(newResource);

            // Memindahkan tombol ke bagian bawah setelah menambahkan elemen baru
            moveAddResourceButtonToBottom();
        }

        // Memindahkan tombol Add Resource ke bagian bawah setelah elemen baru ditambahkan
        function moveAddResourceButtonToBottom() {
            if (addButtonContainer) {
                container.appendChild(addButtonContainer);
            }
        }

    });

</script>
