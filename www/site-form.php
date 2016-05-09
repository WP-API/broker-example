<form action="" method="POST">
	<input type="hidden" name="step" value="connect" />

	<h2>Step 1: Enter Details!</h2>
	<p>
		<label>
			Broker connect URL:
			<input type="url" name="broker_url" class="uri-input" required />
			<code>http://broker.local/broker/connect/</code>
		</label>
		<label>
			Client key:
			<input type="text" name="client_key" required />
			<code>8dmCrNJC4Cnh</code>
		</label>
		<label>
			Client secret:
			<input type="text" name="client_secret" required />
			<code>FLEeSGQ3fWVA9FjU41pXgtNnA6kCOrS2nkZ7xv9qG1fuikm2</code>
		</label>
		<label>
			Site to connect to:
			<input type="url" name="site_uri" class="uri-input" required />
			<code>http://api.local/</code>
		</label>
		<button type="submit">Connect</button>
	</p>
</form>
