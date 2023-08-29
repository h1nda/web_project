
// Get all elements with class 'queue-button'
var queueButtons = document.querySelectorAll(".queue-button");
// Attach event listeners to each 'queue-button'
queueButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        var qid = button.getAttribute("id");
        window.location.href = `queues.php?qid=${qid}`;
    });
});


// Get all elements with class 'queue-button'
var queueButtons = document.querySelectorAll(".remove-button");
// Attach event listeners to each 'queue-button'
queueButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        if (window.confirm("Are you sure you want to delete this queue? ")) {
        var qid = button.getAttribute("id");
        let fd = new FormData();
        fd.append("qid", qid);
        // Create an object to send as POST data
        // Send AJAX request using fetch
        fetch("includes/remove_queue.php", {
            method: "POST",
            body: fd
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            location.reload();
        })
        .catch(error => {
            console.log(error);
        });
    }
    });
});

