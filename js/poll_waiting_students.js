function pollWaitingStudents(qid) {
  fd = new FormData();
  fd.append("qid", qid);
  setInterval(function () {
    fetch("includes/waiting_students.php", {
      method: "POST",
      body: fd,
    })
      .then((response) => response.json())
      .then((data) => {
        var numStudents = data.num_students;
        if (numStudents === 0) {
          document.getElementById("no-students").style.display = "block";
          document.getElementById("students").style.display = "none";
        } else {
          document.getElementById("students").style.display = "block";
          document.getElementById("no-students").style.display = "none";
        }
        document.getElementById("numStudents").textContent = numStudents;
      });
  }, 5000);
}

pollWaitingStudents(qid);
