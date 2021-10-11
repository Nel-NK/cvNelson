
/*
Objectif du prog:
1/ Prendre les infos du formulaire et les envoyer à un fichier externe de php qui va les traiter et me les renvoyer
2/ Avec les infos renvoyées, je fais une maj des éléments html et css dans la mme page. Mais juste celles du formulaire
*/
// code jquery
$(document).ready(function () {
  // attache un évennement à l'élément html : contact-form lorsqu'on soumet le formulaire
  $("#contact-form").submit(function (e) {
    e.preventDefault(); // Je lui dis de ne pas passer à la page indiquée dans action
    $(".comments").empty(); //Je lui demande de faire un raz de tt les messages d'erreur(les éléments html avec la class .comments) une fois le formulaire soumit
    var postdatat = $("#contact-form").serialize(); // Je récupère tt les élément du formulaire, je les serialise et les mets dans postdatat
    /* AJAX */

    $.ajax({
      type: "POST", //je dis à l'ajax le type d'info il va recoir,
      url: "php/contact.php", //je dis à l'ajax vers quel url va t-il les envoyer
      data: postdatat, // je lui dis la data à envoyé. Ici c'est la data contenue dans la var postdatat
      dataType: "json", // je lui dit le type de data
      // je lui dis d'exécuter cette fonction si tout se passe bien
      success: function (result) {
        // je vérifie si le champs isSuccess est true (pas de message d'erreur)
        if (result.isSuccess) {
          // On rajoute dans le formulaire le message de remerciemment
          $("#contact-form").append(
            "<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté.</p>"
          );
          // Je remets tous les champs à 0
          $("#contact-form")[0].reset();
        }
        // affichage du message d'erreur
        else {
          // Je lui demande de mettre du html dans l'élément de class comments qui vient juste après celui qui a l'id firstname, name...
          $("#firstname + .comments").html(result.firstnameError);
          $("#name + .comments").html(result.nameError);
          $("#phone + .comments").html(result.phoneError);
          $("#mail + .comments").html(result.mailError);
          $("#message + .comments").html(result.messageError);
        }
      },
    });
  });
});
