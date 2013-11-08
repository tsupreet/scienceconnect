<?php
/**
 * A class used for maintaining user registry. It handles sign in, sign up and sessions.
 * This is never instantiated as an object and has no non-static members
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
class UserRegistry 
{
/**
 * Registers a new user into the database
 *
 * @param array 	$params	User's registration details
 * 
 * @return boolean
 */    
    public static function signup ($params)
    {                            
        $row = R::getRow( 'select * from user where email = :email', array(':email'=>$params['email']) );
        if (count($row)>0)
        {
            return EMAILEXISTS;
        }                        
        $user = R::dispense('user');
        $user->email = $params['email'];
        $user->password = $params['password'];       
        R::store($user);                           
        return SUCCESS;               
    }
/**
 * Authenticates a user for logging into the website.
 *
 * @param array 	$params	User's login details
 * 
 * @return boolean
 */     
    public static function signin ($params)
    {        
        $email = $params['email'];
        $password = $params['password'];
        $row = R::getRow( 'select * from user where email = :email', array(':email'=>$email) );
        if (count($row)>0 && $row['password'] == $password) 
        {
            return SUCCESS;            
        }        
        return FAILURE;
    } 
/**
 * Checks if the session is registered.
 * 
 * @return boolean
 */    
    public static function checkSession ()
    {
        session_start();        
        return isset($_SESSION['email'])?TRUE:FALSE;
    }
/**
 * Gets the registered session ID.
 * 
 * @return string
 */     
    public static function getSessionID()
    {        
        return $_SESSION['email'];
    }
/**
 * Registers a new session.
 * 
 * @param string    $var    Email ID of the user acts as session ID
 */      
    public static function registerSession($var)
    {              
        $_SESSION['email'] = $var;        
    }
/**
 * Destroys a session.
 * 
 */     
    public static function destroySession()
    {
        session_unset();
        session_destroy();
    }    
}

?>
