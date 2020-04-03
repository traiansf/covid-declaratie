<?php
require_once(__DIR__.'/paths.php');
$profil = $_POST['profil'];
$model_path = __DIR__ . '/models/MODEL_'.$profil.'.pdf';
$asocieri=[
    'locatie' => 'fill_10',
    'data' => 'fill_1',
    'motiv' => [
        'profesional' => 'Group1',
        'necesitati' => 'Group2',
        'medical' => 'Group3',
        'justificat' => 'Group4',
        'plimbare' => 'Group5',
        'agricol' => 'Group6',
        'sange' => 'Group7',
        'voluntar' => 'Group8',
        'piata' => 'Group9',
        'rechizite' => 'Group10'
   ]
];

$today=date('j.m.Y');

$xfdf="";
$xfdf.="<xml>\n";
$xfdf.="  <xfdf>\n";
$xfdf.="    <fields>\n";
$xfdf.=field($asocieri['data'], $today);
if (isset($_POST['locatie'])) {
    $xfdf.=field($asocieri['locatie'], $_POST['locatie']);
}
if (isset($_POST['motiv']))
  foreach($_POST['motiv'] as $motiv) {
    #echo "$motiv -> ".$asocieri['motiv'][$motiv]; 
    $xfdf.=field($asocieri['motiv'][$motiv], 'Choice1');
  } 
$xfdf.="    </fields>\n";
$xfdf.="  </xfdf>\n";
$xfdf.="</xml>\n";

$xfdf_path = tempnam(__DIR__ . '/tmp', 'covid');
$xfdf_file = fopen($xfdf_path, "w");
fwrite($xfdf_file, $xfdf);
fclose($xfdf_file);
#echo htmlspecialchars($xfdf);
#return 0;

$pdf_path = tempnam(__DIR__ . '/tmp', 'covid');
exec("$pdftk $model_path fill_form $xfdf_path output $pdf_path owner_pw foopass allow printing");
unlink($xfdf_path);

header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename=declaratie-$profil-$today.pdf");
readfile($pdf_path);
unlink($pdf_path);

function field($name, $value) {
    $xfdf="";
    $xfdf.="    <field name='$name'>\n";
    $xfdf.="      <value>$value</value>\n";
    $xfdf.="    </field>\n";
    return $xfdf;
}
?>
