<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container my-4">
    <div class="card p-4">
        <h1 class="text-center mb-4">Form Perkuliahan - Topik 1</h1>
        <form>
            <div class="mb-3">
                <label for="type" class="form-label fw-bold">Type:</label>
                <select class="form-select" id="type" name="type">
                    <option value="Perkuliahan" selected>Perkuliahan</option>
                    <option value="Project">Project</option>
                    <option value="Studi Kasus">Studi Kasus</option>
                    <option value="Ujian Sumatif">Ujian Sumatif</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="bahan_kajian" class="form-label fw-bold">Bahan Kajian:</label>
                <input type="text" class="form-control" id="bahan_kajian" placeholder="Masukkan bahan kajian..." value="Pengantar & Arsitektur IoT">
            </div>

            <div class="mb-3">
                <label for="deskripsi_topik" class="form-label fw-bold">Deskripsi Topik:</label>
                <textarea class="form-control" id="deskripsi_topik" rows="4" placeholder="Masukkan deskripsi topik..."></textarea>
            </div>

            <div class="mb-3">
                <label for="sub_cpmk" class="form-label fw-bold">Sub CPMK:</label>
                <textarea class="form-control" id="sub_cpmk" rows="4" placeholder="Masukkan Sub CPMK..."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sub Materi:</label>
                <div id="sub-materi-list">
                    <div class="card p-3 mb-2 position-relative" id="sub-materi-1">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteItem('sub-materi-1')" aria-label="Close"></button>
                        <div class="mb-2">
                            <label for="sub_materi_1" class="form-label">Sub Materi:</label>
                            <input type="text" class="form-control" id="sub_materi_1" placeholder="Masukkan sub materi...">
                            <textarea class="form-control mt-2" id="sub_materi_desc_1" rows="3" placeholder="Masukkan deskripsi sub materi..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addSubMateri()">Tambah Sub Materi</button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Referensi:</label>
                <div id="referensi-list">
                    <div class="card p-3 mb-2 position-relative" id="referensi-1">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteItem('referensi-1')" aria-label="Close"></button>
                        <div class="mb-2">
                            <label for="referensi_1" class="form-label">Referensi:</label>
                            <textarea class="form-control" id="referensi_1" rows="3" placeholder="Masukkan referensi..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addReferensi()">Tambah Referensi</button>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    let subMateriCount = 1;
    let referensiCount = 1;

    function addSubMateri() {
        subMateriCount++;
        const newSubMateri = document.createElement('div');
        newSubMateri.className = 'card p-3 mb-2 position-relative';
        newSubMateri.id = `sub-materi-${subMateriCount}`;
        newSubMateri.innerHTML = `
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteItem('sub-materi-${subMateriCount}')" aria-label="Close"></button>
            <div class="mb-2">
                <label for="sub_materi_${subMateriCount}" class="form-label">Sub Materi:</label>
                <input type="text" class="form-control" id="sub_materi_${subMateriCount}" placeholder="Masukkan sub materi...">
                <textarea class="form-control mt-2" id="sub_materi_desc_${subMateriCount}" rows="3" placeholder="Masukkan deskripsi sub materi..."></textarea>
            </div>
        `;
        document.getElementById('sub-materi-list').appendChild(newSubMateri);
    }

    function addReferensi() {
        referensiCount++;
        const newReferensi = document.createElement('div');
        newReferensi.className = 'card p-3 mb-2 position-relative';
        newReferensi.id = `referensi-${referensiCount}`;
        newReferensi.innerHTML = `
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="deleteItem('referensi-${referensiCount}')" aria-label="Close"></button>
            <div class="mb-2">
                <label for="referensi_${referensiCount}" class="form-label">Referensi:</label>
                <textarea class="form-control" id="referensi_${referensiCount}" rows="3" placeholder="Masukkan referensi..."></textarea>
            </div>
        `;
        document.getElementById('referensi-list').appendChild(newReferensi);
    }

    function deleteItem(id) {
        const element = document.getElementById(id);
        if (element) {
            element.remove();
        }
    }
</script>
