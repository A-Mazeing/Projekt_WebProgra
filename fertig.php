<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen der POST-Daten
$Artikelnummer = isset($_POST['Artikelnummer']) ? $_POST['Artikelnummer'] : '';
$KundenNr = isset($_POST['kundennummer']) ? $_POST['kundennummer'] : '';
$Menge = isset($_POST['menge']) ? $_POST['menge'] : '';
$BestellDatum = date('Y-m-d');

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten, um die Bestellung einzufügen
    $st = $db->prepare("INSERT INTO bestellung (ArtikelNr, KundenNr, Menge, BestellDatum) VALUES (:ArtikelNr, :KundenNr, :Menge, :BestellDatum)");
    $st->execute(array(
        ':ArtikelNr' => $Artikelnummer,
        ':KundenNr' => $KundenNr,
        ':Menge' => $Menge,
        ':BestellDatum' => $BestellDatum
    ));

    // SQL-Abfrage vorbereiten, um die Artikeldetails abzurufen
    $st = $db->prepare("SELECT ArtikelNr, Bezeichnung, Hersteller, 'Füllmenge in floz', 'Preis in €', Kategorie, Mindestbestand, Bestellmenge, Liefereinheit FROM artikel WHERE ArtikelNr = :Artikelnummer");
    $st->execute(array(':Artikelnummer' => $Artikelnummer));
    $artikel = $st->fetch(PDO::FETCH_ASSOC);

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>Bestellung</title>";
    echo "<link rel='stylesheet' href='style.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "Bestellung erfolgreich hinzugefügt.<br>";
    echo "<table border='1'>";
    echo "<tr>";
    for ($i = 0; $i < $st->columnCount(); $i++) {
        $meta = $st->getColumnMeta($i);
        echo "<th>" . htmlspecialchars($meta['name']) . "</th>";
    }
    echo "<th>Menge</th>";
    echo "<th>Bestelldatum</th>";
    echo "</tr>";
    echo "<tr>";
    foreach ($artikel as $value) {
        echo "<td>" . htmlspecialchars($value) . "</td>";
    }
    echo "<td>" . htmlspecialchars($Menge) . "</td>";
    echo "<td>" . htmlspecialchars($BestellDatum) . "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<button onclick=\"window.location.href='index.html'\">Zurück</button>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>