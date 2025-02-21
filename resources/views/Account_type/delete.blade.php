<div id="delete-type-Modal" class="modal fade p-4">
    <div class="modal-dialog modal-confirm">
      <div class="modal-content p-4">
        <div class="modal-header">
          <h5 class="modal-title text-center w-100">Are you sure?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body text-center">
          <p>Do you really want to delete these records? This process cannot be undone.</p>
        </div>


        <input type="text" id="deletetypeId" class="d-none">

        <div class="m-4">
          <button type="button" id="delete-type-modal" class="btn btn-info w-45" data-bs-dismiss="modal">Cancel</button>
          <button type="button" onclick="DeleteType()" class="btn btn-danger w-45">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <div class="overlay" id="overlay">
    <div class="loader"></div>
  </div>


<script>

    async function DeleteType(){

let id = document.getElementById('deletetypeId').value
        console.log(id)

        let overlay = document.getElementById("overlay");


        if (overlay) {
            overlay.style.display = "flex"; // 🟢 Show overlay and freeze screen
            // Redirect after 1 second
            setTimeout(async function() {
                let res = await axios.post('/account_type_destroy', {
                    id: id
                })
                console.log(res)
                if (res.data['status'] === 'success' && res.status === 200) {
                    success("Data deleted successfully")
                    AccountTypeList()
                    document.getElementById("delete-type-modal").click()

                } else {
                    error("Data not Deleted")
                }
                overlay.style.display = "none"; // 🔴 Hide loader after redirection
            }, 1000);

        } else {
            console.log("❌ Overlay not found!");
        }

    }

</script>


