<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen der Kundennummer aus der Abfragezeichenfolge
$KundenNummer = isset($_GET['kundennummer']) ? $_GET['kundennummer'] : '';

if (empty($KundenNummer)) {
    echo "Keine Kundennummer angegeben.";
    exit;
}

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten, um alle Einträge mit der Kundennummer zu löschen
    $st = $db->prepare("DELETE FROM bestellung WHERE KundenNr = :KundenNummer");
    if ($st->execute(array(':KundenNummer' => $KundenNummer))) {
        echo "Inhalt des Warenkorbs wurde vollständig gelöscht.";
    } else {
        echo "Datenbankaufruf fehlgeschlagen";
    }
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
echo '<button onclick="window.location.href=\'index.html\'">Zurück</button>';
?>