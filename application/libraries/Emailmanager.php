<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Emailmanager {
    public $mail; 
    public $isHtml;
    public function __construct() {
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();                 // Set mailer to use SMTP
        $this->mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;          // Enable SMTP authentication
        $this->mail->Username = 'nileshkumar.gupta4@gmail.com';  // SMTP username
        $this->mail->Password = 'nilesh2521';  // SMTP password
        $this->mail->SMTPSecure = 'tls';       // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 587;
        $this->isHtml = true;
    }
    
    public function sendEmail(){
        if(!$this->mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            } else {
                echo 'Message has been sent'; 
            }
    }

    public function setIsHtml($flag=true){
        $this->mail->isHTML($flag);
        $this->isHtml = $flag;
    }

    public function setToReplyEmail($replyToEmail="info@example.com",$replyToName="Information"){
        $this->mail->addReplyTo($replyToEmail, $replyToName);   
    }

    public function setToEmail($toEmail,$toName=""){
        if($toName!=""){
            $this->mail->addAddress($toEmail,$toName);
        }else{
            $this->mail->addAddress($toEmail);
        }
    }

    public function setFromEmail($fromEmail="nileshkumar.gupta4@gmail.com",$fromName="Nilesh"){
        if($fromName!=""){
            $this->mail->setFrom($fromEmail,$fromName);
        }else{
            $this->mail->setFrom($fromEmail);
        }
    }

    public function setCCEmail($ccEmail=""){
        if($ccEmail!=""){
            $this->mail->addCC($ccEmail);
        }
    }

    public function setBCCEmail($bccEmail=""){
        if($bccEmail!=""){
            $this->mail->addBCC($bccEmail);
        }
    }

    public function setEmailAttacthment($file,$filename=""){
        if($filename!=""){
            $this->mail->addAttachment($file, $filename); 
        }else{
            $this->mail->addAttachment($file); 
        }
    }

    public function setEmailSubject($subject){
        $this->mail->Subject = $subject;
    }

    public function setEmailBody($message){
        var_dump($this->isHtml);
        if($this->isHtml){
             $this->mail->Body = $message;
        }else{
            $this->mail->AltBody = $message;
        }
    }
}