<?php
namespace Application\Modules\Main\Forms;

class Test extends \Saros\Form
{
	function __construct()
	{
		parent::__construct("testForm");
		//$this
		//	->setAction(array('index','form'))
		//	->setMethod(Saros_Form::DATA_POST);

		$this
			->addElement("text", "username")
			->setLabel("Username")
			->setDescription("Enter your username!")
			->setRequired(true)
			->addValidator("minLength", array(4), false);

		$this
			->addElement("text", "email")
			->setLabel("Email!")
			->setDescription("Enter your email address!")
			->addValidator("email");

		$this->addElement("reCaptcha", "captcha")
			->setLabel("Captcha")
			->setPublicKey("6LfcwQUAAAAAAHPESvBlbU72AP7XE-dHxfqPdgFa")
			->setPrivateKey("6LfcwQUAAAAAAJQvcxnz-diD9GOxqh58fCKHiV6h");

		$this->addSubmit("submit");
	}
}