{{-- {{$numberDetails}} --}}

<div class="container mt-5">





    <div class="mb-4 mx-5 mt-5">
         <a class="BackBtn btn btn-secondary mt-4">Back</a>

     </div>





     {{-- <div class="container">
        <div class="row justify-content-between">
            <h2 class="mb-4 text-center">Transaction Table</h2>

            <!-- Create Button Row -->
            <div class="col-12 mb-3">
                <button id="createtransactionbutton" class="float-end btn  btn-success mx-3">Create</button>
            </div>

            <!-- Filter Inputs Row -->
            <div class="col-12">
                <div class="row g-2">
                    <div class="col-lg-4 col-md-6 col-12">
                        <label for="start-date" class="form-label">Start Date</label>
                        <input type="date" id="start-date" class="form-control">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label for="end-date" class="form-label">End Date</label>
                        <input type="date" id="end-date" class="form-control">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label for="account_type" class="form-label">Account Type</label>
                        <select class="form-control" id="account_type" name="account_type">
                            <option value="" selected>Select Account Type</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <button class="btn btn-primary w-100 mt-4" id="AgentNumberList">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="container">
        <div class="row justify-content-between">
            <h2 class="mb-4 text-center">Transaction Table</h2>

            <!-- Filter Inputs Row for Start Date and End Date -->
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

            <!-- Filter Inputs Row for Account Type and Search Button -->
            <div class="col-12 mt-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="account_type" class="form-label">Account Type</label>
                        <select class="form-control" id="account_type" name="account_type">
                            <option value="" selected>Select Account Type</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <button class="btn btn-primary w-100 mt-4" id="AgentNumberList">Search</button>
                    </div>
                </div>
            </div>
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
                         <th  style="text-align: center;">Account Type</th>
                         <th  style="text-align: center;">Amount</th>
                         <th  style="text-align: center;">Payment Method</th>
                         <th  style="text-align: center;">Date</th>
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





         $("#viewtransactionbutton").on('click', function() {
             //    let id= $(this).data('id')
             //    alert(id)

             let overlay = document.getElementById("overlay");

 if (overlay) {
     overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
     // Redirect after 1 second
     setTimeout(function() {
         $("#view-transaction-modal").modal('show')
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
    lengthMenu: [100, 200, 300],
    order: [[0, 'desc']], // 0 = First column, 'desc' = Descending order
    searching: false, // সার্চ অপশন নিষ্ক্রিয় করা হয়েছে
});


     }





 </script>
