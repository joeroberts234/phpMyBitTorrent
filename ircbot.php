<?php

/**
 * @author Felix Oghina
 * @desc A bot that connects to an IRC server and joins a particular channel. This is the main class that handles the connection.
 * @version 0.0.2
 * @copyright 2008 Felix OGhina
 */
class PhpIrc {
	
	var $_NAME_ = "PhpIrc Bot";
	var $_VERSION_ = "0.0.2";
	var $_DEBUG_ = false;
	
	var $C = Array (
		'RPL_ENDOFMOTD' => 376
	);
	
	/**
	 * @desc Class constructor. This connects to the server and logs in.
	 * @param $hostname Hostname of the server to connect to.
	 * @param $channel The channel to join.
	 * @param $nickname The nickname to use.
	 * @param $port Optional argument specifying the port on which to connect. Defaults to 6667.
	*/
	function __construct($hostname, $channel, $nickname, $port = 6667) {
		
		// Set time limit to be infinite.
		set_time_limit(0);
		// This makes php fill the $php_errormsg var with the last php error.
		if (!ini_get('track_errors')) ini_set('track_errors', true);
		
		// Save the arguments so they can be used by other functions, too.
		$this->hostname = $hostname;
		$this->channel  = $channel;
		$this->nickname = $nickname;
		$this->port     = $port;
		
		// Connect to the server.
		$this->fpSocket = @fsockopen($hostname, $port, $errno, $errstr, 10);
		if (!$this->fpSocket) {
			trigger_error("[" . __METHOD__ . "] Error #{$errno}: {$errstr}", E_USER_WARNING);
			return;
		}
		// Make the socket blocking and set the read/write timeout to 10 seconds.
		stream_set_blocking($this->fpSocket, true);
		stream_set_timeout($this->fpSocket, 10);
		
		// Get machine's hostname (UNIX only)
		$local_hostname = trim(@file_get_contents("/etc/hostname"));
		if (!$local_hostname) $local_hostname = "localhost"; // Non-UNIX OSes
		
		// Log in.
		$this->send("NICK {$nickname}");
		$this->send("USER {$nickname} {$local_hostname} {$hostname} :{$this->_NAME_} {$this->_VERSION_}");
		
		
		// Start the message receive / send loop..
		$this->message_loop();
		
	}
	
	/**
	 * @desc Receives messages from the server and responds to them by case.
	 */
	function message_loop() {
		
		$cmd = '';
		while (!feof($this->fpSocket)) {
			
			// Read data from socket.
			$buf = @fread($this->fpSocket, 1024);
			if ($buf === false) trigger_error("[" . __METHOD__ . "] Error: {$php_errormsg}\nWhile reading from socket.", E_USER_WARNING);
			$cmd .= $buf;
			if (strpos($cmd, "\n") === false) continue;
			$cmd_array = explode("\n", substr($cmd, 0, strrpos($cmd, "\n")));
			$cmd = substr($cmd, strrpos($cmd, "\n")+1);
			
			// Parse received commands
			foreach($cmd_array as $cur_cmd) {
				if ($this->_DEBUG_) echo '>> ' . $cur_cmd . "\n";
				$cmd_args = explode(" ", $cur_cmd);
				$num = intval($cmd_args[1]);
				
				// Numeric reply
				if ($cur_cmd[0] == ':' && $num) {
					switch ($num) {
						case $this->C['RPL_ENDOFMOTD']:
							$this->send("JOIN {$this->channel}");
							$this->send_message("hello");
							break;
					}
				}
				
				// Non-numeric command
				else {
					$switch_by = ($cur_cmd[0] == ':') ? $cmd_args[1] : $cmd_args[0];
					switch ($switch_by) {
						case "PING":
							$this->send("PONG {$cmd_args[1]}");
							break;
						case "PRIVMSG":
							unset($cmd_args[0], $cmd_args[1], $cmd_args[2]);
							$msg = trim(substr(implode(" ", $cmd_args), 1));
							if ($msg == $this->nickname) $this->send_message("What?");
							else if ($msg == "talk") $this->send_message("What do you want me to tell you?");
							else if ($msg == "about you") $this->send_message("I'm {$this->_NAME_} v{$this->_VERSION_}. Nice to meet you.");
							else if ($msg == "bye bye") {
								$this->send_message("I shall go now. I have to.. uhm... compile something..");
								$this->send("QUIT :Compile error!");
							}
							break;
						case "ERROR":
							if ($cmd_args[1] . $cmd_args[2] == ":Closing Link:") break 3;
							break;
					}
				}
			}
		
		}
		
		// Close socket
		fclose($this->fpSocket);
	}
	
	/**
	 * @desc Send a command to the IRC Server.
	 * @param $string The command to send.
	*/
	function send($string) {
		
		// Append a newline character to the string because that's how IRC commands are formed.
		$command = $string . "\n";
		$bytes = @fwrite($this->fpSocket, $command);
		if ($bytes === false) trigger_error("[" . __METHOD__ . "] Error: {$php_errormsg}\nWhile sending command: {$string}", E_USER_WARNING);
		// If we're debugging, output the sent command.
		if ($this->_DEBUG_) echo '<< ' . $command;
		
	}
	
	/**
	 * @desc Send a message to the channel.
	 * @param $string The message to send.
	 */
	 function send_message($string) {
	 	
	 	$this->send("PRIVMSG {$this->channel} :{$string}");
	 	
	 }
	 
}
$chan = "#JP";
$server = "irc.p2p-network.net";
$port = 6666;
$nick = "JP-bot";

$irc = new PhpIrc($server, $chan, $nick, $port);

?>