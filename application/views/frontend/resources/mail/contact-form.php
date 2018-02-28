<?php
 $html = 'First Name: '. $_POST['name'] .'
 Email: '.$_POST['email'].'
 Phone: '.$_POST['contactnumber'].'
 Message: '.$_POST['message'];
$message = $html;
$subject = 'Client Enquiry Mail from RSAOI Website'; 
$headers = 'From:support@bigappcompany.com' . "\r\n" . 'Reply-To:support@bigappcompany.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
$to ='rakesh@spotsoon.com';
if(mail($to, $subject, $message, $headers)) {
     echo "<script>alert('Thanks For Contacting. We will contact you shortly.');location.href=\"index.html\"</script>";
}
else 
{
    echo "<script>alert('Unable to send mail. Please try after some time.');location.href=\"contact.html\"</script>"; 
}			
?>