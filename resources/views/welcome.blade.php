<x-guest-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kek Gallery — Draw, Share, Deliver!</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(120deg, #f472b6 0%, #60a5fa 100%);
            height: 100vh;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .features-section {
            padding: 50px 0;
        }
        .features-icon {
            font-size: 3rem;
            color: #f472b6;
        }
        .brand-title {
            font-family: 'Comic Sans MS', 'Comic Sans', cursive;
            letter-spacing: 2px;
            color: #f472b6;
        }
        .btn-main {
            background: #f472b6;
            border: none;
        }
        .btn-main:hover {
            background: #ec4899;
        }
        .btn-outline-main {
            border: 2px solid #f472b6;
            color: #f472b6;
        }
        .btn-outline-main:hover {
            background: #f472b6;
            color: #fff;
        }
        .footer-bg {
            background: linear-gradient(90deg, #f472b6 0%, #60a5fa 100%);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bold brand-title mb-3">Kek Gallery</h1>
            <p class="lead mb-4">Draw, share, and send your creations by mail!<br>Create unique art on any item and order delivery right now.</p>
            <a href="{{ route('login') }}" class="btn btn-main btn-lg me-2 shadow">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-outline-main btn-lg shadow">Register</a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section bg-light" id="features">
        <div class="container text-center">
            <h2 class="mb-5 brand-title">What can Kek Gallery do?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <div class="features-icon mb-3">
                            <i class="bi bi-brush"></i>
                        </div>
                        <h5 class="card-title">Online Drawing</h5>
                        <p class="card-text">Create drawings right in your browser on any item from your collection.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <div class="features-icon mb-3">
                            <i class="bi bi-images"></i>
                        </div>
                        <h5 class="card-title">Gallery & Likes</h5>
                        <p class="card-text">Publish your works, like, comment, and get inspired by others' creativity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <div class="features-icon mb-3">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h5 class="card-title">Drawing Delivery</h5>
                        <p class="card-text">Order delivery of your drawing using a convenient parcel machine map.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container my-5" id="contact">
        <h2 class="text-center mb-4 brand-title">Contact Us</h2>
        <div class="text-center">
            <p>Email: <a href="mailto:support@kekgallery.com" class="text-pink-500">support@kekgallery.com</a></p>
            <p>Telegram: <a href="https://t.me/kekgallery" target="_blank" class="text-pink-500">@kekgallery</a></p>
            <p>Address: Kek Street 42, Art City</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 footer-bg text-light text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Kek Gallery. Draw, Share, Deliver!</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</x-guest-layout>