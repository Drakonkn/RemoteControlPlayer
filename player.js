var songs_cash;
var played_song;
var playing;
addEvent(window, 'load', onWinLoad, false);

function onWinLoad(){
  init_play_list();
  setInterval(req_cmd, 1000);
  var player = document.getElementById('player');
  addEvent(player,'play',onPlay,false);
  addEvent(player,'durationchange',onDurationchange,false);
  addEvent(player,'pause',onPaused,false);
  addEvent(player,'ended',play_next,false);
  addEvent(player,"timeupdate", progress,false);
  addEvent(player,"volumechange",onVolumechange,false);
}

function onPlay(){
  player = document.getElementById('player');
  play_button.src = 'img/pause.png';
}

function onVolumechange(event){
  var vol = event.target.volume;
  var progress_bar = document.getElementById('volume_inner');
  progress_bar.style.width = (vol*100)+"%";
}

function onDurationchange(){
  player = document.getElementById('player');
  var duration = document.getElementById('duration');
  var seconds = player.duration.toFixed()%60>9 ? player.duration.toFixed()%60 : '0'+player.duration.toFixed()%60;
  var minutes = ('0'+(player.duration.toFixed(0)/60).toFixed()).slice(-2);
  duration.innerHTML = minutes + ":" + seconds;
}

function onPaused(){
  play_button.src = 'img/play.png';
}

function progress(data){
  var player = document.getElementById('player');
  var progress_bar = document.getElementById('seek_inner');
  progress_bar.style.width = (player.currentTime.toFixed()/player.duration)*100+"%";
  var curent_time = document.getElementById('curent_time');
  var seconds = player.currentTime.toFixed()%60>9 ? player.currentTime.toFixed()%60 : '0'+player.currentTime.toFixed()%60;
  var minutes = ('0'+(player.currentTime.toFixed(0)/60).toFixed()).slice(-2);
  curent_time.innerHTML = minutes + ":" + seconds;
}

function getOffsetSum(elem) {
  var top=0, left=0
    top = top + parseFloat(elem.offsetTop)
    left = left + parseFloat(elem.offsetLeft)
    elem = elem.offsetParent  
    top = top + parseFloat(elem.offsetTop)
    left = left + parseFloat(elem.offsetLeft)     
 return {top: Math.round(top), left: Math.round(left)}
}

function seek(event, seek_bar){
  var prb_offset = getOffsetSum(seek_bar);
  var clickX = (event.layerX == undefined ? event.offsetX : event.layerX) -prb_offset.left;
  var clickY = (event.layerY == undefined ? event.offsetY : event.layerY) -prb_offset.top;
  var player = document.getElementById('player');
  player.currentTime = (clickX/seek_bar.clientWidth)*player.duration;
}

function volumeChange(event, volume_bar){
  var prb_offset = getOffsetSum(volume_bar);
  var clickX = (event.layerX == undefined ? event.offsetX : event.layerX) -prb_offset.left;
  var clickY = (event.layerY == undefined ? event.offsetY : event.layerY) -prb_offset.top;
  var player = document.getElementById('player');
  player.volume = (clickX/volume_bar.clientWidth);
}

function onOriginSet(spinbox){
  init_play_list(spinbox.value);
}

function init_play_list(origin){
  $.post("get_vk_audio.php",
  {
    origin: origin,
    dataType: "json"
  },
    onMusicUpdate,
    "json"
  );
}

function onMusicUpdate(jdata){
  if(jdata.result == 'error'){
    if (jdata.command == 'redirect'){
      redirect(jdata.url);
    }
    else{
      alert(jdata.error_string);
    }
    
  }
  var wraper = document.getElementById('list_wraper');
  var songs = jdata.songs;
  var html = '<div id="song_list">';
  for (var song in songs){
    html +='<div onclick="play(this)" aid="'+songs[song].aid+'" artist="'+songs[song].artist+'" class="song_element" path="'+songs[song].url+'">'+songs[song].artist+" - "+songs[song].title+'</div>';
  }
  html += '</div>'
  wraper.innerHTML = html;
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
    //alert(ret);
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

function play_pause(){
  if (playing){
    playing = false;
    return pause();
  }
  resume();
  playing = true;
}

function play(song){
  var player = document.getElementById('player');
  var source = document.getElementById('src');
  var play_button = document.getElementById('play_button');
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
        var HeaderTop = $('#player_wraper').offset().top;
    
        $(window).scroll(function(){
                if( $(window).scrollTop() > HeaderTop ) {
                        $('#player_wraper').css({position: 'fixed', top: '5px', right: '5px', border:'solid #FFF 1px'});
                } else {
                        $('#player_wraper').css({position: 'relative', top: '0', top: '0', right: '0', border:'none'});
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

function redirect(url){
  window.location = url;
}