<?php

class LogException {
	
	static function log($message, $type=E_NOTICE) {
		
		if(Symphony::Configuration()->get('enabled', 'exception_notifier') == 'no') return;
		
		require_once 'Airbrake/Client.php';
		require_once 'Airbrake/Configuration.php';
		
		$apiKey = General::Sanitize(Symphony::Configuration()->get('key', 'exception_notifier'));
		
		$message = explode(" ", $message, 2);
		$detail = explode(" - ", $message[1], 2);

		if(!empty($apiKey)) {
			$options = array(
				'host' => General::Sanitize(Symphony::Configuration()->get('host', 'exception_notifier')),
				'environmentName' => General::Sanitize(Symphony::Configuration()->get('environment', 'exception_notifier')),
				'component'  => 'Symphony',
				'action' => $message[0],
				'hostname' => General::Sanitize(Symphony::Configuration()->get('server', 'exception_notifier'))
			);
			
			$config = new Airbrake\Configuration($apiKey, $options);
			$client = new Airbrake\Client($config);
			
			$client->notifyOnError($detail[1], $type);
		
		}
		
	}

}