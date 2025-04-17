HEAD
const button = document.getElementById("magicButton");
const message = document.getElementById("message");

button.addEventListener("click", () => {
  message.textContent = "congrats";
});
