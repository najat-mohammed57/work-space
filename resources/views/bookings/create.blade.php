@extends('layouts.guest')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

<style>

    .booking-hero {
        background: linear-gradient(135deg, #0061ff 0%, #0045b5 50%, #003080 100%);
        position: relative;
        overflow: hidden;
        min-height: 400px;
        display: flex;
        align-items: center;
        color: white;
        padding: 60px 0;
        margin-bottom: -50px;
    }


    .hero-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        z-index: 1;
    }
    .shape-1 { width: 300px; height: 300px; top: -100px; right: -50px; animation: float 6s ease-in-out infinite; }
    .shape-2 { width: 200px; height: 200px; bottom: -50px; left: -50px; background: rgba(255,255,255,0.05); animation: float 8s ease-in-out infinite reverse; }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
    }

    .booking-hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        font-size: clamp(2.5rem, 6vw, 3.8rem);
        font-weight: 800;
        letter-spacing: -1.5px;
        margin-bottom: 15px;
        background: linear-gradient(to bottom, #ffffff 60%, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        animation: slideInDown 1s ease-out;
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.3rem);
        font-weight: 300;
        opacity: 0.95;
        margin-bottom: 25px;
        letter-spacing: 0.5px;
        animation: fadeInUp 1.2s ease-out;
    }

    .booking-card {
        border: none;
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
        border-radius: 30px;
        overflow: hidden;
        background: #ffffff;
        position: relative;
        z-index: 5;
        animation: slideInUpCard 1s ease-out 0.3s both;
    }

    .rounded-15 { border-radius: 15px !important; }


    .gradient-btn {
        background: linear-gradient(135deg, #0061ff 0%, #0045b5 100%) !important;
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: white !important;
        outline: none !important;
    }

    .gradient-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 20%;
        height: 200%;
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(30deg);
        animation: shine-effect 3s infinite;
    }

    @keyframes shine-effect {
        0% { left: -60%; }
        20% { left: 120%; }
        100% { left: 120%; }
    }

    .gradient-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,97,255,0.3);
        background: linear-gradient(135deg, #0072ff 0%, #0052d4 100%) !important;
    }

    .gradient-btn:active, .gradient-btn:focus {
        background: linear-gradient(135deg, #0045b5 0%, #003080 100%) !important;
        color: white !important;
        box-shadow: none !important;
        transform: translateY(-1px);
    }

    .form-control {
        transition: all 0.3s ease;
        border: 1px solid #eee !important;
        background: #f8faff !important;
    }

    .form-control:hover {
        transform: translateY(-2px);
        border-color: #0061ff !important;
        background: #fff !important;
    }

    .form-control:focus {
        background: #fff !important;
        box-shadow: 0 5px 15px rgba(0,97,255,0.1) !important;
        border-color: #0061ff !important;
        outline: none;
    }

    .back-link {
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        border-radius: 20px;
        background: rgba(0,0,0,0.03);
    }

    .back-link:hover {
        transform: translateX(-5px);
        color: #0061ff !important;
    }

    @keyframes slideInDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes fadeInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes slideInUpCard { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    .booking-form-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .booking-form-container .form-control::placeholder {
        color: #adb5bd !important;
        opacity: 0.6;
        font-weight: 400;
    }

    .rounded-15 {
        border-radius: 15px !important;
    }

    .extra-margin-bottom {
        margin-bottom: 40px !important;
    }
</style>

<div class="container-fluid py-0 px-0">
    <div class="booking-hero">
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center booking-hero-content">
                    <h1 class="hero-title">Confirm Your<br>Professional Workspace</h1>
                    <p class="hero-subtitle lead">Complete your details to secure your spot in Gaza's premier tech hub.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">
                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm border-0 mb-4 animate__animated animate__shakeX rounded-15">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card booking-card">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('bookings.store', $service->id) }}" method="POST">
                            @csrf

                            <div class="booking-form-container">
    <div class="mb-4">
        <label class="form-label fw-bold text-dark mb-2">
            <i class="bi bi-calendar-event text-primary me-2"></i>Pick Your Date
        </label>
        <input type="date" name="booking_date"
               class="form-control shadow-sm p-3 border-0 rounded-15"
               value="{{ old('booking_date') }}" min="{{ date('Y-m-d') }}" required>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <label class="form-label fw-bold text-dark mb-2">
                <i class="bi bi-clock text-primary me-2"></i>From
            </label>
            <input type="time" name="start_time"
                   class="form-control shadow-sm p-3 border-0 rounded-15"
                   value="{{ old('start_time') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-dark mb-2">
                <i class="bi bi-clock-fill text-primary me-2"></i>To
            </label>
            <input type="time" name="end_time"
                   class="form-control shadow-sm p-3 border-0 rounded-15"
                   value="{{ old('end_time') }}" required>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label fw-bold text-dark mb-2">
            <i class="fas fa-phone me-2 text-primary"></i>Phone Number
        </label>
        <input type="text" name="phone"
               class="form-control shadow-sm p-3 border-0 rounded-15 bg-light"
               placeholder="e.g., +970 599..." required>
    </div>


    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold text-dark mb-2">
                <i class="fas fa-building me-2 text-primary"></i>Company / University
            </label>
            <input type="text" name="company"
                   class="form-control shadow-sm p-3 border-0 rounded-15 bg-light"
                   placeholder="Where do you work/study?">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold text-dark mb-2">
                <i class="fas fa-briefcase me-2 text-primary"></i>Job Title
            </label>
            <input type="text" name="job_title"
                   class="form-control shadow-sm p-3 border-0 rounded-15 bg-light"
                   placeholder="e.g., Software Engineer">
        </div>
    </div>

    <div class="mb-5 extra-margin-bottom">
        <label class="form-label fw-bold text-dark mb-2">
            <i class="bi bi-chat-left-text text-primary me-2"></i>Any special requirements?
        </label>
        <textarea name="notes" class="form-control shadow-sm p-3 border-0 rounded-15"
                  rows="3" placeholder="(e.g., quiet zone, power outlet, air conditioning)...">{{ old('notes') }}</textarea>
    </div>
</div>
                            <div class="mt-5">
                                <div class="mb-3">
                                    <h5 class="fw-bold mb-0" style="color: #0061ff; font-size: 1.25rem;">{{ $service->name }}</h5>
                                    <p class="text-muted small">Ready for your productive session!</p>
                                </div>

                                <button type="submit" class="btn gradient-btn w-100 shadow-lg mb-0">
                                    <i class="bi bi-rocket-takeoff-fill me-2"></i>Secure Booking Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="{{ url()->previous() }}" class="back-link text-dark text-decoration-none fw-semibold small">
                        <i class="bi bi-chevron-left me-1"></i>Return to Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>
@endsection
