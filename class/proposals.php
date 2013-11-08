<?php
/**
 * A class used in connecting to the database for inserting and retrieving proposals.
 * This is never instantiated as an object and has no non-static members
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
class Proposals 
{
/**
 * Gets the user's proposal details from the database
 *
 * @param string 	$email	User's email, the session ID
 * 
 * @return array
 */     
    public static function getUserProposals($email) 
    {
        $data = R::getAll( 'select * from proposals where email = :email', array(':email'=>$email) );
        return $data;
    }
/**
 * Writes the user's new proposal into the database
 *
 * @param array 	$params The proposal content that needs to be inserted into the database
 * 
 */     
    public static function writeProposals($params) 
    {
         $currentDate = date("F j, Y");
         $proposal = R::dispense('proposals');
         $proposal->email = $params['email'];
         $proposal->name = $params['name'];
         $proposal->title = $params['title'];
         $proposal->content = $params['content'];
         $proposal->date = $currentDate;
         R::store($proposal);         
     }
/**
 * Gets the list of proposals from the database sorted according to the date of insertion
 * 
 * 
 * @return array
 */      
     public static function getRecentProposals()
     {
         $recentProposals = R::getAll('SELECT * FROM proposals ORDER BY date DESC');
         return $recentProposals;
     }
/**
 * Gets the list of proposals from the database whose title matches to the query string
 * 
 * 
 * @return array
 */     
     public static function getSearchResults($param)
     {
         $searchResults = R::getAll("SELECT * FROM proposals WHERE title LIKE '%$param%'");
         return $searchResults;
     }    
}

?>
