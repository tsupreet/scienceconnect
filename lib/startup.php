<?php
/**
 * Carries out various important initialisations and defines various error handling functions
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
    error_reporting(E_ALL|E_STRICT);

    require_once('config.php');
    require_once('returnMessages.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/local.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/context.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/userregistry.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/userprofile.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/proposals.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/messages.php');
    require_once($_SERVER['DOCUMENT_ROOT'].SUBDIRECTORY.'/class/formreader.php');
/**
 * Send an email message using PHPMailerLite
 *
 * @param $to		string The "To" address
 * @param $subj		string The Subject Line
 * @param $msg		string The message content
 * @return boolean
 */
    function mymail($to, $subj, $msg)
    {
	$ml = new PhpMailerlite();
	$ml->SetFrom('noreply@'.MAILHOST, SITE);
	$ml->Subject = $subj;
	$ml->Body = $msg;
	$ml->AddAddress($to, '');
	return $ml->Send();
    }
/**
 * Debugging output for strings
 */
    function dump_string($var, $level = 0)
    {
	$str = '';
	foreach($var as $i => $value)
	{
	    if(is_array($value) || is_object($value))
	    {
		$str .= "\n\n".dump_string($value, false, ($level +1));
	    }
	    else
	    {
		$str .= "\n".$level.': '.$i.' => "'.$value.'"';
	    }
	}
	return $str;
    }
/**
 * Shutdown function - this is used to catch certain errors that are not otherwise trapped and
 * generate a clean screen as well as an error report to the developers.
 * It also closes the RedBean connection
 */
    function shutdown()
    {
        if ($error = error_get_last())
        {
            if (isset($error['type']) && ($error['type'] == E_ERROR || $error['type'] == E_PARSE || $error['type'] == E_COMPILE_ERROR))
            {
		mymail(implode(',', Local::$sysadmin),
		    'System Error - '.$error['type'].' ',
		    'Type : '.$error['type']."\n".$error['message']."\n".
		    $error['file'].' Line '.$error['line'].dump_string(debug_backtrace()));
		if (!headers_sent())
		{ # haven't generated any output yet.
		    header('HTTP/1.0 500 Internal Server Error');
		    dump_table(debug_backtrace());
		    if (!Context::$ajax)
		    { # not in an ajax page so send a pretty page.....
			require(Local::$subdpath.'/errors/syserror.php');
		    }
		}
		else
		{
		    echo '<div>There has been a system error</div>';
		}
            }
        }
	R::close(); # close RedBean connection
    }
/**
 * Deal with untrapped exceptions - see PHP documentation
 * @param Exception	$e
 */
    function exception_handler($e)
    {
	global $errormsg;

	mymail(implode(',', Local::$sysadmin),
	    'System Error - '.$e->getMessage().' ',
	    'Type : '.get_class($e)."\n".
	    $e->getFile().' Line '.$e->getLine().dump_string(debug_backtrace()));
	if (!headers_sent())
	{ # haven't generated any output yet.
	    header('HTTP/1.0 500 Internal Server Error');
	    if (!Context::$ajax)
	    { # not in an ajax page so send a pretty page.....
		if (Context::$developer)
		{
		    $errormsg =  ''.
			'<p class="left">System Error - '.$e->getMessage().'</p>'.
			'<p class="left">Type : '.get_class($e).'</p><p class="left">'.
			$e->getFile().' Line '.$e->getLine().' '.
			$_SERVER['DOCUMENT_ROOT'].'</p>';
		}
		require(Local::$subdpath.'/errors/syserror.php');
	    }
	}
	exit;
    }
/**
 * Called when a PHP error is detected - see PHP documentation for details
 * @param integer	$errno
 * @param string	$errstr
 * @param string	$errfile
 * @param integer	$errline
 * @param string	$errcontext
 *
 * @return boolean
 */
    function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
    {
	global $errormsg;

	if (Context::$errignore)
	{
	    Context::$wasignored = TRUE;
	    return TRUE;
	}

	mail(implode(',', Local::$sysadmin),
	    'System Error - '.$errno.' '.$errstr.' ',
	    'Type : Error'."\n".
	    $errfile.' Line '.$errline.dump_string(debug_backtrace()));
	if ($errno == E_USER_ERROR)
	{
	    if (!headers_sent())
	    { # haven't generated any output yet.
		header('HTTP/1.0 500 Internal Server Error');
		if (!Context::$ajax)
		{ # not in an ajax page so send a pretty page.....
		    header('HTTP/1.0 500 Internal Server Error');
		    $errormsg =  ''.
			'<p class="left">System Error - '.$errstr.'</p>'.
			'<p class="left">Type : error</p><p class="left">'.
			$errfile.' Line '.$errline.' '.
			$_SERVER['DOCUMENT_ROOT'].'</p>';
		    require(Local::$subdpath.'/errors/syserror.php');
		}
	    }
	    exit;
	}
	return TRUE;
    }

    $errormsg = '';
    set_exception_handler('exception_handler');
    set_error_handler('error_handler');
    register_shutdown_function('shutdown');

/*
 * Set up local values
 */
    Local::initialise();
/*
 * Bring in files we know we need
 */
    require_once('Twig/lib/Twig/Autoloader.php'); # from PHP path
/*
 * Initialise database access
 */
    require('rb.php'); # redbeans interface
   // R::setup('sqlite:'.Local::$subdpath.'/db/database'); # sqlite initialiser
   // R::setup('mysql:host='.DBHOST.';dbname='.DB, DBUSER, DBPW); # mysql initialiser
   R::setup('mysql:host='.DBHOST.'; dbname='.DB,DBUSER,DBPW);
   // R::freeze(TRUE);
?>
