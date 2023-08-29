import { startTimer } from "./entry_timer.js";

export function sendInvite(qid) {
    console.log(`Trying to send invite for ${qid}`)
    let fd = new FormData();
    fd.append("qid", qid);
    // Create an object to send as POST data
    // Send AJAX request using fetch
    fetch("includes/invite_student.php", {
        method: "POST",
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.message === 'No students waiting') {
                document.getElementById("no-students").style.display = "block";
                document.getElementById("numStudents").textContent = 0;
                return null;
        } else {
            startTimer(qid, data.student_sid);
            return data.student_sid;
        }
        
    })
    .catch(error => {
        console.log(error);
    });
};

var inviteButton = document.getElementById("invite-button");
if (inviteButton) {
    inviteButton.addEventListener("click", function() {
        sendInvite(qid); // Call the sendInvite function when the button is clicked
    });
};