<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f2e9">
    <meta name="description" content="Qlinic membantu kamu mengambil nomor antrean klinik dari rumah dan memantau giliran secara real-time. Gratis, tanpa install aplikasi.">
    <title>Qlinic — Antre dari rumah, datang tepat waktu</title>
    <link rel="canonical" href="{{ route('landing') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
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
                <img src="{{ asset('logo.png') }}" alt="" class="brand__logo" width="42" height="42">
                <span>Qlinic<span class="brand__dot">.</span></span>
            </a>

            <nav class="landing-nav__links" aria-label="Navigasi utama">
                <a class="landing-nav__login" href="{{ route('login') }}">Masuk</a>
                <a class="landing-nav__register" href="{{ route('register') }}">Daftar <span aria-hidden="true">↗</span></a>
            </nav>
        </div>
    </header>

    <main id="main">
        <section class="hero container" aria-labelledby="hero-title">
            <div class="hero__stage">
                <div class="hero__copy">
                    <p class="eyebrow hero-enter"><span class="eyebrow__line"></span> Antrean klinik, lebih sederhana</p>
                    <h1 id="hero-title" class="hero__title hero-enter">
                        Antre dari rumah.
                        <em>Datang tepat waktu.</em>
                    </h1>
                    <p class="hero__lead hero-enter">
                        Ambil nomor antrean lewat HP dan pantau giliranmu. Sampai di klinik saat kamu memang perlu di sana.
                    </p>
                    <div class="hero__actions hero-enter">
                        <a href="{{ route('register') }}" class="hero__cta">
                            <span>Ambil nomor antrean</span>
                            <span class="hero__cta-arrow" aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('queue.display') }}" class="landing-text-link">Lihat layar antrean <span aria-hidden="true">→</span></a>
                    </div>
                    <p class="hero__note hero-enter"><span aria-hidden="true">✓</span> Gratis <b>·</b> Tanpa install aplikasi</p>
                </div>

                <div class="hero__visual hero-enter">
                    <div class="ticket-object">
                        <figure class="ticket-demo" aria-labelledby="ticket-caption">
                            <figcaption id="ticket-caption" class="ticket-demo__caption">
                                <span>Ilustrasi antrean</span>
                                <span class="ticket-demo__badge">Dari HP kamu</span>
                            </figcaption>
                            <div class="ticket-demo__meta">
                                <span>Poli Umum</span>
                                <span>UMM-012</span>
                            </div>
                            <p class="ticket-demo__label">Nomor antrean</p>
                            <div class="ticket-demo__number">012</div>
                            <p class="ticket-demo__status"><i aria-hidden="true"></i> Menunggu panggilan</p>
                            <div class="ticket-demo__perforation" aria-hidden="true"></div>
                            <div class="ticket-demo__footer">
                                <p class="ticket-demo__hint">Pantau giliran langsung dari dashboard. Tidak perlu menebak di ruang tunggu.</p>
                                <span class="ticket-demo__monogram" aria-hidden="true">Q.</span>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

        <section id="cara-kerja" class="journey container" aria-labelledby="steps-title">
            <div class="journey__heading">
                <div>
                    <p class="eyebrow"><span class="eyebrow__line"></span> Cara kerja</p>
                    <h2 id="steps-title" class="section-title">Tiga langkah, lalu<br>lanjutkan harimu.</h2>
                </div>
            </div>

            <div class="steps-list">
                <article class="step-row">
                    <span class="step-row__number" aria-hidden="true">01</span>
                    <div>
                        <h3>Daftar</h3>
                        <p>Buat akun dalam beberapa saat, langsung dari browser.</p>
                    </div>
                </article>
                <article class="step-row">
                    <span class="step-row__number" aria-hidden="true">02</span>
                    <div>
                        <h3>Pilih poli</h3>
                        <p>Pilih layanan yang kamu butuhkan dan ambil nomornya.</p>
                    </div>
                </article>
                <article class="step-row">
                    <span class="step-row__number" aria-hidden="true">03</span>
                    <div>
                        <h3>Pantau giliran</h3>
                        <p>Cek status antrean dari HP, di mana pun kamu berada.</p>
                    </div>
                </article>
            </div>
        </section>

        <section class="closing container reveal" aria-labelledby="closing-title">
            <div class="closing__inner">
                <div>
                    <p class="eyebrow"><span class="eyebrow__line"></span> Lebih sedikit menunggu</p>
                    <h2 id="closing-title" class="section-title">Waktumu tetap<br><em>milikmu.</em></h2>
                </div>
                <div class="closing__actions">
                    <div class="queue-buddy" role="img" aria-label="Maskot Qlinic tersenyum sambil memegang tiket antrean">
                        <span class="queue-buddy__bubble">Sampai jumpa di giliranmu!</span>
                        <svg class="queue-buddy__art" viewBox="0 0 320 190" aria-hidden="true" focusable="false">
                            <ellipse cx="162" cy="173" rx="75" ry="8" fill="#163e27" opacity=".13"/>
                            <g class="queue-buddy__character" stroke="#163e27" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M139 140v20m32-20v20" fill="none" stroke-width="7"/>
                                <path d="M126 165h17m23 0h17" fill="none" stroke-width="9"/>
                                <path d="M106 49 95 35m97 14 12-14" fill="none" stroke-width="7"/>
                                <path d="m96 33-8-3m8 3-2-9m109 12 7-5m-7 5 1-10" fill="none" stroke-width="4"/>
                                <path d="M111 53c-16 8-23 22-24 38m106-38c17 8 23 21 22 36" fill="none" stroke-width="8"/>
                                <g class="queue-buddy__wave">
                                    <path d="m87 88-13-10" fill="none" stroke-width="8"/>
                                    <circle cx="70" cy="74" r="8" fill="#fff7e7" stroke-width="4"/>
                                    <path d="m66 68-3-8m9 8 2-10m3 13 7-6" fill="none" stroke-width="3"/>
                                </g>
                                <rect x="111" y="48" width="82" height="100" rx="20" fill="#fff7e7" stroke-width="4"/>
                                <path d="M116 51c16 10 46 10 72-2" fill="none" stroke-width="3" opacity=".18"/>
                                <path d="M127 76v5m38-5v5" class="queue-buddy__eyes" fill="none" stroke-width="6"/>
                                <path d="M141 91c7 7 15 7 22 0" fill="none" stroke-width="3"/>
                                <circle cx="121" cy="91" r="5" fill="#e8a18a" stroke="none" opacity=".6"/>
                                <circle cx="176" cy="91" r="5" fill="#e8a18a" stroke="none" opacity=".6"/>
                                <path d="M107 113c16-2 26 5 34 13m71-14c-14-2-26 4-34 13" fill="none" stroke-width="7"/>
                                <g transform="rotate(-7 152 129)">
                                    <path d="M126 111h52v13l-4 4 4 4v17h-52v-17l4-4-4-4z" fill="#d5ee8d" stroke-width="3"/>
                                    <path d="M138 112v36" fill="none" stroke-width="1.5" stroke-dasharray="3 3" opacity=".6"/>
                                    <text x="158" y="132" fill="#163e27" stroke="none" font-family="Georgia,serif" font-size="16" font-weight="700" text-anchor="middle">012</text>
                                </g>
                            </g>
                            <path d="m47 98-6 4m17-25-1-8m27-4 6-6m140 30 6 5m-6-25 5-7" fill="none" stroke="#163e27" stroke-linecap="round" stroke-width="3" opacity=".45"/>
                        </svg>
                    </div>
                    <a href="{{ route('register') }}" class="closing__cta">Ambil nomor antrean <span aria-hidden="true">↗</span></a>
                </div>
            </div>
        </section>
    </main>

    <footer class="landing-footer">
        <div class="container landing-footer__inner">
            <p>© {{ date('Y') }} Qlinic. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
