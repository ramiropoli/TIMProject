<?php
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
$sql = $db->prepare('SELECT * FROM tv_smart_living');

// esecuzione della query 
$sql->execute(); 

// creazione di un array dei risultati 
$res = $sql->fetchAll();
echo json_encode($res);