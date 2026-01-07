<div class="container py-4">
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="rounded overflow-hidden shadow-sm">
                <img src="{{asset('/uploads/courses/' . $course->image)}}"
                    class="img-fluid w-100"
                    style="max-height: 400px; object-fit: cover;"
                    alt="{{ $course->name }}"
                    loading="lazy">
            </div>

            <h1 class="h2 my-4">{{ $course->name }}</h1>
            <p class="lead">{{ $course->description }}</p>
        </div>
        <div class="col-12 col-lg-4">
            <div class="sticky-lg-top" style="top: 2rem;">
                <h3 class="h4 mb-4">Course Details</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Duration:</strong> {{ $course->getFormattedTotalDurationAttribute() }} hours</li>
                    <li class="list-group-item"><strong>Price:</strong> ${{ $course->price }}</li>
                    <li class="list-group-item"><strong>Lessons:</strong> {{ $course->lessons->count() }}</li>
                    <li class="list-group-item"><strong>Enrolled Students:</strong> {{ $totalEnrollments }}</li>
                    @if($isEnrolled)
                    <li class="list-group-item">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Course Progress</strong>
                                @php
                                $trackData = \App\DTOs\Lesson\TrackProgressData::fromRequest((object)[
                                'course_id' => $course->id,
                                'student_id' => auth()->guard('student')->id()
                                ]);
                                $action = new \App\Actions\Lesson\TrackProgress($trackData->course_id, $trackData->student_id);
                                $progress = $action->execute($trackData);
                                @endphp
                                <span class="text-muted small">{{ round($progress) }}%</span>
                            </div>
                            <p>check</p>
                            <div class="progress" style="height: 8px; background-color: #e9ecef;">

                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                    role="progressbar"
                                    style="width: {{ $progress }}%; transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);"
                                    aria-valuenow="{{ $progress }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($isEnrolled)
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        <p>You are enrolled in this course!</p>
                    </div>
                    <button wire:click="enroll" class="btn btn-danger mt-4" disabled>
                        Unenroll from Course
                    </button>
                    @else
                    <button wire:click="enroll" class="btn btn-primary mt-4">
                        Enroll in this Course
                    </button>
                    @endif

                </ul>
            </div>
        </div>
        <div class="mt-5">
            <div class="scrollable-wrapper mb-4">
                <div class="d-flex gap-3 pb-2" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    @foreach ($course->modules as $module)
                    <button
                        wire:click="selectModule({{ $module->id }})"
                        wire:key="module-{{ $module->id }}"
                        class="btn {{ $selectedModuleId === $module->id ? 'btn-primary' : 'btn-outline-primary' }} flex-shrink-0">
                        {{ $module->name }}
                    </button>
                    @endforeach
                </div>
            </div>
            @php
            $activeModule = $course->modules->firstWhere('id', $selectedModuleId);
            @endphp

            @if ($activeModule)
            <div class="scrollable-wrapper mb-4">
                <div class="d-flex gap-3 pb-2" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    @foreach ($activeModule->lessons as $lesson)
                    <button
                        wire:click="selectLesson({{ $lesson->id }})"
                        wire:key="lesson-{{ $lesson->id }}"
                        class="btn {{ $selectedLessonId == $lesson->id ? 'btn-secondary' : 'btn-outline-secondary' }} flex-shrink-0">
                        {{ $lesson->title }}
                    </button>
                    @endforeach
                </div>
            </div>
            @php
            $activeLesson = $activeModule->lessons->where('id', $selectedLessonId)->first();
            @endphp
            <div class="d-flex justify-content-between align-items-center"  x-data="{showConfirm:false}">

                @if($isEnrolled&&$activeLesson!==null)
                @if($this->isLessonCompleted($activeLesson->id))
                <button class="btn btn-success btn-sm" disabled>Completed</button>
                @else
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal" @click="showModal=true">
                 Mark as completed
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  x-show="showModal"> 
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are You sure you want to complete this lesson
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" wire:click="markAsCompleted({{$activeLesson->id}},true)" data-bs-dismiss="modal" @click="showModal:false">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif

            </div>
            @if($activeLesson!=null&&$activeLesson->visible==false && (auth()->guard('guest')->check()||!$isEnrolled))
            <h2 class="h3 mb-3 ms-2">{{ $activeLesson->title }}</h2>

            <div class="alert alert-info mt-4">
                <h4 class="alert-heading">Lesson Locked</h4>
                <p>This lesson is locked. Please enroll in the course to access this content.</p>
            </div>
            @elseif ($activeLesson)
            <h2 class="h3 mb-3 ms-2">{{ $activeLesson->title }}</h2>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <button wire:click="previousLesson" class="btn btn-outline-secondary btn-sm">&larr; Previous</button>
                    </div>
                    <div>
                        <button wire:click="nextLesson" class="btn btn-outline-secondary btn-sm">Next &rarr;</button>
                    </div>


                </div>
                <div class="lesson-content">
                    <p class="text-muted">{{ $activeLesson->content }}</p>
                </div>
                <div class="video-wrapper mb-4 rounded overflow-hidden" x-data="plyrPlayer('{{ $activeLesson->title ?? 'Lesson Video' }}')" x-init="init()" @plyr:refresh.window="init()">
                    <video controls class="plyr-video">
                        <source src="{{asset('/uploads/lessons/' . $activeLesson->video_url)}}" type="video/mp4">
                    </video>
                </div>


            </div>

            @else
            <div class="text-center py-8 text-gray-500">
                <p>No lessons available for this module</p>
            </div>

            @endif


            @endif
        </div>
    </div>
    <script>
        // Progress bar animation handling
        document.addEventListener('livewire:init', () => {
            Livewire.on('progressUpdated', () => {
                const progressBar = document.querySelector('.progress-bar');
                const progressText = document.querySelector('.progress-text');
                if (progressBar) {
                    // Force a reflow to ensure the transition runs
                    progressBar.style.transition = 'none';
                    progressBar.offsetHeight;
                    progressBar.style.transition = 'width 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
                }
            });
        });

        // Alpine-based Plyr integration. Creates/destroys players using Alpine component lifecycle
        document.addEventListener('alpine:init', () => {
            Alpine.data('plyrPlayer', (title) => ({
                title: title ?? 'Lesson Video',
                players: [],

                init() {
                    this.destroy();

                    const videos = this.$el.querySelectorAll('video');
                    videos.forEach(videoElement => {
                        try {
                            const player = new Plyr(videoElement, {
                                title: this.title,
                                controls: [
                                    'play-large', 'play', 'progress', 'current-time', 'mute', 'volume',
                                    'captions', 'settings', 'pip', 'airplay', 'fullscreen'
                                ],
                                settings: ['captions', 'quality', 'speed'],
                                hideControls: true,
                                ratio: '16:9',
                                storage: {
                                    enabled: true,
                                    key: 'plyr'
                                }
                            });

                            this.players.push(player);

                            player.on('ready', () => {
                                // no-op or custom ready behavior
                            });

                            player.on('play', () => {
                                // no-op or custom play behavior
                            });
                        } catch (e) {
                            console.warn('Plyr init failed', e);
                        }
                    });
                },

                destroy() {
                    if (!this.players || this.players.length === 0) return;
                    this.players.forEach(p => {
                        try {
                            if (p && typeof p.destroy === 'function') p.destroy();
                        } catch (e) {}
                    });
                    this.players = [];
                }
            }));

            // Reinitialize after Livewire updates (morphs). We use message.processed for Livewire 2/3 compatibility.
            if (window.Livewire) {
                Livewire.hook('message.processed', (el, component) => {
                    // Find all Alpine plyr components and re-init them
                    document.querySelectorAll('[x-data^="plyrPlayer"]').forEach(el => {
                        try {
                            const alpineComponent = el.__x;
                            if (alpineComponent && alpineComponent.$data && typeof alpineComponent.init === 'function') {
                                // Wait a tick for DOM to settle
                                setTimeout(() => alpineComponent.init(), 50);
                            }
                        } catch (e) {
                            // fallback: trigger a custom event the component listens to
                            el.dispatchEvent(new Event('plyr:refresh'));
                        }
                    });
                });
            }
        });
    </script>