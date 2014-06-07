logout_redirect
===============

Roundcube Webmail Plugin Logout Redirect

Plugin to redirect on logout to a different website.
The logout can depend on the domain name (not a must) if you have diffent customers. This way you can redirect to their homepages f.e.

Download and install via http://plugins.roundcube.net

Set the following options directly in Roundcube's main config file or via 
[host-specific](http://trac.roundcube.net/wiki/Howto_Config/Multidomains) configurations:

$config['logout_redirect_url'] = 'http://www.%d/'; // %d ~ users domain part will be take from email address

Homepage:
http://www.std-soft.com/index.php/hm-service/81-c-std-service-code/5-rc-plugin-logout-redirect-beim-logout-auf-die-homepage-der-domain-umleiten

