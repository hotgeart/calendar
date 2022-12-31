<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($_POST) {
  $c = new FWieP\PdfMonthCalendar($_POST['code'], "2023");
  $c->getPDF();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <title>Planning 2023</title>
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .columns {
      background-color: #fafafa;
      margin: 50px auto;
      max-width: 500px;
      padding: 10px 20px;
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <div class="columns">
    <div class="column">
      <h1 class="title">Planning 2023</h1>
      <form action="<?php print basename($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="field content ">
          <label class="label">Code</label>
          <div class="control">
            <input class="input" type="text" name="code" id="code" value="BE" placeholder="Agent 26 : BE">
          </div>
          <p class="help">Le code est la colonne de l'Excel.</p>
          <p class="help">Exemples pour l'agent 26, c'est BE :</p>
          <img src="data:image/png;base64,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" alt="">
        </div>
        <button class="button is-link">
          Générer
        </button>
      </form>
    </div>
  </div>
</body>

</html>