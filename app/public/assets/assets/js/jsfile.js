function modifparam(param, objet){
  //permet d'aller à une autre @ en ajoutant un parametre dans l'@url
  var url = window.location.href;
  var valeur = document.getElementById(objet).value;
  window.location.href = URL_add_parameter(url, param, valeur);
}
function supprparam(param){
 //permet de supprimer un parametre dans l'@url
 var url = window.location.href;
 window.location.href = removeURLParameter(url, param);
}
function modifdeuxparam(paramun, objet, paramdeux){
  //permet de supprimer paramdeux et mattre param1 à jour dans l'@url
  var url = window.location.href;
  url=removeURLParameter(url, paramdeux);
  var valeur = document.getElementById(objet).value;
  window.location.href = URL_add_parameter(url, paramun, valeur);
}
function URL_add_parameter(url, param, value){
  // Ajoute le parametre 'param' avec la valeur 'value' dans l'url de la page
  var hash       = {};
  var parser     = document.createElement('a');

  parser.href    = url;

  var parameters = parser.search.split(/\?|&/);

  for(var i=0; i < parameters.length; i++) 
  {
    if(!parameters[i]) continue;
    var ary      = parameters[i].split('=');
    hash[ary[0]] = ary[1];
  }

  hash[param] = value;

  var list = [];  
  Object.keys(hash).forEach(function (key) 
  {
    list.push(key + '=' + hash[key]);
  });

  parser.search = '?' + list.join('&');
  return parser.href;
}
function removeURLParameter(url, parameter) {
  //prefer to use l.search if you have a location/link object
  var urlparts = url.split('?');   
  if (urlparts.length >= 2) {

      var prefix = encodeURIComponent(parameter) + '=';
      var pars = urlparts[1].split(/[&;]/g);

      //reverse iteration as may be destructive
      for (var i = pars.length; i-- > 0;) {    
          //idiom for string.startsWith
          if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
              pars.splice(i, 1);
          }
      }
      return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
  }
  return url;
}
function updateFilename(path) {
  //sert pour ajout photo
  var name = extractFilename(path);
  document.getElementById('filename').textContent = name;
}
function affichage(id){
// Afficher un element en fonction de son id
  var x = document.getElementById(id);
  x.style.display = "";
}
function annuler(id){
  // Annule la demande et de fait disparaitre le formulaire
    var x = document.getElementById(id);
    x.style.display = "none";
}    
/*function Impression(id){
//Redirection vers une page afin d'imprimer une fiche synthese, un contrat de compagnonnage ou un livret de transformation
  a = document.getElementById("switch");
  
  optionImpression = a.innerText;
  if (optionImpression == 'Fiche de synthèse'){
    window.location = 'http://Localhost/transfremm/public/index.php/impressionLivret?marin='+id;
  }
  else if (optionImpression == 'Contrat de compagnonnage'){
    window.location = 'http://Localhost/transfremm/public/index.php/ficheSynthese?marin='+id;
  }
  else{
    window.location = 'http://Localhost/transfremm/public/index.php/contrat?compagnonnage='+id;
  }
}*/
function modificationOuiNon(x){
// Fait apparaitre une liste de choix (oui/non)
  x.innerHTML = "<select class='custom-select' name='"+x.id+"'> <option value='1' >Oui</option> <option value='0' >Non</option></select>"
  x.onclick=null;
}
function remarqueDouble(x,obj_id){
// Permet de rendre modifiable la case remarque 
  var memoire = x.innerText;
  var txt = '<textarea class="form-control" name="'+obj_id+'" style="width:100%; height: 100%; background-color: inherit;" form="formulaireContratCompagnonnageDouble'+obj_id+'">'+memoire+'</textarea><input class="btn btn-outline-primary" value="Enregistrer" type="submit" form="formulaireContratCompagnonnageDouble'+obj_id+'"/>';
  x.innerHTML = txt;
  x.onclick=null;
}
function remarqueLache(x,obj_id){
// Permet de rendre modifiable la case remarque 
  var memoire = x.innerText;
    var txt = '<textarea class="form-control" name="'+obj_id+'" style="width:100%; height: 100%; background-color: inherit;" form="formulaireContratCompagnonnageLache'+obj_id+'">'+memoire+'</textarea><input class="btn btn-outline-primary" value="Enregistrer" type="submit" form="formulaireContratCompagnonnageLache'+obj_id+'"/>';
    x.innerHTML = txt;
    x.onclick=null;
}
function validationDoubleLacher(parametre,numero){
// Permet de valider un double
  if(confirm("Souhaitez-vous lâcher ce marin ?")){
    var element = document.getElementById("inputValidation");
    var elementValue = element.value;
    if (parametre == 1){ //double
      element.value = elementValue+numero+'doubl'+'='+numero+'&';
      var td = document.getElementById("double="+numero);
      td.innerHTML = '✓'
    }
    else if (parametre == 0){ //lacher
      element.value = elementValue+numero+'lache'+'='+numero+'&';
      var td = document.getElementById("lacher="+numero);
      td.innerHTML = '✓'
    }
  }
}
/*function validationObjectifTache(multiple,parametre,numero){
//Valider les taches/objectifs.
  
  // Tache
  if (parametre == 1){
    if(multiple == 1){
      var element = document.getElementById("inputValidationMultiple");
    }
    else{
      var element = document.getElementById("inputValidation");
    }
    var elementValue = element.value;
    element.value = elementValue+numero+'tache'+'='+numero+'&';
    var th = document.getElementById("nomTache="+numero);
    thValue = th.innerText;
    th.innerHTML = thValue;
  }
  // Objectif
  else if(parametre == 0){
    if(multiple == 1){
      var element = document.getElementById("inputValidationMultiple");
    }
    else{
      var element = document.getElementById("inputValidation");
    }    
    var elementValue = element.value;
    element.value = elementValue+numero+'objec'+'='+numero+'&';

    var td = document.getElementById("tdObjectif"+numero);
    td.innerHTML = '✓'
  }
  else if(parametre == 2){
    var element = document.getElementById("inputValidation");
    var elementValue = element.value;
    element.value = elementValue+numero+'stage'+'='+numero+'&';

    var td = document.getElementById("tdStage"+numero);
    td.innerHTML = '✓'
  }
}*/
function validationParticulier(objectif_id){
// Permet de valider un lacher
  if(confirm("Souhaitez-vous lâcher ce marin ?")){
    validationObjectifTache(0,0,objectif_id)
  }
}