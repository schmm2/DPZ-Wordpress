<p>* Pflichtfelder</p>
<form class="contactForm" onsubmit="return false;"> 
	<div class="contactForm-sender">				
		<div>
			<p>Dein Name *</p>
		  	<input class="input-name" type="text"></input>
		</div>
		<div>
			<p>E-Mail-Adresse *</p>
		    <input class="input-mail" type="email"></input>
		</div>		
		<div>
			<p>Betreff</p>
			<input class="input-subject" type="text"></input>
			<div class="message"></div>
		</div>	
	</div>		
	<div class="contactForm-message">
		<div>
			<p>Nachricht *</p>
			<textarea class="input-message"></textarea>
		</div>
		<input class="bgColor-main-bright-hover" value="Senden" type="submit" id="form-submit"></input>
		<div style="clear:both"></div>
	</div>	
</form>
<p id="message"></p>
