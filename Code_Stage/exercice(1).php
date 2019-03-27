<?php
$VARSOCACTU=$_REQUEST['societe'] ;
$socactu=$VARSOCACTU;

include './bdd.php';
 $date=date("Y"); 
// on se connecte à la base de donnée	
	$connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");	
 // ma requete
			  $req='select icexe_num from icexe where totie_cod='.$socactu.' order by  icexe_num desc';
			  $statement = $connexion->query($req);
              $statement->setFetchMode(PDO::FETCH_ASSOC);
			
		      While($row = $statement->fetch()) 
		        { ?>
			     
			<OPTION id="exe" value="<?=$row['ICEXE_NUM'];?>" <?=$row['ICEXE_NUM']===$date? 'selected' : '' ;?> ><?= $row['ICEXE_NUM'] ;?></option>
				<?php 
		        }	 
				echo"</select>";
?>