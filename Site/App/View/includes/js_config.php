<script src="View/js/jquery.config.min.js"></script>
<script src="View/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="View/js/DataTable/datatables.min.js"></script>
<script src="View/js/src/jquery.global.js"></script>
<script src="View/js/plugin/SweetAlert/sweetalert.min.js"></script>

<!-- Bootstrap Select -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>

<script>
    const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text");
    mainContainer = body.querySelector(".main-container");
    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        mainContainer.classList.toggle("main-alt-size");
    })
    searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
    })
    modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");

        if (body.classList.contains("dark")) {
            modeText.innerText = "Light mode";
        } else {
            modeText.innerText = "Dark mode";

        }
    });
</script>