<!DOCTYPE html>
<html>
<head>
<title>Travel Click - Smartq Ticket Details </title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<div id="details"> 
<?php
/*smartQ API reference site http://www.getsmartq.com/help/api.php
Application build 1/17/14 Erik Vecchione


credentials for SmartQ API*/
 

 /** This part is for  the project id and the api key is being used to retrieve the ticket info. Also it will initialize the variables  **/
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $strUrl);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
curl_setopt ($curl, CURLOPT_USERPWD, $strCurlLog);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Client-Id:' . $strApi));
$projects = curl_exec($curl);

 /**  returns the list of notes **/
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $strNotes);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
curl_setopt ($curl, CURLOPT_USERPWD, $strCurlLog);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Client-Id:' . $strApi));
$notelist = curl_exec($curl);


//Decodes data strings, sets tickets into an PHP arrays
$tickets = json_decode($projects, TRUE);
$notes = json_decode($notelist,TRUE);
/* Getting the fields for the ticket details */

foreach ($tickets as $ticket) {
    $ticketid =  $ticket['id'];
    $ticketName = $ticket['name'];
    $ticketDescription = $ticket['description'];
    $ticketOpened = $ticket['insert_time'];
    $ticketUpdated = $ticket['update_time'];
    $ticketType = $ticket['update_time'];
            $detail1 =  $ticket['custom_fields']['f1'];
            $detail2 =  $ticket['custom_fields']['f2'];
            $detail3 =  $ticket['custom_fields']['f3'];
            //$detail4 =  $ticket['custom_fields']['f4'];
            //$detail5 =  $ticket['custom_fields']['f5'];
            $detail6 =  $ticket['custom_fields']['f6'];
            //$detail7 =  $ticket['custom_fields']['f7'];
            $detail8 =  $ticket['custom_fields']['f8'];
            //$detail9 =  $ticket['custom_fields']['f9'];
            $detail10 =  $ticket['custom_fields']['f10'];
            //$detail11 =  $ticket['custom_fields']['f11'];
            $detail12 =  $ticket['custom_fields']['f12'];
            //$detail13 =  $ticket['custom_fields']['f13'];
            //$detail14 =  $ticket['custom_fields']['f14'];
            //$detail15 =  $ticket['custom_fields']['f15'];
            $detail16 =  $ticket['custom_fields']['f16'];
            //$detail17 =  $ticket['custom_fields']['f17'];
            //$detail18 =  $ticket['custom_fields']['f18'];
            //$detail19 =  $ticket['custom_fields']['f19'];
            $detail20 =  $ticket['custom_fields']['f20'];
           $detail21 =  $ticket['custom_fields']['f21'];
           // $detail22 =  $ticket['custom_fields']['f22'];
           //$detail24 =  $ticket['custom_fields']['f24'];
           // $detail25 =  $ticket['custom_fields']['f25'];
}


/*Display Table */

echo <<<EOD

<table id="ticketDetails">
    <tr><td colspan="2" class="sorting"><h1>Ticket Details: $ticketid</h1></td></tr>
    <tr><td class="label"><h2>Name</h2></td><td><h2>$ticketName</h2></td></tr>
    <tr><td class="label">Description</td><td>$ticketDescription</td></tr>
    <tr><td class="label">Opened</td><td>$ticketOpened</td></tr>
    <tr><td class="label">Last Updated</td><td>$ticketUpdated</td></tr>
    <tr><td class="label">Priority</td><td>

EOD;
/*  The way the API is set-up we don't have all the data sets in the SmartQ tables available to us.
    SmartQ arrays are decoded from a series of JSON feeds, there are two different feeds that offer data for individual ticket details
    and the actual detail fields for parameters such as priority and ticket type. It is a bit of a challenge to associate the two arrays, as the values of one array are the keys of another.
    The quickest solution for the time being was to just specify the values for these field options, there probably is a better way to do this in the future though 
    - EV */
if ($detail1 == '599') {
    echo "Blocker";}
if ($detail1 == '600') {
    echo "Critical";}
if ($detail1 == '601') {
    echo "Major";}
if ($detail1 == '602') {
    echo "Minor";}
if ($detail1 == '603') {
    echo "Trivial";} 
echo <<<EOD
</td></tr>
    <tr><td class="label">Business Case</td><td>
EOD;
  if(isset($ticket['custom_fields']['f22'], $tickets))
            { echo $ticket['custom_fields']['f22'];}
            else { echo "None";
             }
 echo <<<EOD
 </td></tr>
    <tr><td class="label">Type of Ticket</td><td>
EOD;


if ($detail2 == '604') {
    echo "Bug";}
if ($detail2 == '605') {
    echo "Epic";}
if ($detail2 == '606') {
    echo "Impediment";}
if ($detail2 == '607') {
    echo "Improvement";}
if ($detail2 == '608') {
    echo "New Feature";}
echo <<<EOD
</td></tr>
    <tr><td class="label">Requestor</td><td>$detail3</td></tr>
    <tr><td class="label">Steps to Reproduce</td><td>$detail6</td></tr>
    <tr><td class="label">Expected Behavior</td><td>$detail20</td></tr>
    <tr><td class="label">Link Affected</td><td><a href="$detail8" "target="_blank">$detail8</a></td></tr>
    <tr><td class="label">Affected Module</td><td>$detail10</td></tr>
    <tr><td class="label">Assigned To:</td><td>$detail12</td></tr>
    <tr><td class="label">Status</td><td>$detail16</td></tr>
    <tr><td colspan="2" class="sorting"><h1>Recent Notes: </h1></td></tr>
    

</table>


EOD;

foreach ($notes['data'] as $value) {
    
    foreach ($value as $k => $v) {
        $noteContent = $v['text'];
        $ownerID = $v['owner_id'];
        $insertTime = $v['insert_time'];
        $strUrl = 'http://tcweb.smartqweb.com/api/v1/users/' .$ownerID . '';
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $strUrl);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt ($curl, CURLOPT_USERPWD, $strCurlLog);
        curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Client-Id:' . $strApi));
        $userInfo = curl_exec($curl);
        $user = json_decode($userInfo, TRUE);

        foreach ($user as $key => $value) {
            $speaker = $value['name'];
        }
        
        echo <<<EOD
        <table id="Notes">
        <tr><td class="label">$speaker:</td><td>$noteContent</td><td>$insertTime</td><tr>
        </table>




EOD;
    }

    break;
}


?>
<button type="reset"  class="btnReset" value="Reset" onClick="document.location.reload(true)">Refresh</button>
</div></body>
</html>
