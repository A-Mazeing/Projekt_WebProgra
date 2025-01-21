<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen der neuen Menge und der BestellNr aus dem POST-Request
$neueMenge = isset($_POST['neueMenge']) ? $_POST['neueMenge'] : '';
$BestellNr = isset($_POST['BestellNr']) ? $_POST['BestellNr'] : '';
$KundenNummer = isset($_POST['KundenNummer']) ? $_POST['KundenNummer'] : '';

if (empty($neueMenge) || empty($BestellNr) || empty($KundenNummer)) {
    echo "Fehlende Daten.";
    exit;
}

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten, um die Menge zu aktualisieren
    $st = $db->prepare("UPDATE bestellung SET Menge = :neueMenge WHERE BestellNr = :BestellNr AND KundenNr = :KundenNummer");
    $st->execute(array(':neueMenge' => $neueMenge, ':BestellNr' => $BestellNr, ':KundenNummer' => $KundenNummer));

    echo "<link rel='stylesheet' href='style.css'>";
    echo "Menge erfolgreich aktualisiert.";
    echo "<a href='Anzeigen.php?kundennummer=" . htmlspecialchars($KundenNummer) . "'>Zurück zum Warenkorb</a>";
} catch (PDOException $e) {
    echo "Aktualisierung fehlgeschlagen: " . $e->getMessage();
}
?>