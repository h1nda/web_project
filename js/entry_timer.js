import { callRemoval } from "./remove.js";
var countdown = 60;
var timerInterval;

function updateTimer() {
  var minutes = Math.floor(countdown / 60);
  var seconds = countdown % 60;
  document.getElementById("countdown").textContent = `${minutes}:${seconds
    .toString()
    .padStart(2, "0")}`;
}

function studentRemoved_(qid, sid) {
  let fd = new FormData();
  fd.append("sid", sid);
  fetch("includes/check_user_waiting.php", {
    method: "POST",
    body: fd,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.message === "Student left" && data.student_id !== "undefined") {
        clearTimer(qid, sid);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

function clearTimer(qid, sid, temporary = false) {
  clearInterval(timerInterval);
  countdown = 60;
  if (!temporary) {
    callRemoval(qid, sid);
  }

  document.getElementById("countdown").textContent = "1:00";
  document.getElementById("timer").style.display = "none";
}

export function startTimer(qid, sid, temporary = false) {
  document.getElementById("timer").style.display = "block";
  timerInterval = setInterval(function () {
    countdown--;
    updateTimer();
    studentRemoved_(qid, sid);

    if (countdown === 0) {
      clearTimer(qid, sid, temporary);
    }
  }, 1000);
}
