<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f6ef">
    <meta name="description" content="Qlinic membantu kamu mengambil nomor antrean klinik dari rumah dan memantau giliran secara real-time. Gratis, tanpa install aplikasi.">
    <title>Qlinic — Antre dari rumah, datang tepat waktu</title>
    <link rel="canonical" href="{{ route('landing') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..600;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/qlinic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <script src="{{ asset('js/landing.js') }}" defer></script>
</head>
<body class="landing-body">
    <a class="landing-skip-link" href="#main">Langsung ke konten utama</a>

    <header class="landing-header">
        <div class="container landing-nav">
            <a href="{{ route('landing') }}" class="brand" aria-label="Qlinic, kembali ke beranda">
                <img src="{{ asset('img/logo.png') }}" alt="" class="brand__logo" width="46" height="46">
                <span>Qlinic<span class="brand__dot">.</span></span>
            </a>

            <nav class="landing-nav__links" aria-label="Navigasi utama">
                <a class="landing-nav__anchor" href="#cara-kerja">Cara kerja</a>
                <a class="landing-nav__login" href="{{ route('login') }}">Masuk</a>
                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
            </nav>
        </div>
    </header>

    <main id="main">
        <section class="hero container" aria-labelledby="hero-title">
            <div class="hero__copy">
                <p class="eyebrow hero-enter"><span class="eyebrow__line"></span> Antrean klinik, lebih sederhana</p>
                <h1 id="hero-title" class="hero__title hero-enter">
                    Antre dari rumah.<br>
                    <em>Datang tepat waktu.</em>
                </h1>
                <p class="hero__lead hero-enter">
                    Ambil nomor antrean lewat HP dan pantau giliranmu tanpa perlu menunggu lama di klinik.
                </p>
                <div class="hero__actions hero-enter">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Ambil nomor antrean <span aria-hidden="true">↗</span>
                    </a>
                    <a href="{{ route('queue.display') }}" class="landing-text-link">Lihat layar antrean</a>
                </div>
                <p class="hero__note hero-enter"><span aria-hidden="true"></span> Gratis · Tanpa install aplikasi</p>
            </div>

            <div class="hero__visual hero-enter">
                <figure class="ticket-demo" aria-labelledby="ticket-caption">
                    <figcaption id="ticket-caption" class="ticket-demo__caption">
                        <span>Ilustrasi antrean</span>
                        <span class="ticket-demo__badge">Dari HP kamu</span>
                    </figcaption>
                    <div class="ticket-demo__number">UMM-012</div>
                    <p class="ticket-demo__service">Poli Umum</p>
                    <div class="ticket-demo__divider" aria-hidden="true"></div>
                    <div class="ticket-demo__status">
                        <span class="ticket-demo__status-label"><i aria-hidden="true"></i> Menunggu panggilan</span>
                        <span>Status antrean</span>
                    </div>
                    <div class="ticket-demo__progress" role="img" aria-label="Ilustrasi progres antrean">
                        <span></span>
                    </div>
                    <p class="ticket-demo__hint">Pantau status dan giliranmu langsung dari dashboard.</p>
                </figure>
            </div>
        </section>

        <section id="cara-kerja" class="steps container" aria-labelledby="steps-title">
            <div class="steps__heading reveal">
                <p class="eyebrow">Semudah itu</p>
                <h2 id="steps-title" class="section-title">Tiga langkah, lalu lanjutkan harimu.</h2>
            </div>

            <div class="steps-list">
                <article class="step-row reveal">
                    <span class="step-row__number" aria-hidden="true">01</span>
                    <h3>Daftar</h3>
                    <p>Buat akun dalam beberapa saat, langsung dari browser.</p>
                </article>
                <article class="step-row reveal">
                    <span class="step-row__number" aria-hidden="true">02</span>
                    <h3>Pilih poli</h3>
                    <p>Pilih layanan yang kamu butuhkan dan ambil nomornya.</p>
                </article>
                <article class="step-row reveal">
                    <span class="step-row__number" aria-hidden="true">03</span>
                    <h3>Pantau giliran</h3>
                    <p>Cek status antrean dari HP, di mana pun kamu berada.</p>
                </article>
            </div>

            <div class="service-links reveal" aria-label="Pilihan layanan klinik">
                <span class="service-links__label">Tersedia untuk</span>
                <div class="service-links__items">
                    <a href="{{ route('register') }}" aria-label="Daftar ke Poli Umum">Poli Umum <span aria-hidden="true">↗</span></a>
                    <a href="{{ route('register') }}" aria-label="Daftar ke Poli Gigi">Poli Gigi <span aria-hidden="true">↗</span></a>
                </div>
            </div>
        </section>

        <section class="closing container reveal" aria-labelledby="closing-title">
            <div>
                <p class="eyebrow">Satu hal yang tidak perlu dikhawatirkan</p>
                <h2 id="closing-title" class="section-title">Lebih tenang sebelum giliranmu.</h2>
            </div>
            <div class="closing__actions">
                <a href="{{ route('register') }}" class="btn btn-primary">Mulai sekarang <span aria-hidden="true">↗</span></a>
                <a href="{{ route('login') }}" class="landing-text-link">Sudah punya akun?</a>
            </div>
        </section>
    </main>

    <footer class="landing-footer">
        <div class="container landing-footer__inner">
            <a href="{{ route('landing') }}" class="landing-footer__brand">Qlinic<span class="brand__dot">.</span></a>
            <p>Antre lebih nyaman, tanpa aplikasi tambahan.</p>
            <a href="{{ route('queue.display') }}" class="landing-text-link">Layar antrean</a>
        </div>
    </footer>
</body>
</html>
