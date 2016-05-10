<?php

namespace AuthBroker\ExampleClient;

use Exception;
use Guzzle\Stream\PhpStreamRequestFactory;
use League\OAuth1\Client\Server\Server;
use League\OAuth1\Client\Server\User;
use League\OAuth1\Client\Credentials\TokenCredentials;

class WPBroker extends Server {
	protected $broker_url;

	public function __construct($clientCredentials, SignatureInterface $signature = null) {
		parent::__construct($clientCredentials, $signature);
		$this->broker_url = $clientCredentials['broker_url'];
	}

	/**
	 * Generate the OAuth protocol header for a temporary credentials
	 * request, based on the URI.
	 *
	 * @param string $uri
	 *
	 * @return string
	 */
	protected function brokerCredentialsProtocolHeader($uri, $site) {
		$parameters = array_merge($this->baseProtocolParameters(), array(
			'server_url' => $site,
		));

		$parameters['oauth_signature'] = $this->signature->sign($uri, $parameters, 'POST');

		return $this->normalizeProtocolParameters($parameters);
	}

	/**
	 * Gets temporary credentials by performing a request to
	 * the server.
	 *
	 * @return TemporaryCredentials
	 */
	public function requestCredentialsForSite( $site ) {
		$uri = $this->broker_url;

		$client = new \GuzzleHttp\Client;

		$header = $this->brokerCredentialsProtocolHeader($uri, $site);
		$authorizationHeader = array('Authorization' => $header);
		$headers = $this->buildHttpClientHeaders($authorizationHeader);

		$options = array(
			// 'debug' => true,
			'headers'     => $headers,
			'form_params' => array(
				'server_url' => $site,
			),
			'stream'      => true,
		);
		$response = $client->post($uri, $options);

		$credentials = array();

		try {
			$body = $response->getBody()->getContents();
			$data = json_decode( $body, true );
			if ( isset( $data['client_token'] ) && isset( $data['client_secret'] ) ) {
				$credentials = $data;
			} else {
				throw new Exception( sprintf( 'Error returned from broker: %s', $body ) );
			}

		} catch (BadResponseException $e) {
			return $this->handleTemporaryCredentialsBadResponse($e);
		}

		if ( empty( $credentials ) ) {
			// WTF?
			return null;
		}

		return $credentials;
	}
}
