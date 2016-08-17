Smartbots PHP API
======

This API kit has been created from scratch to ease development of your online web services which integrate with SmartBots for SecondLife.

To get started with this API, you will first need to know the basics of PHP programming. This documentation uses some terms which are specific to Object Orientated PHP programming, so it may be best to freshen yourself up on the terminology before continuing.

---

To begin, you will first need to create a blank .php file and include the 'smartbots_api.php' file.
```php
<?php
	include("smartbots_api.php"); // Include the SmartBots API file.
```

---

Next, we will need to define your [SmartBots Developer API key](https://www.mysmartbots.com/process/adminbot.html), your bot's name and [access code](http://www.mysmartbots.com/docs/Bot_access_code) so that it's easier to use them later.
