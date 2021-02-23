logout_redirect
===============

Roundcube Webmail Plugin Logout Redirect depend on domain.

Plugin to redirect on logout to a different website.
The logout can depend on the domain name (not a must) if you have diffent customers. This way you can redirect to their homepages f.e.

Download and install via http://plugins.roundcube.net

Set the following options directly in Roundcube's main config file or via 
[host-specific](http://trac.roundcube.net/wiki/Howto_Config/Multidomains) configurations:

```php
/* %d will be replaced with the default user identity email domain part
 *    i.e. email@domain.com will replace %d with "domain.com"
**/
$config['logout_redirect_url'] = 'http://www.%d/';
```

Homepage:
https://www.std-soft.com/hm-service/code/5-rc-plugin-logout-redirect-beim-logout-auf-die-homepage-der-domain-umleiten
