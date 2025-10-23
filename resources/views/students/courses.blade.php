@extends('components.layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">My Enrolled Courses</h2>

    @if($enrolledCourses)
    <div class="row">
        @foreach($enrolledCourses as $course)
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
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small>{{ $course->lessons }} Lessons</small>
                    <small>{{ $course->getFormattedTotalDurationAttribute() }} Duration</small>
                    @if($course->progress < 100)
                        <span class="btn btn-warning btn-sm">In progress <small>{{ $course->progress }} % </small>
                        </span>
                        @else
                        <span class="btn btn-success btn-sm">Completed</span>
                        @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>You are not enrolled in any courses yet.</p>
    @endif
</div>
@endsection