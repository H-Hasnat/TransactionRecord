<!-- Modal -->
<div class="modal fade" id="create-agentDetails-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Agent Number Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button class="btn btn-primary" id="AgentNumberList">Search</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>


                <!-- Result Table -->
                <div class="mt-4">
                    <table class="table   table-bordered table-striped" id="agent_tableData">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Agent Number</th>

                                <th style="text-align: center;">Transaction Amount</th>
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

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>


<script>


$("#AgentNumberList").on('click', async function () {
    console.log("hi");
    let start_date = document.getElementById("start-date").value;
    let end_date = document.getElementById("end-date").value;
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
            }{
                // Send the request to the server with start and end date
                let res = await axios.post('/agent_number_details', {
                    start_date: start_date,
                    end_date: end_date
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
                for (let agentNumber in res.data['agent_sums']) {
                    if (res.data['agent_sums'].hasOwnProperty(agentNumber)) {
                        let amount = res.data['agent_sums'][agentNumber]['amount'];
                        let type = res.data['agent_sums'][agentNumber]['type'];
                        // console.log(`Agent Number: ${agentNumber}, Amount: ${amount}`);

                        // Append a new row to the table
                        let row = `
                            <tr>
                                <td style="text-align: center;">${agentNumber}</td>

                                <td style="text-align: center;">${amount}</td>
                            </tr>`;
                        agenttableList.append(row);
                    }
                }

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












// $("#DownloadTable").on("click", async function () {
// let start_date = document.getElementById("start_date").value;
// let end_date = document.getElementById("end_date").value;

// try {

//     if(start_date.length===0 || end_date.length==0){
//         error('start date and end date required.')
//     }else{
//         // Send POST request and handle binary response
//         let response = await axios.post(
//         "/history/download",
//         { start_date: start_date, end_date: end_date },
//         { responseType: "blob" } // Important: Set response type to blob for binary data
//     );

//     // Create a download link
//     const url = window.URL.createObjectURL(new Blob([response.data]));
//     const link = document.createElement("a");
//     link.href = url;
//     link.setAttribute("download", "transaction_history.pdf");
//     document.body.appendChild(link);
//     link.click();
//     document.body.removeChild(link);
//     }

// } catch (error) {
//     console.error("Error downloading the PDF:", error);
// }
// });

// $("#printTable").on("click", async function () {
// let startDate = document.getElementById("start_date").value; // Get start date
// let endDate = document.getElementById("end_date").value; // Get end date

// if(startDate.length===0 || endDate.length==0){
//         error('start date and end date required.')
// }else{
// let printContent = `
//     <div>
//         <h2 class="text-center">Transaction History</h2>
//         <h4>Start Date: ${startDate}</h4>
//         <h4>End Date: ${endDate}</h4>
//         <h4>Total Amount: ${document.getElementById('totalamount').innerHTML} Taka</h4>
//         ${document.getElementById('tableData').outerHTML}
//     </div>`;

// let newWindow = window.open("", "_blank");
// newWindow.document.write(`
//     <html>
//         <head>
//             <title>Transaction History</title>
//             <style>
//                 table { width: 100%; border-collapse: collapse; margin: 20px 0; }
//                 th, td { border: 1px solid #000; padding: 8px; text-align: center; }
//                 th { background-color: #343a40; color: white; }
//                 body { font-family: Arial, sans-serif; margin: 20px; }
//             </style>
//         </head>
//         <body>${printContent}</body>
//     </html>`);
// newWindow.document.close();
// newWindow.focus();
// newWindow.print();
// }
// })
</script>
