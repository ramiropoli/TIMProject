<?php
function getLink($cat, $id){
    $page='';
    switch($cat){
        case 'TIMGames': $page='ilovegamesdescription.html'; break;
        case 'TV': $page='timvisiondescription.html'; break;
        case 'TIMReading': $page='quotidianidescription.html'; break;
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
SELECT name,id,image,category FROM timgames
	WHERE (id,category) IN (SELECT ServiceId,ServiceCategory FROM available_services WHERE DeviceId=? AND DeviceType=?) UNION
SELECT name,id,image,category FROM timreading
	WHERE (id,category) IN (SELECT ServiceId,ServiceCategory FROM available_services WHERE DeviceId=? AND DeviceType=?) UNION
SELECT name,id,image,category FROM tv
	WHERE (id,category) IN (SELECT ServiceId,ServiceCategory FROM available_services WHERE DeviceId=? AND DeviceType=?)
EOS
                   );
$id = intval($_POST['id']);
$category = $_POST['category'];
// esecuzione della query 
$sql->execute(array($id,$category,$id,$category,$id,$category)); 
// creazione di un array dei risultati 
$res = $sql->fetchAll(PDO::FETCH_OBJ);
$size=count($res);
for($i=0;$i<$size;$i++){
    $res[$i]->link = getLink($res[$i]->category, $res[$i]->id);
}
echo json_encode($res);