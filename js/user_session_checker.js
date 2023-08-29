function checkSession() {
    fetch("includes/check_user_session.php", {
        method: "GET"
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Session expired and destroyed") {
            alert("You have been removed from the queue.");
            window.location.href = "login.php";
        }
        return true;
    }
    ).catch(error => {
        console.log(error);
    }
    );
    return false;
}
var sessionInterval = setInterval(function(){
    if (checkSession()) {
        clearInterval(sessionInterval);
    }
}, 100000);

checkSession();

