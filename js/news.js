jQuery(document).ready(function($) {
	
	var newsContainer = document.getElementById('news-container');
	var hammertime = new Hammer(newsContainer);
	
	// brightness style adjustments
	if($('.post-categories a').length){
		$('.post-categories a').bgBrightness(180);
	}
	
	// Todo
	hammertime.on('swipe', function(ev) {
	});	
		
	if (platform.os.family == 'iOS' && parseInt(platform.os.version, 10) >= 8) {   	
   		var newsContainerHeight = window.innerHeight - $("#nav-container").height();
   		$("#news-container").height(newsContainerHeight);
   	}
	
	// active Swiper H
	var activeSwiperH = null;
	 
	var swiperV = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        loop: false,
        pagination: '.swiper-pagination',
        direction: 'vertical',
        mousewheelControl: true,
        mousewheelForceToAxis: true,
        spaceBetween: 0,
        grabCursor: true,
	    resistanceRatio: 0.85,
	    slideActiveClass: 'swiperV-slide-active',
        keyboardControl: true,
        centeredSlides: true,
        onSlideChangeStart: function(swiper){
			if(swiperV.isBeginning === false){
		        $('#slider').show();
	        } else{
		        $('#slider').hide();
	        }
			stop_players_youtube();	
			stop_players_vimeo();
			stop_players_soundcloud();
	    },
        onSlideChangeEnd: function(swiper){ 
	        BackgroundCheck.refresh();
        },
    });

	// newsPost
	$('.button-readmore').on('click',function(){
		var post_url = $(this).attr('data-post-url');
		var slide_data = {index: swiperV.activeIndex};
		Cookies.set('dpz-news',{index:slide_data.index, url:window.location.href, ttl:1}, { expires: 1 });
		window.location = post_url;
	});   	
	
	function slideRestoreFromCookie(){
		if(Cookies.get('dpz-news') !== undefined){
			var cookie_news = JSON.parse(Cookies.get('dpz-news'));
			if(cookie_news.ttl == 0){
				swiperV.slideTo(cookie_news.index);
				Cookies.remove('dpz-news');
			}
		} 
	}
	
	
	$('#slider').on("click", function(){
		if($(this).hasClass('arrow-top')){
			swiperV.slideTo(0);
		}
	});
	
	if($('.backgroundCheck-image').length){
	    BackgroundCheck.init(
		{
			targets: '.backgroundCheck',
			images: '.backgroundCheck-image'
		});
	}
	
	
	/* --- Youtube Player --- */
	
	// Youtube API
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
	var players_youtube = [];	
	var i = 0;
	
	window.onYouTubePlayerAPIReady = function(){
		
		// slides can only be restored if youtube api is loaded, otherwise the site will crash
		slideRestoreFromCookie();
			
		$('.player-youtube .player').each(function(){
			
			var player_youtube = this;	
			// needed because api rebuild dom object
			var container = $(this).parent();				
			var videoId = $(player_youtube).data('videoid');
			
			// redefine play-youtube div	    	
	    	var player = new YT.Player(player_youtube.id, {
		    	videoId: videoId,
		       	playerVars: { 'autoplay': 0, 'controls': 1,'autohide':1,'showinfo':0,'modestbranding':1,'rel':0,'fs':1},
		        events: {
		        	'onReady': onPlayerReady,
		            'onStateChange': onPlayerStateChange
		        }
	    	});	   
		    
		    function onPlayerReady(event) {
			    players_youtube[players_youtube.length] = event.target;	
		    }
		    
		    // check new state	
		    function onPlayerStateChange(event) {
		    	
				// paused
		    	if(event.data == 2){
					show_postText(player_youtube.id);
		    	} 
		    	// buffering
		    	else if(event.data == 3){
			    	hide_videoOverlay(player_youtube.id);
		    	} 
		    	// play
		    	else if(event.data == 1){
			    	hide_videoOverlay(player_youtube.id);
		    	} 
		    	// ended
		    	else if(event.data == 0){
			    	show_videoOverlay(player_youtube.id);
			    }   		    	
			}	
						
			$(container).find('.button-play').on("click", function(){
				// play video
				if (platform.os.family == 'iOS'){   	
					hide_videoOverlay(player_youtube.id);
   				} else{
					player.playVideo();
				}
			});
		});
	}
	
	function stop_players_youtube(){
		for(var i = 0; i < players_youtube.length; i++){
			//check state of video
			if(players_youtube[i].getPlayerState() == 1){
				players_youtube[i].pauseVideo();
			}
		}
	}	
	
	/* --- Vimeo --- */ 	
	
	var players_vimeo = [];
	var v = 0;
	
	$('.player-vimeo .player').each(function(){
		player = $f(this);
		container = $(this).parent();
		
		player.addEvent('ready', function() {
			player.addEvent('play', hide_videoOverlay);
			player.addEvent('pause', show_postText);
			player.addEvent('finish', show_videoOverlay);
		});

		$(container).find('.button-play').on("click", function(){
			if (platform.os.family == 'iOS'){   	
				hide_videoOverlay(player.element.id);
   			}
   			// play video 
   			else{
				player.api("play");
			}
			
		});
		
		players_vimeo[v++] = player;
	});
	
	function stop_players_vimeo(){
		for(var i = 0; i < players_vimeo.length; i++){
			//check state of video
			players_vimeo[i].api("pause");
		}
	}	
	
	/* --- Soundcloud Player --- */
	
	var players_soundcloud = [];
	var s = 0;
	
	$('.player-soundcloud .player').each(function(){
		var player = SC.Widget(this);
		var playerId = this.id;
		
		var container = $(this).parent();
      
		player.bind(SC.Widget.Events.PLAY, function(){
			hide_videoOverlay(playerId);
			$("#"+playerId).addClass('playing');
		});
		player.bind(SC.Widget.Events.PAUSE, function(){
			show_postText(playerId);
			$("#"+playerId).removeClass('playing');
		});	
		player.bind(SC.Widget.Events.FINISHED, function(){
			show_videoOverlay(playerId);
			$("#"+playerId).removeClass('playing');
		});		
		
      	$(container).find('.button-play').on("click", function(){
			if (platform.os.family == 'iOS'){   	
				hide_videoOverlay(playerId);
				$("#"+playerId).addClass('playing');
   			}
   			// play video 
   			else{
				player.play();
			}
		});
		
		
		players_soundcloud[s++] = player;
	});
	
	function stop_players_soundcloud(){
		for(var i = 0; i < players_soundcloud.length; i++){
			//check state of video
			players_soundcloud[i].pause();
		}
	}
	
	/* Player Util */
	// needs id of player element
	function hide_videoOverlay(id){
		$("#"+id).siblings('.post-shadow').hide();
		$("#"+id).siblings('.post-image').hide();
	}
	
	function show_videoOverlay(id){
		$("#"+id).siblings('.post-shadow').show();
		$("#"+id).siblings('.post-image').show();
	}
	
	function show_postText(id){
		$("#"+id).siblings('.post-shadow').show();
	}	
});


