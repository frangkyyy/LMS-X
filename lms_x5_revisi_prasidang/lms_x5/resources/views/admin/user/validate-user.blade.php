 <div class="container mt-5">
    <h3 class="mb-4">📘 Internet Of Things

    </h3>
    <p class="text-muted">descripsi</p>

    <div class="list-group">
      <!-- Loop ini akan dibuat 16x -->
      @for ($i = 1; $i <= 16; $i++)
      <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        Topik {{ $i }}: Judul Topik {{ $i }}
        <button class="btn btn-sm btn-outline-primary">Edit Materi</button>
      </a>
      @endfor
    </div>
  </div>
