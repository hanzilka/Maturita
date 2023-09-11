<?php

/*
 * Web SSO system for SPS Ostrov. Author: Vlastimil Setka, 2007
 *
 * Persistence class - using standard PHP sessions.
 *  
 * List of changes:
 * 
 * Version 0.9 2008-10-31 
 *   - first versioned
 *   - config can be passed to constructor (cookie path; session name)
 */

class Auth_SSO_Persistence_Session
{
  public function __construct($config = null)
  {
    if(session_id() == '')
    {
      if(isset($config['path']))
      {
        session_set_cookie_params(0, $config['path']);
      }
      if(isset($config['name']))
      {
        session_name($config['name']);
      }

      session_start();
      echo "var_dump: " . "<br />"; 
      var_dump($_SESSION);
      //
     
    }
  }

  public function get_data()
  {
    if(isset($_SESSION['auth']))
    {
      return $_SESSION['auth'];
    }
    else
    {
      return false;
    }
  }

  public function set_data($data)
  {
    $_SESSION['auth'] = $data;
  }
}
