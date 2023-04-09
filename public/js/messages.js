function removeMessage() {
  const messageContainer = document.querySelector(".success-message");
  if (messageContainer) {
    setTimeout(function () {
      messageContainer.style.opacity = 0;
      messageContainer.style.transition = "opacity 300ms";

      setTimeout(function () {
        messageContainer.remove();
        document.querySelector("script[data-script='remove-self']").remove();
      }, 300);
    }, 3000);
  }
}
