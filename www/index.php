<?php

namespace AuthBroker\ExampleClient;

use Exception;

require dirname( __DIR__ ) . '/vendor/autoload.php';
require dirname( __DIR__ ) . '/broker.php';
require __DIR__ . '/helpers.php';

// Start session
session_start();

// Handle CSS on local server.
if ( $_SERVER['REQUEST_URI'] === '/style.css' ) {
	header( 'Content-Type: text/css; charset=utf-8' );
	readfile( __DIR__ . '/style.css' );
	return;
}

// What should we show?
$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : '';
switch ( $step ) {
	// Step 0: Pre-Connect
	case '':
		return output_page( load_template( 'site-form' ) );

	// Step 1: Connect
	case 'connect':
		foreach ( [ 'broker_url', 'client_key', 'client_secret', 'site_uri' ] as $key ) {
			if ( empty( $_POST[ $key ] ) ) {
				var_dump( $key );
				return output_page( load_template( 'site-form' ) );
			}
		}

		$_SESSION['broker_url'] = $_POST['broker_url'];
		$_SESSION['client_key'] = $_POST['client_key'];
		$_SESSION['client_secret'] = $_POST['client_secret'];
		$_SESSION['site_uri'] = $_POST['site_uri'];

		$server = get_server();
		$credentials = $server->requestCredentialsForSite( $_POST['site_uri'] );
		return output_page( load_template( 'connected', compact( 'credentials' ) ), 'Connected' );

	// Reset session data
	case 'reset':
		session_destroy();

		// Redirect back to the start
		$here = get_requested_url();
		header("Location: {$here}");
		return;
}
