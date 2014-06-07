<?php

/**
 * Redirect on logout
 *
 * @version 1.2 - 2014-06-07
 * @author Roland 'rosali' Liebl
 * @website http://myroundcube.googlecode.com
 * @licence GNU GPL
 * @history 1.1 - 2010-12-26
 * @        1.2 - 2011-05-04 - rewritten Markus Neubauer: set default return when still %d in return link
 * @        1.3 - 2014-06-07 - adopted for RC 1
 **/
/**
 * Notice: This plugin must run as the last plugins because it exits
  *         on the 'logout_after' hook !!!
**/
/**
 * 1.2 stripped down to an only logout function with variable return page
 * rewritten by Markus Neubauer
 **/
 
/**
 *
 * Usage: http://www.std-soft.com/index.php/hm-service/81-c-std-service-code/5-rc-plugin-logout-redirect-beim-logout-auf-die-homepage-der-domain-umleiten
 *
 **/ 
 
class logout_redirect extends rcube_plugin
{
  public $task = 'logout';
  
  function init()
  {
      if ( file_exists("./plugins/logout_redirect/config.inc.php") )
          $this->load_config('config.inc.php');
      else
          $this->load_config('config.inc.php.dist');

    $this->add_hook('logout_after', array($this,'logout_after'));
  }

  // user logout 
  function logout_after($args)  
  {        
    $rcmail = rcmail::get_instance();
    $this->load_config();

    if ( $rcmail->config->get('logout_redirect_url') ) {

        $redirect = $rcmail->config->get('logout_redirect_url');

        if ( preg_match('/%d/',$redirect) ) {
            $sql_result = $rcmail->db->query(
                "SELECT i.email FROM ".$rcmail->config->get('db_table_users')." AS u
                  JOIN ".$rcmail->config->get('db_table_identities')." AS i 
                    ON u.user_id = i.user_id where u.username=? and i.standard=1",
              $args['user']);

            if ( $sql_result && ($sql_arr = $rcmail->db->fetch_assoc($sql_result)) ) {
                list($name,$domain) = explode('@', $sql_arr['email']);
                $redirect = str_replace('%d', $domain, $redirect);
            }
        }
        if ( !preg_match('/%d/',$redirect) ) {
            setcookie ('ajax_login','',time()-3600);
            $rcmail->output->add_script('top.location.href="' . $redirect . '";');
            $rcmail->output->send('plugin'); 
            exit; 
        }
    }

    return $args; 
  } 
     
}
?>
