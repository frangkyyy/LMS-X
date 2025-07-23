<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $subTopic->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>
            </ol>
        </nav>

        <!-- Pesan Error atau Sukses -->
        @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors')->first() }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Informasi Halaman -->
        <div class="card mb-4">
            <div class="card-header">
                <h1>{{ $page->name }}</h1>
            </div>
            <div class="card-body">
                @if ($page->description)
                    <h5>Deskripsi</h5>
                    <p class="card-text">{!! $page->description !!}</p>
                @endif

                @if ($page->content)
                    <h5>Konten</h5>
                    <div class="card-text">{!! $page->content !!}</div>
                @else
                    <p class="card-text">Tidak ada konten tersedia untuk halaman ini.</p>
                @endif
            </div>
        </div>

        <!-- Informasi Subtopik -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Subtopik: {{ $subTopic->title }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Bagian dari: <a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></p>
                <p class="card-text">Mata Kuliah: {{ $course->full_name }}</p>
            </div>
        </div>

        <!-- Tombol Navigasi -->
        <div class="mt-4">
            <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Kembali ke Section</a>
        </div>


    </div>
</div>
