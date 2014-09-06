<?php
/**
 * ISP configuration provider using Mozilla ISPDB
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @copyright Copyright (c) 2014, Andreas Goetz <cpuidle@gmx.de>
 * @package MozillaMailConfig
 */

namespace MozillaMailConfig;

abstract class AbstractServer {

	public static SOCKET_TYPE_PLAIN = 'plain';
	public static SOCKET_TYPE_STARTTLS = 'STARTTLS';
	public static SOCKET_TYPE_SSL = 'SSL';

	public static USERNAME_EMAIL = '%EMAILADDRESS%';

	public static AUTHENTICATION_CLEARTEXT = 'password-cleartext';
	public static AUTHENTICATION_ENCRYPTED = 'password-encrypted';

	protected $type;
	protected $hostname;
	protected $port;
	protected $socketType;
	protected $username;
	protected $authentication;

	public function __construct($xml = null) {
		if ($xml) {
			$this->parseConfiguration($xml);
		}
	}

	/**
	 * Parse Mozilla ISP database xml result
	 */
	public function parseConfiguration($xml) {
		if (isset($xml['type']))
			$this->type = (string)$xml['type'];

		if (isset($xml->hostname))
			$this->hostname = (string)$xml->hostname;

		if (isset($xml->port))
			$this->port = (int)$xml->port;

		if (isset($xml->socketType))
			$this->socketType = (string)$xml->socketType;

		if (isset($xml->username))
			$this->username = (string)$xml->username;

		if (isset($xml->authentication))
			$this->authentication = (string)$xml->authentication;

		return true;
	}

	/*
	 * Getter
	 */
	public function getType() { return ($this->type); }
	public function getHostname() { return ($this->hostname); }
	public function getPort() { return ($this->port); }
	public function getSocketType() { return ($this->socketType); }
	public function getUsername() { return ($this->username); }
	public function getAuthentication() { return ($this->authentication); }
}

?>
