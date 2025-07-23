<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Komentar Forum</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('forum-posts.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden fields for context -->
                    <input type="hidden" name="forum_id" value="{{ $post->forum_id }}">
                    <input type="hidden" name="style_slug" value="{{ $styleSlug }}">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="section_id" value="{{ $forum->section_id }}">

                    <div class="form-group mb-4">
                        <label for="content" class="form-label fw-bold">Isi Komentar:</label>
                        <textarea name="content" id="content" class="form-control" rows="6" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route($styleSlug, [
                            'course_id' => $course->id,
                            'topik' => $forum->section_id,
                            'section_id' => $forum->section_id
                        ]) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
