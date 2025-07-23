<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $subTopic->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="folder">{{ $folder->name }}</li>
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

        <!-- Folder Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h1>{{ $folder->name }}</h1>
            </div>
            <div class="card-body">
                @if ($folder->description)
                    <h5>Deskripsi</h5>
                    <p class="card-text">{!! $folder->description !!}</p>
                @endif

                    <!-- Files in Folder -->
                    <h2>File dalam Folder</h2>
                    @if($files->isEmpty())
                        <p>Tidak ada file di folder ini.</p>
                    @else
                        <div class="mb-3">
                            @foreach($files as $file)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-folder" style="margin-right: 0.5rem;"></i>
                                    <a href="{{ Storage::url('uploads/folders/'.basename($file->file_path)) }}" target="_blank" class="text-decoration-none text-primary">
                                        {{ $file->name }}
                                    </a>
                                </div>
                                @if($file->description)
                                    <p class="mb-0">{{ $file->description }}</p>
                                @endif
                            @endforeach
                        </div>
                    @endif
            </div>

        </div>

        <!-- Subtopic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Subtopik: {{ $subTopic->title }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Bagian dari: <a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $section->title }}</a></p>
                <p class="card-text">Mata Kuliah: {{ $course->full_name }}</p>
            </div>
        </div>

        <!-- Navigation Button -->
        <div class="mt-4">
            <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
