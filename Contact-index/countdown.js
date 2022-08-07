var timeleft = 9;
var downloadTimer = setInterval(function(){
  document.getElementById("countdown").innerHTML = timeleft + "後にログインページへ移動します。";
  timeleft -= 1;
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    document.getElementById("countdown").innerHTML = ""
  }
}, 1000);