<?php
error_reporting(E_ALL& ~(E_NOTICE | E_USER_NOTICE));
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
	if (error_reporting() == 0 && $errno != E_WARNING && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE)
	{
		return;
	}
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
//die($errno);
    switch ($errno) {
    case E_STRICT:
    case E_ERROR:
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile<br />";
array_walk(debug_backtrace(),create_function('$a,$b','print "{$a[\'function\']}()(".basename($a[\'file\']).":{$a[\'line\']}); ";'));		echo "<br />";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit();
        break;

    case E_WARNING:
    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        echo "  Warning error on line $errline in file $errfile<br />";
        break;

    //case E_NOTICE:
    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        echo "  Notice error on line $errline in file $errfile<br />\n";
        break;

 /*   default:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;*/
    }

    /* Don't execute PHP internal error handler */
    return true;
}
?>