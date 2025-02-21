
 <!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responsive Sidebar</title>

    <!-- Using asset() for local files in the public directory -->
    <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css') }}">

    <!-- CSS file from the public directory -->
    <link rel="stylesheet" href="{{ asset('css/modify.css') }}">

    <!-- External CSS links (no need for asset()) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Local JS files -->
    <script src="{{ asset('js/modify.js') }}"></script>

    <!-- External JS files (no need for asset()) -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

</head>

<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(".BackBtn").on('click', async function() {
            let overlay = document.getElementById("overlay");

            if (overlay) {
                overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
                // Redirect after 1 second
                setTimeout(function() {
                    history.back()
                    overlay.style.display = "none"; // 🔴 Hide loader after redirection
                }, 1000);
            } else {
                console.log("❌ Overlay not found!");
            }
        })
    </script>
</body>

</html>
