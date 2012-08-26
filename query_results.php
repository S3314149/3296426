<?php
  if ($_GET['submit'] != 'Show Wines') {
    header("Location: html_form.php");
    exit;
  }
?>
<!DOCTYPE HTML PUBLIC
"-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>The Results Searching</title>
</head>

<body bgcolor="white">
<?php

  require 'db.php';
   
 function mysqlclean($input, $maxlength, $connection)
{
	$input = substr($input, 0, $maxlength);
	$input = mysql_real_escape_string($input, $connection);
	return($input);
}
  
     function showerror() {
    die("Error " . mysql_errno() . " : " . mysql_error());
  }
	
  function displayWinesList($connection, $query, $wineryName) {
   
            if (!($result = @ mysql_query ($query, $connection)))
			showerror();
           $rowsFound = @ mysql_num_rows($result);

      if ($rowsFound > 0) {
     
      print "Wines of $wineryName<br>";
      print "\n<table>\n<tr>" .
          "\n\t<th>Wine Name</th>" .
		  "\n\t<th>Grape Varieties</th>" .
		  "\n\t<th>Year</th>" .
		  "\n\t<th>Winery</th>" .
		  "\n\t<th>Region</th>" .
		  "\n\t<th>Invent Cost</th>" .
		  "\n\t<th>Total available</th>" .
          "\n\t<th>Total sale</th>" .
          "\n\t<th>Total earn</th>";
      while ($row = @ mysql_fetch_array($result)) {
     
        print "\n<tr>\n\t<td>{$row["wine_name"]}</td>" .
              "\n\t<td>{$row["variety"]}</td>" .
              "\n\t<td>{$row["year"]}</td>" .
              "\n\t<td>{$row["winery_name"]}</td>" .
			  "\n\t<td>{$row["region_name"]}</td>" .
			  "\n\t<td>{$row["cost"]}</td>" .
              "\n\t<td>{$row["on_hand"]}</td>\n</tr>";
      } 
        print "\n</table>";
    } 
        print "{$rowsFound} records found matching your criteria<br>";
  } 

  
  if (!($connection = @ mysql_connect(DB_HOST, DB_USER, DB_PW))) { die("Could not connect");}

      $regionName = mysqlclean($_GET, "wineryName", $connection);
      if (!mysql_select_db(DB_NAME, $connection))
	  { showerror();}

  
  
  $query = "SELECT wine_id, wine_name, description, year, winery_name
FROM winery, region, wine
WHERE winery.region_id = region.region_id
AND wine.winery_id = winery.winery_id";

      $query .= " ORDER BY wine_name"; 
      displayWinesList($connection, $query, $wineryName);
?>
</body>
</html>


