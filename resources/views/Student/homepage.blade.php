<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/Homepage.css') }}" rel="stylesheet">
    <title>Homepage</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar ">
            <img class="img-logo" src="{{ asset('image/Norton.png') }}" alt="Logo">
    </nav>
    <div class="slide_container">
        <div  class="text_content">
        <div class="caption">
            <h2>Norton University</h2>
            <p>Streamline your document management with our secure and user-friendly system. Organize, store, and access files with ease, all in one place. Say goodbye to clutter and hello to efficiency!</p>
        </div>
        </div>
    <div class="slider">
        <div class="slides">
            <img class="slide-img" src="{{ asset('image/slide2.png') }}" alt="Slide 1">
            <img class="slide-img" src="{{ asset('image/book.png') }}" alt="Slide 2">
            <img class="slide-img" src="{{ asset('image/slide3.png') }}" alt="Slide 3">
        </div>
    </div>
</div>
<div class="info_container" style="margin-top: 120px;">
    <div class="container-grid">
            <div class="image">
                <img class="image-at" src="/image/know.png" alt="About Image">
            </div>
            <div class="text_containt">
                <p>The Advatages Of reading</p>
                <ul style="margin-top: 20px;">
                    <li><span>01.Enhances Knowledge: </span>Reading expands your understanding of the world, improves vocabulary, and introduces new ideas.</li>
                    <li><span>02.Boosts Mental Stimulation:</span> Regular reading keeps the brain active, improves focus, and may reduce the risk of cognitive decline.</li>
                    <li><span>03.Improves Communication Skills:</span> Exposure to diverse writing styles and ideas helps develop better writing and speaking abilities.</li>
                </ul>
                <button onclick="window.location.href='{{ route('document') }}'">Documentation</button>
            </div>
    </div>
</div>
    <div class="contact_container">
        <h2 style="text-align: center; color: #0c7beb; font-size: 40px; margin-top: 20px;">Location</h2>
        <p>Keo Chenda St, Phnom Penh 12000</p>
        <a name="contact"></a>
        <iframe width="80%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.4884007138176!2d104.92760177934565!3d11.588487300000008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310953fd9f9a51e9%3A0xc26eafcd2ed5ca29!2sNorton%20University!5e0!3m2!1sen!2skh!4v1736494188217!5m2!1sen!2skh"></iframe>
    </div>
    <footer>
        <div class="info">
            <a><i class="fa-brands fa-telegram"></i></a>
            <a><i class="fa-brands fa-instagram"></i></a>
            <a><i class="fa-brands fa-facebook"></i></a>
            <a><i class="fa-brands fa-whatsapp"></i></a>
        </div>
        <p style="margin-top: 20px;">Copyright © Norton University</p>
    </footer>
    <script src="{{ asset('js/homepage.js') }}"></script>
</body>
</html>
