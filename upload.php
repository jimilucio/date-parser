<?
print_r($_FILES['parseFile']);
$file2Upload = $_FILES['parseFile'];

print_r($file2Upload);

if ($file2Upload['size'] == 0){
print "Inserire un file valido";
}
?>