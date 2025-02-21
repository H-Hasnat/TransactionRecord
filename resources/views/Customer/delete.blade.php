
<!-- Modal -->
<div id="delete-customer-Modal" class="modal fade p-4">
    <div class="modal-dialog modal-confirm">
      <div class="modal-content p-4">
        <div class="text-center">
          <h4 class="modal-title ">Are you sure?</h4>

        </div>
        <div class="modal-body">
          <p>Do you really want to delete these records? This process cannot be undone.</p>
        </div>
        <input type="text" id="deletecusId" class="d-none">
        <div class="m-4">
          <button type="button" class="btn btn-info" id="delete-customer-modal" data-bs-dismiss="modal">Cancel</button>
          <button type="button" onclick="DeleteCustomer()" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <div class="overlay" id="overlay">
    <div class="loader"></div>
</div>


<script>

    async function DeleteCustomer(){
        let id=document.getElementById('deletecusId').value
        console.log(id)

        let overlay = document.getElementById("overlay");

if (overlay) {
    overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
    // Redirect after 1 second
    setTimeout(async function() {
        let res=await axios.post('/customer_destroy',{id:id})
        if(res.data['status']==='success' && res.status===200){
        success("Data deleted successfully")
        CustomerList()
        document.getElementById("delete-customer-modal").click()

    }else{
    error('Data not deleted')
}
        overlay.style.display = "none"; // 🔴 Hide loader after redirection
    }, 1000);

} else {
    console.log("❌ Overlay not found!");
}



    }

</script>


