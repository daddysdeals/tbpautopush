<?php
// Your TouchBasePro username
define('TBP_USERNAME', 'your_TBP_username_here');

// Your TouchBasePro password
define('TBP_PASSWORD', 'your_TBP_password_here');

// The URL to the TouchBasePro web service WSDL document
define('TBP_WSDL_URL', 'https://www.touchbasepro.com/ws/api_linq.asmx?WSDL');

// The TouchBasePro API result field holding the ID of the newly created subscriber
define('TBP_API_SUBSCRIBER_ID_FIELD', 'SubscriberID');

// The TouchBasePro API result field holding the error message generated during an operation
define('TBP_API_ERROR_MESSAGE', 'strFailReason');

// The field from the database queries used to load the e-mail of the subscribers
define('EMAIL_FIELD', 'email');

// The time interval used by the CRON job (minutes)
define('CRON_INTERVAL', 60); // run every hour

/* The array containing all the database connections from where data needs to be imported
 * 
 * Each database connection is defined as an array, containing the DB credentials, 
 * the queries use to extract data and the ID of the TouchBasePro list where the subscribers will be added
 * Example:
 * 
 * array(
 * 		The ID of the list (this is the GUID of the TouchBasePro list)
 * 		'tbp_list_id' => '64a02c4d-d44e-4f85-a608-5b0e295a1ddd',
 * 		
 * 		The database connection credentials
 * 		'connection' => array(
 * 			'host' => 'database.domain.com',
 * 			'username' => 'username_here',
 * 			'password' => 'password_here'
* 			'database' => 'database_name'
 * 		),
 * 
 * 		The SQL queries used to extract data
 * 		If the field holding the e-mails has a different name than "email", use an ALIAS
 * 		'queries' => array(
 * 			array(
 * 				'city' => 'Cape Town', 'query' => 'SELECT email FROM user_list1 WHERE city_id = 7;'
 * 			),
 * 			array(
 * 				'city' => 'Johannesburg', 'query' => 'SELECT email_address AS email FROM user_list2 WHERE city_id = 1;'
 * 			)
 * 		)
 * 
 * 
 */ 
$db_to_tbp_connections = array(
	array(
		'tbp_list_id' => '72a02c4d-b44d-4f94-a608-5b0e495a1ddd',
		'connection' => array(
			'host' => 'localhost',			
			'username' => 'db_user',
			'password' => 'db_pass',
			'database' => 'database1'
		),
		'queries' => array(
			array(
				'city' => 'Cape Town', 
				'query' => 'SELECT email FROM table1 WHERE city_id = 1 AND TIMESTAMPDIFF(MINUTE,date_created, NOW()) < ' . CRON_INTERVAL, 
				'table' => 'table1'
			),
			array(
				'city' => 'Johannesburg', 
				'query' => 'SELECT email_address AS email FROM table2 WHERE city_id = 10 AND TIMESTAMPDIFF(MINUTE,date_created, NOW()) < ' . CRON_INTERVAL,
				'table' => 'table2')
		)
	),
	array(
		'tbp_list_id' => 'e3014f89-49e2-4742-5a34-64bc8b64733a',
		'connection' => array(
			'host' => 'localhost',
			'username' => 'db_user',
			'password' => 'db_pass',
			'database' => 'database2'
		),
		'queries' => array(
			array(
				'city' => 'Cape Town',
				'query' => 'SELECT email FROM table1 WHERE city_id = 1 AND TIMESTAMPDIFF(MINUTE,date_created, NOW()) < ' . CRON_INTERVAL,
				'table' => 'table1'
			),
			array(
				'city' => 'Johannesburg', 
				'query' => 'SELECT email FROM table1 WHERE city_id = 2 AND TIMESTAMPDIFF(MINUTE,date_created, NOW()) < ' . CRON_INTERVAL, 
				'table' => 'table1'
			)
		)
	)
);

/*
 * An array containing the database credentials and the queries used to log each import operation
 */
$db_log_connection = array(
	'connection' => array(
		'host' => 'localhost',			
		'username' => 'db_user',
		'password' => 'db_pass',
		'database' => 'ddeals_admin'
	),
	
	// query used to log an import operation
	'log_import_query' => "INSERT INTO tbp_imports (`database`, `table`, `city`) VALUES('{database}', '{table}', '{city}')",
	
	// query used to log the import of each subscriber
	'log_subscriber_import_query' => "INSERT INTO tbp_imports_subscribers (import_id, email, import_status, tbp_subscriber_id) VALUES({import_id}, '{email}', {import_status}, '{tbp_subscriber_id}')"
);
?>