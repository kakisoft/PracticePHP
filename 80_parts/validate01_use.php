<?php

public function validateForInsert(){
	$this->errMessageArray = [];

	$this->checkForRequired('email'        , $this->email);
	$this->checkForRequired('email_confirm', $this->email_confirm);
	$this->checkForEmailConfirmInput('email', $this->email, $this->email_confirm);
	$this->checkForEmailStyleLegacy('email', $this->email);
	$this->checkForDuplicateEmail('email', $this->email);

	$this->checkForRequired('password'    , $this->password);
	$this->checkForPasswordPolicy('password', $this->password);

	$this->checkForRequiredSelect('admin', $this->admin);

	$this->checkForRequired('company_name', $this->company_name);
	$this->checkForRequired('user_nm'     , $this->user_nm);
	$this->checkForRequired('address'     , $this->address);
	$this->checkForRequired('tel'         , $this->tel);

	$this->checkForTelStyleLegacy('tel', $this->tel);
	$this->checkForUrlStyleLegacy('url', $this->url);


	$this->setErrorJudgmentProperties();
}



