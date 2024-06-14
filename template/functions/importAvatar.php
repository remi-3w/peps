
<?php
session_start();
try{	
    $db= new PDO('sqlite:db.sqlite');
} 
    catch (PDOException $e) 
{
      print "Erreur : " . $e->getMessage();

  die();
}

$user = $_SESSION['user']['pseudo'];
$user_id = (string)$_SESSION['user']['id'];



$fileTmpPath = $_FILES['userfile']['tmp_name'];
$fileName = $_FILES['userfile']['name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
$uploadFileDir = '../../assets/img/userfile/' . $user .'/';
$dest_path = $uploadFileDir . $newFileName;


if (!file_exists($uploadFileDir)) {
    mkdir($uploadFileDir, 0777, true);
}

if(copy($fileTmpPath, $dest_path))
{   
    $_SESSION['flash']['success'] = "Le score est bien enregistré !";
    $sql = 'UPDATE users SET picture = :picture WHERE id = :id';
    var_dump($sql);
    $smt = $db->prepare($sql);
    $smt -> bindValue(':id', $user_id, PDO::PARAM_INT);
    $smt -> bindValue(':picture', $newFileName, PDO::PARAM_STR);
    $smt->execute();
    header('Location: ' . '../profile.php');
}
else
{
echo $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
header('Location: ' . '../profile.php');

}
?>
