<p>Credentials obtained for <code><?php echo htmlspecialchars( $_SESSION['site_uri'] ) ?></code>.
	<a class="reset" href="?step=reset">Reset?</a></p>

<h3>Broker Information</h3>
<dl>
	<dt>Site URI</dt>
	<dd><?php echo htmlspecialchars( $_SESSION['broker_url'] ) ?></dd>
	<dt>Client Key</dt>
	<dd><code><?php echo htmlspecialchars( $_SESSION['client_key'] ) ?></code></dd>
	<dt>Client Secret</dt>
	<dd><code><?php echo htmlspecialchars( $_SESSION['client_secret'] ) ?></code></dd>
</dl>

<h3>Site Information</h3>
<dl>
	<dt>Site URI</dt>
	<dd><?php echo htmlspecialchars( $_SESSION['site_uri'] ) ?></dd>
	<dt>Client Key</dt>
	<dd><code><?php echo htmlspecialchars( $args['credentials']['client_token'] ) ?></code></dd>
	<dt>Client Secret</dt>
	<dd><code><?php echo htmlspecialchars( $args['credentials']['client_secret'] ) ?></code></dd>
</dl>
