{{-- {{$numberDetails}} --}}

<div class="container mt-5">
    <div class="mb-4">
        <a class="BackBtn btn btn-secondary mt-4">Back</a>
    </div>

    <div class="card p-4 py-5">
        <div class="row justify-content-between">
            <h2 class="mb-4 text-center">Account Type Table</h2>
            <div class="align-items-center col">
                <button id="createtypebutton" class="float-end btn btn-success">Create</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered border-black" id="tableData">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Name</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableList">
                    <!-- Table data will go here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>


<script>
    AccountTypeList()
    async function AccountTypeList() {


        let res = await axios.get('/account_type_details')
        console.log(res)

        let tableList = $('#tableList')
        let tableData = $('#tableData')


        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, indx) {

            let row = `<tr>
        <td style="text-align: center;">${indx+1}</td>
        <td style="text-align: center;" contenteditable="true"  class="editable" data-id="${item['id']}" data-column="name">${item['name']}</td>
        <td style="text-align: center;">

            <button data-id="${item['id']}" class="btn deletetypeBtn btn-sm btn-outline-danger">Delete</button>

            </td>
     </tr>`
            tableList.append(row)

        });





        $("#createtypebutton").on('click', async function() {


            let overlay = document.getElementById("overlay");

            if (overlay) {
                overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
                // Redirect after 1 second
                setTimeout(function() {
                    $("#create-type-modal").modal('show')
                    overlay.style.display = "none"; // 🔴 Hide loader after redirection
                }, 1000);

            } else {
                console.log("❌ Overlay not found!");
            }

            //    console.log(id)

        });



        $('.deletetypeBtn').on('click', async function() {



            let overlay = document.getElementById("overlay");
            let id = $(this).data('id');

            if (overlay) {
                overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
                // Redirect after 1 second
                setTimeout(function() {
                    $("#delete-type-Modal").modal('show')
                    $("#deletetypeId").val(id);
                    overlay.style.display = "none"; // 🔴 Hide loader after redirection
                }, 1000);

            } else {
                console.log("❌ Overlay not found!");
            }
        })






        $(".editable").on('keydown blur', async function(event) {
            // Handle Enter key to prevent leaving the editable mode
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



            let overlay = document.getElementById("overlay");

            // Show overlay (loader)
            if (overlay) {
                overlay.style.display = "flex"; // Freeze screen
            }

            try {
                let res = await axios.post('/account_type_update', {
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
        });




        new DataTable('#tableData', {

            lengthMenu: [10,20,30]
        });

    }
</script>
