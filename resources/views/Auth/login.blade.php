@extends('layout')

@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-10 col-lg-8"> <!-- Updated classes for responsive sizing -->
            <div class="card loginContiner shadow border-primary">
                <div class="card-body">
                    <h2 class="text-center mb-4">Login</h2>

                    <div class="mb-3">
                        <label for="email" class="form-label">Number</label>
                        <input type="email" class="form-control" id="number" name="number">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" onclick="Login()">Login</button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="/signup"></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>


    <script >
async function Login() {
    let number = document.getElementById("number").value;
    let password = document.getElementById("password").value;

    let overlay = document.getElementById("overlay");




    if (number.length !== 11) {
        error("email required");
    } else if (password.length == 0) {
        error("password required");
    } else {

        if (overlay) {
            overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen

            setTimeout(async function() {

        let res = await axios.post("/userLogin", {
            number:number,
            password: password,
        });

        console.log(res);

        if (res.data["status"] === "success") {
            success("login successfully");
            setTimeout(function () {
                window.location.href = "/index";
            }, 500);
        } else {
            error("Information Incorrect");
        }

        overlay.style.display = "none"; // 🔴 Hide loader after redirection

    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}


    }
}

    </script>
@endsection
