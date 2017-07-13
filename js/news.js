jQuery(document).ready(function($) {

    function isLocal(url) {
        hostname = new RegExp(location.host);
        return (hostname.test(url));
    }

	// calculates brightness of picture
    function setImageBrightness(image) {

        // extract image url
    	var imageUrl = $(image).css('background-image');
        imageUrl = /url\(([^\)]+)\)/.exec(imageUrl)[1];

		var img = document.createElement("img");

        // handle cors requests
        if(isLocal(imageUrl)){
            imageSrc =  imageUrl.replace(/"/g, '');

        }else{
            img.crossOrigin = "Anonymous";
            imageSrc =  'https://crossorigin.me/' + imageUrl.replace(/"/g, '');

		}

        img.src = imageSrc;
        img.style.display = "none";

        img.onload=imageFound;
        img.onerror=imageNotFound;


        document.body.appendChild(img);

        var colorSum = 0;
        var brightness = 0;

        function imageNotFound(){
            $(image).parents('.post').addClass('background--light');
		}

        function imageFound(){
        	// create canvas
            var canvas = document.createElement("canvas");
            canvas.width = this.width;
            canvas.height = this.height;

            var ctx = canvas.getContext("2d");
            ctx.drawImage(this, 0, 0);

            var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            var data = imageData.data;
            var r, g, b, avg;

            for (var x = 0, len = data.length; x < len; x += 4) {
                r = data[x];
                g = data[x + 1];
                b = data[x + 2];

                avg = Math.floor((r + g + b) / 3);
                colorSum += avg;
            }
            brightness = Math.floor(colorSum / (this.width * this.height));

            if(brightness > 180){
                $(image).parents('.post').addClass('background--light');
            } else if(brightness < 120){
                $(image).parents('.post').addClass('background--dark');
            } else{
                $(image).parents('.post').addClass('background--complex');
			}
        }
    }


	$(".post-image").each(function(){
        setImageBrightness(this);
    });


	var newsContainer = document.getElementById('news-container');
	var resizeHeight = false;

    // browser troubleshooting

    // Chrome
    var isChromium = window.chrome,
        winNav = window.navigator,
        vendorName = winNav.vendor,
        isOpera = winNav.userAgent.indexOf("OPR") > -1,
        isIEedge = winNav.userAgent.indexOf("Edge") > -1,
        isIOSChrome = winNav.userAgent.match("CriOS");

    // is Google Chrome on IOS
    if(isIOSChrome){
        resizeHeight = true;
    }
    // is Google Chrome on Android
    else if(isChromium !== null && isChromium !== undefined && vendorName === "Google Inc." && isOpera == false && isIEedge == false) {
        if (platform.os.family == 'Android') {
            resizeHeight = true;
        }
    }

    // iOS
    if (platform.os.family == 'iOS' && parseInt(platform.os.version, 10) >= 8) {
        resizeHeight = true;
    }

    if(resizeHeight == true){
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
	    resistanceRatio: 0.75,
	    slideActiveClass: 'swiper-slide-active',
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
		onSlideChangeEnd: function(){
            $('#slider').removeClass('background--dark');
            $('#slider').removeClass('background--light');
            $('#slider').removeClass('background--complex');

        	// style slider-up according to background image
            if($('.swiper-slide-active').hasClass('background--dark')){
            	$('#slider').addClass('background--dark');
			} else if($('.swiper-slide-active').hasClass('background--light')){
                $('#slider').addClass('background--light');
            } else if($('.swiper-slide-active').hasClass('background--complex')){
                $('#slider').addClass('background--complex');
            }
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

	$('#slideDown').on("click", function(){
            swiperV.slideTo(1);
    });


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
		player = new Vimeo.Player(this);
		container = $(this).parent();
        playerId = this.id;

        player.on('play', function() {
            hide_videoOverlay(playerId);
        });

        player.on('pause', function() {
            show_postText(playerId);
        });

        player.on('finish', function() {
            show_videoOverlay(playerId);
        });

		$(container).find('.button-play').on("click", function(){
			if (platform.os.family == 'iOS'){   	
				hide_videoOverlay(playerId);
   			}
   			// play video 
   			else{
				player.play();
			}
			
		});
		
		players_vimeo[v++] = player;
	});
	
	function stop_players_vimeo(){
		for(var i = 0; i < players_vimeo.length; i++){
			//check state of video
			players_vimeo[i].pause();
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
        $('#slideDown').hide();
        $('#slider').hide();
	}
	
	function show_videoOverlay(id){
		$("#"+id).siblings('.post-shadow').show();
		$("#"+id).siblings('.post-image').show();
        $('#slideDown').show();
        $('#slider').show();
	}
	
	function show_postText(id){
		$("#"+id).siblings('.post-shadow').show();
	}

});