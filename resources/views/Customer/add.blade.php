
<!-- Modal -->
<div class="modal fade" id="create-customer-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Create Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="cus_name" name="" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Number</label>
                        <input type="text" class="form-control" id="cus_number" name="" required>
                    </div>


                    <button id="modal-close" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-success" onclick="CustomerCreate()">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>

<script>





async function CustomerCreate(){

let number=document.getElementById('cus_number').value

let name=document.getElementById('cus_name').value




let overlay = document.getElementById("overlay");

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(async function() {
        let res=await axios.post('/customer_store',{number:number,name:name})

console.log(res)
// console.log(name)
// console.log(number)
if(number.length != 11){
    error("Number required 11 digit")
}
else if(res.data['status']==='success' && res.status===200){
    success("Data added successfully")
  CustomerList()
    document.getElementById("modal-close").click()

}
overlay.style.display = "none"; // 🔴 Hide loader after redirection

    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}







}


</script>

