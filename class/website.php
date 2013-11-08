<?php
/**
 * A singleton class that can be used for generic information provision.
 * The sole instance of the class is passed into all twig templates and so
 * gives a single place to access data from.
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
    class Website
    {
	private static $idgen = 0;			# used for generating unique ids
/**
 * Generates a new, unique id value
 *
 * @param string	$id The prefix for the id
 * @return string
 */
	public function newid($str = 'id')
	{
	    self::$idgen += 1;
	    return $str.self::$idgen;
	}
/**
 * Returns the site name as specified in lib/config.php
 *
 * @return string
 */
	public function name()
	{
	    return SITE;
	}
    }
?>
