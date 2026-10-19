<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#071a13">
    <title>Layar Antrean — Qlinic</title>
    <meta name="description" content="Layar informasi nomor antrean klinik Qlinic.">
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..600;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/qlinic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/display.css') }}">
</head>
<body class="tv-body">
    <div class="tv-shell">
        <header class="tv-header">
            <div class="tv-brand">
                <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                <div class="tv-brand__text">
                    <span class="tv-brand__name">Qlinic</span>
                    <span class="tv-brand__sub">Layanan Informasi Antrean</span>
                </div>
            </div>

            <div class="tv-clock">
                <span class="tv-clock__status" id="connection-status" role="status">Live</span>
                <div>
                    <div class="tv-clock__time" id="clock">--:--:--</div>
                    <div class="tv-clock__date" id="date">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</div>
                </div>
            </div>
        </header>

        <main class="tv-main" id="display-container">
            <article class="tv-card" aria-label="Memuat antrean">
                <div class="tv-card__head">
                    <div class="tv-card__service">
                        <span class="tv-card__code">…</span>
                        <span class="tv-card__name">Memuat antrean</span>
                    </div>
                </div>
                <div class="tv-card__body">
                    <span class="tv-card__label">Mohon tunggu</span>
                    <div class="tv-card__number is-empty">—</div>
                    <span class="tv-card__patient is-empty">Menyiapkan layar informasi</span>
                </div>
            </article>
        </main>

        <footer class="tv-footer">
            <span class="tv-footer__tip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H3v6h3l5 4V5Z"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/><path d="M18.5 5.5a9 9 0 0 1 0 13"/></svg>
                Mohon perhatikan nomor antrean dan nama yang dipanggil.
            </span>
            <span class="tv-footer__brand">Qlinic · Antrean Klinik</span>
        </footer>
    </div>

    <p class="sr-only" id="live-announcer" aria-live="assertive"></p>

    <noscript>
        <div style="position: fixed; inset: auto 16px 16px; padding: 16px; border-radius: 12px; background: #f7f3e9; color: #12211b; font-family: sans-serif; text-align: center;">
            Aktifkan JavaScript untuk menampilkan antrean secara langsung.
        </div>
    </noscript>

    <script>
        (function () {
            "use strict";

            var endpoint = @json(route('queue.api.status'));
            var container = document.getElementById("display-container");
            var clock = document.getElementById("clock");
            var dateLabel = document.getElementById("date");
            var statusBadge = document.getElementById("connection-status");
            var announcer = document.getElementById("live-announcer");
            var previousCalls = {};

            function tickClock() {
                var now = new Date();
                clock.textContent = now.toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit",
                    hour12: false,
                    timeZone: "Asia/Jakarta"
                });
                dateLabel.textContent = now.toLocaleDateString("id-ID", {
                    weekday: "long",
                    day: "numeric",
                    month: "long",
                    year: "numeric",
                    timeZone: "Asia/Jakarta"
                });
            }

            setInterval(tickClock, 1000);
            tickClock();

            function maskName(name) {
                if (!name) return "Pasien";
                var parts = name.trim().split(/\s+/);
                if (parts.length === 1) return parts[0];
                return parts[0] + " " + parts[parts.length - 1].charAt(0).toUpperCase() + ".";
            }

            function make(tag, className, text) {
                var element = document.createElement(tag);
                if (className) element.className = className;
                if (text !== undefined && text !== null) element.textContent = text;
                return element;
            }

            var audioContext = null;

            function initAudio() {
                if (!audioContext) {
                    var AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (AudioCtx) audioContext = new AudioCtx();
                }
                if (audioContext && audioContext.state === "suspended") {
                    audioContext.resume();
                }
            }

            document.addEventListener("click", initAudio, { once: true });
            document.addEventListener("touchstart", initAudio, { once: true, passive: true });

            function playChime() {
                if (!audioContext || audioContext.state !== "running") return;

                var now = audioContext.currentTime;
                [880, 1174.66].forEach(function (frequency, index) {
                    var oscillator = audioContext.createOscillator();
                    var gain = audioContext.createGain();
                    var start = now + index * 0.18;

                    oscillator.type = "sine";
                    oscillator.frequency.value = frequency;
                    gain.gain.setValueAtTime(0.0001, start);
                    gain.gain.exponentialRampToValueAtTime(0.18, start + 0.03);
                    gain.gain.exponentialRampToValueAtTime(0.0001, start + 0.55);

                    oscillator.connect(gain);
                    gain.connect(audioContext.destination);
                    oscillator.start(start);
                    oscillator.stop(start + 0.6);
                });
            }

            function buildCard(service, queue, shouldFlash) {
                var card = make("article", "tv-card" + (queue ? " is-calling" : ""));
                card.setAttribute("aria-label", service.name + (queue ? " memanggil " + queue.queue_number : " belum memanggil"));

                var head = make("div", "tv-card__head");
                var serviceWrap = make("div", "tv-card__service");
                serviceWrap.appendChild(make("span", "tv-card__code", service.code || ""));
                serviceWrap.appendChild(make("span", "tv-card__name", service.name || "Poli"));

                var badge = make(
                    "span",
                    "tv-card__badge" + (queue ? "" : " is-idle"),
                    queue ? "Sedang dipanggil" : "Menunggu"
                );

                head.appendChild(serviceWrap);
                head.appendChild(badge);

                var body = make("div", "tv-card__body");
                body.appendChild(make("span", "tv-card__label", queue ? "Nomor antrean" : "Belum ada panggilan"));

                var number = make("div", "tv-card__number" + (queue ? "" : " is-empty"), queue ? queue.queue_number : "—");
                body.appendChild(number);

                body.appendChild(
                    make(
                        "span",
                        "tv-card__patient" + (queue ? "" : " is-empty"),
                        queue ? maskName(queue.user && queue.user.name) : "Menunggu antrean berikutnya"
                    )
                );

                if (queue) {
                    body.appendChild(make("span", "tv-card__cta", "Silakan masuk poli"));
                } else {
                    body.appendChild(make("span", "tv-card__cta is-idle", "Terima kasih atas kesabaran Anda"));
                }

                card.appendChild(head);
                card.appendChild(body);

                if (shouldFlash) {
                    card.classList.add("is-flashing");
                }

                return card;
            }

            function render(services) {
                var fragment = document.createDocumentFragment();
                var announcements = [];
                var playBell = false;

                services.forEach(function (service) {
                    var queue = service.queues && service.queues.length ? service.queues[0] : null;
                    var previousNumber = previousCalls[service.id];
                    var currentNumber = queue ? queue.queue_number : null;
                    var shouldFlash = previousNumber !== undefined && previousNumber !== currentNumber && currentNumber !== null;

                    if (shouldFlash) {
                        playBell = true;
                        announcements.push(service.name + " memanggil nomor " + currentNumber);
                    }

                    previousCalls[service.id] = currentNumber;
                    fragment.appendChild(buildCard(service, queue, shouldFlash));
                });

                if (!services.length) {
                    var empty = make("article", "tv-card");
                    var head = make("div", "tv-card__head");
                    var wrap = make("div", "tv-card__service");
                    wrap.appendChild(make("span", "tv-card__code", "--"));
                    wrap.appendChild(make("span", "tv-card__name", "Belum ada layanan"));
                    head.appendChild(wrap);
                    var body = make("div", "tv-card__body");
                    body.appendChild(make("span", "tv-card__label", "Informasi"));
                    body.appendChild(make("div", "tv-card__number is-empty", "—"));
                    body.appendChild(make("span", "tv-card__patient is-empty", "Layanan klinik belum dibuka"));
                    empty.appendChild(head);
                    empty.appendChild(body);
                    fragment.appendChild(empty);
                }

                container.replaceChildren(fragment);

                if (announcements.length) {
                    announcer.textContent = announcements.join(". ");
                }

                if (playBell) {
                    playChime();
                }
            }

            function setConnection(online) {
                statusBadge.textContent = online ? "Live" : "Offline";
                statusBadge.classList.toggle("is-offline", !online);
            }

            var isLoading = false;

            function fetchLiveStatus() {
                if (isLoading) return;
                isLoading = true;

                fetch(endpoint, {
                    headers: { "Accept": "application/json" },
                    cache: "no-store"
                })
                    .then(function (response) {
                        if (!response.ok) throw new Error("HTTP " + response.status);
                        return response.json();
                    })
                    .then(function (services) {
                        setConnection(true);
                        render(Array.isArray(services) ? services : []);
                    })
                    .catch(function () {
                        setConnection(false);
                    })
                    .finally(function () {
                        isLoading = false;
                    });
            }

            fetchLiveStatus();
            setInterval(fetchLiveStatus, 3000);
        })();
    </script>
</body>
</html>
