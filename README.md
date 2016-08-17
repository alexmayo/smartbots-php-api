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
```php
$apiKey        = "e40e365171a99nl05bdmd697273b573t"; // SmartBots API Key.
$botName       = "Example Resident"; // The bot's full name.
$botAccessCode = "KbYpnfa"; // The bot's access code.
```

---

If you're not familiar with Object-Orientated PHP, the next section may look a little strange, however follow the instructions and all should be clear.

Now we will create the `$bot` variable and instansiate a `new SmartBot()` class so that we can begin making our bot function.
```php
$bot = new SmartBot(); // Instansiate a new SmartBot class.
```

---

To let the SmartBots API know what bot we are going to be controlling, we now need to use the `setup()` method/function to enter in the variables we created earlier. The setup process returns `TRUE` or `FALSE`, depending on whether or not it was successful, meaning that you would use it within an 'if' statement if you wanted.

```php
$bot->setup($apiKey, $botName, $botAccessCode); // Pass the setup variables to the API.
```

---

Your SmartBot is now connected to the API and is ready to accept some awesome functions!
At the end of this section, your code could look a little something like this:

```php
<?php
	include("smartbots_api.php"); // Include the SmartBots API file.
	
	$apiKey        = "e40e365171a99nl05bdmd697273b573t"; // SmartBots API Key.
	$botName       = "Example Resident"; // The bot's full name.
	$botAccessCode = "KbYpnfa"; // The bot's access code.
	
	$bot = new SmartBot(); // Instansiate a new SmartBot class.
	$bot->setup($apiKey, $botName, $botAccessCode); // Pass the setup variables to the API.
?>
```

