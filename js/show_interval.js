const entryMethodRadio = document.getElementsByName("entry_method");
const entryIntervalInput = document.getElementById("entryIntervalInput");

for (const radio of entryMethodRadio) {
    radio.addEventListener("change", () => {
        if (radio.value === "interval") {
            entryIntervalInput.style.display = "block";
        } else {
            entryIntervalInput.style.display = "none";
        }
    });
}