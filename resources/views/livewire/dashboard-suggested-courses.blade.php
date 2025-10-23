<div class="container-fluid">
    <div class="mb-4">
        <h3 class="h4 mb-4">Recommended Courses</h3>
    </div>
    <div wire:ignore class="swiper mySwiper px-2">
        <div class="swiper-wrapper py-4">
            @foreach($randomCourses as $course)
            <div class="swiper-slide">
                <div class="course-card">
                    <div class="course-card-content">
                        @if($course->image)
                        <div class="mb-3">
                            <img src="{{ asset('uploads/courses/' . $course->image) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $course->name }}"
                                 loading="lazy">
                        </div>
                        @endif
                        <h3 class="h5 mb-2">{{ $course->name }}</h3>
                        <p class="text-muted small mb-2">{{ Str::limit($course->description, 100) }}</p>
                        <p class="h6 mb-3">${{ number_format($course->price, 2) }}</p>
                        <a href="{{ route('courses.index', $course->slug) }}" 
                           class="btn btn-primary w-100">
                            View Course
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Include Swiper CSS once globally in your layout -->

    <style>
        .swiper {
            width: 100%;
            padding: 20px 0;
            margin: 0 -10px;
        }

        .swiper-slide {
            height: auto;
            width: 300px;
            padding: 0 10px;
        }

        @media (min-width: 768px) {
            .swiper-slide {
                width: 350px;
            }
        }

        .course-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .course-card img {
            max-height: 160px;
            object-fit: cover;
            border-radius: 8px;
        }

        .course-card-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .course-card h3 {
            font-size: 1.1rem;
            margin-bottom: 12px;
            color: #2d3748;
            line-height: 1.4;
        }

        .course-card p {
            font-size: 0.9rem;
            color: #4a5568;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #4a5568;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
        }

        @media (max-width: 767px) {
            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        }

        .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background: #cbd5e0;
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: #4a5568;
            width: 24px;
            border-radius: 4px;
            transition: width 0.3s;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            let swiper;

            function initSwiper() {
                if (swiper) {
                    swiper.destroy(true, true);
                }

                swiper = new Swiper(".mySwiper", {
                    slidesPerView: "auto",
                    spaceBetween: 20,
                    centeredSlides: false,
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    grabCursor: true,
                    breakpoints: {
                        768: {
                            centeredSlides: true,
                            spaceBetween: 30,
                        }
                    },
                        disableOnInteraction: false,
                  
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 20
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 30
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        }
                    }
                });
            }

            initSwiper();

            Livewire.on('courseDataUpdated', () => {
                // Wait for DOM to update
                setTimeout(initSwiper, 100);
            });
        });
    </script>
</div>