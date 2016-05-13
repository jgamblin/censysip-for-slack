<?php
/*
REQUIREMENTS
* A custom slash command on a Slack team
* A web server running PHP5 with cURL enabled
USAGE
* Place this script on a server running PHP5 with cURL.
* Set up a new custom slash command on your Slack team: 
  http://my.slack.com/services/new/slash-commands
* Under "Choose a command", enter whatever you want for 
  the command. /dns is easy to remember.
* Under "URL", enter the URL for the script on your server.
* Leave "Method" set to "Post".
* Decide whether you want this command to show in the 
  autocomplete list for slash commands.
* If you do, enter a short description and usage hint.
*/

# Grab some of the values from the slash command, create vars for post back to Slack
$command = $_POST['command'];
$text = $_POST['text'];
$token = $_POST['token'];

# Check the token and make sure the request is from our team 

if($token != 'uUnyGjMVcC1e0AYmoerYPyFz'){ #replace this with the token from your slash command configuration page
  $msg = "The token for the slash command doesn't match. Check your script.";
  die($msg);
  echo $msg;
}

$user_agent = "HostLookup/1.0";

# We're just taking the text exactly as it's typed by the user. If it's not a valid domain, isitup.org will respond with a `3`.

# You need to add your censys.io API ID and Secert. 
$url_to_check = "https://API ID:SecertB@censys.io/api/v1/view/ipv4/".$text;

# Set up cURL 
$ch = curl_init($url_to_check);
# Set up options for cURL 

# We want to get the value back from our query 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

# Send in our user agent string 
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

# Send Our Username And Password
#curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

# Make the call and get the response 
$ch_response = curl_exec($ch);

# Close the connection 
curl_close($ch);

$result = json_decode($ch_response);
print_r($result);

