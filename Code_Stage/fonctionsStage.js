$(document).ready(function() {
           //creation des evenements quand on clique sur le bouton
        $("#btn_valider").click(function() {chercher_factures();});

              // afficher le nom du fournisseur en meme temps que l'utilisateur saisie le code
        $("#fournisseur").keyup(function(){affiche_libelleF();});
              //mettre  l'ESI en fonction de l'eso
        $("#ESO").change(function(){actu_esi();});
            //actualiser l'esi et l'exercice en fonction de la societe
        $("#societe").change(function(){actu_exe();actu_esi();});
          //afficher liste deroulant de nature depense lorsque le poste budgetaire est indiqué
        $("#poste_budge").change(function(){nature_depense();});
        actu_exe();
        actu_esi();
        nature_depense();
            //on cache le gif pour l'attente
        $("#attente").hide();
        //permettre que lorsqu'on tape sur "entrer" la recherche des factures se lance
        $('.autoentrer').keyup(function(event){chercher_enter(event.which);});
}
);

//fonction pour chercher les factures
function chercher_factures()
{  
       //on affiche le gif
    $("#attente").show();
    
     $.ajax(
     {
        type: 'POST',
        url: 'listefactures.php',            
        data: "societe="+$('#societe').val()+"&exercice="+$('#exercice').val()+"&ESO="+$('#ESO').val()+"&ESI="+$('#ESI').val()+"&nature_depense="+$('#nature_depense').val()+"&fournisseur="+$('#fournisseur').val()+"&poste_budge="+$('#poste_budge').val(),        
        dataType:'text',
        success: creertableau ,
        error: function() {alert('Erreur serveur');}
    });
    

};
    // on creer le tableau avec l'ensemble des factures
function creertableau(reponse)
{
  $("#tab").empty();
  $("#tab").append(reponse);
    //on cache le gif
  $("#attente").hide();
}


// fonction qui permet de cocher toutes les cases en cochant la case "principale"
function cocher_cases(cocher) {
  checkboxes = document.getElementsByName('factures');
 
      for(var i=0, n=checkboxes.length;i<n;i++)
          {
          checkboxes[i].checked = cocher.checked;    
          }
}

//evenements pour creer le fichier
//selectionner les factures des cases qui ont ete selectionnées
function select_caseCocher() {
  checkboxes = document.getElementsByName('factures');
  facts = document.getElementsByName('fact');
  scts = document.getElementsByName('sct');
  exes = document.getElementsByName('exe');
  j=0;
  lstFactures='';

      for(var i=0, n=checkboxes.length;i<n;i++) { //on parcoure toutes les cases
                           if (checkboxes[i].checked ){    //si la case est coche
                         lstFactures=lstFactures+';';
                         lstFactures=lstFactures+scts.item(i).innerText+'-'+facts.item(i).innerText+'-'+exes.item(i).innerText;
                            
                      j++;
                    
                 }
                
         }    
lstFactures=lstFactures.substring(1);  // on commence a partir de un pour ne pas avoir le ; au debut

$.ajax(
{
            type: 'POST',
            url: 'creer_fichier.php',
            data: "facts="+lstFactures,
            dataType:'text',
            success: ok_fichier,
            error:function() {alert('Erreur serveur');}
});

}

function ok_fichier(reponse){
         $("#fich").empty();
         $("#fich").append(reponse); //retourne ou se trouve le fichier de l'utilisateur
}


function affiche_libelleF() {
 
    $.ajax(
  {
      
            type: 'POST',
            url: 'fournisseur.php',
            data: "fournisseur="+$('#fournisseur').val(), //on envoi ce qui a te saisi dans le champ fournisseur
            dataType:'text',
            success: ok_libelle,
            error:function() {alert('Erreur serveur');}
      
  });  
}
//afficher le libelle du fournisseur
function ok_libelle(reponse){
    $("#fourn").empty();
    $("#fourn").append(reponse);
}

//actualise la liste deroulante des exercices en fonction de la societe selectionne
function actu_exe(){
    a=$("#societe").val(); // recuperation de la societe
    $.ajax(
  {
            type: 'POST',
            url: 'exercice.php',
            data:"societe="+a,
            dataType:'text',
            success: ok_exe,
            error:function() {alert('Erreur serveur');}
      
  });  
}
function ok_exe(reponse){
$("#exercice").empty();
$("#exercice").append(reponse);
}    
// actualisela liste deroulante des ESI en fonction de la societe selectionne
function actu_esi(){
    a=$("#societe").val();
    b=$("#ESO").val();
    
    
      $.ajax(
      {
            type: 'POST',
            url: 'esi.php',
            data:"societe="+a+"&ESO="+$('#ESO').val(),
            dataType:'text',
            success: ok_esi,
            error:function() {alert('Erreur serveur');}
          
      });  
    
}
function ok_esi(reponse){
$("#ESI").empty();
$("#ESI").append(reponse);
}    

 
function chercher_enter(e)
{        
        if (e==13){
            chercher_factures();
    
        };
}
    
    
function nature_depense(){

    $.ajax(
      {
            type: 'POST',
            url: 'nature_depense.php',
            data:"poste_budge="+$('#poste_budge').val(),
            dataType:'text',
            success: ok_nature_depense,
            error:function() {alert('Erreur serveur');}
          
      });  
}

    function ok_nature_depense(reponse){
            
        $("#mod_nature_depense").empty();
        $("#mod_nature_depense").append(reponse);
        
    }

