<?php

$dbgedpdo = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=CSEDNA-REC1)(PORT=1656))(CONNECT_DATA=(SERVICE_NAME=RGED)))";
	$dbprodpdo = "oci:dbname=(DESCRIPTION=
		    (ADDRESS=
		      (PROTOCOL=TCP)
		      (HOST=CMOON-PROD1)
		      (PORT=1539)
		    )
		    (CONNECT_DATA=
		      (GLOBAL_NAME=PRGERANC)
		      (SID=PRGERANC)
		    )
		   )"; 
	$dbrecettepdo = "oci:dbname=(DESCRIPTION=
		    (ADDRESS=
		      (PROTOCOL=TCP)
		      (HOST=RAGNAR)
		      (PORT=1652)
		    )
		    (CONNECT_DATA=
		      (SERVER=dedicated)
		      (SERVICE_NAME=ETGERAN2)
		    )
		   )"; 
	
	//	ajout keren
	$dbrecetteRF2PDO = "oci:dbname=(DESCRIPTION=
		(ADDRESS=
		  (PROTOCOL=TCP)
		  (HOST=BJORN)
		  (PORT=1639)
		)
		(CONNECT_DATA=
		  (SERVICE_NAME=RFGERAN2)
		)
	  )"; 		   
		   
		   
$dbgedprodpdo = "oci:dbname=(DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=CMOON-PROD2)
      (PORT=1559)
    )
    (CONNECT_DATA=
      (SERVICE_NAME=PRPATRI)
    )
  )";  
$dbged = " (DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=CSEDNA-REC1)
      (PORT=1656)
    )
    (CONNECT_DATA=
      (SERVICE_NAME=RGED)
    )
  )";

 $dbgedrecette = " (DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=CSEDNA-REC1)
      (PORT=1656)
    )
    (CONNECT_DATA=
      (SERVICE_NAME=RGED)
    )
  )
"; 

$dbgedprod = " (DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=CMOON-PROD2)
      (PORT=1559)
    )
    (CONNECT_DATA=
      (SERVICE_NAME=PRPATRI)
    )
  )";  
  

	$dbprod = "(DESCRIPTION=
		    (ADDRESS=
		      (PROTOCOL=TCP)
		      (HOST=CMOON-PROD1)
		      (PORT=1539)
		    )
		    (CONNECT_DATA=
		      (GLOBAL_NAME=PRGERANC)
		      (SID=PRGERANC)
		    )
		   )"; 
	

$dbold = "(DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=CSEDNA-REC2)
      (PORT=1652)
    )
    (CONNECT_DATA=
      (GLOBAL_NAME=ETGERAN1)
      (SID=ETGERAN1)
    )
  )"; 
$db = "(DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=BJORN)
      (PORT=1639)
    )
    (CONNECT_DATA=
	  (SERVICE_NAME=RFGERAN2)
    )
  )"; 


  
$servername = "localhost";
$username = "adminweb";
$password = "4VwILGGutRfY";
$dbname = "awi";	
?>