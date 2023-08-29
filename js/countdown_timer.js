import { sendInvite } from "./send_invite.js";

var countdown = intervalInMinutes * 60;
var timerInterval;

function restartCountdown(sid) {
    clearInterval(timerInterval); // Stop the timer
    countdown = intervalInMinutes * 60;
    updateCountDown();
    tryCountdown(sid);
}

function studentRemoved(sid) {
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
        console.log(data);
        if (data.message === "Student left" && data.student_id == sid) {
            restartCountdown(sid);
        }
    })
    .catch(error => {
        console.log(error);
    });
}

function updateCountDown() {
    var minutes = Math.floor(countdown / 60);
    var seconds = countdown % 60;
    document.getElementById("interval_countdown").textContent = `${minutes}:${seconds.toString().padStart(2, "0")}`;
}

function startCountdown(sid) {
    timerInterval = setInterval(function() {
        countdown--;
        updateCountDown();
        studentRemoved(sid);

        if (countdown === 0) {
            restartCountdown(sid);
        }
    }, 1000); // Update every 1 second
}

function tryCountdown(sid) {
    const numStudentsSpan = document.getElementById("numStudents");
    const interval = setInterval(() => {
        if (parseInt(numStudentsSpan.textContent) > 0) {
            clearInterval(interval); // Stop the interval
            startCountdown(sid); // Call the startCountdown function
        }
    }, 1000); // Check every 1 second
}

sendInvite(qid).then(sid1 => {
    tryCountdown(sid1);
});
