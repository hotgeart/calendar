<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($_POST) {
  $c = new FWieP\PdfMonthCalendar($_POST['code'], "2023");
  $c->getPDF();
}

?>
<!DOCTYPE html>
<html lang="fr">
<!-- Ne regarde pas le code, il est dégeulasse -->

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <title>🏛️ BXL 🇧🇪</title>
  <style>
    html {
      background: rgb(243, 244, 246);
    }

    body {
      margin: 0;
      padding: 0 0 50px 0;
    }

    .columns {
      background-color: #fff;
      margin: 50px auto;
      max-width: 520px;
      padding: 10px 20px;
      border-radius: 10px;
      --shadow-color: 220deg 5% 67%;
      --shadow-elevation-low:
        0.6px 0.7px 1px hsl(var(--shadow-color) / 0.27),
        1px 1.1px 1.7px -1.2px hsl(var(--shadow-color) / 0.27),
        2.2px 2.4px 3.7px -2.5px hsl(var(--shadow-color) / 0.27);
      --shadow-elevation-medium:
        0.6px 0.7px 1px hsl(var(--shadow-color) / 0.23),
        1.5px 1.7px 2.6px -0.6px hsl(var(--shadow-color) / 0.23),
        2.9px 3.2px 4.9px -1.2px hsl(var(--shadow-color) / 0.23),
        5.7px 6.3px 9.6px -1.9px hsl(var(--shadow-color) / 0.23),
        11px 12.2px 18.5px -2.5px hsl(var(--shadow-color) / 0.23);
      box-shadow: var(--shadow-elevation-medium);
    }
  </style>
</head>

<body>
  <div class="columns">
    <div class="column">
      <h1 class="title">📅 Planning 2023</h1>
      <div class="content">
        <p>Créer un calendrier personnel PDF en analysant l'Excel du service.</p>
        <form action="<?php print basename($_SERVER['PHP_SELF']) ?>" method="post">
          <div class="field content">
            <label for="code" class="label">Agent :</label>
            <div class="select" style="display: block;">
              <select name="code" id="code" style="width:100%;">
                <option value="C">Agent 1</option>
                <option value="E">Agent 2</option>
                <option value="G">Agent 3</option>
                <option value="I">Agent 4</option>
                <option value="K">Agent 5</option>
                <option value="M">Agent 6</option>
                <option value="O">Agent 7</option>
                <option value="Q">Agent 8</option>
                <option value="S">Agent 9</option>
                <option value="U">Agent 10</option>
                <option value="Y">Agent 11</option>
                <option value="AA">Agent 12</option>
                <option value="AC">Agent 13</option>
                <option value="AE">Agent 14</option>
                <option value="AG">Agent 15</option>
                <option value="AI">Agent 16</option>
                <option value="AK">Agent 17</option>
                <option value="AM">Agent 18</option>
                <option value="AO">Agent 19</option>
                <option value="AQ">Agent 20</option>
                <option value="AU">Agent 21</option>
                <option value="AW">Agent 22</option>
                <option value="AY">Agent 23</option>
                <option value="BA">Agent 24</option>
                <option value="BC">Agent 25</option>
                <option value="BE" selected>Agent 26</option>
                <option value="BG">Agent 27</option>
                <option value="BI">Agent 28</option>
                <option value="BK">Agent 29</option>
                <option value="BM">Agent 30</option>
                <option value="BQ">Agent 31</option>
                <option value="BS">Agent 32</option>
                <option value="BU">Agent 33</option>
                <option value="BW">Agent 34</option>
                <option value="BY">Agent 35</option>
                <option value="CA">Agent 36</option>
                <option value="CC">Agent 37</option>
                <option value="CE">Agent 38</option>
                <option value="CG">Agent 39</option>
                <option value="CI">Agent 40</option>
                <option value="CM">Agent 41</option>
                <option value="CO">Agent 42</option>
                <option value="CQ">Agent 43</option>
                <option value="CS">Agent 44</option>
                <option value="CU">Agent 45</option>
                <option value="CW">Agent 46</option>
                <option value="CY">Agent 47</option>
                <option value="DA">Agent 48</option>
                <option value="DC">Agent 49</option>
                <option value="DE">Agent 50</option>
              </select>
            </div>
            <p class="help my-2">Sélectionnez votre numéro d'agent.</p>
          </div>
          <button class="button is-link">
            Générer
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="columns">
    <div class="column">
      <h1 class="title">🧮 Calcule sanctions par heure</h1>
      <div class="content">
        <form action="" method="post">
          <div class="field content">
            <label for="total-sanctions" class="label">Nombre de sanction :</label>
            <input class="input" type="number" id="total-sanctions" name="total-sanctions" required value="2000">
          </div>
          <p class="help my-2 pb-3">Le nombre total de sanctions que vous avez fait pour le mois.</p>

          <div class="field content">
            <label for="per-sanction" class="label">Pourcentage de sanction <em style="opacity:.5;">(facultatif)</em> :</label>
            <input class="input" type="number" id="per-sanction" name="per-sanction" required value="50">
          </div>
          <p class="help my-2 pb-3">Estimez votre pourcentage de sanction, par exemple 50%</p>

          <div class="field content">
            <label for="total-working-days" class="label">Nombre de jours travaillé :</label>
            <input class="input" type="number" id="total-working-days" name="total-working-days" required value="15">
          </div>
          <p class="help my-2 pb-3">Une journée égale = 9h, donc <strong>X</strong> × 9h</p>

          <div class="field content">
            <label for="total-scancar" class="label">Combien de fois avez-vous roulé avec la scan car ?</label>
            <input class="input" type="number" id="total-scancar" name="total-scancar" required value="13">
          </div>
          <p class="help my-2 pb-3">Une prise de scan car va retirer 4h30, donc - <strong>X</strong> × 4h30</p>
        </form>
        <div id="result"></div>
        <script>
          // Function to calculate sanctions per hour
          function calculateSanctionPerHour() {
            const totalSanctions = document.getElementById("total-sanctions").value;
            const totalWorkingDays = document.getElementById("total-working-days").value;
            const totalScancar = document.getElementById("total-scancar").value;
            const perSanction = document.getElementById("per-sanction").value;

            const hoursPerWorkingDay = 9;
            const hoursPerScancarDay = 4.5;

            const totalWorkingHours = totalWorkingDays * hoursPerWorkingDay;
            const totalWorkingHoursScancar = totalScancar * hoursPerScancarDay;
            const totalWorkingOnDesk = totalWorkingHours - totalWorkingHoursScancar;
            const sanctionPerHour = totalSanctions / totalWorkingOnDesk;
            const casePerhour = sanctionPerHour / (perSanction / 100);

            // Displaying the result on the page
            const resultElement = document.getElementById("result");

            resultElement.innerHTML = `
            <h2>Résultat :</h2>
            <h3 class="is-size-5">Jour de travail en heures</h3>
            <pre>${totalWorkingDays} jours × ${hoursPerWorkingDay} heures = <strong>${totalWorkingHours} heures</strong></pre>

            <h3 class="is-size-5">Scan car en heures</h3>
            <pre>${totalScancar} × 4h30 = <strong>${totalWorkingHoursScancar} heures</strong></pre>

            <h3 class="is-size-5">Desk en heures</h3>
            <pre>${totalWorkingHours}h - ${totalWorkingHoursScancar}h = <strong>${totalWorkingOnDesk} heures</strong></pre>

            <h3 class="is-size-5"><strong class="has-text-danger"> ${sanctionPerHour.toFixed(2)} </strong> sanctions par heure</h3>
            <pre>${totalSanctions} ÷ ${totalWorkingOnDesk}h = <strong>${sanctionPerHour.toFixed(2)}</strong></pre>

            <h3 class="is-size-5"><strong class="has-text-info"> ${casePerhour.toFixed(2)} </strong> cas par heure</h3>
            <pre>${sanctionPerHour.toFixed(2)} ÷ (${perSanction} / 100) = <strong>${casePerhour.toFixed(2)}</strong></pre>
            `;
          }

          // Add event listeners to update the result in real time
          const formInputs = document.querySelectorAll("input");
          formInputs.forEach(input => input.addEventListener("input", calculateSanctionPerHour));
          calculateSanctionPerHour();
        </script>
      </div>

      <?php if (isset($_GET['secret'])) { ?>
        <div class="columns">
          <div class="column">
            <h1 class="title">🗺️ Map Tracker</h1>
            <div class="content">
              <p>Cette app <strong>Android</strong> permet de voir les limites de Bruxelles (1000) et de tracker avec la 4G les déplacements et de "colorier" les routes où nous sommes passées.</p>
              <a href="map.jpg"><img src="map.jpg" class="my-2" style="display: block; margin: auto; max-height:300px;" /></a>
              <a href="https://drive.google.com/file/d/1Lv-k4EnAEsofuiASH_0KFNQOSVkN6EQA/view?usp=sharing" class="mt-2 button is-link">Télécharger l'APK (32Mo)</a>
              <p class="mt-3">Anciennes versions :</p>
              <ul>
                <li>
                  <a href="https://drive.google.com/file/d/1P6JTpEmQ2YrwioX8wgsyw3ltZQ8u4uj_/view?usp=share_link">
                    v2.1 (32Mo)
                  </a>
                </li>
                <li>
                  <a href="https://drive.google.com/file/d/11ITrXo4n8s21LMIR5i49VwHJgtEXphLP/view?usp=share_link">
                    v2.0 (32Mo)
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="columns">
          <div class="column">
            <h1 class="title">🧩 Extension "Quick Reject"</h1>
            <div class="content">
              <p>Cette extension ajoute un bouton pour rejeter rapidement avec la raison : <em>"Situation pas claire"</em>. Ainsi qu'un compteur de situations traitées.</p>
              <p>Ne fonctionne que si votre CityControl est en Français.</p>
              <a href="screenshot.png"><img src="screenshot.png" class="my-2" style="display: block; margin: auto; max-height:300px;" /></a>
              <a href="https://chrome.google.com/webstore/detail/quick-reject/nenocmjmmkkgmieegnpmllihfmjgiobi" class="mt-2 button is-link">Télécharger l'extension</a>
            </div>
          </div>
        </div>
      <?php } ?>
</body>

</html>