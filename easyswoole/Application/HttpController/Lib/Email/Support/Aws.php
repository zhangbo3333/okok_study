<?php


namespace App\HttpController\Lib\Email\Support;
use PHPMailer\PHPMailer\PHPMailer;
use EasySwoole\Config;

class Aws extends BaseEmail
{
    public $PHPMailer;

    public $provider = 'aws';

    private $Host;
    private $from;
    private $SMTPAuth;
    private $SMTPSecure;
    private $Port;

//    public $subject = 'Amazon SES test (SMTP interface accessed using PHP)';
//    public $altBody = "Email Test\r\nThis email was sent through the
//    Amazon SES SMTP interface using the PHPMailer class.";
    public function __construct()
    {
        $this->PHPMailer = new PHPMailer;
        $this->PHPMailer->isSMTP();
        $this->initParams();
    }

    public  function send($email,$body,$name,$subject,$altBody = '',$config = [])
    {
        if(!empty($config)){
            foreach($config as $k=>$v)
            {
                if(isset($this->$k)){
                    if($k == 'provider' || $k == 'PHPMailer'){
                        continue;
                    }
                    $this->PHPMailer->$k = $v;
                }
            }
        }
        $this->PHPMailer->setFrom($this->from,$name);
        $this->PHPMailer->addAddress($email, 'Recipient Name');
        $this->PHPMailer->Subject = $subject;
        $this->PHPMailer->AltBody = $altBody;
        $this->PHPMailer->Body = $body;
        try{
            $result = $this->PHPMailer->send();
            if($result){
                return ['server_provider'=>$this->provider,'result'=>'ok','receive_time'=>date('Y-m-d H:i:s')];
            }else{
                return ['server_provider'=>$this->provider,'result'=>'','remark'=>$this->PHPMailer->ErrorInfo];
            }
        }catch(\Exception $e){
            //todo
        }

    }

    public function initParams()
    {
        $conf = Config::getInstance()->getConf('AWS_SMTP');
        $this->PHPMailer->isSMTP();
        $this->PHPMailer->Username = $conf['KEY'];
        $this->PHPMailer->Password = $conf['SECRET'];
        $this->PHPMailer->Host = $conf['HOST'];
        $this->PHPMailer->SMTPAuth = $conf['AUTH'];
        $this->PHPMailer->SMTPSecure = $conf['SECURE'];
        $this->PHPMailer->Port = $conf['PORT'];
        $this->PHPMailer->isHTML($conf['IS_HTML']);
        $this->PHPMailer->CharSet = $conf['CHARSET'];
        $this->from = $conf['FROM'];
    }
}