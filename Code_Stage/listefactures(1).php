<?php

$VARSOCIETE=$_REQUEST['societe'] ;
$VAREXERCICE=$_REQUEST['exercice'] ;
$VARESO=$_REQUEST['ESO'];
$VARESI=$_REQUEST['ESI'];
$VARNATURE_DEPENSE=$_REQUEST['nature_depense'];
$VARFOURNISSEUR=$_REQUEST['fournisseur'];
$VARBUDGE=$_REQUEST['poste_budge'];

// connexiona la bdd
include './bdd.php';

$wErr = false; //Nous permet de voir a quel niveau les champ sont mal renseigne
$wListErr=''; // pour afficher les erreures .
        
	if(strlen($VARESO)==0 && strlen($VARESI)==0&& strlen($VARBUDGE)==0 && strlen($VARNATURE_DEPENSE)==0 && strlen($VARFOURNISSEUR)==0  )
	{
	  $wErr =true;
	    $wListErr=$wListErr." Renseigner un autre champ SVP ";
		}
// on se connecte à la base de donnée	
	$connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");	
    // si les valeurs sont saisis, ils sont enregistres dans $wCrit 
$wCrit=" ";
if(strlen($VARESI)>0){

	$wCrit=$wCrit." and groupe.paesi_codext = '".$VARESI."' " ;
}
if(strlen($VARESO)>0)
{
	
	$wCrit=$wCrit." and rivp.agence(groupe.paesi_num)= '".$VARESO."' " ;
}

if(strlen($VARFOURNISSEUR)>0)

{
	$wCrit=$wCrit." and tafac.totie_cod= ".$VARFOURNISSEUR;
}


if(strlen($VARBUDGE)>0){
	
	$wCrit=$wCrit."and tafav.mgnad_cod in (select mgnad_cod from mgnad where gbpob_cod ='".$VARBUDGE."')";
}
$nbFactures = 0;  // pour afficher le nombre de factures

// si il n'y a pas d'erreure on lance la requete avec $wCrit 
if ($wErr== false){

	if(strlen($VARNATURE_DEPENSE)>0)
{
$req="select tafac.totie_codscte , tafac.icexe_num, tafac.tafac_num ,paesi.paesi_codext , mgnad_cod,sum(tafav_mntfact) mnt_ht,sum(tafav_mnttvaf) mnt_tva,
                       totie_cod ||'-' ||rivp.tiers(totie_cod) fournisseur
from tafac , tafav,paesi, paesi groupe  
where tafac.tafac_num=tafav.tafac_num and tafac.icexe_num=tafav.icexe_num and tafac.totie_codscte=tafav.totie_codscte and tafac.tasta_cod='C'
and paesi.paesi_rng1=groupe.paesi_rng1 and groupe.panes_cod='GROUP' and tafav.paesi_num=paesi.paesi_num
and tafac.totie_codscte=$VARSOCIETE
and tafac.icexe_num= $VAREXERCICE".$wCrit."
and tafav.mgnad_cod= upper('".$VARNATURE_DEPENSE ."')
group by tafac.totie_codscte , tafac.icexe_num, tafac.tafac_num ,paesi.paesi_codext , totie_cod ||'-' ||rivp.tiers(totie_cod) , mgnad_cod";
}else{
	//ma requête 
	$req="select tafac.totie_codscte , tafac.icexe_num, tafac.tafac_num ,paesi.paesi_codext , sum(tafav_mntfact) mnt_ht ,sum(tafav_mnttvaf) mnt_tva,
                       totie_cod ||'-' ||rivp.tiers(totie_cod) fournisseur
from tafac , tafav,paesi, paesi groupe  
where tafac.tafac_num=tafav.tafac_num and tafac.icexe_num=tafav.icexe_num and tafac.totie_codscte=tafav.totie_codscte and tafac.tasta_cod='C'
and paesi.paesi_rng1=groupe.paesi_rng1 and groupe.panes_cod='GROUP' and tafav.paesi_num=paesi.paesi_num
and tafac.totie_codscte=$VARSOCIETE
and tafac.icexe_num= $VAREXERCICE".$wCrit."
group by tafac.totie_codscte , tafac.icexe_num, tafac.tafac_num ,paesi.paesi_codext , totie_cod ||'-' ||rivp.tiers(totie_cod)";
}
	   // j'execute ma requête
    $statement = $connexion->query($req);
	
	 //je récupère les élements de ma requête
    $statement->setFetchMode(PDO::FETCH_ASSOC); 
	     // si il ya des factures	 
		   
             // j'affiche les champs de mon tableau
        $tabT='<table id="table"  class="table table-striped table-bordered table-sm" style="margin-bottom: 0rem" >

          <tbody>
             <tr style="background-color:lightgrey; height:20px;"> 
                 <th class="th-sm" style="width:10px;" ><input id="cocher" type="checkbox" value="cocher" onClick="cocher_cases(this)" name="cocher" /> </th>
                 <th class="th-sm" style="width:30px;">Société </th>
                 <th class="th-sm" style="width:30px;">Exercice</th>
                 <th class="th-sm" style="width:80px;">Montant de la facture </th>
	             <th class="th-sm" style="width:85px;">Numero de facture </th>';
				
		
		         // on affiche le fournisseur dans le tableau que si il est renseignée
		 if(strlen($VARFOURNISSEUR)==0)
		     {  
		       $tabT .=  '<th class="th-sm" style="width:160px;"  >Fournisseur </th>' ;
	       	 }
		 if(strlen($VARNATURE_DEPENSE)>0) // on affiche la nature de la depense dans le tableau que si elle est renseignée
		    {
		      $tabT .=  '<th class="th-sm" style="width: 105px;" >Montant de la nature depense </th>' ;
	    	 }  
       $tabT .= ' <th class="th-sm" style="width:16px;"> </th>';
         $tabT .= ' </tbody>';

        $tabT .= '</table>';
         $tabT .= '<body>';

        $tab = '<div  style="height:650px;overflow-y:scroll;">';
		   //creation d'un deuxieme tableaux avec les caracteristiques des factures
        $tab .='<table class="table table-striped table-bordered table-sm" >';
        
  	
      while($row = $statement->fetch()) { 
	  $tab .='<tr>';
         $nbFactures=$nbFactures+1;
          //on remplit le tableau
     
         $tab.='<td style="width:10px;"> <INPUT type="checkbox" name="factures" >';
	    $tab.= '<td style="width:55px;" align="right" id="sct" name="sct">'.$row['TOTIE_CODSCTE']. '</td>';
          $tab.='<td style="width:60px;" align="right" id="exe" name="exe" > ' .$row['ICEXE_NUM']. '</td>';
         $tab.='<td style="width:80px;" align="right">' .$row['MNT_HT']. '</td>';
	      $tab.='<td style="width:80px;" align="right"><a id="fact" name="fact" href=" http://srvpwged.rivp-groupe.net/rheaweb2/controler?cmd=list&action=newquery&baseid=2&view=1&query=AND(EQU(0,PIECES COMPTABLES),EQU(15,'.$row['TOTIE_CODSCTE'].'),EQU(16,'.$row['TAFAC_NUM'].'),EQU(17,'.$row['ICEXE_NUM'].'))" target="_blank" >' .$row['TAFAC_NUM']. '</a></td>';
	 	
	   	if(strlen($VARFOURNISSEUR)==0)
		{
			 $tab.='<td align="right"  style="width:140px;"  >'.$row['FOURNISSEUR']. '</td>';
		}
         if(strlen($VARNATURE_DEPENSE)>0)
		 {
			 $tab.='<td align="right"  style="width:80px;" >' .$row['MNT_HT']. '</td>';
		 }
		 $tab.='</div> '; 
	 $tab.= '</tr>';
	}
  
	
	 $tab.='</body>';
 
 
     $tab.='</table>';
	if ($nbFactures==0){
		
		echo '<script type="text/javascript">window.alert("Aucune facture ");</script>';
	
	}else{
		//bouton qui permet de generer le pdf.
     	echo   '<input id=btn_pdf name=btn_pdf id=btn_pdf value="Générer le PDF" class="btn btn-outline-secondary"  onClick="select_caseCocher(this)" type="button" />' ;
	// affichage du nombre de factures 
	$a=($nbFactures==1)? 'facture' : 'factures' ;
    echo "<p style='color:green; padding:40px; display: -moz-inline-box;'>".$nbFactures." " .$a." trouvées</p>" ;
    echo $tabT;
    echo $tab;
	}
 

//affiche les elements manquant pour lancer la requete
}else {
	
		echo '<script type="text/javascript">window.alert("'.$wListErr.'");</script>';
		
}

 ?>
 






