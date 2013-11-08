<?php
/**
 * A class that helps in reading the form data.
 * This is never instantiated as an object and has no non-static members
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
class FormReader 
{
/**
 * Reads user Email ID and password from the form
 *
 * @return array
 */    
    public static function getUserCredentials()
    {
        $email = Context::postpar('email', '');
        $password = Context::postpar('password', '');
        $data = array('email' => $email, 'password' => $password);
        return $data;
    }
/**
 * Reads user profile details
 *
 * @return array
 */    
    public static function getUserProfileDetails()
    {
        $email = UserRegistry::getSessionID();
        $newname = Context::postpar('editname', '');
        $newemail = Context::postpar('editemail', '');
        $newuniversity = Context::postpar('edituniversity', '');
        $newaddress = Context::postpar('editaddress', '');
        $newnumber = Context::postpar('editnumber', ''); 
        $data = array('email' => $email, 'name' => $newname, 'newemail' => $newemail, 
            'university' => $newuniversity, 'address' => $newaddress, 'number' => $newnumber);  
        return $data;
    }
/**
 * Reads a new user's profile details
 *
 * @return array
 */    
    public static function getNewUserDetails()
    {
        $email = UserRegistry::getSessionID();
        $newname = Context::postpar('name', '');
        $newemail = Context::postpar('newemail', '');
        $newuniversity = Context::postpar('university', '');
        $newaddress = Context::postpar('address', '');
        $newnumber = Context::postpar('number', '');        
        $data = array('email' => $email, 'name' => $newname, 'newemail' => $newemail,
            'university' => $newuniversity, 'address' => $newaddress, 'number' => $newnumber);        
        return $data;
    }
/**
 * Reads user's new proposal 
 *
 * @return array
 */    
    public static function getNewProposal()
    {
        $email = UserRegistry::getSessionID();
        $userDetails = UserProfile::getUserDetails($email);
        $name = $userDetails['name'];        
        $title = Context::postpar('title', '');
        $content = Context::postpar('content', '');
        $data = array('email' => $email, 'title' => $title, 'content' => $content, 'name' => $name);  
        return $data;
    }
/**
 * Reads message content that needs to be sent
 *
 * @return array
 */    
    public static function getMessageContent()
    {
        $from = UserRegistry::getSessionID();
        $to = Context::postpar('to', '');
        $subject = Context::postpar('subject', '');
        $body = Context::postpar('body', '');
        $data = array('from' => $from, 'to' => $to, 'subject' => $subject, 'body' => $body); 
        return $data;       
    }
}

?>
