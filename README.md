#Smartbots PHP API

- [Download](https://github.com/alexmayo/smartbots-php-api/blob/master/smartbots_api.php)
	- [Getting Started](#Getting-Started)
	- [Performing Actions](#Performing-Actions)
	- [Multiple Bots](#Multiple-Bots)
	- [Available Actions](#Available-Actions)
- [Demo](http://renderworks-sl.com/smartbots_php_api#Live_Demo)
- [Support](http://renderworks-sl.com/smartbots_php_api/#Support)
- [Licensing](http://renderworks-sl.com/smartbots_php_api/#License)
	
##<a name="Getting-Started">Getting Started</a>

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

---

##<a name="Performing-Actions">Performing Actions</a>

We've made it really easy to perform actions with your SmartBot, for example it's as simple as `$bot->login();` to log in your bot! We'll take a look at all of the different actions and the different ways in which you can use them below:

---

To send an Instant Message from your bot, you use the `im()` method on your `$bot` variable. For example the below will send an IM to GTASkinCentral Resident with a message of "Hello world!".

```php
$bot->im("GTASkinCentral Resident", "Hello World!"); // Send an IM to GTASkinCentral Resident.
```

---

If you need to see the response that the bot gives after the action has been executed, it's as simple as calling the `response()` method. This method returns the result as an array, however if you would like the raw string format, directly from the SmartBots server, simply use `response(TRUE)` instead.
```php
print_r($bot->response()); // Get the bot's response in array format.
```
```php
Array (
	[result] => OK
	[action] => im
)
```
or in string format
```php
echo $bot->response(TRUE); // Get the bot's response in query string format.
```
```php
result=OK&action=im
```

---

Again, we can use a simple 'if' statement to see if an acton was successful or not. This is done by checking whether or not the 'result' parameter in the response is set to `TRUE` or `FALSE`.

```php
if($bot->im("GTASkinCentral Resident", "Hello World!") == TRUE) { // If the action was successful.
	echo "Success!".
} else { // If the action failed.
	echo "Fail!".
}
```

---

As you may be aware, SmartBots also has a number of commands which return a lot of information. For example, to find out an avatar's name from their UUID or key, you can use the `key2name()` method. You can also pass in custom variables this way. All methods accept one custom variable at the end of the action's default variables (see below).

```php
$bot->key2name("4d9ce772-d3ee-4cce-9555-bfb06ffcb228", "Custom Text"); // Send the key2name command.
print_r($bot->response()); // Print the result.
}
```
```php
Array (
	[action] => key2name
	[result] => OK
	[key] => 4d9ce772-d3ee-4cce-9555-bfb06ffcb228
	[name] => gtaskincentral resident
	[custom] => Custom Text
)
```

---

Your SmartBot is now able to accept commands from you!
At the end of this section, your code could look a little something like this:

```php
<?php
	include("smartbots_api.php"); // Include the SmartBots API file.

	$apiKey        = "e40e365171a99nl05bdmd697273b573t"; // SmartBots API Key.
	$botName       = "Example Resident"; // The bot's full name.
	$botAccessCode = "KbYpnfa"; // The bot's access code.

	$bot = new SmartBot(); // Instansiate a new SmartBot class.
	$bot->setup($apiKey, $botName, $botAccessCode); // Pass the setup variables to the API.

	$bot->im("GTASkinCentral Resident", "Hello World!"); // Send an IM to GTASkinCentral Resident.

	$bot->key2name("4d9ce772-d3ee-4cce-9555-bfb06ffcb228", "Custom Text"); // Send the key2name command.
	print_r($bot->response()); // Print the result.
?>
```

---

##<a name="Multiple-Bots">Multiple Bots</a>

If you're familiar with Object-Orientated PHP, you've most likely already worked this out, however you can actually have multiple bots interacting with each other at once, in one single script! The below code demonstrates how two bots will IM each other, and then echo their responses to the screen!

---

```php
<?php
	include("smartbots_api.php"); // Include the SmartBots API file.

	$apiKey = "e40e365171a99nl05bdmd697273b573t"; // SmartBots API Key.

	/* Bot Number 1 */
	$bot1_Name       = "Example Resident"; // The bot's full name.
	$bot1_AccessCode = "KbYpnfa"; // The bot's access code.

	/* Bot Number 2 */
	$bot2_Name       = "Awesome Linden"; // The bot's full name.
	$bot2_AccessCode = "f9xH9oD"; // The bot's access code.

	/* Instansiate Bot 1 */
	$bot1 = new SmartBot(); // Instansiate a new SmartBot class.
	$bot1->setup($apiKey, $bot1_Name, $bot1_AccessCode); // Pass the setup variables to the API.

	/* Instansiate Bot 2 */
	$bot2 = new SmartBot(); // Instansiate a new SmartBot class.
	$bot2->setup($apiKey, $bot2_Name, $bot2_AccessCode); // Pass the setup variables to the API.

	/* Send the IMs */
	$bot1->im($bot2_Name, "Hello bot number two!"); // Send an IM.
	$bot2->im($bot1_Name, "Hello bot number one!"); // Send an IM.

	echo "Bot 1 returned '" . $bot1->response(TRUE) . "'<br>"; // Print the result from Bot 1.
	echo "Bot 2 returned '" . $bot2->response(TRUE) . "'<br>"; // Print the result from Bot 2.
?>
```

---

##<a name="Available-Actions">Available Actions</a>

This section shows all of the available actions which you can use with this API. Currently, all API actions available from SmartBots can be used with this API.

* indicates a required parameter, the command will not work if this paramater is left empty.

| Action            	| Method                                                                             	     |
|-------------------	|---------------------------------------------------------------------------------------     |
| login             	| ``` login( region*, custom ); ```                                                 	     |
| logout            	| ``` logout( custom* ); ```                                                         	     |
| set_http_callback 	| ``` set_http_callback( url, events*, custom ); ```                                         |
| activate_group    	| ``` activate_group( uuid*, custom ); ```                                                   |
| attachment_touch  	| ``` attachment_touch( objectname*, linkset*, custom ); ```                                 |
| attachments       	| ``` attachments( skipnames, matchnames, matchuuid, custom ); ```                   	     |
| avatar_groups     	| ``` avatar_groups( avatar*, skipnames, matchnames, matchuuid, custom ); ```        	     |
| avatar_picks      	| ``` avatar_picks( avatar*, skipnames, matchnames, matchuuid, custom ); ```         	     |
| give_inventory    	| ``` give_inventory( avatar*, object*, custom ); ```                                	     |
| give_money        	| ``` give_money( avatar*, amount*, comment, custom ); ```                                   |
| give_money_object 	| ``` give_money_object( object_uuid*, amount*, object_name, custom ); ```                   |
| group_eject       	| ``` group_eject( avatar*, groupuuid*, custom ); ```                                        |
| group_invite      	| ``` group_invite( avatar*, groupuuid*, roleuuid*, check_membership, message, custom ); ``` |
| group_join        	| ``` group_join( groupuuid*, custom ); ```                                                  |
| group_leave       	| ``` group_leave( groupuuid*, custom ); ```                                                 |
| im                	| ``` im( slname*, message*, custom ); ```                                                   |
| key2name          	| ``` key2name( key*, request_case, custom ); ```                                            |
| list_group_roles  	| ``` list_group_roles( groupuuid*, custom ); ```                                            |
| listgroups        	| ``` listgroups( custom ); ```                                                              |
| listinventory     	| ``` listinventory( uuid, extended, custom ); ```                                           |
| move              	| ``` move( instruction*, param1*, custom ); ```                                             |
| name2key          	| ``` name2key( name*, request_case, custom ); ```                                           |
| offer_friendship  	| ``` offer_friendship( avatar*, message, custom ); ```                                      |
| offer_teleport    	| ``` offer_teleport( avatar*, message, custom ); ```                                        |
| parcel_info       	| ``` parcel_info( x, y, getvalue, custom ); ```                                             |
| rebake            	| ``` rebake( custom ); ```                                                                  |
| reply_dialog      	| ``` reply_dialog( channel*, object*, button*, custom ); ```                                |
| say_chat_channel  	| ``` say_chat_channel( channel*, message*, custom ); ```                                    |
| send_group_im     	| ``` send_group_im( groupuuid*, message*, custom ); ```                                     |
| send_notice       	| ``` send_notice( groupuuid*, subject*, text*, attachment, custom ); ```                    |
| setrole           	| ``` setrole( groupuuid*, roleuuid*, member*, custom ); ```                                 |
| sit               	| ``` sit( uuid*, save, custom ); ```                                                        |
| takeoff           	| ``` takeoff( uuid*, custom ); ```                                                          |
| teleport          	| ``` teleport( location*, custom ); ```                                                     |
| touch_prim        	| ``` touch_prim( uuid*, custom ); ```                                                       |
| touch_prim_coord  	| ``` touch_prim_coord( x*, y*, z*, precision, custom ); ```                                 |
| wear              	| ``` wear( uuid*, custom ); ```                                                             |
