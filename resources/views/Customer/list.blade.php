

<div class="container mt-5">
    <div class="mb-4">
        <a class="BackBtn btn btn-secondary mt-4">Back</a>
    </div>

    <div class="card px-5 py-5">
        <div class="row justify-content-between">
            <h2 class="mb-4 text-center">Customer Details</h2>
            <div class="text-end">

                <button id="createcusbutton" class="btn btn-success">Create</button>
            </div>
        </div>

        <!-- টেবিল স্ক্রলযোগ্য করার জন্য কনটেইনার -->
        <div class="table-responsive">
            <table class="table table-bordered border-black" id="tableData">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Number</th>
                        <th style="text-align: center;">Name</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableList"></tbody>
            </table>
        </div>
    </div>
</div>



<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>

<script>

    CustomerList()
    async function CustomerList() {


        let res = await axios.get('/customer_details')
        console.log(res)

        let tableList = $('#tableList')
        let tableData = $('#tableData')


        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, indx) {

            let row = `<tr>
        <td style="text-align: center;">${indx+1}</td>

        <td style="text-align: center;" contenteditable="true" class="editable" data-id="${item['id']}" data-column="number">${item['number']}</td>
        <td style="text-align: center;" contenteditable="true"  class="editable" data-id="${item['id']}" data-column="name">${item['name']}</td>

        <td style="text-align: center;">

            <button data-id="${item['id']}" class="btn deletecusBtn btn-sm btn-outline-danger">Delete</button>

            </td>
     </tr>`
            tableList.append(row)

        });







        $("#createcusbutton").on('click', async function() {
            //    let id= $(this).data('id')
            //    alert(id)

            let overlay = document.getElementById("overlay");

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(function() {
        $("#create-customer-modal").modal('show')
        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}

            //    console.log(id)

        });



        $('.deletecusBtn').on('click', async function() {



            let overlay = document.getElementById("overlay");
            let id = $(this).data('id');

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(function() {
        $("#delete-customer-Modal").modal('show')
            $("#deletecusId").val(id);
        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}


        })




        $(".editable").on('keydown blur', async function (event) {
    // Handle Enter key to prevent leaving the editable mode
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
        if (column === "number") {
            error("Mobile number is required!");
        }
        return; // Stop execution if value is empty
    }

    // Validation: Check if number is 11 digits
    if (column === "number" && value.length !== 11) {
        error("Mobile number must be 11 digits!");
        return; // Stop execution if number is invalid
    }

    let overlay = document.getElementById("overlay");

    // Show overlay (loader)
    if (overlay) {
        overlay.style.display = "flex"; // Freeze screen
    }

    try {
        let res = await axios.post('/customer_update', {
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
        // }
    }
}
});






        new DataTable('#tableData', {

            lengthMenu: [10,20,30]
        });

    }




</script>























