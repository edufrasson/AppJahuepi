<script src="View/js/jquery.config.min.js"></script>
<script src="View/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>-->

<!-- DataTable -->
<script src="View/js/DataTable/datatables.min.js"></script>

<script src="View/js/src/jquery.global.js"></script>
<script src="View/js/plugin/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>

<!-- Bootstrap Select -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>

<!--  JS da Navbar -->
<script>
    const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text"),
        mainContainer = body.querySelector(".main-container");

    var state = 0;
    let style = window.getComputedStyle(mainContainer)

    const startWidth = mainContainer.offsetWidth
    const startHeight = mainContainer.offsetHeight
    const startMargin = style.marginLeft

    toggle.addEventListener("click", () => {


        sidebar.classList.toggle("close");

        /*if ($(window).width() < 1380 && state == 0) {
            mainContainer.style.width = "75vw";
            mainContainer.style.marginLeft = "19%";
            console.log(startWidth)
            state = 1
        } else {
            mainContainer.style.width = startWidth + "px"
            mainContainer.style.marginLeft = startMargin
            state = 0
        }*/
    })

    body.addEventListener("click", (event) => {
        if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
            if (!sidebar.classList.contains("close")) {
                sidebar.classList.add("close");
            }
        }
    });
</script>