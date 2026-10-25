(function () {
    "use strict";

    var header = document.querySelector(".landing-header");
    var headerFrame = null;
    var headerScrolled = header ? header.classList.contains("is-scrolled") : false;
    var expandAt = 32;
    var collapseAt = 12;

    function updateHeader() {
        headerFrame = null;
        if (!header) return;

        // Separate thresholds keep small scroll corrections from restarting
        // the navbar transition around a single boundary.
        if (window.scrollY > expandAt) {
            headerScrolled = true;
        } else if (window.scrollY <= collapseAt) {
            headerScrolled = false;
        }
        header.classList.toggle("is-scrolled", headerScrolled);
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
