function showNotification(notification) {
  const notificationEl = document.querySelector(
    `[data-notification='${notification}']`
  );

  notificationEl.classList.remove("hidden");
}

function hideNotification(notification) {
  const notificationEl = document.querySelector(
    `[data-notification='${notification}']`
  );

  notificationEl.classList.add("hidden");
}
