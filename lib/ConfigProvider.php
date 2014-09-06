<?php
/**
 * ISP configuration provider using Mozilla ISPDB
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @copyright Copyright (c) 2014, Andreas Goetz <cpuidle@gmx.de>
 * @package MozillaMailConfig
 */

namespace MozillaMailConfig;

class ConfigProvider {

	const ISPDB = "https://autoconfig.thunderbird.net/v1.1/";

	/**
	 * Extract domain part from email address
	 */
	public function extractDomain($domain) {
		// remove email address if present
		if ($pos = strpos($domain, '@')) {
			$domain = substr($domain, $pos + 1);
		}
		return $domain;
	}

	/**
	 * Lookup email address or domain in Mozilla ISP db
	 */
	public function lookup($email) {
		$domain = $this->extractDomain($email);

		if (false === ($document = @file_get_contents(self::ISPDB . $domain))) {
			return false;
		}

		$emailProvider = new EmailProvider($document);

		return $emailProvider;
	}
}

?>
