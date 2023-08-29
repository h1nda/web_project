import { callRemoval } from "./remove.js";
import { startTimer } from "./entry_timer.js";

function pollEntryFlag(qid, sid) {
    console.log(qid);
    console.log(sid);
    let fd = new FormData();
    fd.append("sid", sid);
    var interval = setInterval(function() {
        fetch("includes/check_for_entry.php", {
            method: "POST",
            body: fd
        })
        .then(response => response.json())
        .then(data => {
            if (data.enter === true) {
                clearInterval(interval); // Stop polling
                // Redirect or perform other actions for user entry
                document.getElementById("entryLink").style.display = "block";
                document.getElementById("timer").style.display = "block";
                document.getElementById("entryLink").addEventListener("click", function() {
                    // Call the removal function
                    callRemoval(qid, sid);
                });

                // Start the timer
                startTimer(qid, sid);
            }
        });
    }, 5000); // Poll every 5 seconds
}

// Call the function to start polling when needed
pollEntryFlag(qid, sid);