<?php

/**
 * Redirect on logout
 *
 * @version 1.4 - 2014-06-07
 * @Original author Roland 'rosali' Liebl
 * @website http://myroundcube.googlecode.com
 * @licence GNU GPL
 * @history 1.1 - 2010-12-26
 * @        1.2 - 2011-05-04 - rewritten Markus Neubauer: stripped down to an only logout function with variable return page
 * @        1.3 - 2014-06-07 - adopted for RC 1
 * @        1.4 - 2014-06-16 - changed db interface to rc 1
 **/
/**
 * Notice: This plugin must run as the last plugins because it exits
  *         on the 'logout_after' hook !!!
**/
/**
 * Usage: http://www.std-soft.com/index.php/hm-service/81-c-std-service-code/5-rc-plugin-logout-redirect-beim-logout-auf-die-homepage-der-domain-umleiten
 **/ 
 
class logout_redirect extends rcube_plugin
{
  public $task = 'logout';
    // we've got no ajax handlers
    public $noajax = true;
    // skip frames
    public $noframe = true;

    private $redirect_url ='';
  
  function init()
  {
    $this->add_hook('logout_after', array($this,'logout_after'));
  }

  // user logout 
  function logout_after($args)  
  {        

    $rcmail = rcmail::get_instance();
    $this->load_config();

    if ( $this->redirect_url = $rcmail->config->get('logout_redirect_url') ) {

        if ( preg_match('/%d/',$this->redirect_url) ) {
	    // pick users default identity email
            $sql_result = $rcmail->db->query(
                "SELECT i.email FROM ".$rcmail->db->table_name('users')." AS u
                  JOIN ".$rcmail->db->table_name('identities')." AS i 
                    ON u.user_id=i.user_id WHERE u.username=? AND i.standard=1 LIMIT 1;",
              $args['user']);

            if ( $sql_result && ($sql_arr = $rcmail->db->fetch_assoc($sql_result)) ) {
                list($name,$domain) = explode('@', $sql_arr['email']);
                $this->redirect_url = str_replace('%d', $domain, $this->redirect_url);
            }
        }

	// make shure the replacement is done, otherwise continue with normal exit proc
        if ( !preg_match('/%d/',$this->redirect_url) ) {

            setcookie ('ajax_login','',time()-3600);
            header("Location: $this->redirect_url", true, 307);
            exit;
	}

    }
    return $args; 
  } 
     
}
?>
