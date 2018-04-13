<?php
// Includo la connessione al database
include('core.php');
// Esegue il logout cancellando la sessione
session_destroy();

$msg="Logout avvenuto con successo";

//codifica il messaggio con urlencode
$msg=urlencode($msg);
header("Location: login.php?msg=$msg");
exit();
?>
