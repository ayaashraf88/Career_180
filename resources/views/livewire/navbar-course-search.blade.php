<div class="position-relative" x-data @click.away="$wire.hideDropdown()">
    <input
        class="form-control me-2"
        type="search"
        placeholder="Search courses..."
        aria-label="Search"
        wire:model.live.debounce.300ms="searchTerm"
        wire:focus="showDropdown">
    @if($showDropdown)
    <div class="position-absolute top-100 start-0 w-100 border rounded shadow bg-white p-3"
        style="z-index: 1050; max-height: 300px; overflow-y: auto;">
        @if(count($results) > 0)
        <ul class="list-group list-group-flush">
            @foreach($results as $course)
            <li class="list-group-item">
                <a href="{{ route('courses.index', $course->slug) }}" class="text-decoration-none text-dark">
                    {{ $course->name }}
                </a>
            </li>
            @endforeach
        </ul>
        @elseif(strlen($searchTerm) > 1)
        <div class="list-group-item text-muted">No courses found</div>
        @endif
    </div>
    @endif

    <div wire:loading.delay wire:target="searchTerm" class="position-absolute top-50 end-0 translate-middle-y me-3">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Searching...</span>
        </div>
    </div>
</div>