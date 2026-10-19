(function () {
    "use strict";

    document.addEventListener("click", function (event) {
        var toggle = event.target.closest("[data-password-toggle]");
        if (!toggle) return;

        var input = document.getElementById(toggle.getAttribute("data-password-toggle"));
        if (!input) return;

        var isVisible = input.type === "text";
        input.type = isVisible ? "password" : "text";
        toggle.setAttribute("aria-pressed", String(!isVisible));
        toggle.setAttribute("aria-label", isVisible ? "Tampilkan password" : "Sembunyikan password");
    });

    document.addEventListener("click", function (event) {
        if (!event.target.closest("[data-sidebar-toggle]")) return;
        document.body.classList.toggle("sidebar-open");
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            document.body.classList.remove("sidebar-open");
        }
    });

    var nikInput = document.querySelector("[data-nik-input]");
    var nikCounter = document.querySelector("[data-nik-counter]");

    if (nikInput && nikCounter) {
        var updateCounter = function () {
            var count = nikInput.value.replace(/\D/g, "").length;

            if (count === 0) {
                nikCounter.textContent = "Masukkan 16 digit NIK sesuai KTP Anda.";
                nikCounter.classList.remove("is-valid", "is-invalid");
            } else if (count < 16) {
                nikCounter.textContent = count + "/16 digit NIK sesuai KTP Anda.";
                nikCounter.classList.remove("is-valid", "is-invalid");
            } else if (count === 16) {
                nikCounter.textContent = "NIK lengkap — 16 digit.";
                nikCounter.classList.add("is-valid");
                nikCounter.classList.remove("is-invalid");
            } else {
                nikCounter.textContent = "NIK maksimal 16 digit.";
                nikCounter.classList.add("is-invalid");
                nikCounter.classList.remove("is-valid");
            }
        };

        nikInput.addEventListener("input", updateCounter);
        updateCounter();
    }
})();
