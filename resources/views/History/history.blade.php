
@extends('layout')

@section('content')

<div class="mb-4 mx-5 mt-5">
    <a class="BackBtn btn btn-secondary mt-4 mb-5">Back</a>
</div>

<div class="container mt-4 ">
    <div class="row bg-info p-4 rounded shadow-sm p-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label text-white">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label text-white">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
        </div>
        <div class="col-md-4 d-flex align-items-end mt-4">
            <button class="btn btn-primary w-100 p-2" onclick="historyList()">Search</button>
        </div>
    </div>
</div>

<div class="card px-5 py-5 mt-4 shadow-sm">
    <div class="row justify-content-between">
        <h2 class="mb-4 text-center">Transaction History</h2>
    </div>

    <div class="row justify-content-between mb-3">
        <h4>Total In:  <span id="totalin" class="fw-bold"> 0</span>(+) taka</h4>
        <h4>Total Out:  <span id="totalout" class="fw-bold">0</span>(-) taka</h4>
        <h4>Total Amount: <span id="totalamount" class="fw-bold">0</span> taka</h4>

    </div>

    <div class="text-end">
            <button class="btn btn-outline-success" id="DownloadTable">Download</button>
        <button class="btn btn-outline-primary" id="printTable">Print</button>
    </div>



    <div class="table-responsive mt-4">
        <table class="table table-bordered border-black" id="tableData">
            <thead class="table-dark">
                <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Number</th>
                <th style="text-align: center;">Agent Number</th>
                <th style="text-align: center;">Payment Method</th>
                <th style="text-align: center;">Amount</th>
            </tr>
        </thead>
        <tbody id="tableList"></tbody>
    </table>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>

<script>


    async function historyList() {
        let start_date = document.getElementById("start_date").value;
        let end_date = document.getElementById("end_date").value;

        let overlay = document.getElementById("overlay");

        if (overlay) {
            overlay.style.display = "flex"; // Show overlay loader

            setTimeout(async function () {
                if (start_date > end_date) {
                    alert("End Date must be greater than Start Date!");
                } else {
                    let res = await axios.post('/historylist', { start_date: start_date, end_date: end_date });
                    console.log(res)
                    let tableList = $('#tableList');
                    let tableData = $('#tableData');

                    tableData.DataTable().destroy();
                    tableList.empty();

                    res.data['transactions'].forEach(function (item, indx) {
                        let row = `
                            <tr>
                                <td style="text-align: center;">${indx + 1}</td>
                                <td style="text-align: center;">${item['name']}</td>
                                <td style="text-align: center;">${item['cus_number']}</td>
                                <td style="text-align: center;">${item['number']['agent_number']} </br> (${item['number']['type1']['name']})</td>
                                <td style="text-align: center;">${item['payment_method']['type']}</td>
                                <td style="text-align: center;">${item['amount']}</td>
                            </tr>`;
                        tableList.append(row);
                    });

                    // Update total amount
                    document.getElementById('totalamount').innerHTML = res.data['total_amount'];
                    document.getElementById('totalin').innerHTML = res.data['total_in'];
                    document.getElementById('totalout').innerHTML = res.data['total_out'];


                    // Reinitialize DataTable
                    new DataTable('#tableData', {
                        lengthMenu: [30,60,90]
                    });
                }

                overlay.style.display = "none"; // Hide loader
            }, 1000);
        } else {
            console.log("Overlay not found!");
        }
    }


    $("#DownloadTable").on("click", async function () {
    let start_date = document.getElementById("start_date").value;
    let end_date = document.getElementById("end_date").value;

    try {

        if(start_date.length===0 || end_date.length==0){
            error('start date and end date required.')
        }else{
            // Send POST request and handle binary response
            let response = await axios.post(
            "/history/download",
            { start_date: start_date, end_date: end_date },
            { responseType: "blob" } // Important: Set response type to blob for binary data
        );

        // Create a download link
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "transaction_history.pdf");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        }

    } catch (error) {
        console.error("Error downloading the PDF:", error);
    }
});

$("#printTable").on("click", async function () {
    let startDate = document.getElementById("start_date").value; // Get start date
    let endDate = document.getElementById("end_date").value; // Get end date

    if(startDate.length===0 || endDate.length==0){
            error('start date and end date required.')
    }else{
    let printContent = `
        <div>
            <h2 class="text-center">Transaction History</h2>
            <h4>Start Date: ${startDate}</h4>
            <h4>End Date: ${endDate}</h4>
            <h4>Total In (+) : ${document.getElementById('totalin').innerHTML} Taka</h4>
            <h4>Total Out (-) : ${document.getElementById('totalout').innerHTML} Taka</h4>
            <h4>Total Amount: ${document.getElementById('totalamount').innerHTML} Taka</h4>
            ${document.getElementById('tableData').outerHTML}
        </div>`;

    let newWindow = window.open("", "_blank");
    newWindow.document.write(`
        <html>
            <head>
                <title>Transaction History</title>
                <style>
                    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    th, td { border: 1px solid #000; padding: 8px; text-align: center; }
                    th { background-color: #343a40; color: white; }
                    body { font-family: Arial, sans-serif; margin: 20px; }
                </style>
            </head>
            <body>${printContent}</body>
        </html>`);
    newWindow.document.close();
    newWindow.focus();
    newWindow.print();
}

})

</script>

@endsection
