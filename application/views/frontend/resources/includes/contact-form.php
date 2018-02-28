<?php
 $html = 'Name: '. $_POST['name'] .'
 Organization: '.$_POST['organization'].'
 Email: '.$_POST['email'].'
 Name of Inquiry: '.$_POST['inquiry'].' 
 Message: '.$_POST['message'];
$message = $html;
$subject = 'Friend Reference from SPUNK'; 
$headers = 'From:support@bigappcompany.com' . "\r\n" . 'Reply-To:support@bigappcompany.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
$to ='pravin@spotsoon.com';
if(mail($to, $subject, $message, $headers)) {
     echo "<script>alert('Thanks For Contacting. We will contact you shortly.');location.href=\"../index.php\"</script>";
}
else 
{
    echo "<script>alert('Unable to send mail. Please try after some time.');location.href=\"../contact-us.php\"</script>"; 
}			
?>