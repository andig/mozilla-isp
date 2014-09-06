<?php
/**
 * ISP configuration provider using Mozilla ISPDB
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @copyright Copyright (c) 2014, Andreas Goetz <cpuidle@gmx.de>
 * @package MozillaMailConfig
 */

namespace MozillaMailConfig;

class IncomingServer extends AbstractServer {

	public static TYPE_IMAP = 'imap';
	public static TYPE_POP3 = 'pop3';

}

?>
