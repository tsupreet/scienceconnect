<?php
/**
 * A class that uses statics to store various useful pieces of data for access throught out the rest of the system.
 * This is never instantiated as an object and has no non-static members
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
    class Context
    {
	public static $debug		= FALSE;
	public static $developer	= FALSE;
	public static $ajax		= FALSE;	# used when dealing with errors. Handle them differently in ajax calls
	public static $errignore	= FALSE;	# needed for checking preg expressions....
	public static $wasignored	= FALSE;

	public static $site		= NULL;		# singleton object for easy DB access to beans

	public static $twig;				# Twig template engine

/**
 * Check to see if there is a session and return a specific value form it if it exists
 *
 * @param string	$var	The variable name
 * @param boolean	$fail	If TRUE then exit with an error returnif the value  does not exist
 *
 * @return mixed
 */
        public static function sessioncheck($var, $fail = TRUE)
        {
            if (isset($_COOKIE[ini_get('session.name')]))
            {
                session_start();
                if (isset($_SESSION[$var]))
                {
                    return $_SESSION[$var];
                }
            }
            if ($fail)
            {
                self::noaccess();
            }
            return NULL;
        }
/**
 * Generate a Location header
 *
 * @parm string		$where	The URL to divert to
 */
	public static function divert($where)
	{
	    header('Location: '.$where);
	    exit;
	}
/**
 * Generate a 400 Bad Request error return
 *
 * @parm string		$msg	A message to be sent
 */
	public static function bad($msg = '')
	{
	    header('HTTP/1.0 400 Bad Request');
	    if ($msg != '')
	    {
		echo '<p>'.$msg.'</p>';
	    }
	    exit;
	}
/**
 * Generate a 403 Access Denied error return
 *
 * @parm string		$msg	A message to be sent
 */
	public static function noaccess($msg = '')
	{
	    header('HTTP/1.0 403 Access Denied');
	    if ($msg != '')
	    {
		echo '<p>'.$msg.'</p>';
	    }
	    exit;
	}
/**
 * Generate a 404 Not Found error return
 *
 * @parm string		$msg	A message to be sent
 */
	public static function notfound($msg = '')
	{
	    header('HTTP/1.0 404 Not Found');
	    if ($msg != '')
	    {
		echo '<p>'.$msg.'</p>';
	    }
	    exit;
	}
/**
 * Generate a 500 Internal Error error return
 *
 * @parm string		$msg	A message to be sent
 */
	public static function internal($msg = '')
	{
	    header('HTTP/1.0 500 Internal Error');
	    if ($msg != '')
	    {
		echo '<p>'.$msg.'</p>';
	    }
	    exit;
	}
/**
 * Load a bean or fail with a 400 error
 *
 * @parm string		$table	A bean type name
 * @parm integer	$id	A bean id
 *
 * @return object
 */
	public static function load($bean, $id)
	{
	    $foo = R::load($bean, $id);
	    if ($foo->getID() == 0)
	    {
		self::bad($bean.' '.$id);
	    }
	    return $foo;
	}
/**
 * Look in the _GET array for a key and return its trimmed value
 *
 * @param string	$name	The key
 * @param boolean	$fail	If TRUE then generate a 400 if the key does not exist in the array
 *
 * @return mixed
 */
	public static function mustgetpar($name, $fail = TRUE)
	{
	    if (filter_has_var(INPUT_GET, $name))
	    {
		return trim($_GET[$name]);
	    }
	    if ($fail)
	    {
		self::bad();
	    }
	    return NULL;
	}
/**
 * Look in the _POST array for a key and return its trimmed value
 *
 * @param string	$name	The key
 * @param boolean	$fail	If TRUE then generate a 400 if the key does not exist in the array
 *
 * @return mixed
 */
	public static function mustpostpar($name, $fail = TRUE)
	{
	    if (filter_has_var(INPUT_POST, $name))
	    {
		return trim($_POST[$name]);
	    }
	    if ($fail)
	    {
		self::bad();
	    }
	    return NULL;
	}
/**
 * Look in the _GET array for a key and return its trimmed value or a default value
 *
 * @param string	$name	The key
 * @param mixed		$dflt	Returned if the key does not exist
 *
 * @return mixed
 */
	public static function getpar($name, $dflt)
	{
	    return filter_has_var(INPUT_GET, $name) ? trim($_GET[$name]) : $dflt;
	}
/**
 * Look in the _POST array for a key and return its trimmed value or a default value
 *
 * @param string	$name	The key
 * @param mixed		$dflt	Returned if the key does not exist
 *
 * @return mixed
 */
	public static function postpar($name, $dflt)
	{
	    return filter_has_var(INPUT_POST, $name) ? trim($_POST[$name]) : $dflt;
	}
/**
 * Render a twig to the output stream
 *
 * @param string	$tpl	A template file name
 * @param array		$vals	The Twig variable array
 *
 */
        public static function render($tpl, $vals)
        {
            echo self::$twig->render($tpl, $vals);
        }
/**
 * Initialise the context
 *
 * @param boolean	$jax	TRUE if this is an ajax handling call
 * @param boolean	$tdebug	If TRUE add in Twig debugging
 *
 */
	public static function initialise($jax = FALSE, $tdebug = TRUE)
	{
	    self::$ajax = $jax;
	    self::$site = new Website;
/*
 * Initialise template engine
 */
            Twig_Autoloader::register();

            self::$twig = new Twig_Environment(new Twig_Loader_Filesystem(Local::$commonpath.'/twigs'),
                array('cache' => FALSE /* Local::$subdpath.'/twigcache' */, 'debug' => $tdebug));
            if ($tdebug)
            {
                self::$twig->addExtension(new Twig_Extension_Debug());
            }
//          self::$twig->addFilter('regsub', new Twig_Filter_Function('site_regsub'));
	}
        
        
    }
?>
