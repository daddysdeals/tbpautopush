<?php
require_once('../secure/config.php');
require_once('classes/tbp_soap_client.class.php');
require_once('classes/db.class.php');

// create an instance of the TBP_SoapClient class, which will be used to call the TouchBasePro web services
$soapClient = new TBP_SoapClient(TBP_WSDL_URL, TBP_USERNAME, TBP_PASSWORD);

// store the API fields into variables, so they can dynamically be used to retrieve fields from restul objects 
$tbp_api_subscriber_id_field = TBP_API_SUBSCRIBER_ID_FIELD;
$tbp_api_error_message = TBP_API_ERROR_MESSAGE;



// create a new database connection used for the log operations
$log_db = new Db($db_log_connection['connection']['host'], $db_log_connection['connection']['username'], $db_log_connection['connection']['password'], $db_log_connection['connection']['database']);

// loop through the connections defined in config.php
foreach($db_to_tbp_connections as $conn) {
	
	// create a new database connection for each connection defined in config.php
	$db = new Db($conn['connection']['host'], $conn['connection']['username'], $conn['connection']['password'], $conn['connection']['database']);
	
	// loop through the queries defined for each connection
	foreach($conn['queries'] as $query) {
		// run each query and load the data from the tables		
		$rows = $db->getData($query['query']);
		
		// log the import operation
		$log_data = array(
			'database' => $conn['connection']['database'],
			'table' => $query['table'],
			'city' => $query['city']
		);
		$log_db->insertData($db_log_connection['log_import_query'], $log_data);
		$import_id = $log_db->getLastInsertedId();
		
		// loop through the subscribers
		foreach($rows as $row) {
			$successfulImport = 1;
			$tbpSubscriberId = '';
			
			// save the current subscriber to TouchBasePro
			try {
				$soapResult = $soapClient->saveSubscriber($conn['tbp_list_id'], $row[EMAIL_FIELD]);
				if($soapResult->$tbp_api_error_message != '') {
					// unsuccessful operation
					$successfulImport = 0;
				} else {
					// successful operation; get the GUID of the newly inserted subscriber
					$tbpSubscriberId = $soapResult->$tbp_api_subscriber_id_field;
				}
			} catch(Exception $e) {
				$successfulImport = 0;
			}

			// log the subscriber import operation
			$subscriberData = array(
				'import_id' => $import_id,
				'email' => $row[EMAIL_FIELD], 
				'import_status' => $successfulImport,
				'tbp_subscriber_id' => $tbpSubscriberId
			);
			$log_db->insertData($db_log_connection['log_subscriber_import_query'], $subscriberData);
		}		
	}
	
	// close the current connection since it's not needed anymore
	$db->close();
}

// close the database connection used for logging operations
$log_db->close();
?>