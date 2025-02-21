
function success(msg){
    Toastify({
        text: msg,
        className: "info",
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        }
      }).showToast();

    }


    function error(msg){
        Toastify({
            text: msg,
            className: "info",
            style: {
              background: "red",
            }
          }).showToast();

    }
