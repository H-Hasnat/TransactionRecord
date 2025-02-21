{{-- @extends('layout')


@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for Large Screens -->
        <div class="col-lg-3 d-none d-lg-block sidebar">
            <h4 class="text-center  mb-4">Navbar</h4>
            <a  class=" PaymentBtn d-block mb-3">Payment Method</a>
            <a  class=" account_typeBtn d-block mb-4">Account Type</a>
            <a  class="cus_detailsBtn d-block mb-4">Customer Details</a>
            <a class="NumberBtn d-block mb-4">Agent Number Details</a>
            <a  class=" TransactionBtn d-block mb-3">Transaction</a>
            <a  class="HistoryBtn d-block mb-3">Histroy</a>
        </div>

        <!-- Sidebar Toggle Button for Medium & Small Screens -->
        <div class="m-4">
            <button class="btn btn-primary p-2  d-lg-none" type="button" id="MenuBtn" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                ☰ Menu
            </button>
        </div>


        <!-- Offcanvas Sidebar for Medium & Small Screens -->
        <div class="offcanvas offcanvas-start d-lg-none d-md-none" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Navbar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <a  class=" PaymentBtn d-block mb-2">Payment Method</a>
                <a  class=" account_typeBtn d-block mb-2">Account Type</a>
                <a  class="cus_detailsBtn d-block mb-2">Customer Details</a>
                <a class="NumberBtn d-block mb-2">Agent Number Details</a>
                <a  class=" TransactionBtn d-block mb-2">Transaction Details</a>
                <a  class="HistoryBtn d-block mb-2">History</a>

             </div>
        </div>





    </div>
</div>


<!-- Main Content -->
<div class="MainContainer d-flex justify-content-center ">
    <div class="col-lg-9 col-md-12 col-12 p-3 maincontent">
        <!-- Header Section -->
        <div style="background-color: #7c0e0e; padding: 20px; color: white;">
            <h2 class="text-center fw-bold" style="font-size: 5vw;">Rezoan's Store</h2>
        </div>
        <p></p>

        <!-- Image Section -->
        <div class="text-center">
            <img src="{{asset('image/demo.jpg')}}" alt="Image description" class="img-fluid mb-4" style="max-height: 700px; width: 100%; object-fit: cover;">
        </div>
    </div>
</div>







<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>



<script>

$(".NumberBtn, .TransactionBtn, .HistoryBtn, .PaymentBtn, .account_typeBtn,.cus_detailsBtn").on('click', function() {


    let overlay = document.getElementById("overlay");

    if (overlay) {
        overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen

        // Get the target URL dynamically based on button class
        let targetURL = "";

        if ($(this).hasClass("NumberBtn")) {
            targetURL = "/number_details_page";
        } else if ($(this).hasClass("TransactionBtn")) {
            targetURL = "/transaction_details_page";
        } else if ($(this).hasClass("HistoryBtn")) {
            targetURL = "/history_page";
        }else if ($(this).hasClass("PaymentBtn")) {
            targetURL = "/payment_method_page";
        }else if ($(this).hasClass("account_typeBtn")) {
            targetURL = "/account_type_page";
        }else if ($(this).hasClass("cus_detailsBtn")) {
            targetURL = "/customer_details_page";
        }



        // Redirect after 1 second
        setTimeout(function() {
            window.location.href = targetURL;
            overlay.style.display = "none"; // 🔴 Hide loader after redirection
        }, 1000);

    } else {
        console.log("❌ Overlay not found!");
    }
});


</script>

@endsection




 --}}


 {{-- @extends('layout')


@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for Large Screens -->
        <div class="col-lg-3 d-none d-lg-block sidebar">
            <h4 class="text-center  mb-4">Navbar</h4>
            <a  class=" PaymentBtn d-block mb-3">Payment Method</a>
            <a  class=" account_typeBtn d-block mb-4">Account Type</a>
            <a  class="cus_detailsBtn d-block mb-4">Customer Details</a>
            <a class="NumberBtn d-block mb-4">Agent Number Details</a>
            <a  class=" TransactionBtn d-block mb-3">Transaction</a>
            <a  class="HistoryBtn d-block mb-3">Histroy</a>
        </div>

        <!-- Sidebar Toggle Button for Medium & Small Screens -->
        <div class="m-4">
            <button class="btn btn-primary p-2  d-lg-none" type="button" id="MenuBtn" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                ☰ Menu
            </button>
        </div>


        <!-- Offcanvas Sidebar for Medium & Small Screens -->
        <div class="offcanvas offcanvas-start d-lg-none d-md-none" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Navbar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <a  class=" PaymentBtn d-block mb-2">Payment Method</a>
                <a  class=" account_typeBtn d-block mb-2">Account Type</a>
                <a  class="cus_detailsBtn d-block mb-2">Customer Details</a>
                <a class="NumberBtn d-block mb-2">Agent Number Details</a>
                <a  class=" TransactionBtn d-block mb-2">Transaction Details</a>
                <a  class="HistoryBtn d-block mb-2">History</a>

             </div>
        </div>





    </div>
</div>


<!-- Main Content -->
<div class="MainContainer d-flex justify-content-center ">
    <div class="col-lg-9 col-md-12 col-12 p-3 maincontent">
        <!-- Header Section -->
        <div style="background-color: #7c0e0e; padding: 20px; color: white;">
            <h2 class="text-center fw-bold" style="font-size: 5vw;">Rezoan's Store</h2>
        </div>
        <p></p>

        <!-- Image Section -->
        <div class="text-center">
            <img src="{{asset('image/demo.jpg')}}" alt="Image description" class="img-fluid mb-4" style="max-height: 700px; width: 100%; object-fit: cover;">
        </div>
    </div>
</div>







<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>



<script>

$(".NumberBtn, .TransactionBtn, .HistoryBtn, .PaymentBtn, .account_typeBtn,.cus_detailsBtn").on('click', function() {


    let overlay = document.getElementById("overlay");

    if (overlay) {
        overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen

        // Get the target URL dynamically based on button class
        let targetURL = "";

        if ($(this).hasClass("NumberBtn")) {
            targetURL = "/number_details_page";
        } else if ($(this).hasClass("TransactionBtn")) {
            targetURL = "/transaction_details_page";
        } else if ($(this).hasClass("HistoryBtn")) {
            targetURL = "/history_page";
        }else if ($(this).hasClass("PaymentBtn")) {
            targetURL = "/payment_method_page";
        }else if ($(this).hasClass("account_typeBtn")) {
            targetURL = "/account_type_page";
        }else if ($(this).hasClass("cus_detailsBtn")) {
            targetURL = "/customer_details_page";
        }



        // Redirect after 1 second
        setTimeout(function() {
            window.location.href = targetURL;
            overlay.style.display = "none"; // 🔴 Hide loader after redirection
        }, 1000);

    } else {
        console.log("❌ Overlay not found!");
    }
});


</script>

@endsection --}}





@extends('layout')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for Large Screens -->
        <div class="col-lg-3 d-none d-lg-block sidebar">
            <h4 class="text-center mb-4">Navbar</h4>
            <a class="PaymentBtn d-block mb-3">Payment Method</a>
            <a class="account_typeBtn d-block mb-4">Account Type</a>
            <a class="cus_detailsBtn d-block mb-4">Customer Details</a>
            <a class="NumberBtn d-block mb-4">Agent Number Details</a>
            <a class="TransactionBtn d-block mb-3">Transaction</a>
            <a class="HistoryBtn d-block mb-3">History</a>
        </div>

        <!-- Sidebar Toggle Button for Medium & Small Screens -->
        <div class="m-4">
            <button
                class="btn btn-primary p-2 d-lg-none"
                type="button"
                id="MenuBtn"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar"
            >
                ☰ Menu
            </button>
        </div>

        <!-- Offcanvas Sidebar for Medium & Small Screens -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileSidebarLabel">Navbar</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <a class="PaymentBtn d-block mb-2">Payment Method</a>
                <a class="account_typeBtn d-block mb-2">Account Type</a>
                <a class="cus_detailsBtn d-block mb-2">Customer Details</a>
                <a class="NumberBtn d-block mb-2">Agent Number Details</a>
                <a class="TransactionBtn d-block mb-2">Transaction Details</a>
                <a class="HistoryBtn d-block mb-2">History</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="MainContainer d-flex justify-content-center">
    <div class="col-lg-9 col-md-12 col-12 p-3 maincontent">
        <!-- Header Section -->
        <div style="background-color: #7c0e0e; padding: 20px; color: white;">
            <h2 class="text-center fw-bold" style="font-size: 5vw;">Rezoan's Store</h2>
        </div>
        <p></p>

        <!-- Image Section -->
        <div class="text-center">
            <img src="{{ asset('image/demo.jpg') }}" alt="Image description" class="img-fluid mb-4" style="max-height: 700px; width: 100%; object-fit: cover;">
        </div>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>

<script>
    $(".NumberBtn, .TransactionBtn, .HistoryBtn, .PaymentBtn, .account_typeBtn, .cus_detailsBtn").on('click', function () {
        let overlay = document.getElementById("overlay");

        if (overlay) {
            overlay.style.display = "flex"; // Show overlay and freeze screen

            let targetURL = "";

            if ($(this).hasClass("NumberBtn")) {
                targetURL = "/number_details_page";
            } else if ($(this).hasClass("TransactionBtn")) {
                targetURL = "/transaction_details_page";
            } else if ($(this).hasClass("HistoryBtn")) {
                targetURL = "/history_page";
            } else if ($(this).hasClass("PaymentBtn")) {
                targetURL = "/payment_method_page";
            } else if ($(this).hasClass("account_typeBtn")) {
                targetURL = "/account_type_page";
            } else if ($(this).hasClass("cus_detailsBtn")) {
                targetURL = "/customer_details_page";
            }

            setTimeout(function () {
                window.location.href = targetURL;
                overlay.style.display = "none"; // Hide loader after redirection
            }, 1000);
        } else {
            console.log("❌ Overlay not found!");
        }
    });
</script>

@endsection




