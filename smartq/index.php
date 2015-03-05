<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Travel Click - Current Smartq Tickets </title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">

    //DataTables plugin sorting
            $(document).ready(function() {
          $('#TicketTable').dataTable( {
              "aaSorting": [[ 0, "desc" ]]
                } );
            } );
    </script>
    <script>
    //popup window script for ticket details
        var newwindow;
        function poptastic(url)
        {
          newwindow=window.open(url,'name','height=600,width=800,scrollbars=1');
          if (window.focus) {newwindow.focus()}
        }
    </script>

</head>
<?php
/*smartQ API reference site http://www.getsmartq.com/help/api.php
Application build 1/17/14 Erik Vecchione

smartQ API Credentials*/


 /** gets JSON api feed for header titles - we need this for page titles  **/
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $strBase);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
curl_setopt ($curl, CURLOPT_USERPWD, $strCurlLog);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Client-Id:' . $strApi));
$headings = curl_exec($curl);
//Decodes data string, sets tickets into an array
$list = json_decode($headings, TRUE);
?>
<body> 

<!--select menu is manual for now - needs a filter array function in the future -->
<div id="wrapper"><div class="header"><div class=logo><img src="images/logo.png" alt="TravelClick Logo" /></div>

<div class="pageHeading">
<h1> SmartQ Board: Z_HTB Triage Queue</h1>
<p>This page will allow you to check ticket statuses. <br />If you have any questions about any ticket please contact <a href="mailto:trozman@travelclick.com">Theresa Rozman</a></p>
</div>
</div><div id="main"><div id="navigation"><div id="menu"> 
  <div id="systemMenu"><a href="index.php">Home</a> | <a href="submit-ticket.php">Submit a Ticket</a> | <a href="mailto:trozman@travelclick.com">Email</a></div>
    <div id="boardMenu"><form id="nav"><select class="selectBoardMenu"  onchange="window.open(this.options[this.selectedIndex].value,'_top')">
      <option selected value="#">Select Board</option>
      <option value="index.php">Z_HTB Active Triage Queue</option>
      <option value="list-tickets.php?pid=24">Z_HTB Release 13.1.1</option>
      <option value="list-tickets.php?pid=17">Z_HTB Sprint - 13.1</option>
      <option value="list-tickets.php?pid=20">Z_HTB Sprint - 13.2</option>
      <option value="list-tickets.php?pid=21">Z_HTB Sprint - 13.3</option>
      <option value="list-tickets.php?pid=23">Z_HTB Sprint - 13.4</option>
      <option value="list-tickets.php?pid=26">Z_HTB Sprint - 13.5</option>
      <option value="list-tickets.php?pid=29">Z_HTB Sprint - 13.6</option>
      <option value="list-tickets.php?pid=30">Z_HTB Sprint - 14.1</option>
      <option value="list-tickets.php?pid=31">Z_HTB Sprint - 14.2</option>
      <option value="list-tickets.php?pid=49">Z_HTB Sprint - 14.3</option>
      <option value="list-tickets.php?pid=53">Z_HTB Sprint - 14.4</option>
      <option value="list-tickets.php?pid=51">Z_HTB Triage - Deferred Tickets</option>
    </select></form></div> 
</div></div>

<?php
//gets JSON API feed for the list of tickets
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $strUrl);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
curl_setopt ($curl, CURLOPT_USERPWD, $strCurlLog);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Client-Id:' . $strApi));
$projects = curl_exec($curl);

//Ticket Table List
echo <<<EOD
 

  <table id="TicketTable">
   <thead>
   <th>ID</th>
   <th>Ticket Name</th>
   <th>Opened</th>
   <th>Modified</th>
   </thead>
EOD;
$tickets = json_decode($projects, TRUE);
foreach ($tickets['data']['items'] as $ticket) {
  $projectid = $ticket['project_id'];
  $ticketid = $ticket['id'];
    echo "<tr>";
    echo "<td>";
    echo '<a href="javascript:poptastic(\'ticket-details.php?pid='. $projectid .'&tid='. $ticketid .'\');">';
    echo "&nbsp;<i class='fa fa-external-link-square'></i>&nbsp;";
    echo $ticket['id'];
    echo "</a>";
    echo "</td>";
    echo "<td>";
    echo $ticket['name'];
    echo "</td>";
    echo "<td>";
    echo $ticket['insert_time'];
    echo "</td>";
    echo "<td>";
    echo $ticket['update_time'];
    echo "</td>";
    echo "</tr>";
}
echo <<<EOD

  </table>

  
EOD;
?></div><div class="footer"> &copy; 2014 TravelClick."TravelClick" and all related logos and marks are owned by and/or are registered trademarks of TravelClick, Inc.</div></div>
</body>
</html>
