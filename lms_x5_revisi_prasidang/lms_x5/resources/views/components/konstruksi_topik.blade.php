<!-- Button untuk Mode Konstruksi -->
<div class="flex justify-end mb-4">
    <button id="toggleEditMode" class="btn btn-primary">
        Mode Konstruksi
    </button>
</div>

<style>
/* Style untuk Elemen yang Bisa Di-Drop dan Di-Drag */
#sortable-topics .card-body {
    padding: 10px;
    margin-bottom: 10px;
    /* cursor: move; */
    position: relative;
}

/* Border hanya muncul saat mode konstruksi aktif */
body.edit-mode .card.construction-mode .card-body {
    border: 2px dashed #ffc107; /* Hanya tampil saat mode konstruksi aktif */
}

#sortable-topics .card-body:hover {
    background-color: #e1f5fe;
}

.sortable-ghost {
    opacity: 0.4; /* Efek transparansi saat dipindahkan */
}

/* Menambahkan efek hover saat drag */
#sortable-topics .card-body.dragging {
    opacity: 0.7;
}

/* Mengubah background saat dalam mode konstruksi */
body.edit-mode {
    background-color: #f5f5f5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let editMode = false; // Status untuk mode konstruksi
    let sectionSort;
    const toggleButton = document.getElementById('toggleEditMode');
    const container = document.querySelector('#sortable-topics');
    
    if (!container || !toggleButton) return;

    // Fungsi untuk mengaktifkan drag-and-drop menggunakan SortableJS
    function enableDragDrop() {
        sectionSort = new Sortable(container, {
            animation: 150, // Animasi saat memindahkan elemen
            draggable: '> .col-md-6', // Hanya elemen card di dalam .col-md-6 yang bisa dipindahkan
            handle: undefined, // Seluruh elemen bisa di-drag
            ghostClass: 'sortable-ghost', // Menambahkan kelas saat elemen sedang dipindahkan
            onStart(evt) {
                evt.item.classList.add('dragging');
            },
            onEnd(evt) {
                evt.item.classList.remove('dragging');
            }
        });

        // Menambahkan efek mode konstruksi pada setiap card
        document.querySelectorAll('.card').forEach(card => {
            card.classList.add('construction-mode');
        });
    }

    // Fungsi untuk menonaktifkan drag-and-drop
    function disableDragDrop() {
        if (sectionSort) sectionSort.destroy(); // Menghentikan SortableJS

        // Hapus efek mode konstruksi dari semua card
        document.querySelectorAll('.card').forEach(card => {
            card.classList.remove('construction-mode');
        });
    }

    // Event listener untuk toggle mode konstruksi
    toggleButton.addEventListener('click', function () {
        editMode = !editMode;
        this.textContent = editMode ? 'Tutup Mode Konstruksi' : 'Mode Konstruksi';
        
        if (editMode) {
            enableDragDrop();
            document.body.classList.add('edit-mode'); // Tambahkan kelas untuk memberikan indikasi visual
        } else {
            disableDragDrop();
            document.body.classList.remove('edit-mode'); // Menghapus kelas edit-mode
        }
    });
});
</script>
