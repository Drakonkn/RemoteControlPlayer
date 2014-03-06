var songs_cash;
  var played_song;
      function update_song1 () {
          $.getJSON(songGetter,function success( data ) {
          if (JSON.stringify(songs_cash) != JSON.stringify(data)){
            var song_list = document.getElementById('song_list');
            song_list.innerHTML = '';
            Songs_cash = data;
            for (var song in data) {
              var song_list = document.getElementById('song_list');
              var song_element =  document.createElement('div');
              song_element.innerHTML = data[song]['name'];
              song_element.path = data[song]['path'];
              song_element.setAttribute('onclick', "play(this)");
              song_element.setAttribute('class', "song_element");
              song_list.appendChild(song_element);
            }
          };
        });
       }

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

      function playNext(){
        var song_list = document.getElementById('song_list');
        var childs = song_list.childNodes;
        for (var i = 0; i< childs.length; i++){
          if(childs[i].className == 'song_element_active'){
            if (i<childs.length-1) i++;
            else i=0;
            play(childs[i]);
          }
        };
      }

      function playPrev(){
        var song_list = document.getElementById('song_list');
        var childs = song_list.childNodes;
        for (var i = 0; i< childs.length; i++){
          if(childs[i].className == 'song_element_active'){
            if (i==0) i = childs.length-1;
            else i--;
            play(childs[i]);
          }
        };
      }

      function reqcmd1(){
        var player = document.getElementById('player');
          $.getJSON('reqcmd.php',function( data ) {
            for (var cmd in data){
              var command = data[cmd]['cmd'];
              switch (command){
                case "play":
                  player.play();
                  break;
                case "pause":
                  player.pause();
                  break;

              }
            }
      });
    }

window.onload = function(){ 
        setInterval(function reqcmd(){
          var player = document.getElementById('player');
          player.addEventListener("ended", playNext);
          var ret = $.getJSON('reqcmd.php',function( data ) {
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
                player.volume+=0.1;
                  break;
                case "vol_dow":
                  player.volume-=0.1;
                  break;
                case "next":
                  playNext();
                  break;
                case "prev":
                  playPrev();
                  break;                  
              }
            }
      });
          //(ret);
    }, 1000);
}