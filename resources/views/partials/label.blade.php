@if ($label)
<div class="card mt-4">
    <div class="card-body">
        @if (!empty($label))
            <p>{!! $label->konten !!}</p>
        @endif
    </div>
</div>
@endif