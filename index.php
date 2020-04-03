<html lang="ro">
  <head>
    <meta charset="utf-8"/>
  </head>
  <body>
    <form method="POST" action="covid.php">
      <label for="profil">Profil utilizator</label>
<?php echo models(); ?>
      <a href="profil_nou.html">Profil nou</a>
      <br>
      <label for="locatie">Locul/locurile deplasării:</label>
      <input type="text" id="locatie" name="locatie">
      <br>
      <fieldset>
        <legend>Motivul deplasării:</legend>
        <input type="checkbox" id="profesional" name="motiv[]" value="profesional">
        <label for="profesional">
          interes profesional, inclusiv între locuință/gospodărie și
          locul/locurile de desfășurare a activității profesionale și înapoi
        </label>
        <br>
        <input type="checkbox" id="necesitati" name="motiv[]" value="necesitati">
        <label for="necesitati">
          asigurarea de bunuri care acoperă necesitățile de bază ale persoanelor
          și animalelor de companie/domestice
        </label>
        <br>
        <input type="checkbox" id="medical" name="motiv[]" value="medical">
        <label for="medical">
          asistență medicală care nu poate fi amânată și nici realizată de la
          distanță
        </label>
        <br>
        <input type="checkbox" id="justificat" name="motiv[]" value="justificat">
        <label for="justificat">
          motive justificate, precum îngrijirea/ însoțirea unui
          minor/copilului, asistența persoanelor vârstnice, bolnave sau cu
          dizabilități ori deces al unui membru de familie
        </label>
        <br>
        <input type="checkbox" id="plimbare" name="motiv[]" value="plimbare">
        <label for="plimbare">
          activitate fizică individuală (cu excluderea oricăror activități
          sportive de echipă/ colective) sau pentru nevoile animalelor de
          companie/domestice, în apropierea locuinței
        </label>
        <br>
        <input type="checkbox" id="agricol" name="motiv[]" value="agricol">
        <label for="agricol">
          realizarea de activități agricole
        </label>
        <br>
        <input type="checkbox" id="sange" name="motiv[]" value="sange">
        <label for="sange">
          donarea de sânge, la centrele de transfuzie sanguină
        </label>
        <br>
        <input type="checkbox" id="voluntar" name="motiv[]" value="voluntar">
        <label for="voluntar">
          scopuri umanitare sau de voluntariat
        </label>
        <br>
        <input type="checkbox" id="piata" name="motiv[]" value="piata">
        <label for="piata">
          comercializarea de produse agroalimentare (în cazul producătorilor
          agricoli)
        </label>
        <br>
        <input type="checkbox" id="rechizite" name="motiv[]" value="rechizite">
        <label for="rechizite">
          asigurarea de bunuri necesare desfășurării activității profesionale.
        </label>
      </fieldset>
      <br>
      <input type="submit" value="Generează">
    </form>
  </body>
</html>
<?php
function models() {
    $out = "    <select id='profil' name='profil'>\n";
    $models_path = __DIR__ . '/models';
    foreach(glob("$models_path/MODEL_*.pdf") as $model_path) {
        $start = strrpos($model_path, "MODEL_") + 6;
        $length = strlen($model_path) - $start - 4;
        $model = substr($model_path, $start, $length);
        $out .= "      <option value='$model'>$model</option>\n";
    }
    $out .= "    </select>\n";
    return $out;
}
?>    

