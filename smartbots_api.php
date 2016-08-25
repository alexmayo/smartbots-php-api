<!--**************************************************************************
MIT License

Copyright (c) 2016 

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
***************************************************************************-->

<?php

	/**** REMOVE DIRECT ACCESS ****/
	if(__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
		echo "Direct access to the API is not permitted."; 
		die(); 
	}

	/*******************************************************
	********************* APPLICATION **********************
	*******************************************************/

	Class SmartBot {

	/*******************************************************
	**************** APPLICATION VARIABLES *****************
	*******************************************************/

		// Variables.
		private $sb_ApiKey        = ""; // The developer's API key.
		private $sb_BotName       = ""; // The SmartBot's name.
		private $sb_Secret        = ""; // The SmartBot's secret authentication code.
		private $sb_Action        = ""; // The SmartBot's action to perform.
		public  $sb_QueryArray    = array(); // The query variables, displayed as an array.
		public  $sb_QueryString   = ""; // The query variables, displayed as a formatted string.
		public  $sb_QueryResponse = ""; //The response from the query.
		public  $sb_QueryResponseArray = array(); //The response from the query in an array format.
		public  $sb_ScriptURL     = "http://api.mysmartbots.com/api/bot.html"; // Where the POST request will be sent.

	/*******************************************************
	**************** APPLICATION FUNCTIONS *****************
	*******************************************************/

		// The set up method. This assigns all bot variables to the private variables.
		public function setup($apiKey = "", $botName = "", $secret = "") {
			// If the required variables are not empty.
			if($apiKey != "" && $botName != "" && $secret != "") {
				// Set the variables.
				$this->sb_ApiKey  = $apiKey;
				$this->sb_BotName = $botName;
				$this->sb_Secret  = $secret;
				return TRUE;
			// If there are some missing variables.
			} else {
				return FALSE;
			}
		}

		// Create the query string so that it can be accepted in a URL.
		private function buildQueryString() {
			// Build the query string.
			$this->sb_QueryArray["apikey"]  = $this->sb_ApiKey;
			$this->sb_QueryArray["botname"] = $this->sb_BotName;
			$this->sb_QueryArray["secret"]  = $this->sb_Secret;
			$this->sb_QueryArray["action"]  = $this->sb_Action;
			// Set the query string.
		  $this->sb_QueryString = http_build_query($this->sb_QueryArray);
		}

		// Run the action.
		private function run() {
			// Build the query string.
			$this->buildQueryString();
			// Open CURL request.
			$ch = curl_init();
			// Do not follow any redirects.
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			// Set the CURL URL.
			curl_setopt($ch, CURLOPT_URL, $this->sb_ScriptURL."?".$this->sb_QueryString);
			// Execute the action.
			$content = curl_exec($ch);
			// Store the response in an array format and in a string format.
			$this->sb_QueryResponse = $content;
			parse_str($content, $this->sb_QueryResponseArray);
			// Depending on the result, return true or false.
			return $this->sb_QueryResponseArray["result"] == "OK" ? TRUE : FALSE;
		}

		// Get the response from the bot and return it.
		// Set to TRUE to receive the response in a string format.
		public function response($stringFormat = FALSE) {
			if($stringFormat) {
				return $this->sb_QueryResponse;
			} else {
				return $this->sb_QueryResponseArray;
			}
		}

	/*******************************************************
	**************** SMARTBOTS API METHODS *****************
	*******************************************************/	


		// Example of what each segment of a method runes.
		/*
			public function action($data = "", $custom = "") {
				// Clean the current query array.
				$this->sb_QueryArray = array();
				// Set the action.
				$this->sb_Action = "action";
				// Add the necessary query array parameters.
				$this->sb_QueryArray["data"] = $data;
				// If it is set, add the custom query parameter.
				$this->sb_QueryArray["custom"] = $custom;
				// Do the command and return the output.
				return $this->run();
			}
		*/

		// login(location(optional), custom(optional))
		public function login($location = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "login";
			$this->sb_QueryArray["location"] = $location;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// logout(custom(optional))
		public function logout($custom = "") {
			// Clean the current query array.
			$this->sb_QueryArray = array();
			$this->sb_Action = "logout";
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// set_http_callback(url(optional), events(required))
		public function set_http_callback($url = "", $events = "", $custom = "") {
			// Clean the current query array.
			$this->sb_QueryArray = array();
			$this->sb_Action = "set_http_callback";
			$this->sb_QueryArray["url"] = $url;
			$this->sb_QueryArray["events"] = $events;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// activate_group(uuid(required), custom(optional))
		public function activate_group($groupuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "activate_group";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// attachment_touch(objectname(required), linkset(required), custom(optional))
		public function attachment_touch($objectname = "", $linkset = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "attachment_touch";
			$this->sb_QueryArray["objectname"] = $objectname;
			$this->sb_QueryArray["linkset"] = $linkset;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// attachments(skipnames(optional), matchnames(optional), matchuuid(optional), custom(optional))
		public function attachments($skipnames = "", $matchnames = "", $matchuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "attachments";
			$this->sb_QueryArray["skipnames"] = $skipnames;
			$this->sb_QueryArray["matchnames"] = $matchnames;
			$this->sb_QueryArray["matchuuid"] = $matchuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// avatar_groups(avatar(required), skipnames(optional), matchnames(optional), matchuuid(optional), custom(optional))
		public function avatar_groups($avatar = "", $skipnames = "", $matchnames = "", $matchuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "avatar_groups";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["skipnames"] = $skipnames;
			$this->sb_QueryArray["matchnames"] = $matchnames;
			$this->sb_QueryArray["matchuuid"] = $matchuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// avatar_picks(avatar(required), skipnames(optional), matchnames(optional), matchuuid(optional), custom(optional))
		public function avatar_picks($avatar = "", $skipnames = "", $matchnames = "", $matchuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "avatar_picks";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["skipnames"] = $skipnames;
			$this->sb_QueryArray["matchnames"] = $matchnames;
			$this->sb_QueryArray["matchuuid"] = $matchuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// give_inventory(avatar(required), object(required), custom(optional))
		public function give_inventory($avatar = "", $object = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "give_inventory";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["object"] = $object;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// give_money(avatar(required), amount(required), comment(optional), custom(optional))
		public function give_money($avatar = "", $amount = "", $comment = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "give_money";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["amount"] = $amount;
			$this->sb_QueryArray["comment"] = $comment;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// give_money_object(object_uuid(required), amount(required), object_name(optional), custom(optional))
		public function give_money_object($object_uuid = "", $amount = "", $object_name = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "give_money_object";
			$this->sb_QueryArray["object_uuid"] = $object_uuid;
			$this->sb_QueryArray["amount"] = $amount;
			$this->sb_QueryArray["object_name"] = $object_name;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// group_eject(avatar(required), groupuuid(required), custom(optional))
		public function group_eject($avatar = "", $groupuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "group_eject";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// group_invite(avatar(required), groupuuid(required), roleuuid(required), check_membership(optional), message(optional), custom(optional))
		public function group_invite($avatar = "", $groupuuid = "", $roleuuid = "", $check_membership = "", $message = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "group_invite";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["roleuuid"] = $roleuuid;
			$this->sb_QueryArray["check_membership"] = $check_membership;
			$this->sb_QueryArray["message"] = $message;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// group_join(groupuuid(required), custom(optional))
		public function group_join($groupuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "group_join";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// group_leave(groupuuid(required), custom(optional))
		public function group_leave($groupuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "group_leave";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// im(slname(required), message(required), custom(optional))
		public function im($slname = "", $message = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "im";
			$this->sb_QueryArray["slname"] = $slname;
			$this->sb_QueryArray["message"] = $message;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// key2name(key(required), request_case(optional), custom(optional))
		public function key2name($key = "", $request_case = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "key2name";
			$this->sb_QueryArray["key"] = $key;
			$this->sb_QueryArray["request_case"] = $request_case;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// list_group_roles(groupuuid(required), custom(optional))
		public function list_group_roles($groupuuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "list_group_roles";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// listgroups(custom(optional))
		public function listgroups($custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "listgroups";
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// listinventory(uuid(optional), extended(optional), custom(optional))
		public function listinventory($uuid = "", $extended = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "listinventory";
			$this->sb_QueryArray["uuid"] = $uuid;
			$this->sb_QueryArray["extended"] = $extended;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// move(instruction(required), param1(required), custom(optional))
		public function move($instruction = "", $param1 = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "move";
			$this->sb_QueryArray["instruction"] = $instruction;
			$this->sb_QueryArray["param1"] = $param1;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// name2key(name(required), request_case(optional), custom(optional))
		public function name2key($name = "", $request_case = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "name2key";
			$this->sb_QueryArray["name"] = $name;
			$this->sb_QueryArray["request_case"] = $request_case;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// offer_friendship(avatar(required), message(optional), custom(optional))
		public function offer_friendship($avatar = "", $message = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "offer_friendship";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["message"] = $message;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// offer_teleport(avatar(required), message(optional), custom(optional))
		public function offer_teleport($avatar = "", $message = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "offer_teleport";
			$this->sb_QueryArray["avatar"] = $avatar;
			$this->sb_QueryArray["message"] = $message;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// parcel_info(x(optional), y(optional), getvalue(optional), custom(optional))
		public function parcel_info($x = "", $y = "", $getvalue = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "parcel_info";
			$this->sb_QueryArray["x"] = $x;
			$this->sb_QueryArray["y"] = $y;
			$this->sb_QueryArray["getvalue"] = $getvalue;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// rebake(custom(optional))
		public function rebake($custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "rebake";
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// reply_dialog(channel(required), object(required), button(required), custom(optional))
		public function reply_dialog($channel = "", $object = "", $button = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "reply_dialog";
			$this->sb_QueryArray["channel"] = $channel;
			$this->sb_QueryArray["object"] = $object;
			$this->sb_QueryArray["button"] = $button;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// say_chat_channel(channel(required), message(required), custom(optional))
		public function say_chat_channel($channel = "", $message = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "say_chat_channel";
			$this->sb_QueryArray["channel"] = $channel;
			$this->sb_QueryArray["message"] = $message;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// send_group_im(groupuuid(required), message(required), custom(optional))
		public function send_group_im($groupuuid = "", $message = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "send_group_im";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["message"] = $message;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// send_notice(groupuuid(required), subject(required), text(required), attachment(optional), custom(optional))
		public function send_notice($groupuuid = "", $subject = "", $text = "", $attachment = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "send_notice";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["subject"] = $subject;
			$this->sb_QueryArray["text"] = $text;
			$this->sb_QueryArray["attachment"] = $attachment;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// setrole(groupuuid(required), roleuuid(required), member(required), custom(optional))
		public function setrole($groupuuid = "", $roleuuid = "", $member = "",$custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "setrole";
			$this->sb_QueryArray["groupuuid"] = $groupuuid;
			$this->sb_QueryArray["roleuuid"] = $roleuuid;
			$this->sb_QueryArray["member"] = $member;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// sit(uuid(required), save(optional), custom(optional))
		public function sit($uuid = "", $save = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "sit";
			$this->sb_QueryArray["uuid"] = $uuid;
			$this->sb_QueryArray["save"] = $save;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// takeoff(uuid(required), custom(optional))
		public function takeoff($uuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "takeoff";
			$this->sb_QueryArray["uuid"] = $uuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// teleport(location(required), custom(optional))
		public function teleport($location = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "teleport";
			$this->sb_QueryArray["location"] = $location;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// touch_prim(uuid(required), custom(optional))
		public function touch_prim($uuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "touch_prim";
			$this->sb_QueryArray["uuid"] = $uuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// touch_prim_coord(x(required), y(required), z(required), precision(optional), custom(optional))
		public function touch_prim_coord($x = "", $y = "", $z = "", $precision = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "touch_prim_coord";
			$this->sb_QueryArray["x"] = $x;
			$this->sb_QueryArray["y"] = $y;
			$this->sb_QueryArray["z"] = $z;
			$this->sb_QueryArray["precision"] = $precision;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

		// wear(uuid(required), custom(optional))
		public function wear($uuid = "", $custom = "") {
			$this->sb_QueryArray = array();
			$this->sb_Action = "wear";
			$this->sb_QueryArray["uuid"] = $uuid;
			$this->sb_QueryArray["custom"] = $custom;
			return $this->run();
		}

	}

?>
