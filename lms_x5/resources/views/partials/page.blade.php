@if ($page)
<div class="card mt-4">
    <div class="card-body">
        <h4 class="fw-bold text-primary">{{ $page->name }}</h4>
        <p>{{ $page->description }}</p>
        <p>{{ $page->content }}</p>

    </div>
</div>
@endif