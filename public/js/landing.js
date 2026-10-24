(function () {
    "use strict";

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
