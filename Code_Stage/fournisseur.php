<?php

$VARFOURNISSEUR=$_REQUEST['fournisseur'];
include './bdd.php';
$I='I';
$V='';
 
if(strlen($VARFOURNISSEUR)>0)
{	
 if (is_numeric($VARFOURNISSEUR)) {
             // on se connecte à la base de donnée	
	     $connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");	

	           //ma requete
          $req="select rivp.tiers(totie_cod) lib_tiers, toeta_cod etats from todpm where totie_cod =$VARFOURNISSEUR";

             //j'execute ma requete
          $statement = $connexion->query($req);


                //je récupère les élements de ma requête
           $statement->setFetchMode(PDO::FETCH_ASSOC); 
		   
        $form="fournisseur inconnu";
       while($row = $statement->fetch()) { 

	          $form=$row['LIB_TIERS'];
            //affiche le libelle en rouge lorsque le fournisseur est inactif
		
			  if($row['ETATS']==$I)
			  {
	                    $form="<span class='text-danger'>".$form." inactif</span>";
			          }
			  
              }
echo $form;
 }else{
	 echo " afficher le numero du fournisseur svp ";
}
   }
   
 ?>