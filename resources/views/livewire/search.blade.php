<div class="row justify-content-center align-items-center mb-4">
  <div class="col-md-6">
    <input
      class="form-control me-2"
      type="search"
      placeholder="Search courses..."
      aria-label="Search"
      wire:model.live.debounce.300ms="searchTerm">
    @error('searchTerm') <span class="text-red-500">{{ $message }}</span> @enderror

  </div>

  <div class="row mt-4">
    @foreach($results as $course)
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <a href="{{ route('courses.index', $course->slug) }}">
          @if($course->image)
          <img src="{{asset('/uploads/courses/' . $course->image)}}" class="card-img-top" alt="{{ $course->name }}" loading="lazy">
          @endif

          <div class="card-body">
            <h5 class="card-title">{{ $course->name }}</h5>
            <p class="card-text">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
          </div>
        </a>
      </div>
    </div>
    @endforeach
  </div>
</div>