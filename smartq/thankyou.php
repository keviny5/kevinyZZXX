<?php 
 
 /** These will declare the variables based on the input on the form. **/
 $description           = htmlspecialchars_decode($_POST['description']);
 $expected_behavior     = htmlspecialchars_decode($_POST['expected_behavior']); 
 $businesscase          = htmlspecialchars_decode($_POST['businesscase']);
 $ticket_type           = htmlspecialchars($_POST['ticket_type']);
 //$ticket_priority       = htmlspecialchars($_POST['ticket_priority']); 
 $affected_modules      = htmlspecialchars($_POST['affected_modules']);
 $requestor             = htmlspecialchars($_POST['email']);
 $name                  = htmlspecialchars($_POST['ticket_name']);
 $affectedModules       = htmlspecialchars($_POST['affected_modules']);
 $linkAffected          = htmlspecialchars($_POST['link_to_affected_site']);
 $step_id               = htmlspecialchars($_POST['step_id']);

 
 /** Since the steps to reproduce is an required field this is to check and see if there is any data coming through or not. If there is no data there will be N/A
     will be the default value. If there is data will go in normally. **/
 if ($_POST['steps_to_reproduce'] == '') {$stepsReproduce = 'N/A'; } else { $stepsReproduce = htmlspecialchars_decode($_POST['steps_to_reproduce']); }
 
 
 /** This group of code will clean up the data so it will be coming in correctly. In case there is a '/#@*!&@&#^ in the paragraph **/
 $realDescription       = stripslashes($description);
 $stepsToReproduce      = stripslashes($stepsReproduce);
 $expectedBehavior      = stripslashes($expected_behavior);
 $businessCase          = stripslashes($businesscase);
 
 /** This part is for the important log in information, the project id and the api key is being used to enter the ticket info. Also it will initialize the variables  **/
 
 /** This will initalize the php curl so it can send information to an exeternal application. **/
 $curl = curl_init();

/**  This will process the information for the data to be sent into smartq   **/
 curl_setopt ($curl, CURLOPT_URL, $strUrl);
 curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt ($curl, CURLOPT_POST, true);
 curl_setopt ($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
 curl_setopt ($curl, CURLOPT_USERPWD, $strCurlLog);
 curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Client-Id:' . $strApi));

/** This will send the data via an array into smartq based on the information from the web form and the fields into smartq  **/ 
$post  = array (
     'ticket' => array(
     'description' => $realDescription,
     'name' => $name,    
     'f20' => $expected_behavior,
     'f10' => $affectedModules,
     'f7' => '616',    
     'f6' => $stepsToReproduce,
     'f2' => $ticket_type,
//   'f1' => $ticket_priority,
     'f3' => $requestor,     
     'f8' => $linkAffected,
     'f23' => $businessCase,
     'step_id' => $step_id
      )

  );

 /** This will send the data into smartq **/ 
 curl_setopt ($curl, CURLOPT_POSTFIELDS, http_build_query($post));

 /** This will return the result of the input **/
 $result = curl_exec($curl);
 //echo $result;
 
 /** This will close the curl output **/
 curl_close($curl);
 
 /** This will convert the data to an array so the data can be broken down based on the output.. **/
 $data = json_decode($result, TRUE);
 
 /** This will get the id and the email address so it can be sent person that the ticket has been created. **/
 $ticketId = $data['data']['id'];
 $emailAddress = $data['data']['f3'];
 $ticketName = $data['data']['name'];

 /** This will be the php email part. **/
 
 $to = $emailAddress;
 $subject = 'Smartq Ticket Created'; 
 $message = "Hello there,<BR><BR> This email is to confirm that you have submitted ticket number <b>" . $ticketId . "</b>, titled <b>" . $ticketName. "</b>. ";
 $message .= "Thank you for your submission. A member of the platform team will get with you if there are any questions or more information ";
 $message .= "is needed to work this problem.  If you have additional questions, feel free to contact ";
 $message .= "Theresa Rozman at <a href='mailto:trozman@travelclick.com'>trozman@travelclick.com</a>.<BR><BR>";
 $message .= "Thank you";

 
 $headers = 'From: nobody@travelclick.com' . "\r\n";
 $headers .= 'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
 
 (mail($to, $subject, $message, $headers) )
 

 ?>
<!DOCTYPE html>
<html>
<head>
<title>Travel Click - Current Smartq Tickets </title>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/styles.css">
 
</head>
<body> 

<!--select menu is manual for now - needs a filter array function in the future -->
<div id="wrapper"><div class="header"><div class=logo><img src="images/logo.png" alt="TravelClick Logo" /></div>

<div class="pageHeading">
<h1> SmartQ Ticket Submission Form</h1>
<p>Please fill out the form below for any request that is needed. <br />If you have any questions about any ticket please contact <a href="mailto:trozman@travelclick.com">Theresa Rozman</a></p>
</div>
</div><div id="main"><div id="navigation"><div id="menu"> 
  <div id="systemMenu"><a href="index.php">Home</a> | <a href="submit-ticket.php">Submit a Ticket</a> | <a href="mailto:trozman@travelclick.com">Email</a></div>
    <div id="boardMenu"><form id="nav"><select class="selectBoardMenu"  onchange="window.open(this.options[this.selectedIndex].value,'_top')">
      <option selected value="#">Select Board</option>
      <option value="index.php">Z_HTB triage queue</option>
      <option value="list-tickets.php?pid=24">Z_HTB Release 13.1.1</option>
      <option value="list-tickets.php?pid=17">Z_HTB Sprint - 13.1</option>
      <option value="list-tickets.php?pid=20">Z_HTB Sprint - 13.2</option>
      <option value="list-tickets.php?pid=21">Z_HTB Sprint - 13.3</option>
      <option value="list-tickets.php?pid=23">Z_HTB Sprint - 13.4</option>
      <option value="list-tickets.php?pid=26">Z_HTB Sprint - 13.5</option>
      <option value="list-tickets.php?pid=29">Z_HTB Sprint - 13.6</option>
      <option value="list-tickets.php?pid=30">Z_HTB Sprint - 14.1</option>
      <option value="list-tickets.php?pid=31">Z_HTB Sprint - 14.2</option>
    </select></form></div> 
</div></div>
<div id="content">
<p>Thank you for submitting a ticket. Someone will give you a response on the estimated time of completion of the ticket.<br />
 <a href="index.php">Return to the home page.</a>  </p>

</div><div class="footer"> &copy; 2014 TravelClick."TravelClick" and all related logos and marks are owned by and/or are registered trademarks of TravelClick, Inc.</div></div>
</body>
</html>
