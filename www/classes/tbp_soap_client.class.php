<?php
/*
 * Custom class extending SoapClient, used to call SOAP web services from TouchBasePro
 */
class TBP_SoapClient extends SoapClient {
	private $tbp_username;
	private $tbp_password;
	
	public function __construct($wsdl_url, $tbp_username, $tbp_password) {
		$this->tbp_username = $tbp_username;
		$this->tbp_password = $tbp_password;
		
		return parent::__construct($wsdl_url);
	}
	
	public function saveSubscriber($listId, $email) {
		return $this->AddSubscriber(
			array(
				'SubscriberListID' => $listId,
				'username' => $this->tbp_username,
				'password' => $this->tbp_password,
				'NewSubscriber' => array(		
					'isEmail' => true,
					'ID' => '00000000-0000-0000-0000-000000000000',
					'Identifier' => $email,
					'DT' => date('Y-m-d') . 'T' . date('h:i:s'),
					'BounceCount' => '0',
					'SubscriberStatus' => 'ActiveAndSubscribed'
				)
			)
		);
	}
}
?>