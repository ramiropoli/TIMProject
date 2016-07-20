<?php
function getLink($cat, $id){
    $page='';
    switch($cat){
        case 'smartphone': $page='smartphone-description.html'; break;
        case 'tablet': $page='tablet-description.html'; break;
        case 'tv': $page='tv-description.html'; break;
        case 'modem': $page='modem-description.html'; break;
    }
    return $page.'?id='.$id;
}


$col = 'mysql:host=localhost;dbname=my_timprj';
$username='timprj';
$password='';
// blocco try per il lancio dell'istruzione
try {
  // connessione tramite creazione di un oggetto PDO
  $db = new PDO($col , $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
// blocco catch per la gestione delle eccezioni
catch(PDOException $e) {
  // notifica in caso di errorre
  echo 'Attenzione: '.$e->getMessage();
}


# utilizzo del metodo prepare()

// preparazione della query 
$sql = $db->prepare(<<<EOS
SELECT name,id,image,category FROM smartphone_telephones
	WHERE (id,category) IN (SELECT DeviceId,DeviceType FROM available_assistance WHERE AssistanceId=? AND AssistanceCategory=?) UNION
SELECT name,id,image,category FROM tablet_computer
	WHERE (id,category) IN (SELECT DeviceId,DeviceType FROM available_assistance WHERE AssistanceId=? AND AssistanceCategory=?) UNION
SELECT name,id,image,category FROM tv_smart_living
	WHERE (id,category) IN (SELECT DeviceId,DeviceType FROM available_assistance WHERE AssistanceId=? AND AssistanceCategory=?) UNION
SELECT name,id,image,category FROM modem_networking
	WHERE (id,category) IN (SELECT DeviceId,DeviceType FROM available_assistance WHERE AssistanceId=? AND AssistanceCategory=?) 
EOS
                   );
$id = intval($_POST['id']);
$category = $_POST['category'];
// esecuzione della query 
$sql->execute(array($id,$category,$id,$category,$id,$category,$id,$category)); 
// creazione di un array dei risultati 
$res = $sql->fetchAll(PDO::FETCH_OBJ);
$size=count($res);
for($i=0;$i<$size;$i++){
    $res[$i]->link = getLink($res[$i]->category, $res[$i]->id);
}
echo json_encode($res);