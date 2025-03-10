<!-- Modal -->
<div class="modal fade" id="view-transaction-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Filter transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- Start Date and End Date Inputs -->

                <div class="mb-3">
                    <label for="start-date" class="form-label">Start Date</label>
                    <input type="date" id="start-date" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="end-date" class="form-label">End Date</label>
                    <input type="date" id="end-date" class="form-control">
                </div>


                <div class="mb-3">
                    <label for="account_type" class="form-label">Account Type</label>
                    <select class="form-control" id="account_type" name="account_type">
                        <option value="" selected>Select Account Type</option>
                        {{-- <option value="savings">Savings</option> --}}

                    </select>
                </div>


                <button class="btn btn-primary" id="AgentNumberList">Search</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>


                <!-- Result Table -->
                <div class="table-responsive mt-4">

                    <div class="row justify-content-between mb-3">
                        <h4>Total In:  <span id="totalin" class="fw-bold"> 0</span>(+) taka</h4>
                        <h4>Total Out:  <span id="totalout" class="fw-bold">0</span>(-) taka</h4>
                        <h4>Total Amount: <span id="totalAmount" class="fw-bold">0</span> taka</h4>

                    </div>


                    <table class="table   table-bordered table-striped" id="agent_tableData">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Customer Number</th>
                                <th style="text-align: center;">Agent Number</th>
                                <th style="text-align: center;">Account Type</th>
                                <th style="text-align: center;">Amount</th>
                                <th style="text-align: center;">Payment Method</th>

                            </tr>
                        </thead>
                        <tbody id="agent_tableList">
                            <!-- Data will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>


            </div>

        </div>
    </div>
</div>


<script>


fillTransactionSelect()
async function fillTransactionSelect(){

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
}



$("#AgentNumberList").on('click', async function () {
    console.log("hi");
    let start_date = document.getElementById("start-date").value;
    let end_date = document.getElementById("end-date").value;
    let account_type=document.getElementById("account_type").value
    console.log(start_date);
    console.log(end_date);

    let overlay = document.getElementById("overlay");

    // Show the overlay loader while fetching data
    if (overlay) {
        overlay.style.display = "flex";

        setTimeout(async function () {
            // Check if end_date is greater than start_date
            if(start_date.length===0){
                error("Start Date required")

            } else if(end_date.length===0){
                error("End Date required")

            }else   if (start_date > end_date) {
                error("End Date must be greater than Start Date!");
            } else if(account_type.value===" "){
                error('account type required')
            }else {
                // Send the request to the server with start and end date
                let res = await axios.post('/filter_transaction', {
                    start_date: start_date,
                    end_date: end_date,
                    account_type:account_type
                });

                console.log(res);

                let agenttableList = $('#agent_tableList');
                let agenttableData = $('#agent_tableData');

                // Destroy existing DataTable if it exists
                if ($.fn.dataTable.isDataTable('#agent_tableData')) {
                    agenttableData.DataTable().clear().destroy(); // Destroy DataTable if exists
                }

                // Clear the table rows before appending new ones
                agenttableList.empty();

                // Loop through the response data and add rows to the table
                // for (let agentNumber in res.data['agent_sums']) {
                //     if (res.data['agent_sums'].hasOwnProperty(agentNumber)) {
                //         let amount = res.data['agent_sums'][agentNumber]['amount'];
                //         let type = res.data['agent_sums'][agentNumber]['type'];
                        // console.log(`Agent Number: ${agentNumber}, Amount: ${amount}`);

                        // Append a new row to the table
                        res.data['transactions'].forEach(function(item){
                            let row = `
                            <tr>
                                <td style="text-align: center;">${item['cus_number']}</td>

                                <td style="text-align: center;">${item['number']['agent_number']}</td>
                                <td style="text-align: center;">${item['number']['type']['name']}</td>

                                <td style="text-align: center;">${item['amount']}</td>
                                <td style="text-align: center;">${item['payment_method']['type']}</td>

                            </tr>`;
                        agenttableList.append(row);
                        })

                        document.getElementById("totalin").innerHTML=res.data['total_in']
                        document.getElementById("totalout").innerHTML=res.data['total_out']

                        document.getElementById("totalAmount").innerHTML=res.data['total_amount']

                //     }
                // }

                // Reinitialize DataTable after appending new rows
                new DataTable('#agent_tableData', {
                    lengthMenu: [5, 10, 15, 20, 30]
                });
            }

            // Hide the loader after completing the task
            overlay.style.display = "none";
        }, 1000);
    } else {
        console.log("Overlay not found!");
    }
});






















</script>

