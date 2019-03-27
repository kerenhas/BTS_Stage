<?php
   include './bdd.php'; //connexion a la bdd
   session_start();
   if(!isset($_SESSION['ntlm_utilisateur']) && isset($_SERVER['AUTH_USER']))
    {
		$ntlm = substr($_SERVER['AUTH_USER'], strpos($_SERVER['AUTH_USER'], '\\')+1);

	}

    $utilisateur = $ntlm;
   $utilisateur = 'RELARGEM';
   // $utilisateur = 'PHBOITEU'; 
   $_SESSION['nom_uti']=$utilisateur;

             // on se connecte à la base de donnée	pour toute la page
    $connexion = new PDO($dbrecetteRF2PDO,"ERIVP","ERIVP");
          //requete pour recuperer le nom de l'utilisateur
    $req="Select rivp.tiers(totie_cod)  nom_uti from mguti where mguti_cod='".$utilisateur."'";
         //traitement de la requete
    $statement = $connexion->query($req);
    $statement->setFetchMode(PDO::FETCH_ASSOC);
     While($row = $statement->fetch()) 
			  {
				  $nom_uti= $row['NOM_UTI'];
			  }
			  
	$nbFactures = " ";
?>

<!DOCTYPE html PUBLIC "" "">
<html lang="en">

<HEAD>
		<META content="IE=11.0000" 
		http-equiv="X-UA-Compatible">
			 
		<META charset="utf-8">     
		<META name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
			
		<META name="description" content="">     
		<META name="author" content="">     <LINK href="../../../../favicon.ico" rel="icon"> 
			<TITLE>RIVP - factures</TITLE>     <!-- Bootstrap core CSS --> 
			<LINK href="CSS/bootstrap.min.css" rel="stylesheet">     <!-- Custom styles for this template --> 
			<LINK href="./factures.css" rel="stylesheet"> 			
		<META name="GENERATOR" content="MSHTML 11.00.9600.17842">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		
</HEAD>  

<body>
<HEADER><!-- Fixed navbar -->       
    

	  
	  
	  <nav class="navbar navbar-expand-lg" style="background-color:#0c688a;">
    <a class="navbar-brand" href="#">
	<img src="https://macollecte.curie.fr/cdn.iraiser.eu/akUGyCEuK4i9kWQh//Dz1A==/project-gssA_Vnj/thumbnail/rivpPrsentation1.jpg"  height="50px" />
</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">

      </ul>
      <form class="form-inline">
	      <span class="navbar-text" style="color: white;">
      RIVP - <?php echo $nom_uti; ?>
    </span>
      </form>
    </div>
  </nav>
</HEADER><!-- Begin page content -->     
		
	<main class="container">
<div id="chargement">

</div>


<div class="row">
  <div class="col-md-5">
  
  <H1   class="mt-5 text-danger" >RIVP factures </H1>
       <form id='formulaire'>
	   <div class="form-group">
	         <!-- liste deroulante des societes -->
        <label for="societe"></label><br />
		<p>Société : <select name="societe" id="societe" class="form-control autoentrer" >
		<?php
		        // ma requete
	       $req="select totie_cod societe, mguoa_def, rivp.tiers(totie_cod) lib  from mguoa where mguti_cod='".$utilisateur."' ";
			     //j'execute ma requete
              $statement = $connexion->query($req);
                //je récupère les élements de ma requête
              $statement->setFetchMode(PDO::FETCH_ASSOC);
		      While($row = $statement->fetch()) 
			  {
                     //on met la valeur selectionne par defaut dans la variable $socactu
				if ($row['MGUOA_DEF']==1){
					$socactu= $row['SOCIETE'];								
			  };	
		  
		?>
		<!--quand mguoa_def est =1 c'estqu'il doit etre selectionne par defaut -->
	   <!-- affichage de la liste deroulante -->
       <OPTION value ="<?= $row['SOCIETE']; ?>" <?= $row['MGUOA_DEF']==1? 'selected' : '' ;?>  ><?= $row['SOCIETE'].'-'.$row['LIB'];?></OPTION>
			
		<?php
			 };		   
		   echo' </select>';
		
		   //liste deroulante des exercices en fonction de la societe selectionne 
			$date=date("Y"); 
		 	 echo 'Exercice : <select name="exercice" id="exercice" class="form-control autoentrer">';
			 echo '<option value='.$date.'>'.$date.'</option>';
		    echo'</select>';  
		    echo"</div>";
			  
			  //saisie de l'ESO
		echo'ESO : <select name="ESO" id="ESO" class="form-control autoentrer" > ';
		// ma requete
		$req="select toeso_cod, toeso_lib from toeso
          where toneo_cod='AGEN'
          and toeso_eta='A'";

		//j'execute ma requete
        $statement = $connexion->query($req);
         //je récupère les élements de ma requête
		 $statement->setFetchMode(PDO::FETCH_ASSOC);
		 echo"<OPTION  name='ESO' id='ESO'> </option>";
		 While($row = $statement->fetch()) 
			  {
				
				echo"<OPTION  value='".$row['TOESO_COD']."' name='ESO' id='ESO'>".$row['TOESO_COD']."-".$row['TOESO_LIB']."</option>";
				
			  }
         echo '</select>';  
		 echo" <div class='form-group'>";
				// liste deroulante des ESI 					
  		 echo 'ESI :<select type="text" class="form-control autoentrer" name="ESI " id="ESI"/>';
        echo '</select>';
		?>
		</div>
    	<div class="form-group">	
		
		</div>
	<label for="exampleFormControlInput1">Poste Budgétaire: </label>
         <?php       
			     //liste deroulante pour le post budgetaire 
             echo'  <select name="poste_budge" id="poste_budge" class="form-control autoentrer" > ';
		         // ma requete
			$req="select distinct gbpob.gbpob_cod code, gbpob.gbpob_lib lib, gbpob_indetat  etat from tafav, gbbud, gbpob
                 where gbbud.gbbud_num=tafav.gbbud_num and gbpob.gbpob_cod=gbbud.gbpob_cod 
                 and tafav.icexe_num=2017 and totie_codscte=58  order by 1";
           		   //j'execute ma requete
            $statement = $connexion->query($req);
                 //je récupère les élements de ma requête
            $statement->setFetchMode(PDO::FETCH_ASSOC); 
			 echo"<OPTION id='poste_budge'> </option>";
		    while($row = $statement->fetch())  
			{
		       echo'<OPTION value ='.$row["CODE"].'>'.$row['CODE'].'-'.$row['LIB'].'</option>';

		    }
		
		     echo'</select>';

	    ?>		
    	  <div class="form-group">

		  <!-- saisie de la nature de depense -->
		<label for="exampleFormControlInput1">Nature de dépense:</label>
		<p id="mod_nature_depense" class="autoentrer" ></p>
		<!-- <input id="nature_depense" type="text" class="form-control autoentrer" name="nature_depense" />  -->
		
		</div>
	
        <div class="form-group row">
  
        <div class="col-sm-6">
	       <label for="exampleFormControlInput1">Fournisseur: </label>
		  
		       <!--saisie du fournisseur -->
             <input type="text" class="form-control autoentrer" name="fournisseur" id="fournisseur" />
          </div>
	      <div class="col-sm-6">
	               <!-- affichage du libelle du fournisseur ou "fournisseur inconnu"-->
	         <label for="exampleFormControlInput1" style="color:white;">.</label>
	         <label for="staticEmail" class="form-control" style="border:0px;" id='fourn'></label> 
	      </div>
        </div>
			       
<div class="row">
             <!-- bouton pour valider les elements saisies -->		
	    <input name="btn_valider" id="btn_valider" class="btn btn-success autoentrer" type="button" value="Rechercher" />	</br>
				
				 
</div>
	</form>
	</div>
	
 <div class="col-md-7">
 </br>
  <!-- retourne ou se trouve le fichier de l'utilisateur -->
	<p id='fich'></p>
	 <!-- affichage du tableau -->
	<p><span id='tab' ></span></p>
	 <!-- pour signalet quand la page charge -->
        <img id="attente" name="attente"  class="hide" src="./images/attente.gif" >
		
	
	</div>
  
</main>
<script src="./js/factures.js" type="text/javascript"></script>
<FOOTER class="footer">
    <DIV class="container"><SPAN class="text-muted"></SPAN>       </DIV>
</FOOTER>

    </body>
</html>