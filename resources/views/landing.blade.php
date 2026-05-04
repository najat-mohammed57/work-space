@extends('layouts.guest')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
    .hero-section {
        font-family: var(--font-jakarta);
        padding: 80px 0;
        position: relative;
    }

    .hero-content-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .hero-description {
        color: #6c757d;
        font-size: 1.15rem;
        line-height: 1.6;
        max-width: 550px;
        margin-bottom: 2rem;
    }

    .hero-btn-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 25px;
    }

    .bg-blobs {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .blob {
        position: absolute;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(0,123,255,0.05) 0%, rgba(255,255,255,0) 70%);
        filter: blur(50px);
        border-radius: 50%;
    }

    .blob-animate {
        animation: move-blob 20s infinite alternate;
    }

    @keyframes move-blob {
        from { transform: translate(0, 0); }
        to { transform: translate(50px, 100px); }
    }


    .hover-up {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-up:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3) !important;
    }

    .btn-join-interactive {
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-join-interactive:hover {
        color: #3b82f6 !important;
        padding-left: 5px;
    }

    .btn-join-interactive i {
        transition: transform 0.3s ease;
    }

    .btn-join-interactive:hover i {
        transform: translateX(5px);
    }

  .collage-container {
    position: relative;
    width: 100%;
    margin-top: 20px;
}

.creative-border {
    position: absolute;
    top: 20px;
    left: 20px;
    right: -20px;
    bottom: -20px;
    background: rgba(59, 130, 246, 0.08);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    z-index: 1;
    border: 1px solid rgba(255, 255, 255, 0.4);
}

.stack-img {
    z-index: 2;
    position: relative;
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

    .floating-card {
        position: absolute;
        background: white;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        z-index: 10;
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }

    .card-stats { top: 10%; right: -10px; }
    .card-feedback { bottom: 10%; left: -20px; animation-delay: 1.5s; }

    .why-us-minimal {
        background-color: #ffffff;
        padding: 80px 0;
    }

    .text-primary-blue { color: #006aff; }

    .img-medium {
        max-width: 90%;
        height: auto;
        display: block;
        margin: 0 auto;
    }


    .feature-outline-icon i {
        color: #006aff;
        font-size: 20px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .main-workspace-img {
        border: 10px solid #ffffff;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        max-width: 85%;
        border-radius: 24px;
    }

    .floating-badge {
        position: absolute;
        background: white;
        padding: 14px 20px;
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        z-index: 10;
        border: 1px solid rgba(0,0,0,0.05);
        min-width: 200px;
    }


    .services-swiper { padding-bottom: 60px !important; position: relative; }
    .swiper-slide { height: auto !important; display: flex; }
    .service-card-modern { display: flex; flex-direction: column; width: 100%; background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; overflow: hidden; border: 1px solid #f0f0f0; }
    .service-card-modern:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
    .clickable-card:active { transform: scale(0.98); }
    .img-container img { height: 200px; object-fit: cover; width: 100%; }
    .category-tag { font-size: 0.75rem; color: #006aff; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
    .feature-list { min-height: 120px; padding: 0; }
    .feature-list li { font-size: 0.9rem; color: #555; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
    .feature-list i { color: #28a745; font-size: 0.8rem; }
    .price-tag { color: #006aff; font-weight: 800; font-size: 1.5rem; }
    .btn-book-modern { background: #006aff; color: white; border-radius: 50px; padding: 8px 20px; font-weight: 600; transition: 0.3s; }
    .btn-book-modern:hover { background: #0056d2; color: white; box-shadow: 0 5px 15px rgba(0,106,255,0.3); }


    .swiper-pagination { bottom: 0px !important; }
    .swiper-pagination-bullet { width: 10px; height: 10px; background: #ccc; opacity: 1; margin: 0 5px !important; }
    .swiper-pagination-bullet-active { background: #006aff !important; width: 25px; border-radius: 5px; transition: 0.3s; }
    .custom-nav { color: #006aff !important; background: white; width: 45px !important; height: 45px !important; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .custom-nav:after { font-size: 18px !important; font-weight: bold; }

#services .container {
    position: relative;
    padding-left: 50px;
    padding-right: 50px;
}

.custom-nav {
    top: 55% !important;
    z-index: 10;
}

.swiper-button-prev.custom-nav {
    left: 0 !important;
}

.swiper-button-next.custom-nav {
    right: 0 !important;
}

@media (max-width: 768px) {
    .custom-nav {
        display: none !important;
    }
    #services .container {
        padding-left: 15px;
        padding-right: 15px;
    }
}

.badge-top-left { top: 20px; left: -30px; }
.badge-top-right { top: 20px; right: -30px; }
.badge-bottom-left { bottom: 20px; left: -30px; }
.badge-bottom-right { bottom: 20px; right: -30px; }


.position-relative.mx-auto {
    position: relative;
}


#features {
    padding-top: 0 !important;
    margin-top: -50px !important;
}


@keyframes softFloat {
    0% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0); }
}

.floating-badge {
    animation: softFloat 3s ease-in-out infinite;
    cursor: pointer;
    transition: all 0.3s ease;
}

.badge-top-right { animation-delay: 0.5s; }
.badge-bottom-left { animation-delay: 1s; }
.badge-bottom-right { animation-delay: 1.5s; }

.price-tag.font-bold {
    font-weight: 600 !important;
}

</style>
@if (session('booking_success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center" role="alert"
             style="background-color: #d1e7dd; color: #0f5132; border-radius: 10px; padding: 15px 20px;">
            <i class="fas fa-check-circle me-3" style="font-size: 1.2rem;"></i>
            <div>
                <strong>Success!</strong> {{ session('booking_success') }}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<section class="hero-section min-vh-75 d-flex align-items-center bg-white overflow-hidden">

    <div class="bg-blobs">
        <div class="blob blob-1 blob-animate"></div>
        <div class="blob blob-2 blob-animate"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content-column">
                <h1 class="display-3 font-bold mb-4 text-dark" style="line-height: 1.1;">
                    Empowering Your <br>
                    <span class="text-primary position-relative">
                        Workspace
                        <svg class="position-absolute" style="bottom: -5px; left: 0; width: 100%; height: 10px;" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 0 100 5" stroke="currentColor" stroke-width="3" fill="transparent" />
                        </svg>
                    </span>
                    in Gaza
                </h1>

                <p class="hero-description text-secondary lead">
                    Find the perfect professional environment for your study, projects, or meetings. Join our community of creators today.
                </p>

                <div class="hero-btn-group">
                    <a href="#services" class="btn btn-primary btn-lg px-5 shadow-lg rounded-pill py-3 font-bold hover-up">
                        Explore Services
                    </a>
                <a href="{{ route('register') }}" class="text-dark font-bold btn-join-interactive" style="text-decoration: none;">
                    Join Now <i class="fas fa-arrow-right ml-2"></i>
                   </a>
                </div>
            </div>
             <div class="col-lg-6 mt-5 mt-lg-0">
              <div class="collage-container">
        <div class="creative-border"></div>
        <div class="slideshow-wrapper">
             <img src="{{ asset('img/workspace.png') }}" class="stack-img" alt="My Professional Workspace">
        </div>
        <div class="floating-card card-stats d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-check-circle text-primary" style="font-size: 24px; background-color: white; border-radius: 50%;"></i>
            </div>
            <div>
                <small class="text-muted d-block">Available Now</small>
                <span class="font-bold text-dark">25+ Open Desks</span>
            </div>
        </div>

        <div class="floating-card card-feedback" style="bottom: 20px; left: -20px;">
            <div class="d-flex align-items-center">
                <div class="avatar-group d-flex mr-3">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white font-bold"
                         style="width: 35px; height: 35px; border: 2px solid white; background-color: #006aff !important;">G</div>
                    <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center text-white font-bold"
                         style="width: 35px; height: 35px; border: 2px solid white; margin-left: -10px; background-color: #000000 !important;">Z</div>
                </div>
                <div>
                    <h6 class="mb-0 font-bold">500+ Members</h6>
                    <small class="text-success font-semibold" style="color: #28a745 !important;">● Online in Gaza</small>
                </div>
            </div>
        </div>

    </div>
</div>

</section>

<section id="services" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary font-bold text-uppercase mb-2" style="letter-spacing: 2px;">Our Spaces</h6>
            <h2 class="font-bold display-4 text-dark">Professional Environments</h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">
                Tailored workspace solutions for students and freelancers in Gaza, designed for productivity and comfort.
            </p>

        </div>
          <div class="swiper-button-next custom-nav"></div>
            <div class="swiper-button-prev custom-nav"></div>

<div class="swiper services-swiper">
            <div class="swiper-wrapper">
                @forelse($services as $service)
                    <div class="swiper-slide h-auto">
                        <div class="card service-card-modern border-0 h-100 clickable-card">

                            <div class="img-container">
                                @php
                                $name = strtolower($service->name);
                               $imageName = 'workspace.png';
                                if (str_contains($name, 'shared')) {
                                 $imageName = 'shared_desk.png';
                             } elseif (str_contains($name, 'small')) {
                                 $imageName = 'small_desk.png';
                             }
                       elseif (str_contains($name, 'standing')) {
                        if (str_contains($name, 's2') || str_contains($name, '2')) {
                              $imageName = 'standing_desk2.png';
                               } else {
                               $imageName = 'standing_desk1.png';
                             }
                           }
                              elseif (str_contains($name, 'private')) {
                          $imageName = 'praivet_room.png';
                        }
                           elseif (str_contains($name, 'meeting')) {
                        $imageName = 'meeting_room.png';
                          }
                               elseif (str_contains($name, 'large')) {
                          $imageName = 'larg_desk.png';
                        }

                       $displayImage = asset('img/' . $imageName);
                   @endphp
                                 <img src="{{ $displayImage }}" alt="{{ $service->name }}" class="card-img-top">
                            </div>

                            <div class="card-body p-4 d-flex flex-column">
                                <span class="category-tag mb-2">{{ optional($service->serviceType->serviceCategory)->name ?? 'Workspace' }}</span>
                                <h4 class="service-title mb-3">{{ $service->name }}</h4>


                                <ul class="list-unstyled feature-list mb-4 flex-grow-1">
                                    @foreach($service->features->take(4) as $feature)
                                        <li><i class="fas fa-check"></i> {{ $feature->name }}</li>
                                    @endforeach
                                </ul>

                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Starting from</small>
                                        <span class="price-tag h2 font-bold text-secondary">${{ $service->base_price ?? '0' }}</span>
                                    </div>
                                    <a href="{{ auth()->check() ? route('bookings.create', $service->id) : route('register') }}" class="btn btn-outline-dark rounded-pill px-4">
                                        Book Space</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 w-100">
                        <p class="text-muted">No workspaces available.</p>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>


<section id="features" class="py-5 bg-white overflow-hidden" style="margin-top: 30px;">
    <div class="container text-center">

        <div class="mb-2">
            <h6 class="text-primary font-bold tracking-widest uppercase mb-1">WHY US?</h6>
            <h2 class="display-4 font-bold text-dark mb-2">Built for Gaza's Creative Minds</h2>
            <p class="text-secondary lead mx-auto mb-0" style="max-width: 650px;">
                We provide the ultimate environment for productivity, ensuring you stay focused and connected.
            </p>
        </div>
        <div class="position-relative mx-auto" style="max-width: 900px; padding: 30px 0;">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1000"
                 class="img-fluid rounded-2xl shadow-2xl main-workspace-img"
                 alt="Creative Workspace">
            <div class="floating-badge badge-top-left hover-pulse">
                <div class="d-flex align-items-center">
                    <div class="feature-icon-box"><i class="fas fa-bolt text-warning"></i></div>
                    <div class="text-left">
                        <span class="font-bold d-block text-dark">24/7 Power</span>
                        <small class="text-muted">Solar Backup</small>
                    </div>
                </div>
            </div>
            <div class="floating-badge badge-top-right hover-pulse">
                <div class="d-flex align-items-center">
                    <div class="feature-icon-box"><i class="fas fa-wifi text-primary"></i></div>
                    <div class="text-left">
                        <span class="font-bold d-block text-dark">Ultra Fiber</span>
                        <small class="text-muted">High Speed</small>
                    </div>
                </div>
            </div>
            <div class="floating-badge hover-pulse" style="position: absolute; top: 45%; right: -30px;">
                <div class="d-flex align-items-center">
                    <div class="feature-icon-box"><i class="fas fa-snowflake text-info"></i></div>
                    <div class="text-left">
                        <span class="font-bold d-block text-dark">Full A/C</span>
                        <small class="text-muted">Climate Control</small>
                    </div>
                </div>
            </div>
            <div class="floating-badge hover-pulse" style="position: absolute; top: 45%; left: -30px;">
                <div class="d-flex align-items-center">
                    <div class="feature-icon-box"><i class="fas fa-praying-hands text-success"></i></div>
                    <div class="text-left">
                        <span class="font-bold d-block text-dark">Prayer Room</span>
                        <small class="text-muted">Quiet Space</small>
                    </div>
                </div>
            </div>
            <div class="floating-badge badge-bottom-right hover-pulse">
                <div class="d-flex align-items-center">
                    <div class="feature-icon-box"><i class="fas fa-moon text-indigo" style="color: #6610f2;"></i></div>
                    <div class="text-left">
                        <span class="font-bold d-block text-dark">Quiet Zones</span>
                        <small class="text-muted">Zero Noise</small>
                    </div>
                </div>
            </div>
            <div class="floating-badge badge-bottom-left hover-pulse">
                <div class="d-flex align-items-center">
                    <div class="feature-icon-box"><i class="fas fa-mug-hot" style="color: #6F4E37;"></i></div>
                    <div class="text-left">
                        <span class="font-bold d-block text-dark">Free Buffet</span>
                        <small class="text-muted">Coffee & Tea</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.services-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    });
</script>
@endsection
