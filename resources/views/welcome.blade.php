<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Event Space Booking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('/images/hero-bg.jpg') no-repeat center center/cover;
            height: 100vh;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .features-section {
            padding: 50px 0;
        }
        .features-icon {
            font-size: 3rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4">Welcome to Event Space Booking</h1>
            <p class="lead">Easily book your ideal event space anytime, anywhere.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Get Started</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Sign Up</a>
        </div>
    </div>

    <div class="features-section bg-light">
        <div class="container text-center">
            <h2 class="mb-5">Why Choose Us?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-4 border-0">
                        <div class="features-icon mb-3">
                            <i class="bi bi-building"></i>
                        </div>
                        <h5 class="card-title">Wide Range of Spaces</h5>
                        <p class="card-text">From conference rooms to studios, find the perfect venue for your event.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-0">
                        <div class="features-icon mb-3">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h5 class="card-title">Easy Scheduling</h5>
                        <p class="card-text">Use our intuitive calendar to schedule and manage your bookings.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-0">
                        <div class="features-icon mb-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="card-title">Secure and Reliable</h5>
                        <p class="card-text">Your data is protected with top-notch security measures.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4 bg-dark text-light text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} Event Space Booking. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
