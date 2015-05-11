<?php
/**
 */

// todo Need to write Readmen.txt

class Mailer{
    private $config_path;
    private $mailer;

    public function __constract(){


    }

    /*
     * Load classes and config mailer
     * @param $conf_path String path to conf file
     */
    public function init($conf_path){
        include_once BASEDIR . 'sm/core/mailing/mailing/PHPMailer/class.phpmailer.php';
        include_once BASEDIR . 'sm/core/mailing/mailing/PHPMailer/class.smtp.php';
        include_once BASEDIR . 'sm/core/mailing/mailing/PHPMailer/class.pop3.php';
        include_once BASEDIR . 'sm/core/mailing/mailing/MailerConfig.class.php';
        $this->config_path = $conf_path;
        $this->mailer = new PHPMailer();
        //$this->mailer->SMTPDebug = 3;
        $config = new MailerConfig($this->config_path);
        $config->configMailer($this->mailer);
    }

    /*
     * Send mail
     */
    public function send_email($subject = 'Here is the subject', $body = 'This is the HTML message body'){
        //Encoding set
        $this->mailer->CharSet = "Windows-1251";
        //Subject set
        $subject = iconv("UTF-8", "WINDOWS-1251", $subject);
        $this->mailer->Subject = $subject;
        //Body set
        $body = iconv("UTF-8", "WINDOWS-1251", $body);
        $this->mailer->Body = $body;

        if(!$this->mailer->send()) {
            echo 'Message could not be sent.<br>';
            if($this->mailer->SMTPDebug === 3){
                echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
            }
        } else {
            if($this->mailer->SMTPDebug === 3){
                echo 'Message has been sent';
            }
        }
    }
}



