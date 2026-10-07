<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemanggilan Antrean - Qlinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #059669;
            --primary-light: #064E3B;
            --bg-dark: #0F172A;
            --card-dark: #1E293B;
            --white: #F8FAFC;
            --text-light: #94A3B8;
            --accent-glow: 0 0 20px rgba(5, 150, 105, 0.5);
            --border-light: rgba(255, 255, 255, 0.1);
        }

        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--white);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Ambient background glow */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(5, 150, 105, 0.15) 0%, transparent 60%);
            z-index: 0;
        }

        .header {
            position: relative;
            z-index: 10;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            padding: 24px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .header h1 span {
            background-color: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 24px;
        }

        .header .time {
            font-size: 28px;
            font-weight: 700;
            color: var(--white);
            font-variant-numeric: tabular-nums;
        }
        .header .date {
            font-size: 16px;
            color: var(--text-light);
            font-weight: 500;
            text-align: right;
        }

        .main-content {
            position: relative;
            z-index: 10;
            flex-grow: 1;
            padding: 40px 48px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            height: 100%;
        }

        .service-card {
            background: var(--card-dark);
            border-radius: 24px;
            border: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }

        .service-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 24px;
            text-align: center;
            border-bottom: 1px solid var(--border-light);
        }

        .service-header h2 {
            margin: 0;
            color: var(--white);
            font-size: 36px;
            font-weight: 800;
        }

        .service-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            background: radial-gradient(circle at center, rgba(30, 41, 59, 1) 0%, rgba(15, 23, 42, 1) 100%);
        }

        .queue-number {
            font-size: 120px;
            font-weight: 800;
            color: var(--white);
            line-height: 1;
            margin-bottom: 24px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
            letter-spacing: -2px;
        }

        .patient-name {
            font-size: 32px;
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 12px;
        }

        .status-badge {
            background-color: var(--primary);
            color: white;
            padding: 8px 24px;
            border-radius: 999px;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            box-shadow: var(--accent-glow);
        }
        
        .empty-state {
            color: var(--text-light);
            font-size: 36px;
            font-weight: 600;
            opacity: 0.5;
        }

        /* Called Flash Animation */
        @keyframes flash-solid {
            0% { background: var(--card-dark); border-color: var(--border-light); transform: scale(1); }
            5% { background: #064E3B; border-color: #10B981; transform: scale(1.02); box-shadow: 0 0 40px rgba(16, 185, 129, 0.5); }
            100% { background: var(--card-dark); border-color: var(--border-light); transform: scale(1); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        }
        
        @keyframes pulse-text {
            0% { transform: scale(1); color: var(--white); }
            5% { transform: scale(1.1); color: #34D399; }
            100% { transform: scale(1); color: var(--white); }
        }

        .flash-animation {
            animation: flash-solid 2.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .flash-animation .queue-number {
            animation: pulse-text 2.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1><img src="{{ asset('logo.png') }}" alt="Logo" style="height: 40px; width: auto; border-radius: 8px;"> Layanan Informasi Qlinic</h1>
        <div>
            <div class="time" id="clock">00:00:00</div>
            <div class="date">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
        </div>
    </div>

    <div class="main-content" id="display-container">
        <!-- Injected via Fetch API -->
    </div>

    <audio id="bell" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        let previousData = {};

        function fetchLiveStatus() {
            $.get("{{ route('queue.api.status') }}", function(services) {
                let html = '';
                let playBell = false;
                let flashedServices = [];

                services.forEach(service => {
                    const activeQueues = service.queues;
                    const queue = activeQueues.length > 0 ? activeQueues[0] : null;
                    
                    let contentHtml = '';
                    
                    if (queue) {
                        contentHtml = `
                            <div class="queue-number">${queue.queue_number}</div>
                            <div class="patient-name">${queue.user.name}</div>
                            <div class="status-badge">Silakan Masuk Poli</div>
                        `;

                        // Detect new queue number
                        if (previousData[service.id] !== queue.queue_number) {
                            if(previousData[service.id] !== undefined) {
                                playBell = true;
                                flashedServices.push(service.id);
                            }
                            previousData[service.id] = queue.queue_number;
                        }
                    } else {
                        contentHtml = `
                            <div class="empty-state">--</div>
                            <div style="color: var(--text-light); margin-top: 16px;">Menunggu Antrean Berikutnya</div>
                        `;
                        previousData[service.id] = null;
                    }

                    html += `
                        <div class="service-card" id="card-${service.id}">
                            <div class="service-header">
                                <h2>${service.name}</h2>
                            </div>
                            <div class="service-body">
                                ${contentHtml}
                            </div>
                        </div>
                    `;
                });

                document.getElementById('display-container').innerHTML = html;

                if (playBell) {
                    const bell = document.getElementById('bell');
                    bell.play().catch(e => console.log('Audio autoplay prevented:', e));
                    
                    flashedServices.forEach(id => {
                       const el = document.getElementById(`card-${id}`);
                       if(el) {
                           // Trigger CSS animation reflow
                           el.classList.remove('flash-animation');
                           void el.offsetWidth;
                           el.classList.add('flash-animation');
                       }
                    });
                }
            });
        }

        setInterval(fetchLiveStatus, 3000);
        fetchLiveStatus(); 
    </script>
</body>
</html>
