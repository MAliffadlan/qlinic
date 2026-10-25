(function () {
    "use strict";

    var toasts = document.querySelectorAll("[data-admin-toast]");
    if (!toasts.length) return;

    var reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

    function dismiss(toast) {
        if (!toast || toast.classList.contains("is-leaving") || toast.closest("[inert]")) return;

        toast.classList.remove("is-entering");
        toast.classList.add("is-leaving");

        var finished = false;
        var fallback;
        function removeToast() {
            if (finished) return;
            finished = true;
            window.clearTimeout(fallback);
            if (toast.contains(document.activeElement)) {
                var nextToast = Array.from(document.querySelectorAll("[data-admin-toast]")).find(function (candidate) {
                    return candidate !== toast && !candidate.classList.contains("is-leaving");
                });
                var focusTarget = nextToast ? nextToast.querySelector("[data-toast-dismiss]") : document.getElementById("konten");
                if (focusTarget) focusTarget.focus({ preventScroll: true });
            }
            toast.remove();
        }

        if (reducedMotion.matches) {
            removeToast();
            return;
        }

        fallback = window.setTimeout(removeToast, 400);
        toast.addEventListener("animationend", function (event) {
            if (event.animationName === "admin-toast-leave") removeToast();
        });
    }

    toasts.forEach(function (toast) {
        if (reducedMotion.matches) return;

        toast.classList.add("is-entering");
        toast.addEventListener("animationend", function (event) {
            if (event.animationName === "admin-toast-enter") {
                toast.classList.remove("is-entering");
            }
        });
    });

    document.addEventListener("click", function (event) {
        var button = event.target.closest("[data-toast-dismiss]");
        if (button) dismiss(button.closest("[data-admin-toast]"));
    });
})();
