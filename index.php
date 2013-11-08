<?php
/**
 * Main entry point of the system.
 *
 * @author Supreet Totagi <s.r.totagi@ncl.ac.uk>
 * @copyright 2013 Newcastle University
 *
 */
    require_once('lib/startup.php');

    Context::initialise(FALSE);
    $action = strtolower(Context::getpar('_action', 'home'));    
    $vals = array(
	'page'          => $action,
	'subd'          => Local::$subd,
	'assets'        => Local::$assets,
	'shared'        => Local::$shared,
	'website'       => Context::$site,
        'InvalidLogin'  => FALSE        
    );

    $tpl = 'main.twig';    
    $loggedIn = FALSE;
    
    if (UserRegistry::checkSession())
    {
        $loggedIn = TRUE;
        $sessionID = UserRegistry::getSessionID();
        $userDetails = UserProfile::getUserDetails($sessionID);
        $vals['user'] = $userDetails['name'];        
    }
        
    switch ($action)
    {
/**
 * Sign Up.
 * 
 * The page for signing up
 */        
        case 'signup' :
            if (!$loggedIn)
            {
                $tpl = 'signup.twig';
            }
            break;            
/**
 * New User.
 * 
 * Reads registration detail and registers the new user
 */            
        case 'newuser' : 
            if (!$loggedIn)
            {
                $vals['EmailExists'] = FALSE;
                $params = FormReader::getUserCredentials();        
                $retVal = UserRegistry::signup($params);
                if($retVal==EMAILEXISTS)
                {
                    $vals['EmailExists'] = TRUE;                      
                    $tpl = 'signup.twig';
                }
                else
                {
                    UserRegistry::registerSession($params['email']);
                    $tpl = 'newprofile.twig';
                } 
            }
            break;           
/**
 * Add new profile.
 * 
 * Reads new user's profile details and makes the database entry
 */
        case 'addnewprofile' :
            if ($loggedIn)
            {                                
                $params = FormReader::getNewUserDetails();
                UserProfile::addProfile($params);
                $vals['userDetails'] = UserProfile::getUserDetails($params['email']);
                $tpl = 'newprofileadded.twig';
            }
            break; 
/**
 * Sign in.
 * 
 * Authenticates user's EmailID and password
 */            
        case 'signin' :
             if (!$loggedIn)
             {
                 $params = FormReader::getUserCredentials($_POST);
                 if(UserRegistry::signin($params) == SUCCESS)
                 {                    
                    UserRegistry::registerSession($params['email']);                    
                    $tpl = 'signin.twig';                
                 }
                 else
                 {
                     $vals['InvalidLogin'] = TRUE;
                     $tpl = 'main.twig';
                 }            
             }
             else
             {            
                 $tpl = 'signin.twig';   
             }
             break;
/**
 * Home.
 * 
 * User's 'Home' page
 */
        case 'home' :
             if ($loggedIn)
             {
                 $recentProposals = Proposals::getRecentProposals();
                 $vals['recentProposals'] = $recentProposals;                
                 $tpl = 'home.twig';                
             }
             break;
/**
 * Search Results.
 * 
 * Handles the proposals search functionality
 */             
        case 'searchresults' :
             if ($loggedIn)
             {
                $query = Context::postpar('search', '');
                $recentProposals = Proposals::getSearchResults($query);
                $vals['recentProposals'] = $recentProposals;        
                $tpl = 'home.twig';                
             }
             break;            
/**
 * Profile.
 * 
 * User's 'Profile' page
 */
        case 'profile' :
             if ($loggedIn)
             {
                 $vals['userDetails'] = $userDetails;
                 $tpl = 'profile.twig';
             }
             break;   
/**
 * Edit profile.
 * 
 * Read user's new profile details and reflect it into the database
 */
        case 'editprofile' :
             if ($loggedIn)
             {
                 $params = FormReader::getUserProfileDetails();
                 UserProfile::updateProfile($params);                
                 $vals['userDetails'] = $userDetails;
                 $tpl = 'profile.twig';                
             }
             break; 
/**
 * Profile.
 * 
 * User's 'Messages' page
 */          
        case 'messages' :
             if ($loggedIn)
             {
                $vals['inbox'] = Messages::getInbox($sessionID);
                $vals['sentitems'] = Messages::getSentItems($sessionID);
                $tpl = 'messages.twig';
             }
             break;
/**
 * Send message.
 * 
 * Sends message to the desired recepient
 */             
        case 'sendmessage' :
             if ($loggedIn)
             {
                $params = FormReader::getMessageContent();
                Messages::sendMessage($params);                        
                $vals['userinfo'] = UserProfile::getUserDetails($params['to']);                        
                $tpl = 'messagesent.twig';
                break;    
             }
/**
 * User Information.
 * 
 * Display other user's information
 */             
        case 'userinfo' :
             if ($loggedIn)
             {
                $id = Context::getpar('id', '');        
                $userinfo = UserProfile::getUserInfo($id);
                $vals['userinfo'] = $userinfo;
                $vals['name'] = $userinfo['name'];
                $tpl = 'userinfo.twig';
             }
             break;             
/**
 * Proposals.
 * 
 * User's 'Proposals' page
 */             
        case 'proposals' :
             if ($loggedIn)
             {
                 $proposals = proposals::getUserProposals($sessionID);
                 $vals['proposals'] = $proposals;
                 $tpl = 'proposals.twig';                
             }
             break;
/**
 * New proposal.
 * 
 * Read user's new proposal and makes the database entry
 */            
        case 'newproposal' :
             if ($loggedIn)
             {
                 $params = FormReader::getNewProposal();
                 Proposals::writeProposals($params); 
                 $tpl = 'proposals.twig';
             }
             break;                    
/**
 * Logout.
 * 
 * Log off from the website
 */
        case 'logout' :
             UserRegistry::destroySession();
             $tpl = 'main.twig';
             break;        

        default:
            break;
    }    
    
    echo Context::render($tpl, $vals);
    
?>