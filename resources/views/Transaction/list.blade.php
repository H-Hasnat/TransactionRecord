{{--
  @extends('layout')

 @section('content')


    <div class="container mt-5">

        <div class="mb-4 mx-5 mt-5">
            <a class="BackBtn btn btn-secondary mt-4">Back</a>
            <a class="BackBtn btn btn-success mt-4" href="javascript:void(0);" onclick="location.reload();">Refresh</a>

        </div>


        <div class="container">
            <div class="row justify-content-between">
                <h2 class="mb-4 text-center">Transaction Table</h2>

                <div class="col-12">
                    <div class="row g-2">
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="start-date" class="form-label">Start Date</label>
                            <input type="date" id="start-date" class="form-control">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="end-date" class="form-label">End Date</label>
                            <input type="date" id="end-date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <div class="row g-2">
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="account_type" class="form-label">Account Type</label>
                            <select class="form-control" id="account_type" name="account_type">
                                <option value="" selected>Select Account Type</option>

                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <button class="btn btn-primary  my-4" id="AgentNumberList" style=" width: 50%; margin-top: 500px;">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-between mb-3">
            <h4>Total In: <span id="totalin" class="fw-bold"> 0</span>(+) taka</h4>
            <h4>Total Out: <span id="totalout" class="fw-bold">0</span>(-) taka</h4>
            <h4>Total Amount: <span id="totalAmount" class="fw-bold">0</span> taka</h4>
        </div>







        <div class="table-responsive">
            <button id="createtransactionbutton" class="float-end btn  btn-success" >Create</button>

            <table class="table table-bordered border-black" id="tableData">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Name</th>
                        <th style="text-align: center;">Customer Number</th>
                        <th style="text-align: center;">Agent Number</th>
                        <th style="text-align: center;">Account Type</th>
                        <th style="text-align: center;">Amount</th>
                        <th style="text-align: center;">Payment Method</th>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>

    <div class="overlay" id="overlay">
        <div class="loader"></div>
    </div>



    <script>
        TransactionList()
        async function TransactionList() {

            //account type fillTransactionSelect

            let res=await axios.get('/account_type_details')
        console.log(res)

        // let res1=await axios.get('/_details')
        // console.log(res1)

        res.data['data'].forEach(function(item,indx){

            let option=`
        <option value="${item['id']}">${item['name']}</option>
        `

        $("#account_type").append(option)

        })



            let res1 = await axios.get('/transaction_details')
            console.log(res1)

            let tableList = $('#tableList')
            let tableData = $('#tableData')


            tableData.DataTable().destroy();
            tableList.empty();


            res1.data['data'].forEach(function(item, indx) {



        let dateObj = new Date(item['created_at']);
        let date = dateObj.toISOString().slice(0, 10);

                let row = `<tr>
            <td style="text-align: center;">${indx+1}</td>
            <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="name">${item['name']}</td>
            <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="cus_number">${item['cus_number']}</td>
            <td style="text-align: center;" class="readonly">${item['number']['agent_number']}</td>
            <td style="text-align: center;" class="readonly">${item['number']['type1']['name']}</td>
            <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="amount">${item['amount']}</td>
            <td style="text-align: center;" class="readonly">${item['payment_method']['type']}</td>


            <td style="text-align: center;" class="readonly">${date}</td>

        <td style="text-align: center;">
                <button data-id="${item['id']}" class="btn deletetransactionBtn btn-sm btn-outline-danger">Delete</button>

                </td>
        </tr>`
                tableList.append(row)

            });






            $("#createtransactionbutton").on('click', function() {
                //   let id= $(this).data('id')
                //   alert(id)

                let overlay = document.getElementById("overlay");

        if (overlay) {
            overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
            // Redirect after 1 second
            setTimeout(function() {

                $("#create-transaction-modal").modal('show')
                overlay.style.display = "none"; // 🔴 Hide loader after redirection
            }, 1000);

        } else {
            console.log("❌ Overlay not found!");
        }


                //   console.log(id)

            });








            $('.deletetransactionBtn').on('click', async function() {


                let id = $(this).data('id');

                let overlay = document.getElementById("overlay");

        if (overlay) {
            overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
            // Redirect after 1 second
            setTimeout(function() {
                $("#delete-transaction-Modal").modal('show')
                // $("#deletetransactionId").val(id);
                overlay.style.display = "none"; // 🔴 Hide loader after redirection
            }, 1000);

        } else {
            console.log("❌ Overlay not found!");
        }


            })



            $(".edittransactionBtn").on('keydown blur', async function (event) {


        if (event.type === "keydown" && event.key === "Enter") {
            event.preventDefault(); // Prevent default behavior (like creating a new line or losing focus)
            $(this).blur(); // Trigger the blur event programmatically
            return;
        }

        // Only handle blur or Enter-triggered blur
        if (event.type !== "blur") return;

        let id = $(this).data('id');
        let column = $(this).attr('data-column'); // Identify 'name' or 'number'
        let value = $(this).text().trim(); // Remove extra spaces

        // Validation: Check if value is empty
        if (value.length === 0) {
            if (column === "cus_number") {
                    error("Mobile number is required!");
            }
            return; // Stop execution if value is empty
        }else if(value.length !==11){
            if (column === "cus_number") {
                    error("Mobile number is required 11 digit!");
            }
        }


        let overlay = document.getElementById("overlay");

        // Show overlay (loader)
        if (overlay) {
            overlay.style.display = "flex"; // Freeze screen
        }

        try {
            let res = await axios.post('/transaction_update', {
                id: id,
                column: column,
                value: value
            });

            console.log(res);

            // Success or error message based on response
            if (res.data['status'] === 'success' && res.status === 200) {
                    success('Data Updated Successfully');
            } else {
                    error("Update failed! Please try again.");
            }
        } catch (err) {
            console.error(err);
            error("Something went wrong!");
        } finally {
            if (overlay) {
                    overlay.style.display = "none"; // Hide loader
            }
        }

            })

















            $("#AgentNumberList").on('click', async function () {
    console.log("hi");
    let start_date = document.getElementById("start-date").value;
    let end_date = document.getElementById("end-date").value;
    let account_type = document.getElementById("account_type").value;
    console.log(start_date);
    console.log(end_date);

    let overlay = document.getElementById("overlay");

    // Show the overlay loader while fetching data
    if (overlay) {
        overlay.style.display = "flex";

        setTimeout(async function () {
            // Check if end_date is greater than start_date
            if (start_date.length === 0) {
                error("Start Date required")
            } else if (end_date.length === 0) {
                error("End Date required")
            } else if (start_date > end_date) {
                error("End Date must be greater than Start Date!");
            } else if (account_type.value === "") { // Corrected check for empty string
                error('account type required')
            } else {
                // Send the request to the server with start and end date
                let res = await axios.post('/filter_transaction', {
                    start_date: start_date,
                    end_date: end_date,
                    account_type: account_type
                });

                console.log(res);


                let tableList = $('#tableList')
                let tableData = $('#tableData')


                tableData.DataTable().destroy(); // Destroy DataTable on #tableData
                tableList.empty(); // Empty the table body


                res.data['transactions'].forEach(function (item, indx) {
                    let dateObj = new Date(item['created_at']);
                    let date = dateObj.toISOString().slice(0, 10);

                    let row = `<tr>
                        <td style="text-align: center;">${indx + 1}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="name">${item['name']}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="cus_number">${item['cus_number']}</td>
                        <td style="text-align: center;" class="readonly">${item['number']['agent_number']}</td>
                        <td style="text-align: center;" class="readonly">${item['number']['type1']['name']}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="amount">${item['amount']}</td>
                        <td style="text-align: center;" class="readonly">${item['payment_method']['type']}</td>
                        <td style="text-align: center;" class="readonly">${date}</td>
                        <td style="text-align: center;">
                            <button data-id="${item['id']}" class="btn deletetransactionBtn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>`;
                    tableList.append(row);
                });

                document.getElementById("totalin").innerHTML = res.data['total_in']
                document.getElementById("totalout").innerHTML = res.data['total_out']
                document.getElementById("totalAmount").innerHTML = res.data['total_amount']


                // Reinitialize DataTable AFTER appending new rows, on the CORRECT table: #tableData
                new DataTable('#tableData', {
                    lengthMenu: [5, 10, 15, 20, 30],
                    order: [[0, 'desc']], // Optional: Preserve initial sorting if needed
                    searching: false // Optional: Keep searching disabled if it was initially
                });
            }

            // Hide the loader after completing the task
            overlay.style.display = "none";
        }, 1000);
    } else {
        console.log("Overlay not found!");
    }
});





















            new DataTable('#tableData', {
        lengthMenu: [100, 200, 300],
        order: [[0, 'desc']], // 0 = First column, 'desc' = Descending order
        searching: false, // সার্চ অপশন নিষ্ক্রিয় করা হয়েছে
    });


        }





    </script>

@endsection

 --}}



{{-- {{$numberDetails}} --}}

{{-- <div class="container mt-5"> --}}



{{--

    <div class="mb-4 mt-5">
        <a class="BackBtn btn btn-secondary mt-4">Back</a>
        <a class="BackBtn btn btn-success mt-4" href="javascript:void(0);" onclick="location.reload();">Refresh</a>
    </div>

    <div class="">
        <div class="row justify-content-between ">
            <h2 class="mb-4 text-center">Transaction Table</h2>


            <div class="col-12">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="start-date" class="form-label">Start Date</label>
                        <input type="date" id="start-date" class="form-control">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="end-date" class="form-label">End Date</label>
                        <input type="date" id="end-date" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="account_type" class="form-label">Account Type</label>
                        <select class="form-control" id="account_type" name="account_type">
                            <option value="" selected>Select Account Type</option>

                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary  my-4" id="AgentNumberList" style=" width: 50%; margin-top: 500px;">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-between mb-3 mt-5">
        <h4>Total In: <span id="totalin" class="fw-bold"> 0</span>(+) taka</h4>
        <h4>Total Out: <span id="totalout" class="fw-bold">0</span>(-) taka</h4>
        <h4>Total Amount: <span id="totalAmount" class="fw-bold">0</span> taka</h4>
    </div>

        </div>
 --}}

 <div class="container py-4 mt-5"> <!-- container-fluid পরিবর্তন করে container ব্যবহার করেছি -->

    <!-- Back & Refresh Buttons -->
    <div class=" align-items-center mb-4 mt-5">
        <a class="btn btn-secondary" href="javascript:history.back();">Back</a>
        <a class="btn btn-success" href="javascript:void(0);" onclick="location.reload();">Refresh</a>
    </div>

    <!-- Transaction Table Title -->
    <h2 class="text-center mb-4">Transaction Table</h2>

    <!-- First Row: Start Date & End Date -->
    <div class="row g-3"> <!-- g-3 যোগ করা হয়েছে row-এর মধ্যে গ্যাপের জন্য -->
        <div class="col-lg-6 col-md-6 col-12">
            <label for="start-date" class="form-label">Start Date</label>
            <input type="date" id="start-date" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <label for="end-date" class="form-label">End Date</label>
            <input type="date" id="end-date" class="form-control">
        </div>
    </div>

    <!-- Second Row: Account Type & Search Button -->
    <div class="row g-3 mt-3">
        <div class="col-lg-6 col-md-6 col-12">
            <label for="account_type" class="form-label">Account Type</label>
            <select class="form-control" id="account_type" name="account_type">
                <option value="" selected>Select Account Type</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-12 ">
            <button class="btn btn-primary w-50 w-md-auto my-4" id="AgentNumberList">Search</button>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="row g-3 mt-4">
        <div class="col-md-4 col-12 text-md-start text-center">
            <h4>Total In: <span id="totalin" class="fw-bold">0</span> (+) taka</h4>
        </div>
        <div class="col-md-4 col-12 text-md-center text-center">
            <h4>Total Out: <span id="totalout" class="fw-bold">0</span> (-) taka</h4>
        </div>
        <div class="col-md-4 col-12 text-md-end text-center">
            <h4>Total Amount: <span id="totalAmount" class="fw-bold">0</span> taka</h4>
        </div>
    </div>

</div>






<div class="table-responsive m-4">
    <button id="createtransactionbutton" class="float-end btn  btn-success">Create</button>

    <table class="table table-bordered border-black" id="tableData">
        <thead class="table-dark">
            <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Customer Number</th>
                <th style="text-align: center;">Agent Number</th>
                <th style="text-align: center;">Account Type</th>
                <th style="text-align: center;">Amount</th>
                <th style="text-align: center;">Payment Method</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Actions</th>
            </tr>

        </thead>

        <tbody id="tableList">






        </tbody>

    </table>
</div>


</div>

</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>

<script>
    TransactionList()
    async function TransactionList() {


        let res = await axios.get('/account_type_details')
        console.log(res)

        // let res1=await axios.get('/_details')
        // console.log(res1)
        //   let account_type = $('#account_type')
        //   tableData.DataTable().destroy();
        //   tableList.empty();
        //   account_type.empty()
        $("#account_type").empty().append('<option value="" selected>Select Account Type</option>');
        res.data['data'].forEach(function(item, indx) {

            let option = `
        <option value="${item['id']}">${item['name']}</option>
        `

            $("#account_type").append(option)

        })






        let res1 = await axios.get('/transaction_details')
        console.log(res1)

        let tableList = $('#tableList')
        let tableData = $('#tableData')


        tableData.DataTable().destroy();
        tableList.empty();


        res1.data['data'].forEach(function(item, indx) {

            let dateObj = new Date(item['created_at']);
            let date = dateObj.toISOString().slice(0, 10);

            let row = `<tr>
                        <td style="text-align: center;">${indx + 1}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="name">${item['name']}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="cus_number">${item['cus_number']}</td>
                        <td style="text-align: center;" class="readonly">${item['number']['agent_number']}</td>
                        <td style="text-align: center;" class="readonly">${item['number']['type1']['name']}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="amount">${item['amount']}</td>
                        <td style="text-align: center;" class="readonly">${item['payment_method']['type']}</td>
                        <td style="text-align: center;" class="readonly">${date}</td>
                        <td style="text-align: center;">
                            <button data-id="${item['id']}" class="btn deletetransactionBtn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>`;
            tableList.append(row)

        });






        $("#createtransactionbutton").on('click', function() {
            //    let id= $(this).data('id')
            //    alert(id)

            let overlay = document.getElementById("overlay");

            if (overlay) {
                overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
                // Redirect after 1 second
                setTimeout(function() {
                    $("#create-transaction-modal").modal('show')
                    overlay.style.display = "none"; // 🔴 Hide loader after redirection
                }, 1000);

            } else {
                console.log("❌ Overlay not found!");
            }


            //    console.log(id)

        });



        $('.deletetransactionBtn').on('click', async function() {


            let id = $(this).data('id');

            let overlay = document.getElementById("overlay");

            if (overlay) {
                overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
                // Redirect after 1 second
                setTimeout(function() {
                    $("#delete-transaction-Modal").modal('show')
                    $("#deletetransactionId").val(id);
                    overlay.style.display = "none"; // 🔴 Hide loader after redirection
                }, 1000);

            } else {
                console.log("❌ Overlay not found!");
            }





        })



        $(".edittransactionBtn").on('keydown blur', async function(event) {


            if (event.type === "keydown" && event.key === "Enter") {
                event
            .preventDefault(); // Prevent default behavior (like creating a new line or losing focus)
                $(this).blur(); // Trigger the blur event programmatically
                return;
            }

            // Only handle blur or Enter-triggered blur
            if (event.type !== "blur") return;

            let id = $(this).data('id');
            let column = $(this).attr('data-column'); // Identify 'name' or 'number'
            let value = $(this).text().trim(); // Remove extra spaces

            // Validation: Check if value is empty
            if (value.length === 0) {
                if (column === "cus_number") {
                    error("Mobile number is required!");
                }
                return; // Stop execution if value is empty
            } else if (value.length !== 11) {
                if (column === "cus_number") {
                    error("Mobile number is required 11 digit!");
                }
            }


            let overlay = document.getElementById("overlay");

            // Show overlay (loader)
            if (overlay) {
                overlay.style.display = "flex"; // Freeze screen
            }

            try {
                let res = await axios.post('/transaction_update', {
                    id: id,
                    column: column,
                    value: value
                });

                console.log(res);

                // Success or error message based on response
                if (res.data['status'] === 'success' && res.status === 200) {
                    success('Data Updated Successfully');
                } else {
                    error("Update failed! Please try again.");
                }
            } catch (err) {
                console.error(err);
                error("Something went wrong!");
            } finally {
                if (overlay) {
                    overlay.style.display = "none"; // Hide loader
                }
            }

        })










        $("#AgentNumberList").on('click', async function() {
            console.log("hi");
            let start_date = document.getElementById("start-date").value;
            let end_date = document.getElementById("end-date").value;
            let account_type = document.getElementById("account_type").value;
            console.log(start_date);
            console.log(end_date);

            let overlay = document.getElementById("overlay");

            // Show the overlay loader while fetching data
            if (overlay) {
                overlay.style.display = "flex";

                setTimeout(async function() {
                    // Check if end_date is greater than start_date
                    if (start_date.length === 0) {
                        error("Start Date required")
                    } else if (end_date.length === 0) {
                        error("End Date required")
                    } else if (start_date > end_date) {
                        error("End Date must be greater than Start Date!");
                    } else if (account_type.value ===
                        "") { // Corrected check for empty string
                        error('account type required')
                    } else {
                        // Send the request to the server with start and end date
                        let res = await axios.post('/filter_transaction', {
                            start_date: start_date,
                            end_date: end_date,
                            account_type: account_type
                        });

                        console.log(res);


                        let tableList = $('#tableList')
                        let tableData = $('#tableData')


                        tableData.DataTable().destroy(); // Destroy DataTable on #tableData
                        tableList.empty(); // Empty the table body


                        res.data['transactions'].forEach(function(item, indx) {
                            let dateObj = new Date(item['created_at']);
                            let date = dateObj.toISOString().slice(0, 10);

                            let row = `<tr>
                        <td style="text-align: center;">${indx + 1}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="name">${item['name']}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="cus_number">${item['cus_number']}</td>
                        <td style="text-align: center;" class="readonly">${item['number']['agent_number']}</td>
                        <td style="text-align: center;" class="readonly">${item['number']['type1']['name']}</td>
                        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="amount">${item['amount']}</td>
                        <td style="text-align: center;" class="readonly">${item['payment_method']['type']}</td>
                        <td style="text-align: center;" class="readonly">${date}</td>
                        <td style="text-align: center;">
                            <button data-id="${item['id']}" class="btn deletetransactionBtn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>`;
                            tableList.append(row);
                        });

                        document.getElementById("totalin").innerHTML = res.data['total_in']
                        document.getElementById("totalout").innerHTML = res.data[
                            'total_out']
                        document.getElementById("totalAmount").innerHTML = res.data[
                            'total_amount']









                            $('.deletetransactionBtn').on('click', async function() {


let id = $(this).data('id');

let overlay = document.getElementById("overlay");

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(function() {
        $("#delete-transaction-Modal").modal('show')
        $("#deletetransactionId").val(id);
        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}





})



$(".edittransactionBtn").on('keydown blur', async function(event) {


if (event.type === "keydown" && event.key === "Enter") {
    event
.preventDefault(); // Prevent default behavior (like creating a new line or losing focus)
    $(this).blur(); // Trigger the blur event programmatically
    return;
}

// Only handle blur or Enter-triggered blur
if (event.type !== "blur") return;

let id = $(this).data('id');
let column = $(this).attr('data-column'); // Identify 'name' or 'number'
let value = $(this).text().trim(); // Remove extra spaces

// Validation: Check if value is empty
if (value.length === 0) {
    if (column === "cus_number") {
        error("Mobile number is required!");
    }
    return; // Stop execution if value is empty
} else if (value.length !== 11) {
    if (column === "cus_number") {
        error("Mobile number is required 11 digit!");
    }
}


let overlay = document.getElementById("overlay");

// Show overlay (loader)
if (overlay) {
    overlay.style.display = "flex"; // Freeze screen
}

try {
    let res = await axios.post('/transaction_update', {
        id: id,
        column: column,
        value: value
    });

    console.log(res);

    // Success or error message based on response
    if (res.data['status'] === 'success' && res.status === 200) {
        success('Data Updated Successfully');
    } else {
        error("Update failed! Please try again.");
    }
} catch (err) {
    console.error(err);
    error("Something went wrong!");
} finally {
    if (overlay) {
        overlay.style.display = "none"; // Hide loader
    }
}

})




















                        // Reinitialize DataTable AFTER appending new rows, on the CORRECT table: #tableData
                        new DataTable('#tableData', {
                            lengthMenu: [5, 10, 15, 20, 30],
                            order: [
                                [0, 'desc']
                            ], // Optional: Preserve initial sorting if needed
                            searching: false // Optional: Keep searching disabled if it was initially
                        });
                    }

                    // Hide the loader after completing the task
                    overlay.style.display = "none";
                }, 1000);
            } else {
                console.log("Overlay not found!");
            }
        });






















        new DataTable('#tableData', {

            lengthMenu: [10, 20, 30],
            order: [
                [0, 'desc']
            ],
            searching: false
        });

    }
</script>
