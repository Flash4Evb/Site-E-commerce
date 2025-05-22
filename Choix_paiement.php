<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Choix du paiement</title>
  <style>
    .form-carte {
      display: none;
      margin-top: 20px;
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 10px;
      max-width: 400px;
      background: #f9f9f9;
    }
    .form-carte label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .form-carte input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #aaa;
    }
    .valider-btn {
      padding: 10px 20px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h3>Mode de paiement</h3>

  <!-- Formulaire principal -->
  <form id="formPaiement" method="POST" action="paiement.php">
    <label>
      <input type="radio" name="mode" value="Carte Bancaire" onchange="gererAffichageFormulaire()"> Carte Bancaire
    </label><br>

    <label>
      <input type="radio" name="mode" value="Paiement à la livraison" onchange="gererAffichageFormulaire()"> Paiement à la livraison
    </label><br><br>

    <!-- Email de confirmation obligatoire -->
    <label for="email"><strong>Confirmez votre adresse email :</strong></label><br>
    <input type="email" name="email" id="email" placeholder="Votre email" required><br><br>

    <button type="button" onclick="validerPaiement()" class="valider-btn">Valider le paiement</button>

    <!-- Formulaire carte bancaire -->
    <div id="formCarte" class="form-carte">
      <h4>Informations de paiement</h4>

      <label for="numero">
        🧾 Numéro de carte bancaire
      </label>
      <input type="text" id="numero" placeholder="1234 5678 9012 3456">

      <label for="nom">
        👤 Nom du titulaire
      </label>
      <input type="text" id="nom" placeholder="Nom complet">

      <label for="expiration">
        📅 Date d'expiration (MM/YY)
      </label>
      <input type="text" id="expiration" placeholder="MM/YY">

      <!-- Le bouton final envoie le formulaire -->
      <button type="submit" onclick="return confirmerPaiement()" class="valider-btn">Payer maintenant</button>
    </div>
  </form>

  <script>
    function gererAffichageFormulaire() {
      const choix = document.querySelector('input[name="mode"]:checked');
      if (choix && choix.value === "Carte Bancaire") {
        document.getElementById("formCarte").style.display = "block";
      } else {
        document.getElementById("formCarte").style.display = "none";
      }
    }

    function validerPaiement() {
      const choix = document.querySelector('input[name="mode"]:checked');

      if (!choix) {
        alert("Veuillez choisir un mode de paiement.");
        return;
      }

      if (choix.value === "Paiement à la livraison") {
        const confirmation = confirm("Votre commande sera réglée à la livraison. Confirmer ?");
        if (confirmation) {
          document.getElementById("formPaiement").submit();
        }
      } else {
        // Affichage du formulaire carte déjà géré par onchange
        // on attend que l'utilisateur remplisse le formulaire et clique sur "Payer maintenant"
      }
    }

    function confirmerPaiement() {
      // Tu peux aussi valider les champs ici si tu veux, mais ce n’est pas envoyé à la base
      alert("Votre commande a été configurée avec succès.");
      return true; // permet de soumettre le formulaire
    }
  </script>

</body>
</html>
