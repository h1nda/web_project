var check_session = setInterval(function(){
    fetch("includes/check_user_session.php", {
        method: "GET"
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Session expired and destroyed") {
            alert("You have been removed from the queue.");
            window.location.href = "login.php";
        }
    }
    ).catch(error => {
        console.log(error);
    }
    );
    
}, 100000);