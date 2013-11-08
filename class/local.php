<?php
/**
 * A class that uses statics to store various useful pieces of local data for access throught out the rest of the system.
 * This is never instantiated as an object and has no non-static members
 *
 * It uses constant values from lib/config.php to construct local pathnames.
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
    class Local
    {
	public static $subd		= SUBDIRECTORY;		# the path from web root to the base directory
	public static $assets		= ASSETS;		# the path from web root to the assets directory
	public static $shared		= SHARED;
	public static $subdpath;				# the full path to the base directory
	public static $commonpath;
	public static $root;					# the full path to the web root
        public static $sysadmin		= array(SYSADMIN);
/**
 * Make a pathname for a lib file
 * @param string $file
 * @return string
 */
        public static function libfile($fn)
        {
            return self::$subdpath.'/lib/'.$fn;
        }
/**
 * Make a pathname for a class file
 * @param string $file
 * @return string
 */
        public static function classfile($fn)
        {
            return self::$subdpath.'/class/'.$fn;
        }
/**
 * Make a pathname for a class file
 * @param string $file
 * @return string
 */
        public static function commonclass($fn)
        {
            return self::$commonpath.'/class/'.$fn;
        }
/**
 * Make a pathname for a lib file
 * @param string $file
 * @return string
 */
        public static function commonlib($fn)
        {
            return self::$commonpath.'/lib/'.$fn;
        }
/**
 * The class autoloader function - see PHP documentation for full details
 *
 * @param string	$class_name The name of the class to be loaded
 * @throws ErrorException
 */
    public static function autoload($class_name)
    {
	$file = self::commonclass(strtolower($class_name).'.php');
	if (file_exists($file))
	{
	    try
	    {
		require_once($file);
	    }
	    catch (Exception $e)
	    {
		throw new ErrorException('Error loading '.$class_name);
	    }
	}
    }
/**
 * Set up local information
 */
	public static function initialise()
	{
	    self::$root = $_SERVER['DOCUMENT_ROOT'];
	    self::$subdpath = self::$root.self::$subd;
	    self::$commonpath = COMMON == SUBDIRECTORY ? self::$subdpath : self::$root.COMMON;
	    spl_autoload_extensions('.php');
	    spl_autoload_register(array('Local', 'autoload'));
	}
    }
?>
