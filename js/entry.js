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
                clearInterval(interval);
            
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
                        callRemoval(qid, sid);
                        startTimer(qid, sid);
                        
                    }); 
                }
                
            }
        });
    }, 5000);
}

pollEntryFlag(qid, sid);