jQuery(document).ready(function($) {
	
	$('[class^=input-]').after("<div class='message'></div>");
	
	// check if it exist
	if($(".contactForm").length){		
		$(".contactForm").submit(function(e){	
			
			$('.message').html('');
			var msgTemplate = $.templates("<p class='{{:text_color}}'>{{:message}}</p>");
			
			var emptyMsg = "Dieses Feld darf nicht leer sein";
			var syntaxMailMsg = "Keine gültige Mail Adresse";
			var successMsg = "Wir haben deine Mail erhalten, wir antworten so bald wie möglich!";
	
			
			// check regex
		    var mailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		    var name = $(this).find('.input-name');
		    var mail = $(this).find('.input-mail');
		    var message = $(this).find('.input-message');
		    var subject = $(this).find('.input-subject');
			
			// check fields
			var send = true;
			
			// *** Name Field ***
			if(name.val() == ""){
				name.next('.message').html(msgTemplate.render({'text_color':'text-alert',message: emptyMsg}));  
				send = false;
			}
			
			/*** Mail Field ***/
			if(mail.val() == ""){
				mail.next('.message').html(msgTemplate.render({'text_color':'text-alert',message: emptyMsg}));  
				send = false;
			}
			// Fallback if HTML5 is not supported
			else if(!mailReg.test(mail.val())){
				mail.next('.message').html(msgTemplate.render({'text_color':'text-alert',message: syntaxMailMsg}));  	
				send = false;
			}
			if(message.val() == ""){
				message.next('.message').html(msgTemplate.render({'text_color':'text-alert',message: emptyMsg}));  
				send = false;
			}
			
			if(send == true){
				// Ajax send message
				
				$.post( globals.ajaxurl,{action : 'send_mail', "message":message.val(),"senderMail":mail.val(),"subject":subject.val(),"senderName":name.val()})
				.done(function(data) 
				{					
					var serverMsg = JSON.parse(data);
					var color = '';
					var msg = '';
										
					switch(serverMsg['code']){
						case false:
							color = 'text-alert';
							msg = 'Nachricht konnte nicht übermittelt werden';
							break;
						case true:
							color = 'text-success';
							msg = 'Wir haben deine Nachricht erhalten, Merci!';
							break;
						case 'noMail':
							color = 'text-alert';
							msg = 'Kein Empfänger Mail definiert';
							break;
						case 'noContactPage':
							color = 'text-alert';
							msg = 'Keine Kontakt Seite definiert';
							break;
						default:
							color = 'text-alert';
							msg = serverMsg['code'];
							break;	
					}
					// set message
					message.next('.message').html(msgTemplate.render({'text_color':color, message: msg}));
				});	
			}	
			return false;
		});	
	}
});
