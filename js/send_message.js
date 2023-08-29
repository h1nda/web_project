document.getElementById("message-form").addEventListener("submit", function(event) {
    event.preventDefault();
    const fd = new FormData(event.target);

    fetch("includes/send_message.php", {
        method: "POST",
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        document.getElementById("message-form").reset();
    })
    .catch(error => {
        console.error(error);
    });
});
