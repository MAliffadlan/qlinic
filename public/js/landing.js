(function () {
    "use strict";

    var header = document.querySelector(".landing-header");
    var headerFrame = null;

    function updateHeader() {
        headerFrame = null;
        if (header) header.classList.toggle("is-scrolled", window.scrollY > 24);
    }

    function scheduleHeaderUpdate() {
        if (headerFrame !== null) return;
        headerFrame = window.requestAnimationFrame(updateHeader);
    }

    updateHeader();
    window.addEventListener("scroll", scheduleHeaderUpdate, { passive: true });

    var motionPreference = window.matchMedia("(prefers-reduced-motion: reduce)");
    if (motionPreference.matches || !("IntersectionObserver" in window)) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.15 });

    document.querySelectorAll(".reveal").forEach(function (element) {
        observer.observe(element);
    });

    document.documentElement.classList.add("landing-motion");
})();
