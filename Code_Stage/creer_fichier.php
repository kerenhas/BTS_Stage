<?php
	$VARLST_FAC=$_REQUEST['facts'] ;
	session_start();
	$VARNOMUTI= $_SESSION['nom_uti'];
	//la date du jour
	$date=date('Y-m-H-i-s');


if(strlen($VARLST_FAC)>0){
  // sous forme de tablau,on separe tous les ; de notre liste factures
  $a=explode(';',$VARLST_FAC); 
   // chemin on sont ranges les fichiers
  $dossier="./fact/" ; 

    //verifie que le dossier existe
	if(file_exists($dossier)==false){
		mkdir($dossier); // creer le dossier 
	}

	$fich=$_SESSION['nom_uti']."factures".$date;
	//on utilise fopen pour creer un nouveau fichier
	$fichier = fopen($dossier.$fich,"w+"); 
	$b='';
	
	foreach($a as $val)
		{
			$b=$b.",";
			$k=explode('-' ,$val);
			$b=$b.$k[1];
		}
   
	$a="adresse mail: "; 
	$d="";
	$m="";//l'adresse mail
	include './bdd.php';
		// on se connecte à la base de donnée	
	$connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");	
		//requete
	$req="select mguti_cod, mguti_nom,topsp_mesatl 
	from mguti a, topsp b
	where b.totie_cod_pp=a.totie_cod 
	and  a.mguti_cod = '".$VARNOMUTI."'";

	$statement = $connexion->query($req);
              $statement->setFetchMode(PDO::FETCH_ASSOC);
		      While($row = $statement->fetch()) {
				  	$m=$m.$row['TOPSP_MESATL'].chr(13).chr(10);	
			  }
	// mettre le mail
	$d=$a.$m; //format specifique pour que le programme de concatenation des factures puissent etre lance 
	fwrite($fichier,$d);


	$b=substr($b,1);
	$c="requete:EQU(16,".$b.")";

    //ecrire dans le fichier
	fwrite($fichier,$c);

	//fermer le fichier
	fclose($fichier);
      
	rename ($dossier.$fich, $dossier.$fich.".txt");
	copy ($dossier.$fich.".txt","./fact/trt/".$fich.".txt");
 
	// permet a l'utilisateur de retrouve son fichier
	echo "Un mail vous sera envoyé à ".$m."après la constitution du fichier ".$fich;
	
} 

else{
	echo '<script type="text/javascript">window.alert("selectionnez des factures svp ");</script>';
}
?>


	
	