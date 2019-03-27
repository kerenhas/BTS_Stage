<?php
$VARSOCACTU=$_REQUEST['societe'] ;
$VARESO=$_REQUEST['ESO'];

session_start();
   //recuperation du nom de l'utilisateur
$VARNOMUTI= $_SESSION['nom_uti'];
include './bdd.php';
// on se connecte à la base de donnée	
	$connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");	
	$b=$VARESO;
    $c = explode("-",$b);
	$d=$c[0];
if(strlen($d)>0){
			
		// ma requete
$reqs="= '".$d."'";	
 
}	else{
	$reqs=" in
(  
select toeso.toeso_cod  
from mguti , tophr, toeso
where 1=1
and totie_cod_pm= ".$VARSOCACTU."
and mguti.mguti_cod =  '".$VARNOMUTI."'
and tophr.totie_cod_pp=mguti.totie_cod and nvl(tophr_dtf,trunc(sysdate))>=trunc(sysdate) and toeso.toeso_cod=tophr.toeso_cod and toeso.toneo_cod='AGEN'
)";

}
				// ma requete
$req="select paesi_codext code, paesi_lib lib ,rivp.adr(paesi_num) adr
from paesi where panes_cod='GROUP' 
and RIVP.AGENCE(paesi_num)".$reqs."order by code";

 $statement = $connexion->query($req);
              $statement->setFetchMode(PDO::FETCH_ASSOC);

			     echo"<OPTION  name='ESI' id='ESI'></option>";
		      While($row = $statement->fetch()) {
			   ?>
			<OPTION value="<?=$row['CODE'];?>"><?= $row['CODE'].' - '.$row['LIB'] ;?></option>
			
				<?php 
		        }	
			  echo'</select>';  	


		  
?>