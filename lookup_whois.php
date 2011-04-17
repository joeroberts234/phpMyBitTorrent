<?php
include'header.php';
function getwhois($domain, $tld)
    {                                                   
        require_once("whois.php");

        $whois = new Whois();

            if( !$whois->ValidDomain($domain.'.'.$tld) ){
                   // return 'Sorry, the domain is not valid or not supported.';
            }

        if( $whois->Lookup($domain.'.'.$tld) )
        {
            return $whois->GetData(1);
        }else{
            return 'Sorry, an error occurred.';
        }
    }
function user_ipwhois($ip)
{
	$ipwhois = '';

	// Check IP
	// Only supporting IPv4 at the moment...
	if (empty($ip))
	{
		return '';
	}

	$match = array(
		'#RIPE\.NET#is'				=> 'whois.ripe.net',
		'#whois\.apnic\.net#is'		=> 'whois.apnic.net',
		'#nic\.ad\.jp#is'			=> 'whois.nic.ad.jp',
		'#whois\.registro\.br#is'	=> 'whois.registro.br'
	);

	if (($fsk = @fsockopen('whois.arin.net', 43)))
	{
		fputs($fsk, "$ip\n");
		while (!feof($fsk))
		{
			$ipwhois .= fgets($fsk, 1024);
		}
		@fclose($fsk);
	}

	foreach (array_keys($match) as $server)
	{
		if (preg_match($server, $ipwhois))
		{
			$ipwhois = '';
			if (($fsk = @fsockopen($match[$server], 43)))
			{
				fputs($fsk, "$ip\n");
				while (!feof($fsk))
				{
					$ipwhois .= fgets($fsk, 1024);
				}
				@fclose($fsk);
			}
			break;
		}
	}

	$ipwhois = htmlspecialchars($ipwhois);

	// Magic URL ;)
	return $ipwhois;
}

        $domain = $domain;

        $dot = strpos($domain, '.');
        $sld = substr($domain, 0, $dot);
        $tld = substr($domain, $dot+1);                     
   
   
        echo "<pre>";
        echo user_ipwhois($domain);
        echo "</pre>";
		include'footer.php';
?>
