
<?php
/*Réqupération de données du formulaire*/
// Première instance => init des variable à une string vide
/* Ici l'objectif est d'envoyer à mon script.js un seul objet qui est le $array  */
$array = array("firstname " =>"", "name" =>"", "mail" =>"", "phone" =>"", "message" =>"", "firstnameError " =>"", "nameError" =>"", "mailError" =>"", "phoneError" =>"", "messageError" =>"", "isSuccess" =>"false");
//   $firstname = $name = $mail = $phone = $message = "";
  // Validation du formulaire
  // première instance => init des messages d'erreur dans une string vide
//   $firstnameError = $nameError  = $emailError  = $phoneError  = $messageError  = "";
 // $isSuccess = false; // dans la première instance le message n'est pas affiché car formulaire non soumie
  // Envoie du email de remerciemment
  $emailTo = "nnkoulou95@gmail.com";
  // Deuxime instance => init des variables avec les infos entrées par le user
    // vérification si c'est la 2e instance. => Y a t-il eu un "post"?
  if($_SERVER["REQUEST_METHOD"]= "POST"){
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["mail"] = verifyInput($_POST["mail"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput( $_POST["message"]);
    $array["isSuccess"] = true; // dans la 2e instance le message apparaît affiché si pas d'erreur dans un des champs et si le formulaire est soumie
    $emailText = ""; // init la var qui va contenir le mail à envoyer

    // Validation des données du form

    if(empty($array["firstname"])){ // on test le champs firsname: s'il est vide on fait ce qui suit. sinon, on fait le else
      $array["firstnameError"] = "Je veux connaître ton prénom !";
      $array["isSuccess"] = false;
    }
    else{ // si le champs firsname est correctement remplie, on fais ce qui suit: on met son contenu dans le corps du mail à envoyer.
      $emailText .= "Firstname: {$array["firstname"]}\n"; // {$array["firstname"]} => autre façàn de concatener
    }
    if(empty($array["name"])){
      $array["nameError"] = "Et oui je veux tout  savoir même ton nom !";
      $array["isSuccess"] = false; // on vérifie si on peut ou pas afficher le message
    }
    else{ 
      $emailText .= "Name: {$array["name"]}\n";
    }
    
    // Vérification du mail
    if(!isEmail($array["mail"])){ /*renvoie true si c'est un email et false sinon*/
      $array["mailError"] = "Je veux connaître ton adresse mail !";
      $array["isSuccess"] = false;
    }
    else{ 
      $emailText .= "Mail: {$array["mail"]}\n";
    }
    // Vérification du num de téléphone
    if(!isPhone($array["phone"])){ /*renvoie true si le num est valide et false sinon*/
      $array["phoneError"] = "Que des chiffres et des espaces svp";
      $array["isSuccess"] = false;
    }
    else{ 
      $emailText .= "Phone: {$array["phone"]}\n";
    }

    if(empty($array["message"])){
      $array["messageError"] = " Merci d'indiquer le nom de votre entreprise svp !";
      $array["isSuccess"] = false;
    }
    else{ 
      $emailText .= "Message: {$array["message"]}\n";
    }

    if($array["isSuccess"]){
      // On envoi le mail ssi tout les chmps sont correctements rensaignés

      // En tête du mail réponse au mail reçu
      $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["mail"]}>\r\nReply-To: {$array["mail"]}";
      //Envoie du mail
      mail($emailTo, "Un message de votre site", $emailText , $headers);
    }
    /* Je renvoies le travail php de la fonction : success: function(result) */
    echo json_encode($array); // Encode moi en objet json, le array qui contient le travail du php

  }
  // Validation du numéro de téléphone
  function isPhone($var){
        return preg_match("/^[0-9 ]*$/", $var); /*/^[0-9 ]*$" => expression régulière qui permet de vérifier que le num est composé de chiffre de 0 à 9 et qu'on peut les utiliser autant de fois que nécessaire grace à l'étoile */
  }
  // Validation de l'adresse email
  function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
  }
  // sécurité des données
  // la fonction verifyInput() permet de nettoyer les variable
  function verifyInput($var){
    $var = trim($var); //suprime les retour à la ligne et les espaces supplémentaires
    $var = stripslashes($var);//supprime tout les antislash
    $var = htmlspecialchars($var);//
    return $var;
  }
?>