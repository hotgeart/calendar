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
    html {
      background: rgb(243, 244, 246);
    }

    body {
      margin: 0;
      padding: 0;
    }

    .columns {
      background-color: #fff;
      margin: 50px auto;
      max-width: 500px;
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
      <h1 class="title">Planning 2023</h1>
      <form action="<?php print basename($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="field content ">
          <label class="label">Agent :</label>
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
</body>

</html>