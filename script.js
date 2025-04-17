const button = document.getElementById("magicButton");
const message = document.getElementById("message");

button.addEventListener("click", () => {
  message.textContent = "You clicked the button! Now imagine what else this site can do...";
});
