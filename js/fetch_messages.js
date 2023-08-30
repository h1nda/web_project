import { permanent, temporarily } from "./let_by_chat.js";
function fetchMessages() {
  const fd = new FormData();
  fd.append("qid", qid);
  fetch("includes/fetch_messages.php", {
    method: "POST",
    body: fd,
  })
    .then((response) => response.json())
    .then((json_resp) => {
      var messages = json_resp["messages"];
      var is_owner = json_resp["is_owner"];

      var messageContainer = document.getElementById("message-container");
      messageContainer.innerHTML = "";

      messages.forEach((message) => {
        var messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        if (message.private == 1) {
          messageDiv.classList.add("private");
        }

        var timestampSpan = document.createElement("span");
        timestampSpan.classList.add("timestamp");
        timestampSpan.textContent = message.timestamp;

        var nameSpan = document.createElement("span");
        nameSpan.classList.add("name");
        nameSpan.textContent = message.uid;

        messageDiv.appendChild(timestampSpan);
        if (is_owner && message.sid != null) {
          const dropdown = document.createElement("div");
          dropdown.classList.add("dropdown");

          const dropdownList = document.createElement("div");
          dropdownList.classList.add("dropdown-content");

          const letInLink = document.createElement("a");
          letInLink.classList.add("let-in");
          letInLink.textContent = "Let in";
          letInLink.setAttribute("id", message.sid);
          permanent(letInLink);

          const letInTemporarilyLink = document.createElement("a");
          letInLink.classList.add("let-in-temp");
          letInTemporarilyLink.textContent = "Let in temporarily";
          letInTemporarilyLink.setAttribute("id", message.sid);
          temporarily(letInTemporarilyLink);

          dropdownList.appendChild(letInLink);

          dropdownList.appendChild(letInTemporarilyLink);

          nameSpan.appendChild(dropdownList);

          dropdown.appendChild(nameSpan);
          messageDiv.appendChild(dropdown);
        } else {
          messageDiv.appendChild(nameSpan);
        }

        var textDiv = document.createElement("div");
        textDiv.classList.add("text");
        textDiv.textContent = message.text;

        messageDiv.appendChild(textDiv);

        messageContainer.appendChild(messageDiv);
      });

      messageContainer.scrollTop = messageContainer.scrollHeight;
    })
    .catch((error) => {
      console.error("Error fetching messages:", error);
    });
}

window.addEventListener("load", function () {
  fetchMessages();
  setInterval(fetchMessages, 2500);
});
