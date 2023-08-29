var closeButton = document.getElementById("close-button");
    
    if (closeButton) {
        closeButton.addEventListener("click", function() {
            var fd = new FormData();
            fd.append("qid", qid);
            
            // Send AJAX request using fetch
            fetch("includes/close.php", {
                method: "POST",
                body: fd
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Handle response if needed
            })
            .catch(error => {
                console.log(error); // Handle errors if any
            });
        });
    };
