function pollWaitingStudents(qid) {
    fd = new FormData();
    fd.append("qid", qid);
    setInterval(function() {
        fetch("includes/num_waiting_students.php", {
            method: "POST",
            body: fd
        })
        .then(response => response.json())
        .then(data => {
            var numStudents = data.num_students;
            if (numStudents === 0) {
                document.getElementById("no-students").style.display = "block";
                document.getElementById("students").style.display = "none";
            } else {
            // Update the UI with the number of waiting students
            document.getElementById("students").style.display = "block";
            document.getElementById("no-students").style.display = "none";
            }
            document.getElementById("numStudents").textContent = numStudents;
        });
    }, 5000); // Poll every 10 seconds
}

// Call the function to start polling when needed
pollWaitingStudents(qid); // Pass the PHP variable value