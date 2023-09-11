<?php

/*
 * Web SSO system for SPS Ostrov. Author: Vlastimil Setka, 2007
 *
 * Base class.
 *
 * List of changes:
 *
 *  Version 1.20 2019-01-25
 *    * Cleanup.
 *
 *  Version 1.10 2011-07-20
 *    * PHP 5.3 Compatibilitiy fixes - split, ereg
 *    * backported base64/urlencode fix from v1.04prod
 *    * backported fix of problem with non-https services from v1.02prod
 *
 * Version 0.94 2008-11-29
 *  - new default-config feature
 *  - removed duplicious $this->config['application_url']
 *  - new feature: $this->config['force_https']
 *
 * Version 0.93 2008-11-25
 *   - added plain_password support -- depends on -dev branch of the gateway
 *     because of the new feature - key serial-id check   
 *   => if 'require_creds' is configured, plain password can be accessed
 *      in the $object->password;
 *
 * Version 0.90 2008-10-31 
 *   - first versioned
 *   - $object->just_loged_in is true if we have been just authenticated
 *     by the gateway. If authentication is done by the persistence class
 *     the variable is false.
 *   - support for passing config to persistence class 
 *   - some code cleanup 
 */

class Auth_SSO
{
  private $user_data = array();
  private $login;
  private $name;
  private $group;
  private $auth_by;
  private $user;
  private $role;
  private $just_loged_in = false;

  private $user_roles = array();

  public function __construct($cfg)
  {
    $default_config['force_https'] = false;
    $default_config['persistence-class'] = null;
    $default_config['persistence-config'] = null;
    $default_config['roles'] = null;

    $this->config = array_merge($default_config, $cfg);

    if($this->config['persistence-class'] != null)
    {
      $storage = new $this->config['persistence-class']($this->config['persistence-config']);
    }
    else
    {
      $storage = null;
    }
    
    if(isset($_GET['ticket']))
    {
      $data = $this->fetch_user_data($_GET['ticket']);
      $this->set_user_data($data);

      if($this->config['roles'] != null)
      {
        $this->setup_roles($this->config['roles']);
      }

      if($storage != null)
      {
        $storage->set_data(array('data' => $this->user_data, 'roles' => $this->user_roles));
      }
 
      $this->just_loged_in = true;
    }
    else
    {
      if($storage != null)
      {
        $data = $storage->get_data();
        if($data === false)
        {
          $this->gateway_redirect(false, false);
        }
        else
        {
          $this->set_user_data($data['data']);
          if(isset($data['roles']))
          {
            $this->user_roles = $data['roles'];
          }
        }
      }
      else
      {
        $this->gateway_redirect(false, false);
      }
    }
  }

  public function get_login()
  {
    return $this->login;
  }

  public function get_name()
  {
    return $this->name;
  }

  public function get_user_details()
  {
    return $this->user_data;
  }

  public function is_just_loged_in()
  {
    return $this->just_loged_in;
  }

  public function reauth($callback_url = false)
  {
    $this->gateway_redirect(true, $callback_url);
  }

  public function has_role($role)
  {
    return in_array($role, $this->user_roles);
  }

  protected function set_user_data($data)
  {
    $this->user_data = $data;
    $this->login = $data['login'][0];
    $this->name = $data['name'][0];
    $_SESSION['role'] = $this->role = $data['group'][0]; //session role
    $_SESSION['user'] = $this->login = $data['login'][0];
    //bere si to moje sessions z mého projektu a ne z sso????
    
  }

  protected function gateway_redirect($force_auth, $callback_url)
  {
    if($callback_url)
    {
      $uri_part = $callback_url;
    }
    else
    {
      // strip ticket id at the end of URI from previous call
      $uri_part = preg_replace('/[?&]ticket=[a-z0-9]+$/', '', $_SERVER['REQUEST_URI']);
    }

    $service_url = $_SERVER['SERVER_NAME'] . $uri_part;
    if($this->config['force_https'])
    {
      $service_url = 'https://' . $service_url; 
    }
    else
    {
      $service_url = 'http://' . $service_url;
    }

    $redirect_url = $this->config['gateway_url'] . '?service='
      . urlencode(base64_encode($service_url));    

    if($force_auth)
    {
      $redirect_url .= '&force=1';
    }

    if($this->config['require_creds'])
    {
      $redirect_url .= '&creds=1';
    }

    Header('Location: ' . $redirect_url, true, 303);
    die;
  }

  protected function fetch_user_data($ticket_id)
  {
    if($this->config['force_https'])
    {
      $protocol = 'https://'; 
    }
    else
    {
      $protocol = 'http://';
    }
    $check_url = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    // strip query string
    $check_url = preg_replace('/\?.*/', '', $check_url);

    // fetch reply from service-check.php
    $sso_reply = file_get_contents($this->config['gateway_url'] . 'service-check.php' . 
                                   '?service=' . urlencode(base64_encode($check_url)) .
                                   '&ticket=' . $ticket_id);

    $sso_reply = preg_split('/\n/', $sso_reply);

    $data = array();
    foreach($sso_reply as $line)
    {
      if(preg_match('/^ERR: /', $line))
      {
        throw new Exception('SSO Reply: ' . $line);
      }
      if(preg_match('/^([a-z_]+):([^\n]+)/', $line, $args))
      {
        $data[$args[1]][] = $args[2];
      }
    }

    if(isset($data['login']) && isset($data['name']))
    {
      return $data;
    }
    else
    {
      throw new Exception('SSO does not pass user login');
    }
  }

  protected function setup_roles($roles_array)
  {
    $this->user_roles = array(); 
    foreach($roles_array as $role => $role_acl)
    {
      foreach($role_acl as $attribute_name => $attribute_req_values)
      {
        foreach($this->user_data[$attribute_name] as $user_attribute)
        {
          if(in_array($user_attribute, $attribute_req_values) && ! in_array($role, $this->user_roles))
          {
            $this->user_roles[] = $role;
          }
        }
      }
    }
  }
}
