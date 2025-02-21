
<!-- Modal -->
<div class="modal fade" id="create-transaction-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Create Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Number</label>
                        <input type="text" class="form-control" id="cus_number" name="number" required>
                    </div>



                    <div class="mb-3">
                        <label for="number" class="form-label">Customer</label>

                        <select name="" id="customerSelect" class="form-select">
                            <option value=" ">Select</option>

                        </select>


                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Agent Number</label>

                        <select name="" id="numberSelect" class="form-select">


                        </select>


                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Payment Method</label>

                        <select name="" id="paymentSelect" class="form-select">


                        </select>


                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" name="number" required>
                    </div>
                    <button id="modal-close" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-success" onclick="CustomerCreate()">Save</button>

            </div>
        </div>
    </div>
</div>


<script>

fillCustomerSelect()
async function fillCustomerSelect(){

    let res=await axios.get('/number_details')
    console.log(res)

    let res1=await axios.get('/payment_details')
    console.log(res1)

    res.data['data'].forEach(function(item,indx){

        let option=`
     <option value="${item['id']}">${item['agent_number']} - ${item['type']['name']}</option>
    `

    $("#numberSelect").append(option)

    })


    res1.data['data'].forEach(function(item,indx){

let option=`
<option value="${item['id']}">${item['type']}</option>
`

$("#paymentSelect").append(option)

})


let res2=await axios.get('/customer_details')
    console.log(res1)

    // let res1=await axios.get('/_details')
    // console.log(res1)

    res2.data['data'].forEach(function(item,indx){

        let option=`
     <option value="${item['id']}">${item['name']} - ${item['number']} </option>
    `

    $("#customerSelect").append(option)

    })


}




async function CustomerCreate(){

let name=document.getElementById('name').value
let cus_number=document.getElementById('cus_number').value
let number_details_id=document.getElementById('numberSelect').value
let payment_details_id=document.getElementById('paymentSelect').value
let cus_select=document.getElementById("customerSelect").value
let amount=document.getElementById('amount').value


let res=await axios.post("/customer_by_id",{id:cus_select})

console.log(res)
let overlay = document.getElementById("overlay");

// console.log(cus_select)

if(cus_number.length !=0 && cus_select != 0){
    error("select one customer information")
}
else if(cus_select !=0 ){
   name=res.data['name']
   cus_number=res.data['number']

   if(amount.length===0){
    error("amount required")
   }
   else{
    if (overlay) {
        overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen

    setTimeout(async function() {
        let res=await axios.post('/transaction_store',{name:name,cus_number:cus_number,number_details_id:number_details_id,payment_details_id:payment_details_id,amount:amount})

    console.log(res)

    if(res.data['status']==='success' && res.status===200){
        success("Data added successfully")
        TransactionList()
        document.getElementById("modal-close").click()

    }else{
        error('error')
    }

        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}

   }



}else{
    if(cus_number.length != 11){
        error("number required 11 digit")
    }else{
        if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(async function() {
        let res=await axios.post('/transaction_store',{name:name,cus_number:cus_number,number_details_id:number_details_id,payment_details_id:payment_details_id,amount:amount})

    console.log(res)

    if(res.data['status']==='success' && res.status===200){
        success("Data added successfully")
        TransactionList()
        document.getElementById("modal-close").click()

    }else{
        error('error')
    }

        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}
    }


    }
}

























</script>

