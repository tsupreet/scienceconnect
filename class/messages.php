<?php
/**
 * A class used in connecting to the database for sending and receiving messages.
 * This is never instantiated as an object and has no non-static members
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
class Messages
{
/**
 * Inserts the message content into the database
 *
 * @param array 	$params	The message content that needs to be inserted into the database
 * 
 */    
    public static function sendMessage($params)
    {
         $currentDate = date("F j, Y");
         $message = R::dispense('messages');
         $message->fromemail = $params['from'];
         $message->toemail = $params['to'];
         $message->subject = $params['subject'];
         $message->body = $params['body'];
         $message->date = $currentDate;         
         R::store($message);
    }
/**
 * Gets the inbox details from the database
 *
 * @param string 	$email	User's email, the session ID
 * 
 * @return array
 */     
    public static function getInbox($email)
    {
        $inbox = R::getAll("select * from messages where toemail =:toemail", array(':toemail'=>$email));               
        foreach ($inbox as $row => &$value) 
        {
            $fromDetails = UserProfile::getUserDetails($value['fromemail']);            
            $value['fromname']  = $fromDetails['name'];
        }                
        return $inbox;
    }
/**
 * Gets the sent item details from the database
 *
 * @param string 	$email	User's email, the session ID
 * 
 * @return array
 */      
    public static function getSentItems($email)
    {
        $sentitems = R::getAll("select * from messages where fromemail =:fromemail", array(':fromemail'=>$email));        
        foreach ($sentitems as $row => &$value) 
        {
            $toDetails = UserProfile::getUserDetails($value['toemail']);            
            $value['toname']  = $toDetails['name'];
        }                
        return $sentitems;
    }
}

?>
