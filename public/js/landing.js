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
    var isLeavingForAuth = false;
    var navigationFallback = null;

    document.querySelectorAll(".landing-nav__login, .landing-nav__register").forEach(function (link) {
        link.addEventListener("click", function (event) {
            if (isLeavingForAuth || motionPreference.matches || event.defaultPrevented ||
                event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

            event.preventDefault();
            isLeavingForAuth = true;
            var destination = link.href;
            var navigated = false;

            function navigate() {
                if (navigated) return;
                navigated = true;
                if (navigationFallback !== null) window.clearTimeout(navigationFallback);
                window.location.assign(destination);
            }

            document.body.addEventListener("animationend", function (event) {
                if (event.animationName === "landing-auth-leave") navigate();
            });
            document.body.classList.add("landing-auth-leaving");
            // Never hold navigation hostage if an animation event is interrupted.
            navigationFallback = window.setTimeout(navigate, 400);
        });
    });

    window.addEventListener("pageshow", function (event) {
        if (!event.persisted) return;
        isLeavingForAuth = false;
        if (navigationFallback !== null) window.clearTimeout(navigationFallback);
        document.body.classList.remove("landing-auth-leaving");
    });

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
