<!DOCTYPE html>
<html>
<head>
<title>Travel Click - Current Smartq Tickets </title>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/styles.css">
 <script>
// todo: better form validation method
function toggleTest(selectobj)
{
  var tmp =  selectobj.selectedIndex;
  var obj = document.getElementById('other2');
  var obj1 = document.getElementById('other3'); 
  
  if (tmp <= 3) { obj.style.display = "inline";  obj1.style.display = "inline";  }
  else if (tmp >= 4) { obj.style.display = "none";  obj1.style.display = "none";  }
}


function validateForm()
{
 
  var ticketName=document.forms["submitTicket"]["ticket_name"].value;
  var ticketType=document.forms["submitTicket"]["ticket_type"].value;
  var ticketDesc=document.forms["submitTicket"]["description"].value;
  var ticketBcase=document.forms["submitTicket"]["businesscase"].value;
  var ticketSteps=document.forms["submitTicket"]["steps_to_reproduce"].value;
  var ticketExpected=document.forms["submitTicket"]["expected_behavior"].value;
  var ticketLink = document.forms["submitTicket"]["link_to_affected_site"].value;
  var ticketAffected = document.forms["submitTicket"]["affected_modules"].value;
  var ticketEmail = document.forms["submitTicket"]["email"].value;
  
  var atpos=ticketEmail.indexOf("@");
  var dotpos=ticketEmail.lastIndexOf(".");
  
  
  if (ticketName==null || ticketName=="")
  {
  alert("Please enter the name of the ticket!");
  return false;
  }
  else if (ticketType==null || ticketType=="")
  {
   alert("Please select the type of the ticket!");
   return false;
  }
  else if (ticketType != null || ticketType != "")
  {
    
  if (ticketType <= 606)
    {
    if (ticketDesc == null || ticketDesc == "")
    {
      alert ("Please enter the ticket description!");   
         return false;
    }
    else if (ticketBcase == null || ticketBcase == "")
    {
     alert ("Please enter the business case for the ticket!");
     return false;
    }
    else if (ticketSteps == null || ticketSteps == "")
    {
     alert ("Please enter the steps to reproduce the error!");
     return false;
    }
    else if (ticketExpected == null || ticketExpected == "")
    {
     alert ("Please enter the expected behavior!");
     return false;
    }
    else if (ticketLink == null || ticketLink == "")
    {
     alert ("Please enter the link!");
     return false;
    }
    else if (ticketAffected == null || ticketAffected == "")
    {
     alert ("Please enter the modules affected!");
     return false;
    }
    else if (ticketEmail == null || ticketEmail == "")
    {
     alert ("Please enter your email address!");
     return false;
    }
    else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
      {
       alert("Not a valid e-mail address!");
       return false;
      }
     
   }
   else
   {
    if (ticketDesc == null || ticketDesc == "")
    {
      alert ("Please enter the ticket description!");   
         return false;
    }
    else if (ticketBcase == null || ticketBcase == "")
    {
     alert ("Please enter the business case for the ticket!");
     return false;
    }
    else if (ticketExpected == null || ticketExpected == "")
    {
     alert ("Please enter the expected behavior!");
     return false;
    }
    else if (ticketAffected == null || ticketAffected == "")
    {
     alert ("Please enter the modules affected!");
     return false;
    } 
      else if (ticketEmail == null || ticketEmail == "")
    {
     alert ("Please enter your email address!");
     return false;
    }
    else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
      {
       alert("Not a valid e-mail address!");
       return false;
      }   
   
   }
  
  }



}
</script>  <!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

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
<div id="stylized" class="myform">
<form action="thankyou.php" method="post" name="submitTicket" onsubmit="return validateForm();" >

<?php     
echo <<<END
<input type=hidden name=ticket_priority value="602" />
<input type=hidden id=step_id name=step_id value="347" />
<div class="myformLabels"><label for="ticket_name"><strong>Ticket Name:</strong></label></div>
<div class="myformFields"><input type="text" name="ticket_name" size="50" ></div>
<BR><BR>
END;

/** This array will be for the drop down Ticket Type  **/
 
$ticket_type=array(
"Bug"=>"This is a bug for the module that needs to be fixed.",
"Epic"=>"A epic failure that needs to be fixed right away.",
"Impediment"=>"This is an impediment that is needs to be worked on.",
"Improvement"=>"This needs to be imrpoved upon.",
"New Feature"=>"Da Bears!"
);
 



echo <<<END


<div class="myformLabels"><label for="ticket_type"><strong>Type of Ticket:</strong></label></div>
<div class="myformFields"><select name="ticket_type" onchange='toggleTest(this);' id="ticket_type" >
 <option value="">- choose value -</option>
 <option value="604" title="Bug: This is a bug for the module that needs to be fixed.">Bug</option>
 <option value="605" title="Epic: A epic failure that needs to be fixed.">Epic</option>
 <option value="606" title="Impediment: This is an impediment that is needs to be worked on.">Impediment</option>
 <option value="607" title="Improvement: This needs to be imrpoved upon.">Improvement</option>
 <option value="608" title="New Feature: Something new to be added.">New Feature</option>

END;
//foreach($ticket_type as $x=>$x_value) {  echo '<option value="' . $x . '" title="' . $x . ' : '. $x_value . '" >' . $x . '</option>'; $i++; }

echo <<<END
 </select></div>



<div class="myformLabels"><label for="description"><strong>Description:</strong></label></div>
<div class="myformFields"><textarea name="description" cols=40 rows=4>
</textarea></div>

<div class="myformLabels"><label for="businesscase"><strong>Business Case:</strong></label></div>
<div class="myformFields"><textarea name="businesscase" cols=40 rows=4>
</textarea></div>

<div class="myformLabels"><label for="expected_behavior"><strong>Expected behavior:</strong></label></div>
<div class="myformFields"><textarea name="expected_behavior" cols=40 rows=4>
</textarea></div>

<div class="myformLabels"><label for="steps_to_reproduce"><strong>Steps To Reproduce:</strong></label></div>
<div class="myformFields"><textarea name="steps_to_reproduce" cols=40 rows=4>
</textarea></div>

<div class="myformLabels"> 
<label for="affected_modules"><strong>Affected Modules:</strong></label></div>
<div class="myformFields">
<input type="text" name="affected_modules"></div>

<div class="myformLabels"> 
<label for="link_to_affected_site"><strong>Affected Site:</strong></label></div>
<div class="myformFields">
<input type="text" name="link_to_affected_site"></div>

<div class="myformLabels"> 
<label for="email"><strong>Email:</strong></label></div>
<div class="myformFields">
<input type="text" name="email"></div>

<button type="submit" value="Submit Ticket" name="submitButton" class="btn">Submit</button>
<button type="reset" class="btnReset" value="Reset" onClick="document.location.reload(true)">Reset</button>
END;
 ?>

</div><div class="footer"> &copy; 2014 TravelClick."TravelClick" and all related logos and marks are owned by and/or are registered trademarks of TravelClick, Inc.</div></div>
</body>
</html>