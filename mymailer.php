<?php 
    require 'vendor/autoload.php';
	
	class MyMailer
	{
		private $sg_username = "";
		private $sg_password = "";
		
		function __construct()
		{
			/* USER CREDENTIALS
			/  Fill in the variables below with your SendGrid
			/  username and password.
			====================================================*/
			$this->sg_username = getenv("SENDGRID_USERNAME");
			$this->sg_password = getenv("SENDGRID_PASSWORD");
		}

		public function send($to)
		{
			/* CREATE THE SENDGRID MAIL OBJECT
			====================================================*/
			$sendgrid = new SendGrid( $this->sg_username, $this->sg_password, array("turn_off_ssl_verification" => true) );
			$mail = new SendGrid\Email();
			
			/*
			//宛名追加
			$subs = array(
				"%name%" => array($name)
			);
			foreach($subs as $tag => $replacements){
				$mail->addSubstitution($tag,$replacements);
			}
			*/
			
			/*
			//テンプレート有効化
			$filters=array(
				"templates" => array(
					"settings" => array(
						"enabled" => 1,
						"template_id" => "55cf2804-cb68-4398-b79b-891cafac942c"
					)
				)
			);
			
			foreach($filters as $filter =>$contents){
				$settings = $contents['settings'];
				foreach($settings as $key =>$value)
				{
					$mail->addFilterSetting($filter,$key,$value);
				}
			}
			*/
			
			/* SEND MAIL
			/  Replace the the address(es) in the setTo/setTos
			/  function with the address(es) you're sending to.
			====================================================*/
			try {
			    $mail->
				    setFrom( "test@sendgridjp.asia" )->
				    addTo( $to )->
				    setSubject( "サンプルメール" )->
				    setText( "こんにちは\n\nこれはサンプルメールです。\n\nお問い合わせ\nご不明な点がございましたらお問い合わせください。\nhttps://sendgrid.kke.co.jp" )->
				    setHtml( "こんにちは<br>\n<br>\nこれはサンプルメールです。<br>\n<br>\nお問い合わせ</span><br>ご不明な点がございましたら<a href='https://sendgrid.kke.co.jp'>お問い合わせ</a>ください。<br>\n" );
			    
			    $response = $sendgrid->send( $mail);
			
			    if (!$response) {
			        throw new Exception("Did not receive response.");
			    } else if ($response->message && $response->message == "error") {
			        throw new Exception("Received error: ".join(", ", $response->errors));
			    } else {
					return $response;
			    }
			} catch ( Exception $e ) {
			    var_export($e);
			}
		}
	}
	