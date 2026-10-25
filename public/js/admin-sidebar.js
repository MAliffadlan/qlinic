(function () {
    "use strict";

    var openButton = document.querySelector(".js-sidebar-open");
    var sidebar = document.getElementById("admin-navigation");
    var main = document.querySelector(".admin-main");
    var backdrop = document.querySelector(".admin-backdrop");
    var notifications = document.getElementById("admin-notifications");

    if (!openButton || !sidebar || !main || !backdrop) return;

    var mobile = window.matchMedia("(max-width: 1024px)");
    var closeButton = sidebar.querySelector(".admin-sidebar__close");

    function isOpen() {
        return document.body.classList.contains("sidebar-open");
    }

    function focusableElements() {
        return Array.from(sidebar.querySelectorAll("a[href], button:not([disabled])"))
            .filter(function (element) {
                return !element.inert && element.getClientRects().length > 0;
            });
    }

    function setOpen(open, restoreFocus) {
        if (open && !mobile.matches) return;

        document.body.classList.toggle("sidebar-open", open);
        openButton.setAttribute("aria-expanded", String(open));
        sidebar.inert = mobile.matches && !open;
        backdrop.inert = !open;
        main.inert = mobile.matches && open;
        if (notifications) notifications.inert = mobile.matches && open;

        if (open && mobile.matches) {
            sidebar.setAttribute("role", "dialog");
            sidebar.setAttribute("aria-modal", "true");
            if (closeButton) closeButton.focus();
        } else {
            sidebar.removeAttribute("role");
            sidebar.removeAttribute("aria-modal");
            if (restoreFocus && mobile.matches) openButton.focus();
        }
    }

    function syncLayout() {
        var focusWasInSidebar = sidebar.contains(document.activeElement);
        var wasOpen = isOpen();
        setOpen(mobile.matches && wasOpen, false);
        if (mobile.matches && !wasOpen && focusWasInSidebar) openButton.focus();
    }

    openButton.addEventListener("click", function () {
        setOpen(true, false);
    });

    document.addEventListener("click", function (event) {
        if (event.target.closest("[data-sidebar-close]")) {
            setOpen(false, true);
        }
    });

    sidebar.addEventListener("click", function (event) {
        if (event.target.closest("a[href]") && mobile.matches) {
            setOpen(false, false);
        }
    });

    document.addEventListener("keydown", function (event) {
        if (!mobile.matches || !isOpen()) return;

        if (event.key === "Escape") {
            event.preventDefault();
            setOpen(false, true);
            return;
        }

        if (event.key !== "Tab") return;

        var elements = focusableElements();
        if (elements.length === 0) return;
        var first = elements[0];
        var last = elements[elements.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });

    if (typeof mobile.addEventListener === "function") {
        mobile.addEventListener("change", syncLayout);
    } else {
        mobile.addListener(syncLayout);
    }

    syncLayout();
})();
