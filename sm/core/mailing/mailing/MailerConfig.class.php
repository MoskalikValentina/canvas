<?php
/**
 * Configures PHPMailer object base on config.php file
 */


class MailerConfig {
    private $from_name;
    private $from_email;
    private $to_emails;
    private $is_html;
    private $use_smtp;
    private $smtp_host;
    private $smtp_auth;
    private $smtp_username;
    private $smtp_password;
    private $smtp_secure;
    private $smtp_port;

    /**
     * @param $config_path string Path to config file
     */
    function __construct($config_path){
//  todo 'Need to clear path'
//  todo 'Nead to check file exist'
        $configs_list = include($config_path);
        $this->parseConfig($configs_list);

    }

    /**
     * @param $configs Array with configs_samples
     */
    private function parseConfig(Array $configs){
    //  todo    Need validate config fields
        $this->from_name = $configs['from_name'];
        $this->from_email = $configs['from_email'];
        $this->to_emails = $configs['to_emails']; // todo Maybe need to check is it array or single
        $this->is_html = $configs['in_html'];
        $this->use_smtp = $configs['use_smtp'];
        if($this->use_smtp){
            $smtp_configs = $configs['smtp_settings'];
            $this->smtp_host = $smtp_configs['host'];
            $this->smtp_auth = $smtp_configs['auth'];
            $this->smtp_username = $smtp_configs['username'];
            $this->smtp_password = $smtp_configs['password'];
            $this->smtp_secure = $smtp_configs['secure'];
            $this->smtp_port = $smtp_configs['port'];
        }
    }

    public function configMailer(PHPMailer $mailer){
        $mailer->From = $this->from_email;
        $mailer->FromName = $this->from_name;

        foreach($this->to_emails as $email){
            $mailer->addAddress($email);
        }

        if($this->is_html){
            $mailer->isHTML(true);
        }

        if($this->use_smtp){
            $this->smtpConfig($mailer);
        }
    }

    function smtpConfig(PHPMailer $mailer){
        $mailer->isSMTP();
        $mailer->Host = $this->smtp_host;
        $mailer->Port = $this->smtp_port;
        if($this->smtp_auth){
            $mailer->SMTPAuth = true;
            $mailer->Username = $this->smtp_username;
            $mailer->Password = $this->smtp_password;
            $mailer->SMTPSecure = $this->smtp_secure;
        }

    }

}