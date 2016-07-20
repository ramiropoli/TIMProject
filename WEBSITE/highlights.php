<?php
function getLink($cat, $id){
    $page='';
    switch($cat){
        case 'line': $page='linedescription.html'; break;
        case 'hw': $page='hwdescription.html'; break;
        case 'cost': $page='costdescription.html'; break;
        case 'smartlife': $page='smartdescription.html'; break;
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
$sql = $db->prepare('SELECT * FROM smartlife_assistance WHERE id<3 UNION SELECT * FROM line_management WHERE id<3
UNION SELECT * FROM hw_config WHERE id<3 UNION SELECT * FROM cost_payments WHERE id<3');

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