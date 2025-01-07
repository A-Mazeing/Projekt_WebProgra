<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen der Artikelnummer aus der Abfragezeichenfolge
$Artikelnummer = isset($_GET['Artikelnummer']) ? $_GET['Artikelnummer'] : '';
if (empty($Artikelnummer)) {
    echo "Keine Artikelnummer angegeben.";
    exit;
}

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten, um den Eintrag aus der Tabelle Bestellung zu löschen
    $st = $db->prepare("DELETE FROM bestellung WHERE ArtikelNr = :Artikelnummer");
    $st->execute(array(':Artikelnummer' => $Artikelnummer));

    if ($st->rowCount() > 0) {
        echo "Artikel erfolgreich aus dem Warenkorb gelöscht.";
    } else {
        echo "Artikel konnte nicht gefunden werden.";
    }
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>