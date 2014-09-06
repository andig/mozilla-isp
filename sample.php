<?php
/**
 * ISP configuration sample
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @copyright Copyright (c) 2014, Andreas Goetz <cpuidle@gmx.de>
 * @package MozillaMailConfig
 */

require_once 'vendor/autoload.php';

$provider = new MozillaMailConfig\ConfigProvider();
$emailConfig = $provider->lookup('test@gmx.de');

foreach (array('smtp', 'pop3', 'imap') as $type) {
	echo(strtoupper($type) . "servers:\n");

	foreach ($emailConfig->$type() as $server) {
		echo("Server name: " . $server->getHostname());
		echo("Port: " . $server->getPort() . "\n");
		echo("Socket type: " . $server->getSocketType() . "\n");
		echo("Username: " . $server->getUsername() . "\n");
		echo("Authentication: " . $server->getAuthentication() . "\n");
		echo("\n");
	}

	echo("\n");
}
