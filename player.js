var songs_cash;
var played_song;
addEvent(window, 'load', onWinLoad, false);

function onWinLoad(){
  init_play_list();
  var player = document.getElementById('player');
  addEvent(player,'ended',play_next,false);
  setInterval(req_cmd, 1000);
}

function onOriginSet(spinbox){
  init_play_list(spinbox.value);
}

function init_play_list(origin){
  $.post("get_vk_audio.php",
  {
    origin: origin
  },
    onAjaxSuccess
  );
}

function onAjaxSuccess(data){
  var wraper = document.getElementById('list_wraper');
  wraper.innerHTML = data;
  played_song.setAttribute('class', "song_element_active");
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
          pause();
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

function resume(){
  if(played_song){
    player.play();
    set_status('played',played_song.innerHTML);
  }
  else{
    var song_list = document.getElementById('song_list');
    var childs = song_list.childNodes;
    play(childs[0]);
    played_song = childs[0];
  }
}

function pause(){
  player.pause();
  set_status('paused',played_song.innerHTML);
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
  document.getElementById('audio_info').innerHTML = song.innerHTML;
  set_status('played',song.innerHTML);
}

function play_next(){
  var song_list = document.getElementById('song_list');
  var childs = song_list.childNodes;
  for (var i = 0; i< childs.length; i++){
    if(childs[i].className == 'song_element_active'){
      if (i<childs.length-1) i++;
      else i=0;
      play(childs[i]);
      return;
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

function set_status(status, song){
    $.post("status.php",
  {
    action: 'set',
    status: status,
    song_name: song
  },
    onSetStatus
  );
}

function onSetStatus(data){
  var jdata = JSON.parse(data);
  if(jdata.result != 'sucsess'){
    alert(jdata.error_string);
  }
}

$(document).ready(function(){
        var HeaderTop = $('#player').offset().top;
    
        $(window).scroll(function(){
                if( $(window).scrollTop() > HeaderTop ) {
                        $('#player').css({position: 'fixed', top: '10px', right: '0px'});
                } else {
                        $('#player').css({position: 'relative'});
                }
        });
  });



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