<?php

namespace AuthBroker\ExampleClient;

function output_page( $content, $title = 'Connect', $error = '' ) {
	require __DIR__ . '/layout.php';
};

function load_template( $template, $args = array() ) {
	ob_start();
	require __DIR__ . '/' . $template . '.php';
	return ob_get_clean();
}

function get_requested_url() {
	$scheme = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] ) ? 'https' : 'http';
	$here = $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
		// Strip the query string
		$here = str_replace( '?' . $_SERVER['QUERY_STRING'], '', $here );
	}

	return $here;
}

function get_server() {
	date_default_timezone_set('UTC');

	$server = new WPBroker(array(
		'identifier'   => $_SESSION['client_key'],
		'secret'       => $_SESSION['client_secret'],
		'broker_url'   => $_SESSION['broker_url']
	));
	return $server;
}
