function login() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  if (username && password) {
    var data = {
      username: username,
      password: password,
    };

    fetch("/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((data) => {
        return data.json();
      })
      .then((data) => {
        if (data.sucess) {
          document.location = "/";
        } else {
          alert(data.message);
        }
      })
      .catch(() => {
        alert("Oh no, something is going wrong! Contact the support.");
      });
  } else {
    alert("Write all the fields");
  }
}
