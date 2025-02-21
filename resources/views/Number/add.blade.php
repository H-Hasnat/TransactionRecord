
<!-- Modal -->
<div class="modal fade" id="create-number-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Agent Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">


                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="agent_name" name="" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Number</label>
                        <input type="text" class="form-control" id="agent_number" name="" required>
                    </div>




                    <div class="mb-3">
                        <label for="number" class="form-label">Account Type</label>

                        <select name="" id="accountSelect" class="form-select">


                        </select>


                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="agent_amount" name="number" required>
                    </div>


                    <button id="modal-close" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-success" onclick="NumberCreate()">Save</button>
            </div>
        </div>
    </div>
</div>


<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>


<script>




fillNumberSelect()
async function fillNumberSelect(){

    let res=await axios.get('/account_type_details')
    console.log(res)

    // let res1=await axios.get('/_details')
    // console.log(res1)

    res.data['data'].forEach(function(item,indx){

        let option=`
     <option value="${item['id']}">${item['name']}</option>
    `

    $("#accountSelect").append(option)

    })









}



async function NumberCreate(){

let number=document.getElementById('agent_number').value
let account_type=document.getElementById('accountSelect').value
let amount=document.getElementById('agent_amount').value
let name=document.getElementById('agent_name').value




let overlay = document.getElementById("overlay");

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(async function() {
        let res=await axios.post('/number_store',{agent_number:number,account_type_id:account_type,amount:amount,name:name})

console.log(res)
// console.log(name)
// console.log(number)
if(number.length > 20){
    error("Number required maximum 20 digit")
}else if(amount.length==0){
    error('Give amount')
}
else if(res.data['status']==='success' && res.status===200){
    success("Data added successfully")
    NumberList()
    document.getElementById("modal-close").click()

}else{
    error('Data not added')
}
        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}







}


</script>

