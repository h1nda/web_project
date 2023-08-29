function fetchMessages() {
    const fd = new FormData();
    fd.append("qid", qid);
    fetch("includes/fetch_messages.php", {
        method: "POST", 
        body: fd})
        .then(response => response.json())
        .then(messages => {
            var messageContainer = document.getElementById("message-container");
            messageContainer.innerHTML = ""; // Clear existing messages
            
            messages.forEach(message => {
                var messageDiv = document.createElement("div");
                messageDiv.classList.add("message");
            
                var timestampSpan = document.createElement("span");
                timestampSpan.classList.add("timestamp");
                timestampSpan.textContent = message.timestamp;
            
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("name");
                nameSpan.textContent = message.uid;
            
                var textDiv = document.createElement("div");
                textDiv.classList.add("text");
                textDiv.textContent = message.text;
            
                messageDiv.appendChild(timestampSpan);
                messageDiv.appendChild(nameSpan);
                messageDiv.appendChild(textDiv);
            
                messageContainer.appendChild(messageDiv);
            });
            
            
            // Scroll to the bottom
            messageContainer.scrollTop = messageContainer.scrollHeight;
        })
        .catch(error => {
            console.error("Error fetching messages:", error);
        });
}

window.addEventListener("load", function() {
    fetchMessages(); // Fetch messages immediately
    setInterval(fetchMessages, 2500); // Fetch messages every 5 seconds
});
