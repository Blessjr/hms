<?php
include("header.php");
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['submit']))
{  
	$message = "<strong>Cher/Chère $_POST[name],</strong><br />
				<strong>Votre adresse e-mail est :</strong> $_POST[email]<br />
				<strong>Message :</strong> $_POST[comment]
				";
	
	sendmail("danielchristopher315@gmail.com","Courriel depuis Appoint My Doctor",$message);
	
}
?>
<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">Contactez-nous</li>
    </ul>
  </div>
</div>
<div class="wrapper col4">
  <div id="container">
    <h6>Notre adresse</h6>
    <p>
DOCTO LINK en ligne, Bangalore<br />

<strong>Tél</strong> : 080661 86611<br />

<strong>Adresse e-mail</strong> : danielchristopher315@gmail.com</p>

        <h6>Contactez-nous en saisissant les informations suivantes</h6>
            <form action="" method="post">
          <p>
            <input type="text" name="name" id="name" value="" size="22" placeholder="Nom (obligatoire)" />
            <label for="name"><small>Nom (obligatoire)</small></label>
          </p>
          <p>
            <input type="text" name="email" id="email" value="" size="22" placeholder="Email (obligatoire)" />
            <label for="email"><small>Email (obligatoire)</small></label>
          </p>
          <p>
            <textarea name="comment" id="comment" cols="100%" rows="10" placeholder="Votre message ici (obligatoire)"></textarea>
            <label for="comment" style="display:none;"><small>Commentaire (obligatoire)</small></label>
          </p>
          <p>
            <input name="submit" type="submit" id="submit" value="Envoyer le formulaire"  />
            &nbsp;
            <input name="reset" type="reset" id="reset" tabindex="5" value="Réinitialiser le formulaire" />
          </p>
        </form>

  </div>
  
</div>

    <div class="clear"></div>
  </div>
</div>
<?php
include("footer.php");
function sendmail($toaddress,$subject,$message)
{
	
	$mail = new PHPMailer;
	
	//$mail->SMTPDebug = 3;                               // Activer le débogage verbose
	
	$mail->isSMTP();                                      // Utiliser SMTP
	$mail->Host = 'mail.dentaldiary.in';                  // Serveurs SMTP principaux et de secours
	$mail->SMTPAuth = true;                               // Activer l'authentification SMTP
	$mail->Username = 'sendmail@dentaldiary.in';          // Nom d'utilisateur SMTP
	$mail->Password = 'q1w2e3r4/';                        // Mot de passe SMTP
	$mail->SMTPSecure = 'tls';                            // Chiffrement TLS, `ssl` aussi accepté
	$mail->Port = 587;                                    // Port TCP
	
	$mail->From = 'sendmail@dentaldiary.in';
	$mail->FromName = 'Web Mall';
	$mail->addAddress($toaddress, 'Utilisateur');         // Ajouter un destinataire
	$mail->addAddress($toaddress);                        // Nom optionnel
	$mail->addReplyTo('aravinda@technopulse.in', 'Information');
	$mail->addCC('cc@example.com');
	$mail->addBCC('bcc@example.com');
	
	$mail->addAttachment('/var/tmp/file.tar.gz');         // Ajouter des pièces jointes
	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Nom optionnel
	$mail->isHTML(true);                                  // Format email HTML
	
	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = $subject;
	
	if(!$mail->send()) {
		echo 'Le message n\'a pas pu être envoyé.';
		echo 'Erreur Mailer : ' . $mail->ErrorInfo;
	} else {
		echo '<center><strong><font color=green>Courriel envoyé.</font></strong></center>';
	}
}
?>
