<!DOCTYPE HTML PUBLIC
"-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Wines</title>
</head>
<body>
<form action="query_results.php" method="GET">
<?php
  require "db.php";


  function selectDistinct ($connection, 
                           $tableName, 
                           $attributeName, 
                           $pulldownName, 
                           $defaultValue) {
       

	   
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName}";
       if (!($resultId = @ mysql_query ($distinctQuery, $connection))) showerror();

        print "\n<select name=\"{$pulldownName}\">";

         while ($row = @ mysql_fetch_array($resultId))
          {$result = $row[$attributeName];
           if (isset($defaultvalue) && $result == $defaultValue)
                 print "\n\t<option selected value=\"{$result}\">{$result}";
           else
                 print "\n\t<option value=\"{$result}\">{$result}";
        print "</option>";
    }
    print "\n</select>";
  } 
   if (!($connection = @ mysql_connect(DB_HOST, DB_USER, DB_PW))) {showerror();}
   if (!mysql_select_db(DB_NAME, $connection)) {showerror(); }
   print "\nWinery: ";
   selectDistinct($connection, "winery", "winery_name", "wineryName", "All");
?>
<br>
<input type="submit" name="submit" value="Show Wines">
</form>
</body>
</html>


