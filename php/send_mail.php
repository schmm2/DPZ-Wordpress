<?php 
function send_mail(){	
	
	$args = array(
	    'post_type' => 'page',
	    'fields' => 'ids',
	    'nopaging' => true,
	    'meta_key' => '_wp_page_template',
	    'meta_value' => 'page-contact.php'
	);
	$pages = get_posts( $args );
	
	// there is a contact page
	if(isset($pages)){
		$pageId = $pages[0];
		
		// get mail adress
		$receiverMail = get_post_meta( $pageId, '_dpz_contact_business_mail', true ); 
		
		if(isset($receiverMail)){
					
			$message = $_POST['message'];
			$subject = $_POST['subject'];
			$senderMail = $_POST['senderMail'];
			$senderName = $_POST['senderName'];
				
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
	}
	else{
		$returnMsg['code'] = 'noContactPage';	
	}
	
	
		
	echo json_encode($returnMsg);
	die();		
}

?>