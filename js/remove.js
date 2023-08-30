export function callRemoval(qid, sid) {
  var fd = new FormData();
  fd.append("qid", qid);
  fd.append("sid", sid);
  fetch("includes/clear_from_queue.php", {
    method: "POST",
    body: fd,
  })
    .then((response) => {
      var data = response.json();
      return data["fn"];
    })
    .catch((error) => {
      console.log(error);
    });
}
