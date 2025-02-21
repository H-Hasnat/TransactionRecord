
<!-- Modal -->
<div class="modal fade" id="create-type-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Create Account Type </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <button id="modal-close" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-success" onclick="Account_typeCreate()">Save</button>

            </div>
        </div>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="loader"></div>
</div>

<script>


async function Account_typeCreate(){

let name=document.getElementById('name').value



let overlay = document.getElementById("overlay");

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(async function() {
        let res=await axios.post('/account_type_store',{name:name})

console.log(res)


if(res.data['status']==='success' && res.status===200){
    success("Data added successfully")
    AccountTypeList()
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

