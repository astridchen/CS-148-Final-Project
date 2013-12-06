<?php

function sendMail($to, $subject, $message){ 
    $MIN_MESSAGE_LENGTH=40;
    
    $to = htmlentities($to,ENT_QUOTES,"UTF-8");
    $subject = htmlentities($to,ENT_QUOTES,"UTF-8");
    
    // we cannot push message into html entites or we lose the format
    // of our email so be sure to do that before sending it to this function
    
    // be sure to change Your Site and yoursite to something meaningful
    $mailFrom = "Sigil Dictionary<icarter@uvm.edu>";

    $cc = "";  // ex: $cc = "webmaster@yoursite.com";
    $bcc = ""; // ex: $bcc = "youremail@yoursite.com";

    /* message */
    $messageTop  = '<html><head><title>' . $subject . '</title></head><body>';
    $mailMessage = $messageTop . $message;

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";

    $headers .= "From: " . $mailFrom . "\r\n";

    if ($cc!="") $headers .= "CC: " . $cc . "\r\n";
    if ($bcc!="") $headers .= "Bcc: " . $bcc . "\r\n";

    /* this line actually sends the email */
    $blnMail=mail($to, $subject, $mailMessage, $headers);
    
    return $blnMail;
}

?>