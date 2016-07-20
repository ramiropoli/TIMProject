<?php
function getLink($cat, $id){
    $page='';
    switch($cat){
        case 'smartphone': $page='smartphone-description.html'; break;
        case 'modem': $page='modem-description.html'; break;
        case 'tablet': $page='tablet-description.html'; break;
        case 'tv': $page='tv-description.html'; break;
        case 'TV': $page='timvisiondescription.html'; break;
        case 'TIMReading': $page='quotidianidescription.html'; break;
        case 'TIMGames': $page='ilovegamesdescription.html'; break;
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
$sql = $db->prepare('SELECT id,name,image,category FROM smartphone_telephones WHERE id<3 UNION SELECT id,name,image,category FROM tablet_computer WHERE id<3
UNION SELECT id,name,image,category FROM tv_smart_living WHERE id<3 UNION SELECT id,name,image,category FROM modem_networking
 UNION SELECT id,name,image,category FROM timreading WHERE id<2 UNION SELECT id,name,image,category FROM timgames WHERE id<2  UNION SELECT id,name,image,category FROM tv WHERE id<2');

$id = intval($_POST['id']);
$category = $_POST['category'];
// esecuzione della query 
$sql->execute(); 
// creazione di un array dei risultati 
$res = $sql->fetchAll(PDO::FETCH_OBJ);
$size=count($res);
for($i=0;$i<$size;$i++){
    $res[$i]->link = getLink($res[$i]->category, $res[$i]->id);
}
echo json_encode($res);
