<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

function send_mail($to, $subject, $message)
{
  $mail = new PHPMailer(true);

  $mail->IsSMTP();
  $mail->Host       = "smtp.mail.me.com"; 
  $mail->SMTPAuth   = true;        
  $mail->SMTPSecure = "tls";             
  $mail->Host       = "smtp.mail.me.com";     
  $mail->Username   = 'vali7799@icloud.com';
  $mail->Password   = 'ncsg-rzop-ardx-nhut';
  $mail->Port       = 587;
  $mail->setFrom('vali7799@icloud.com', 'Edu Chat');
  $mail->addAddress($to);

  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = '
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body style="margin:0;padding:0;">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:solid;border-spacing:0;background:#ffffff; border-color:red">
        <tr>
            <td align="left" style="padding:20px; font-size:30px;; font-weight:bold">
                ' . $subject . '
            </td>
        </tr>
        <tr>
            <td style="padding:0px 30px; font-size:16px;">
              ' . $message . '
              <br><br>
              Regards, <br>
              Edu Chat
              <br><br><br><br>
            </td>
            
        </tr>
        <tr>
    <td align="center" style="background-color:rgb(189, 184, 184); padding:30px;">
    <a href="https://valentin-nussbaumer.com"><img src="https://valentin-bewerbung.com/media/Bildschirmfoto%202021-08-04%20um%2019.59.26.png" alt="" width="90" style="height:auto;display:block;" /></a>
   <br> Edu Chat | <a style="color:black" href="https://edu-chat.me">edu-chat.me</a> | <a style="color:black" href="mailto: mail@valentin-nussbaumer.com">mail@valentin-nussbaumer.com</a>
  </td>
        </tr>
    </table>
</body>
</html>';
  $mail->send();
}
