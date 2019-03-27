<?php
$VARBUDGE=$_REQUEST['poste_budge'] ;
include './bdd.php';

// si le post budgetaire est renseigne
if(strlen($VARBUDGE)>0){
	
// on se connecte à la base de donnée	
	$connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");	
 // requete pour avoir les natures de depenses,dans une liste deroulante, en fonction du poste budgetaire
$req="select mgnad_cod nature, mgnad_cod ||' - ' || mgnad_lib || decode(mgnad_indetat,'I',' (Inactif)',null) lib_nature  from mgnad 
 where gbpob_cod='".$VARBUDGE."' 
 and mgnad_indetat ='A'
order by mgnad_indetat,mgnad_cod";
 $statement = $connexion->query($req);
              $statement->setFetchMode(PDO::FETCH_ASSOC);
			 echo'  <select  value="nature_depense" name="nature_depense" id="nature_depense" class="form-control autoentrer" > ';
			echo"<OPTION id='nature_depense'> </option>";
		      While($row = $statement->fetch()) 
		        { 
			 echo'<OPTION value ='.$row["LIB_NATURE"].'>'.$row['LIB_NATURE'].'</option>';
	
	              }
    // si le post budgetaire n'est pas renseigne, la nature de depense devra etre inserer				  
}else{
	echo '<input id="nature_depense" type="text" class="form-control autoentrer " name="nature_depense" />';
}
?>