import {startTimer} from "./entry_timer.js"
export function permanent(li) {
    li.addEventListener("click", function(e) {
        e.preventDefault();
        var sid = li.getAttribute("id");
        let fd = new FormData();
        fd.append("sid", sid);
        fd.append("qid", qid);
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
            } else if (data.message === 'Student not in queue') {
                alert("This student is not in the queue!");
            } else {
                startTimer(qid, data.student_sid);
                return data.student_sid;
            }
            
        })
        .catch(error => {
            console.log(error);
        });
    });
}

export function temporarily(li) {
    li.addEventListener("click", function(e) {
        e.preventDefault();
        var sid = li.getAttribute("id");
        let fd = new FormData();
        fd.append("sid", sid);
        fd.append("qid", qid);
        fd.append("temporary", 1);
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
            } else if (data.message === 'Student not in queue') {
                alert("This student is not in the queue!");
            } else {
                startTimer(qid, data.student_sid);
                return data.student_sid;
            }
            
        })
        .catch(error => {
            console.log(error);
        });
    });
}

