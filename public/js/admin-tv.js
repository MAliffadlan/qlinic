(function () {
    "use strict";

    var services = document.getElementById("admin-tv-services");
    if (!services) return;

    var connection = document.getElementById("admin-tv-connection");
    var announcer = document.getElementById("admin-tv-announcer");
    var endpoint = services.dataset.statusUrl;
    var previousCalls = {};
    var isLoading = false;

    function make(tag, className, text) {
        var element = document.createElement(tag);
        if (className) element.className = className;
        if (text !== undefined) element.textContent = text;
        return element;
    }

    function buildCard(service, queue) {
        var card = make("article", "admin-tv-card" + (queue ? " is-calling" : ""));
        card.setAttribute("aria-label", service.name + (queue ? " memanggil " + queue.queue_number : " belum memanggil"));

        var header = make("header", "admin-tv-card__header");
        var serviceWrap = make("div", "admin-tv-card__service");
        serviceWrap.appendChild(make("span", "admin-tv-card__code", service.code || ""));
        serviceWrap.appendChild(make("h2", "admin-tv-card__name", service.name || "Poli"));
        header.appendChild(serviceWrap);
        header.appendChild(make("span", "admin-tv-card__badge", queue ? "Dipanggil" : "Menunggu"));
        card.appendChild(header);

        var body = make("div", "admin-tv-card__body");
        body.appendChild(make("span", "admin-tv-card__label", queue ? "Nomor antrean" : "Belum ada panggilan"));
        body.appendChild(make("strong", "admin-tv-card__number", queue ? queue.queue_number : "—"));
        body.appendChild(make("span", "admin-tv-card__patient", queue && queue.user ? queue.user.name : "Menunggu antrean berikutnya"));
        card.appendChild(body);
        return card;
    }

    function render(data) {
        var fragment = document.createDocumentFragment();
        var announcements = [];
        var seenServices = {};

        data.forEach(function (service) {
            var queue = service.queues && service.queues.length ? service.queues[0] : null;
            var currentNumber = queue ? queue.queue_number : null;
            var previousNumber = previousCalls[service.id];
            if (previousNumber !== undefined && previousNumber !== currentNumber && currentNumber !== null) {
                announcements.push(service.name + " memanggil nomor " + currentNumber);
            }
            seenServices[service.id] = true;
            previousCalls[service.id] = currentNumber;
            fragment.appendChild(buildCard(service, queue));
        });

        Object.keys(previousCalls).forEach(function (id) {
            if (!seenServices[id]) delete previousCalls[id];
        });

        if (!data.length) {
            var empty = make("p", "admin-tv__empty", "Belum ada layanan yang tersedia.");
            fragment.appendChild(empty);
        }

        services.replaceChildren(fragment);
        if (announcements.length) announcer.textContent = announcements.join(". ");
    }

    function fetchStatus() {
        if (isLoading) return;
        isLoading = true;
        fetch(endpoint, { headers: { "Accept": "application/json" }, cache: "no-store" })
            .then(function (response) {
                if (!response.ok) throw new Error("HTTP " + response.status);
                return response.json();
            })
            .then(function (data) {
                connection.textContent = "Live";
                connection.classList.remove("is-offline");
                render(Array.isArray(data) ? data : []);
            })
            .catch(function () {
                connection.textContent = "Koneksi terputus — mencoba lagi";
                connection.classList.add("is-offline");
            })
            .finally(function () { isLoading = false; });
    }

    fetchStatus();
    window.setInterval(fetchStatus, 3000);
})();
