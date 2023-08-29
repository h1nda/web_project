import { callRemoval } from "./remove.js";
var countdown = 60;
var timerInterval; // Declare timerInterval here

function updateTimer() {
    var minutes = Math.floor(countdown / 60);
    var seconds = countdown % 60;
    document.getElementById("countdown").textContent = `${minutes}:${seconds.toString().padStart(2, "0")}`;
}

function studentRemoved_(qid, sid) {
    let fd = new FormData();
    fd.append("sid", sid);
    // Create an object to send as POST data
    // Send AJAX request using fetch
    fetch("includes/check_user_waiting.php", {
        method: "POST",
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'Student left' && data.student_id !== "undefined") {
            clearTimer(qid, sid);
        }
    })
    .catch(error => {
        console.log(error);
    });
}

function clearTimer(qid, sid) {
    clearInterval(timerInterval); // Stop the timer
    countdown = 60;
    callRemoval(qid, sid);
    document.getElementById("countdown").textContent = "1:00";
    document.getElementById("timer").style.display = "none";
}

export function startTimer(qid, sid) {
    document.getElementById("timer").style.display = "block";
    timerInterval = setInterval(function() { // Assign to timerInterval here
        countdown--;
        updateTimer();
        studentRemoved_(qid, sid);

        if (countdown === 0) {
            clearTimer(qid, sid);
        }
    }, 1000); // Update every 1 second
}
