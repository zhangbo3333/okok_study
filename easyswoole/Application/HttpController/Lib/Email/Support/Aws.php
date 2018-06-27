<?php


namespace App\HttpController\Lib\Email\Support;
use PHPMailer\PHPMailer\PHPMailer;

class Aws extends BaseEmail
{
    public $PHPMailer;

    public $provider = 'aws';
    private $smtpKey = 'AKIAJE353SOUXYK5P4UA';
    private $smtpSectrt = 'AhTf8eokqpm+buQszf7Fa80/33bJbqLMUWm2NRwKzM3f';
    private $host = 'email-smtp.us-west-2.amazonaws.com';
    private $from = 'noreply@service.bitboole.com';
    private $SMTPAuth = true;

    private $SMTPSecure = 'tls';
    private $port = 587;

    private $isHtml = true;

    public $subject = 'Amazon SES test (SMTP interface accessed using PHP)';
    public $altBody = "Email Test\r\nThis email was sent through the 
    Amazon SES SMTP interface using the PHPMailer class.";
    public function __construct()
    {
        $this->PHPMailer = new PHPMailer;
        $this->PHPMailer->isSMTP();
        $this->PHPMailer->setFrom($this->from,'Sender Name');
        $this->PHPMailer->Username = $this->smtpKey;
        $this->PHPMailer->Password = $this->smtpSectrt;
        $this->PHPMailer->Host = $this->host;
        $this->PHPMailer->Subject = $this->subject;
        $this->PHPMailer->SMTPAuth = $this->SMTPAuth;
        $this->PHPMailer->SMTPSecure = $this->SMTPSecure;
        $this->PHPMailer->Port = $this->port;
        $this->PHPMailer->isHTML($this->isHtml);
        $this->PHPMailer->AltBody =$this->altBody;

    }

    public  function send($email, $content,$config = [])
    {
        if(!empty($config)){
            foreach($config as $k=>$v)
            {
                if(isset($this->$k)){
                    $this->$k = $v;
                }
            }
        }
        $this->PHPMailer->addAddress($email, 'Recipient Name');
        $this->PHPMailer->Body = $content;
        try{

            $result = $this->PHPMailer->send();
            var_dump($result);
            return ['server_provider'=>'aws','result'=>'ok'];
        }catch(\Exception $e){
            //todo
        }

    }
}