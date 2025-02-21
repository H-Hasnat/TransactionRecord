{{-- {{$numberDetails}} --}}

<div class="container mt-5">





    <div class="mb-4 mt-5">
        <a class="BackBtn btn btn-secondary mt-4">Back</a>

    </div>

    <div class="">
        <div class="row justify-content-between ">
            <h2 class="mb-4 text-center">Transaction Table</h2>
            <div class="align-items-center col">
                <button id="createtransactionbutton" class="float-end btn  btn-success">Create</button>
            </div>
        </div>



        <div class="table-responsive">
            <table class="table table-bordered border-black" id="tableData">
                <thead class="table-dark">
                    <tr>
                        <th  style="text-align: center;">#</th>
                        <th  style="text-align: center;">Name</th>
                        <th  style="text-align: center;">Customer Number</th>
                        <th  style="text-align: center;">Agent Number</th>
                        <th  style="text-align: center;">Amount</th>
                        <th  style="text-align: center;">Payment Method</th>
                        <th  style="text-align: center;">Actions</th>
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


        let res = await axios.get('/transaction_details')
        console.log(res)

        let tableList = $('#tableList')
        let tableData = $('#tableData')


        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, indx) {

            let row = `<tr>
        <td style="text-align: center;">${indx+1}</td>
        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="name">${item['name']}</td>
        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="cus_number">${item['cus_number']}</td>
        <td style="text-align: center;" class="readonly">${item['number']['agent_number']} </br> (${item['number']['type1']['name']})</td>
        <td style="text-align: center;" contenteditable="true"  class="edittransactionBtn" data-id="${item['id']}" data-column="amount">${item['amount']}</td>
        <td style="text-align: center;" class="readonly">${item['payment_method']['type']}</td>
        <td style="text-align: center;">

            <button data-id="${item['id']}" class="btn deletetransactionBtn btn-sm btn-outline-danger">Delete</button>

            </td>
     </tr>`
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




        new DataTable('#tableData', {

            lengthMenu: [10,20,30]
        });

    }





</script>
