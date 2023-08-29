import { callRemoval } from "./remove.js";
import { startTimer } from "./entry_timer.js";
var notif = new Audio("media/link_available.wav");

function pollEntryFlag(qid, sid) {
    let fd = new FormData();
    fd.append("sid", sid);
    var interval = setInterval(function() {
        fetch("includes/check_for_entry.php", {
            method: "POST",
            body: fd
        })
        .then(response => response.json())
        .then(data => {
            if (data.enter > 0) {
                clearInterval(interval); // Stop polling
                // Redirect or perform other actions for user entry
                const link = document.getElementById("entryLink");
                link.style.display = "block";
                document.getElementById("timer").style.display = "block";
                notif.play();
                console.log(notif);
                if (data.enter === 2) {
                    
                    link.target="_blank";
                    link.addEventListener("click", function() {
                        link.style.display = "none";
                        
                    });
                    startTimer(qid, sid, true);
                    
                } else {
                    link.addEventListener("click", function() {
                        // Call the removal function
                        callRemoval(qid, sid);
                        // Start the timer
                        startTimer(qid, sid);
                        
                    }); 
                }
                
            }
        });
    }, 5000); // Poll every 5 seconds
}

// Call the function to start polling when needed
pollEntryFlag(qid, sid);