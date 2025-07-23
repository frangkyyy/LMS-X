@if ($forums)
    @foreach ($forums as $forum)
        <div class="mt-4">
            <h4 class="fw-bold text-primary">{{ $forum->name }}</h4>
            <p>{{ $forum->description }}</p>

            @foreach ($forum->posts as $post)
                <div class="border p-3 rounded mb-2">
                    <strong>{{ $post->user->name ?? 'User Tidak Diketahui' }}</strong> berkata:
                    <p>{{ $post->content }}</p>

                    @if ($post->user_id == auth()->id())
                        <div class="mt-2">
                            <a href="{{ route('forum-posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('forum-posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus komentar ini?')">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach

            <hr>
            <form action="{{ route('forum.post.store') }}" method="POST">
                @csrf
                <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Tulis komentar di sini..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    @endforeach
@endif