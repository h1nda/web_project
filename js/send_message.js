document.getElementById("message-form").addEventListener("submit", function(event) {
    event.preventDefault();
    // Create FormData object
    const fd = new FormData(event.target);
    
    // Send the form data using fetch
    fetch("includes/send_message.php", {
        method: "POST",
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response data as needed
        console.log(data);
        document.getElementById("message-form").reset();
    })
    .catch(error => {
        // Handle errors
        console.error(error);
    });
});
