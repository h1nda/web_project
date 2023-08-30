import { sendInvite } from "./send_invite.js";

var countdown = intervalInMinutes * 60;
var timerInterval;

function restartCountdown() {
  clearInterval(timerInterval);
  countdown = intervalInMinutes * 60;
  sendInvite(qid);
  updateCountDown();
  startCountdown();
}

function updateCountDown() {
  var minutes = Math.floor(countdown / 60);
  var seconds = countdown % 60;
  document.getElementById(
    "interval_countdown"
  ).textContent = `${minutes}:${seconds.toString().padStart(2, "0")}`;
}

function startCountdown() {
  const numStudentsSpan = document.getElementById("numStudents");
  const interval = setInterval(() => {
    if (parseInt(numStudentsSpan.textContent) > 0) {
      clearInterval(interval); // Stop the interval
      timerInterval = setInterval(function () {
        countdown--;
        updateCountDown();
        if (countdown === 0) {
          restartCountdown();
        }
      }, 1000); // Update every 1 second
    }
  }, 1000); // Check every 1 second
}
startCountdown();
