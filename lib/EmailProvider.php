<?php
/**
 * ISP configuration provider using Mozilla ISPDB
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @copyright Copyright (c) 2014, Andreas Goetz <cpuidle@gmx.de>
 * @package MozillaMailConfig
 */

namespace MozillaMailConfig;

use Doctrine\Common\Collections;

class EmailProvider {

	const ISPDB = "https://autoconfig.thunderbird.net/v1.1/";

	protected $domain;
	protected $name;
	protected $shortName;

	protected $incomingServer;
	protected $outgoingServer;

	public function __construct($xmlDoc = null) {
		$this->domain = array();
		// $this->domain = new Collections\ArrayCollection();

		$this->incomingServer = new Collections\ArrayCollection();
		$this->outgoingServer = new Collections\ArrayCollection();

		if ($xmlDoc) {
			$this->parseConfiguration($xmlDoc);
		}
	}

	/**
	 * Parse Mozilla ISP database xml result
	 */
	public function parseConfiguration($xmlDoc) {
		if (false === ($xml = simplexml_load_string($xmlDoc)))
			throw new \RuntimeException('Failed parsing xml');

		if (!isset($xml->emailProvider))
			throw new \RuntimeException('Error parsing xml: emailProvider not found');

		foreach ($xml->emailProvider[0]->domain as $domain) {
			$this->domain[] = (string)$domain;
		}

		if (isset($xml->emailProvider[0]->displayName)) {
			$this->name = $xml->emailProvider[0]->displayName;
		}

		if (isset($xml->emailProvider[0]->displayShortName)) {
			$this->shortName = $xml->emailProvider[0]->displayShortName;
		}

		foreach ($xml->emailProvider->incomingServer as $serverConfig) {
			$server = new IncomingServer($serverConfig);
			$this->incomingServer->add($server);
		}

		foreach ($xml->emailProvider->outgoingServer as $serverConfig) {
			$server = new OutgoingServer($serverConfig);
			$this->outgoingServer->add($server);
		}

		return true;
	}

	public function imap() {
		return ($this->incomingServer->filter(function($server) {
			return IncomingServer::TYPE_IMAP === $server->getType();
		}));
	}

	public function pop3() {
		return ($this->incomingServer->filter(function($server) {
			return IncomingServer::TYPE_POP3 === $server->getType();
		}));
	}

	public function smtp() {
		return ($this->outgoingServer->filter(function($server) {
			return OutgoingServer::TYPE_SMTP === $server->getType();
		}));
	}

	/*
	 * Getter functions
	 */
	public function getDomain() { return($this->domain); }
	public function getName() { return($this->name); }
	public function getShortName() { return($this->shortName); }
}

?>
