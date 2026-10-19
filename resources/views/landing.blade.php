<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a3b2c">
    <title>Qlinic — Antrean Klinik Tanpa Menunggu Lama</title>
    <meta name="description" content="Ambil nomor antrean klinik dari rumah, pantau panggilan real-time, dan datang tepat saat giliran. Gratis, cukup NIK 16 digit.">
    <meta property="og:title" content="Qlinic — Antrean Klinik Tanpa Menunggu Lama">
    <meta property="og:description" content="Ambil nomor antrean dari rumah dan datang tepat saat giliran Anda tiba.">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..600;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/qlinic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <script>document.documentElement.classList.add("js");</script>
</head>
<body class="landing-body">
    <a class="skip-link" href="#main">Lewati ke konten</a>

    <header class="landing-nav" id="nav">
        <div class="container landing-nav__inner">
            <a class="brand" href="{{ route('landing') }}">
                <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                Qlinic
            </a>

            <nav class="landing-nav__links" aria-label="Navigasi utama">
                <a href="#cara-kerja">Cara kerja</a>
                <a href="#layanan">Layanan</a>
                <a href="#layar">Layar TV</a>
                <a href="#faq">FAQ</a>
            </nav>

            <div class="landing-nav__actions">
                <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Masuk</a>
                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="hero">
            <div class="container hero__grid">
                <div class="hero__copy">
                    <span class="eyebrow">Antrean klinik, tanpa antre panjang</span>
                    <h1 class="hero__title">Antre dari rumah.<br>Datang <em>tepat waktu.</em></h1>
                    <p class="hero__lead">
                        Ambil nomor antrean klinik dari rumah, pantau panggilan secara real-time,
                        dan berangkat saat giliran Anda benar-benar mendekat.
                    </p>

                    <div class="hero__actions">
                        <a class="btn btn-primary btn-lg" href="{{ route('register') }}">
                            Ambil nomor antrean
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a class="btn btn-outline btn-lg" href="{{ route('queue.display') }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                            Lihat layar antrean
                        </a>
                    </div>

                    <div class="hero__trust">
                        <span class="hero__trust-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            Gratis
                        </span>
                        <span class="hero__trust-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h4M7 13h7"/><circle cx="17" cy="10" r="1.4"/></svg>
                            Cukup NIK 16 digit
                        </span>
                        <span class="hero__trust-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="2.5" width="12" height="19" rx="2.5"/><path d="M10 18.5h4"/></svg>
                            Tanpa install aplikasi
                        </span>
                    </div>
                </div>

                <div class="hero__visual" aria-label="Ilustrasi tiket antrean Qlinic">
                    <span class="hero__chip">Live · 2 poli</span>

                    <div class="hero__arch"></div>

                    <svg class="hero__plant" viewBox="0 0 240 240" fill="none" aria-hidden="true">
                        <path d="M118 224V104" stroke-width="2" stroke-linecap="round"/>
                        <path d="M118 178c-30-4-54-25-60-56 32-1 56 20 60 56Z" fill="rgba(10,59,44,.13)" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M118 148c28-2 50-20 56-48-29-2-51 18-56 48Z" fill="rgba(10,59,44,.09)" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M118 118c-22-5-39-20-44-43 24 0 41 17 44 43Z" fill="rgba(10,59,44,.16)" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M118 94c19-2 34-15 38-34-20 0-35 13-38 34Z" fill="rgba(10,59,44,.08)" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M74 224h88" stroke-width="2" stroke-linecap="round"/>
                    </svg>

                    <div class="ticket-demo">
                        <div class="ticket-demo__label">
                            <span>Nomor antrean</span>
                            <strong>Hari ini</strong>
                        </div>
                        <div class="ticket-demo__number">UMM-012</div>
                        <div class="ticket-demo__meta">
                            <strong>Poli Umum</strong>
                            <span>± 8 menit lagi</span>
                        </div>
                        <div class="ticket-demo__dash"></div>
                        <div class="ticket-demo__foot">
                            <span>Status</span>
                            <strong>Menunggu panggilan</strong>
                        </div>
                    </div>

                    <div class="hero__mini">
                        <div class="hero__mini-top">
                            <span>Poli Gigi</span>
                            <span>Sedang dipanggil</span>
                        </div>
                        <div class="hero__mini-number">GIG-004</div>
                        <div class="hero__mini-note">Silakan menuju ruang poli</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section--after-hero" id="cara-kerja">
            <div class="container steps-layout">
                <div class="steps-intro reveal">
                    <span class="eyebrow">Cara kerja</span>
                    <h2 class="section-title" style="margin-top: 0.85rem;">Tiga langkah,<br><em>selesai.</em></h2>
                    <p>Tanpa aplikasi tambahan, tanpa antre di loket. Semua bisa diselesaikan dalam hitungan menit.</p>
                    <a class="btn btn-outline" href="{{ route('register') }}">Mulai daftar</a>
                </div>

                <div class="steps-list">
                    <div class="step-row reveal">
                        <span class="step-row__num">01</span>
                        <div>
                            <h3>Daftar sekali</h3>
                            <p>Isi nama, NIK 16 digit, email, dan password. Akun langsung aktif dan bisa dipakai untuk kunjungan berikutnya.</p>
                            <span class="step-row__tag">± 1 menit</span>
                        </div>
                    </div>
                    <div class="step-row reveal">
                        <span class="step-row__num">02</span>
                        <div>
                            <h3>Ambil nomor poli</h3>
                            <p>Pilih Poli Umum atau Poli Gigi. Nomor antrean langsung terbit dengan estimasi waktu tunggu.</p>
                            <span class="step-row__tag">Langsung terbit</span>
                        </div>
                    </div>
                    <div class="step-row reveal">
                        <span class="step-row__num">03</span>
                        <div>
                            <h3>Datang saat dipanggil</h3>
                            <p>Pantau layar antrean dari rumah. Berangkat saat nomor Anda mendekat, lalu tunjukkan tiket kepada petugas.</p>
                            <span class="step-row__tag">Real-time</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section--sand" id="layanan">
            <div class="container">
                <div class="section-head">
                    <span class="eyebrow">Layanan</span>
                    <h2 class="section-title" style="margin-top: 0.85rem;">Pilih poli,<br><em>ambil nomornya.</em></h2>
                    <p>Dua layanan inti klinik dengan alur antrean yang sama sederhananya.</p>
                </div>

                <div class="service-grid">
                    <a class="service-card service-card--feature reveal" href="{{ route('register') }}">
                        <div class="service-card__top">
                            <span class="service-card__code">UMM</span>
                            <span class="badge badge-live">Poli Umum</span>
                        </div>
                        <h3>Poli Umum</h3>
                        <p>Konsultasi keluhan umum, pemeriksaan awal, dan rujukan lanjutan untuk seluruh anggota keluarga.</p>
                        <span class="service-card__foot">
                            Ambil nomor poli umum
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </span>
                        <span class="service-card__watermark" aria-hidden="true">UMM</span>
                    </a>

                    <a class="service-card reveal" href="{{ route('register') }}">
                        <div class="service-card__top">
                            <span class="service-card__code">GIG</span>
                            <span class="badge badge-waiting">Poli Gigi</span>
                        </div>
                        <h3>Poli Gigi</h3>
                        <p>Pemeriksaan gigi, pembersihan, dan konsultasi perawatan untuk menjaga kesehatan mulut Anda.</p>
                        <span class="service-card__foot">
                            Ambil nomor poli gigi
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </span>
                        <span class="service-card__watermark" aria-hidden="true">GIG</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="showcase" id="layar">
            <div class="container showcase__grid">
                <div class="showcase__copy reveal">
                    <span class="eyebrow" style="color: #a7e8c6;">Layar antrean</span>
                    <h2 class="section-title" style="margin-top: 0.85rem;">Satu layar,<br><em>semua jelas.</em></h2>
                    <p>Layar TV di ruang tunggu menampilkan nomor yang sedang dipanggil untuk setiap poli, dengan animasi dan suara bel.</p>

                    <ul class="showcase__list">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            Nomor besar yang mudah dibaca dari jauh
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            Nama pasien disamarkan untuk menjaga privasi
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            Pembaruan otomatis setiap tiga detik
                        </li>
                    </ul>

                    <div class="showcase__actions">
                        <a class="btn btn-light" href="{{ route('queue.display') }}" target="_blank" rel="noopener">
                            Buka layar antrean
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg>
                        </a>
                    </div>
                </div>

                <div class="tv-mock reveal" aria-label="Pratinjau layar antrean">
                    <div class="tv-mock__bar">
                        <span class="tv-mock__brand">
                            <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt=""></span>
                            Layanan Informasi Qlinic
                        </span>
                        <span class="tv-mock__clock">09:42</span>
                    </div>
                    <div class="tv-mock__screen">
                        <div class="tv-card tv-card--calling">
                            <div class="tv-card__service">Poli Umum</div>
                            <div class="tv-card__number">UMM-012</div>
                            <div class="tv-card__name">Rani P.</div>
                            <span class="tv-card__state">Silakan masuk</span>
                        </div>
                        <div class="tv-card">
                            <div class="tv-card__service">Poli Gigi</div>
                            <div class="tv-card__number" style="color: rgba(247,243,233,.2);">&mdash;</div>
                            <div class="tv-card__name">Menunggu antrean</div>
                            <span class="tv-card__state tv-card__state--empty">Belum ada panggilan</span>
                        </div>
                    </div>
                    <div class="tv-mock__caption">
                        <span>Tampilan langsung</span>
                        <span>Diperbarui otomatis</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="faq">
            <div class="container faq-layout">
                <div class="faq-intro reveal">
                    <span class="eyebrow">Pertanyaan umum</span>
                    <h2 class="section-title" style="margin-top: 0.85rem;">Hal yang sering<br><em>ditanyakan.</em></h2>
                    <p>Belum menemukan jawaban? Hubungi petugas klinik saat Anda datang.</p>
                    <a href="{{ route('login') }}">Sudah punya akun? Masuk →</a>
                </div>

                <div class="faq-list reveal">
                    <details class="faq-item" open>
                        <summary>Apakah saya harus punya akun untuk mengambil antrean?<span class="faq-item__icon" aria-hidden="true"></span></summary>
                        <div class="faq-item__body">Ya. Akun diperlukan agar tiket terhubung dengan identitas Anda dan bisa dipantau dari perangkat mana pun. Pendaftaran gratis dan hanya membutuhkan NIK 16 digit.</div>
                    </details>
                    <details class="faq-item">
                        <summary>Berapa banyak tiket yang bisa saya ambil?<span class="faq-item__icon" aria-hidden="true"></span></summary>
                        <div class="faq-item__body">Anda dapat memiliki satu tiket aktif per poli dalam satu hari. Setelah tiket selesai atau dilewati, Anda dapat mengambil tiket baru jika masih diperlukan.</div>
                    </details>
                    <details class="faq-item">
                        <summary>Bagaimana cara tahu giliran saya sudah dekat?<span class="faq-item__icon" aria-hidden="true"></span></summary>
                        <div class="faq-item__body">Halaman dashboard menampilkan estimasi waktu dan jumlah antrean di depan Anda. Layar TV di klinik juga menampilkan nomor yang sedang dipanggil beserta suara bel.</div>
                    </details>
                    <details class="faq-item">
                        <summary>Apakah bisa mengambil antrean tanpa smartphone?<span class="faq-item__icon" aria-hidden="true"></span></summary>
                        <div class="faq-item__body">Bisa. Mintalah bantuan petugas pendaftaran di klinik untuk mengambil nomor atas nama Anda. Tiket tetap tercatat di sistem.</div>
                    </details>
                </div>
            </div>
        </section>

        <section class="cta-band">
            <div class="container">
                <div class="cta-card reveal">
                    <div>
                        <h2>Siap ambil nomor<br><em>pertama Anda?</em></h2>
                        <p>Gratis. Cukup NIK 16 digit. Selesai dalam semenit.</p>
                    </div>
                    <div class="cta-card__actions">
                        <a class="btn btn-light btn-lg" href="{{ route('register') }}">
                            Daftar sekarang
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <span class="text-sm">Sudah punya akun? <a href="{{ route('login') }}" style="color: #d9f5e5; font-weight: 700; text-decoration: none;">Masuk</a></span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="landing-footer">
        <div class="container">
            <div class="landing-footer__grid">
                <div class="landing-footer__brand">
                    <a class="brand" href="{{ route('landing') }}">
                        <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                        Qlinic
                    </a>
                    <p>Sistem antrean klinik yang membuat kunjungan terasa lebih tenang.</p>
                </div>

                <div class="landing-footer__links">
                    <div class="landing-footer__col">
                        <strong>Produk</strong>
                        <a href="#cara-kerja">Cara kerja</a>
                        <a href="#layanan">Layanan</a>
                        <a href="{{ route('queue.display') }}">Layar antrean</a>
                    </div>
                    <div class="landing-footer__col">
                        <strong>Akun</strong>
                        <a href="{{ route('login') }}">Masuk</a>
                        <a href="{{ route('register') }}">Daftar pasien</a>
                        <a href="#faq">FAQ</a>
                    </div>
                </div>
            </div>

            <div class="landing-footer__bottom">
                <span>&copy; {{ date('Y') }} Qlinic. Sistem antrean klinik.</span>
                <span>Dibuat untuk kunjungan yang lebih tenang.</span>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var nav = document.getElementById("nav");
            var onScroll = function () {
                nav.classList.toggle("is-scrolled", window.scrollY > 10);
            };
            window.addEventListener("scroll", onScroll, { passive: true });
            onScroll();

            var items = document.querySelectorAll(".reveal");
            if (window.matchMedia("(prefers-reduced-motion: reduce)").matches || !("IntersectionObserver" in window)) {
                items.forEach(function (item) { item.classList.add("in"); });
                return;
            }

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add("in");
                    observer.unobserve(entry.target);
                });
            }, { threshold: 0.12 });

            items.forEach(function (item) { observer.observe(item); });
        })();
    </script>
</body>
</html>
