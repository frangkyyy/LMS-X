<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $forum->name }}</h3>
                        <div class="card-tools">
                            <a href="javascript:history.back()" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="forum-posts mb-4">
                            <h4 class="mb-3">{!! $forum->description !!}</h4>
                            <div id="posts-container">
                                @forelse($forum->posts as $post)
                                    <div class="card mb-3 post-item" data-post-id="{{ $post->id }}">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $post->user->name }}</strong>
                                                <small class="text-muted ml-2">{{ $post->created_at->diffForHumans() }}</small>
                                            </div>
                                            @if(auth()->id() == $post->user_id)
                                                <div class="post-actions">
                                                    <button class="btn btn-sm btn-outline-primary edit-post"
                                                            data-post-id="{{ $post->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-post"
                                                            data-post-id="{{ $post->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="post-content">
                                                {!! $post->content !!}
                                            </div>
                                            <div class="edit-form" style="display: none;">
                                                <textarea class="form-control edit-content" rows="3">{{ $post->content }}</textarea>
                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-primary save-edit">Simpan</button>
                                                    <button class="btn btn-sm btn-secondary cancel-edit">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="add-comment mt-5">
                            <h4 class="mb-3">Tambah Komentar</h4>
                            <form id="comment-form" method="POST" action="{{ route('forum-posts.store') }}">
                                @csrf
                                <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <div class="form-group">
                                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Summernote or other rich text editor
            $('#content').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });

            // Toggle edit form
            $(document).on('click', '.edit-post', function() {
                const postId = $(this).data('post-id');
                const $postItem = $(`.post-item[data-post-id="${postId}"]`);

                $postItem.find('.post-content').hide();
                $postItem.find('.edit-form').show();
                $postItem.find('.edit-content').summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['para', ['ul', 'ol', 'paragraph']],
                    ]
                });
            });

            // Cancel edit
            $(document).on('click', '.cancel-edit', function() {
                const postId = $(this).closest('.post-item').data('post-id');
                const $postItem = $(`.post-item[data-post-id="${postId}"]`);

                $postItem.find('.edit-form').hide();
                $postItem.find('.post-content').show();
            });

            // Save edit
            $(document).on('click', '.save-edit', function() {
                const postId = $(this).closest('.post-item').data('post-id');
                const content = $(this).closest('.edit-form').find('.edit-content').summernote('code');

                $.ajax({
                    url: `/forum-posts/${postId}`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        content: content
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal memperbarui komentar: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Delete post
            $(document).on('click', '.delete-post', function() {
                if (!confirm('Apakah Anda yakin ingin menghapus komentar ini?')) return;

                const postId = $(this).data('post-id');
                const postElement = $(`.post-item[data-post-id="${postId}"]`);

                $.ajax({
                    url: '/forum-posts/' + postId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            // Hapus elemen komentar dari DOM
                            postElement.fadeOut(300, function() {
                                $(this).remove();
                            });

                            // Tampilkan notifikasi sukses
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus komentar';
                        toastr.error(errorMessage);
                    }
                });
            });

            // Submit new comment
            $('#comment-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const formData = new FormData(form[0]);

                // Get HTML content from Summernote
                formData.set('content', $('#content').summernote('code'));

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = [];

                        for (let field in errors) {
                            errorMessages.push(errors[field][0]);
                        }

                        alert('Gagal mengirim komentar: ' + errorMessages.join('\n'));
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .forum-description img {
            max-width: 100%;
            height: auto;
        }
        .post-actions {
            opacity: 0;
            transition: opacity 0.3s;
        }
        .post-item:hover .post-actions {
            opacity: 1;
        }
        .note-editable {
            background-color: #fff;
        }
    </style>
@endpush
