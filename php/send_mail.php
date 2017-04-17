<?php 
function send_mail(){

	// Get 'adress' posts
	$adress_posts = get_posts( array(
		'post_type' => 'adress',
		'posts_per_page' => -1, // Unlimited posts
		'orderby' => 'date', // Order alphabetically by name
	));

	foreach ($adress_posts as $post_index => $post):
		$receiverMail  = get_post_meta( get_the_ID(), '_dpz_contact_business_email', true );
	endforeach;

	if(isset($receiverMail)){

		$message = $_POST['message'];
		$senderMail = $_POST['senderMail'];
		$senderName = $_POST['senderName'];
		$subject = "Neue Anfrage Webseite:".$senderName;

		// message
		$htmlMessage = '
		<html>
		<head>
		  <title>Neues Mail von der Webseite</title>
		</head>
		<body>
		  <p>Neues E-Mail von der Webseite</p>
		  <table>
		    <tr>
		      <td>Von:</td><td>'.$senderName.'</td>
		    </tr>
		    <tr>
		      <td>Betreff:</td><td>'.$subject.'</td>
		    </tr>
		    <tr>
		      <td>Nachricht</td><td>'.$message.'</td>
		    </tr>
		  </table>
		</body>
		</html>
		';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: <'.$receiverMail.'>' . "\r\n";
		$headers .= 'From: '.$senderName.' <'.$senderMail.'>' . "\r\n";

		// Mail it
		$returnMsg['code'] = mail($receiverMail, $subject, $htmlMessage, $headers);
	} else{
		$returnMsg['code'] = 'noMail';
	}
		
	echo json_encode($returnMsg);
	die();		
}

?>