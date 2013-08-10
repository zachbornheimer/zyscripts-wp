Zyscripts Optimizations - Wordpress Plugin

* Licensed under the GPLv3
* Bug Finders, if you find a bug, leave it to me as an issue...I _may_ give you free access as a thank you.
* This wordpress plugin allows for the optimization of javascript on a wordpress site.
* Note, the first time you visit your site after a change (or after you load it for the first time), it will be very slow.  This is because it is compiling the code you requested.
* It does not compile your code if it is broken or if you have not registered your site at zyscripts.com

Optimizations:
==============
* Asynchronously load all enqueued javascript
* Sends closure-compiled version of all registered scripts
* Implementation of a load balancer - by having half of your traffic being requested from the zyscripts server, 

Precautions:
============
* This plugin will only work if you have registered your site with zyscripts.com
* If you enable the plugin and it your site is not registered with the zyscripts engine, it returns your original script, unmodified
* If you break something in your script, it will not compile, but will return the original copy of the file
* If you change anything in the file, it updates the cache
* By not caching on your server, visitors don't have the capcity to crash your site due to caching in progress
* By not caching on your server, you are able to see the uncompress, unmodified versions of your code, edit it and have it served as if it were compressed and optimized.

Results Thus Far:
=================
* So far, sites that have been using this plugin have seen improvements from 10% - 60% in load time.
* Sites that have used this plugin, so far, also seem to have more stable code.

Multisite:
==========
* If you install this plugin in mu-plugins, it will automatically apply to every site, however it will be unable to update.  The better option is to enable it using "Network Enable."

Application:
============
* If you register your domain with zyscripts.com, it will work on your domain and subdirectories, but not on subdomains
* If you register your subdomain with zyscripts.com, it will work on your subdomain and subdirectories of that subdoomain, but not on the host domain.
