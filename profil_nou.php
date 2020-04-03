<html lang=ro>
  <head>
    <meta charset="utf-8"/>
  </head>
  <body>
<?php
require_once(__DIR__.'/paths.php');
$profil = $_POST['profil'];
$original_model_path = __DIR__ . '/models/MODEL.pdf';
$model_path = __DIR__ . '/models/MODEL_'.$profil.'.pdf';
$model_url = 'models/MODEL_'.$profil.'.pdf';
$asocieri=[
    'adresa1' => 'fill_8',
    'adresa2' => 'fill_9',
];

$xfdf="";
$xfdf.="<xml>\n";
$xfdf.="  <xfdf>\n";
$xfdf.="    <fields>\n";
$xfdf.=field('nume', $_POST['nume']);
$xfdf.=field('prenume', $_POST['prenume']);
$xfdf.=field('ziua', $_POST['ziua']);
$xfdf.=field('luna', $_POST['luna']);
$xfdf.=field('anul', $_POST['anul']);
$xfdf.=field($asocieri['adresa1'], $_POST['adresa1']);
if (isset($_POST['adresa2'])) {
    $xfdf.=field($asocieri['adresa2'], $_POST['adresa2']);
}
$xfdf.="    </fields>\n";
$xfdf.="  </xfdf>\n";
$xfdf.="</xml>\n";

$xfdf_path = tempnam(__DIR__ . '/tmp', 'covid');
$xfdf_file = fopen($xfdf_path, "w");
fwrite($xfdf_file, $xfdf);
fclose($xfdf_file);
# echo htmlspecialchars($xfdf);
# echo "<br>";
# echo "/usr/bin/pdftk $original_model_path fill_form $xfdf_path output $model_path";
# return 0;

$sig_pdf_path = tempnam(__DIR__ . '/tmp', 'covid');
exec("$pdftk $original_model_path fill_form $xfdf_path output $sig_pdf_path.model.pdf",$out,$result);
unlink($xfdf_path);
if ($result !== 0) {
    echo "Error while executing: '$pdftk $original_model_path fill_form $xfdf_path output $sig_pdf_path.model.pdf'";
    return $result;
}


$sig_orig_path = $_FILES['signature']['name'];
$sig_ext = substr($sig_orig_path, strrpos($sig_orig_path, '.'));
$sig_path = $sig_pdf_path.$sig_ext;
move_uploaded_file($_FILES['signature']['tmp_name'], $sig_path);
$dy=$_POST['dy'];
$dx=$_POST['dx'];

exec("$magick -units PixelsPerInch $sig_path -resample 72 -scale x320 -resize 16% -transparent white -page a4+$dy+$dx -quality 75 $sig_pdf_path.stamp.pdf",$out, $result);
unlink($sig_path);
if ($result !== 0) {
    echo "Error while executing: '$magick -units PixelsPerInch $sig_path -resample 72 -scale x320 -resize 16% -transparent white -page a4+$dy+$dx -quality 75 $sig_pdf_path.stamp.pdf'";
    return $result;
}

exec("$pdftk $sig_pdf_path.model.pdf stamp $sig_pdf_path.stamp.pdf output $model_path",$out, $result);
unlink("$sig_pdf_path.model.pdf");
unlink("$sig_pdf_path.stamp.pdf");
unlink("$sig_pdf_path");
if ($result !== 0) {
    echo "Error while executing: '$pdftk $sig_pdf_path.model.pdf stamp $sig_pdf_path.stamp.pdf output $model_path'";
    return $result;
}

function field($name, $value) {
    $xfdf="";
    $xfdf.="    <field name='$name'>\n";
    $xfdf.="      <value>$value</value>\n";
    $xfdf.="    </field>\n";
    return $xfdf;
}
?>

Profil generat cu succes.
<ul>
<li><a href='<?php echo $model_url; ?>'>Vizualizează șablonul creat</a>
<li><a href='index.php'>Generază declarații</a>
</ul>
</body>
</html>
