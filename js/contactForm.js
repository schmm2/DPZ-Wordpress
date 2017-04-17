jQuery(document).ready(function($) {
	
	$('[class^=input-]').after("<div class='notificationMessage'></div>");
	
	// check if it exist
	if($(".contact-form").length){
		$(".contact-form").submit(function(e){

			$('.notificationMessage').html('');
			var msgTemplate = $.templates("<p class='{{:text_color}}'>{{:message}}</p>");
			
			var emptyMsg = "Dieses Feld darf nicht leer sein";
			var syntaxMailMsg = "Keine gültige Mail Adresse";
			var successMsg = "Wir haben deine Mail erhalten, wir antworten so bald wie möglich!";
	
			
			// check regex
		    var mailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		    var name = $(this).find('.input-name');
		    var mail = $(this).find('.input-mail');
		    var message = $(this).find('.input-message');


			// check fields
			var send = true;
			
			// *** Name Field ***
			if(name.val() == ""){
				name.next('.notificationMessage').html(msgTemplate.render({'text_color':'text-alert',message: emptyMsg}));
				send = false;
			}
			
			/*** Mail Field ***/
			if(mail.val() == ""){
				mail.next('.notificationMessage').html(msgTemplate.render({'text_color':'text-alert',message: emptyMsg}));
				send = false;
			}
			// Fallback if HTML5 is not supported
			else if(!mailReg.test(mail.val())){
				mail.next('.notificationMessage').html(msgTemplate.render({'text_color':'text-alert',message: syntaxMailMsg}));
				send = false;
			}
			if(message.val() == ""){
				message.next('.notificationMessage').html(msgTemplate.render({'text_color':'text-alert',message: emptyMsg}));
				send = false;
			}
			
			if(send == true){

				// Ajax send message
				$.post( globals.ajaxurl,{action : 'send_mail', "message":message.val(),"senderMail":mail.val(),"senderName":name.val()})
				.done(function(data) 
				{
				    var serverMsg = JSON.parse(data);
					console.log(serverMsg);
				    var color = '';
					var msg = '';
										
					switch(serverMsg['code']){
						case false:
						    console.log("ERRROR");
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
						default:
							color = 'text-alert';
							msg = 'Unbekannter Fehler';
							break;	
					}
					// set message
					message.next('.notificationMessage').html(msgTemplate.render({'text_color':color, message: msg}));
				});	
			}	
			return false;
		});	
	}
});
