import { callRemoval } from "./remove.js";
window.addEventListener("beforeunload", function () {
    callRemoval(qid, sid);
});