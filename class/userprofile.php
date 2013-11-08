<?php
/**
 * A class used in connecting to the database for inserting and retrieving user's profile details.
 * This is never instantiated as an object and has no non-static members
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
class UserProfile 
{
/**
 * Adds the user's profile details into the database
 *
 * @param array 	$params	User's profile details
 */     
    public static function addProfile ($params)
    {
        $userDetails = R::dispense('userdetails');
        $userDetails->emailID = $params['email'];
        $userDetails->name = $params['name'];
        $userDetails->email = $params['newemail'];
        $userDetails->university = $params['university'];
        $userDetails->address = $params['address'];
        $userDetails->number = $params['number'];
        R::store($userDetails);
    }
/**
 * Gets the user's profile details from the database
 *
 * @param string 	$email	User's email, the session ID
 * 
 * @return array
 */      
    public static function getUserDetails ($email)
    {
        $row = R::getRow( 'select * from userdetails where emailID = :email', array(':email'=>$email) );
        return $row;
    }
/**
 * Updates the user's profile details into the database
 *
 * @param array 	$params	User's profile details
 */    
    public static function updateProfile ($params)
    {
        $row = UserProfile::getUserDetails($params['email']);
        $userDetails = R::load('userdetails', $row['id']);
        $userDetails->emailID = $params['email'];
        $userDetails->name = $params['name'];
        $userDetails->email = $params['newemail'];
        $userDetails->university = $params['university'];
        $userDetails->address = $params['address'];
        $userDetails->number = $params['number'];   
        $id = R::store($userDetails);
    }
/**
 * Gets the user's profile details from the database
 *
 * @param string 	$id	ID of the user whose information needs to be retrieved
 * 
 * @return array
 */    
    public static function getUserInfo($id)
    {
        $row = R::getRow('select * from proposals where id = :id', array(':id'=>$id));
        $email = $row['email'];
        $userinfo = UserProfile::getUserDetails($email);
        return $userinfo;
    }    
}

?>
