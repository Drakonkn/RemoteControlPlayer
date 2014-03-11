var songs_cash;
var played_song;
addEvent(window, 'load', winLoad, false);

function resume(){
  if(played_song)
    player.play();
  else{
    var song_list = document.getElementById('song_list');
    var childs = song_list.childNodes;
    play(childs[0]);
    played_song = childs[0];
  }
}

function play(song){
  var player = document.getElementById('player');
  var source = document.getElementById('src');
  if (played_song){
    played_song.setAttribute('class', "song_element");
  } 
  song.setAttribute('class', "song_element_active");
  source.src=song.getAttribute("path");
  player.load();
  player.play();
  played_song = song;
}

function play_next(){
  var song_list = document.getElementById('song_list');
  var childs = song_list.childNodes;
  for (var i = 0; i< childs.length; i++){
    if(childs[i].className == 'song_element_active'){
      if (i<childs.length-1) i++;
      else i=0;
      play(childs[i]);
    }
  }
}

function play_prev(){
  var song_list = document.getElementById('song_list');
  var childs = song_list.childNodes;
  for (var i = 0; i< childs.length; i++){
    if(childs[i].className == 'song_element_active'){
      if (i==0) i = childs.length-1;
      else i--;
      play(childs[i]);
    }
  }
}

function req_cmd(){
    var ret = $.getJSON('reqcmd.php',function( data ) {
      if(data.result == 'error'){
        alert(data.error_string);
        window.location="login.php?ret="+window.location.pathname;
        return;
      }
      for (var cmd in data){
        var command = data[cmd]['cmd'];
        switch (command){
          case "play":
          resume();
          break;
          case "pause":
          player.pause();
          break;
          case "vol_up":
          if(player.volume<0.9) player.volume+=0.1;
          break;
          case "vol_dow":
          if(player.volume>0.1) player.volume-=0.1;
          break;
          case "next":
          play_next();
          break;
          case "prev":
          play_prev();
          break;                  
        }
      }
    });
  }

function addEvent(elm, evType, fn, useCapture) {
  if (elm.addEventListener) {
    elm.addEventListener(evType, fn, useCapture);
    return true;
  }
  else if (elm.attachEvent) {
    var r = elm.attachEvent('on' + evType, fn);
    return r;
  }
  else {
    elm['on' + evType] = fn;
  }
}

function winLoad(){ 
  var player = document.getElementById('player');
  player.addEventListener("ended", play_next);
  setInterval(req_cmd, 1000);
}