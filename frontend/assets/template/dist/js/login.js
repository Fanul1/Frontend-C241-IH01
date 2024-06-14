document.querySelector("form").addEventListener("submit", function (event) {
  // Client-side validation
  const ip = document.getElementById("ip").value;
  const user = document.getElementById("user").value;
  const password = document.getElementById("password").value;

  if (!ip || !user || !password) {
    alert("All fields are required.");
    event.preventDefault();
    return;
  }

  // Show loading spinner
  document.getElementById("loading-spinner").style.display = "flex";
});

window.onload = function () {
  document.getElementById("loading-spinner").style.display = "none";
};

window.addEventListener("error", function () {
  document.getElementById("loading-spinner").style.display = "none";
});
