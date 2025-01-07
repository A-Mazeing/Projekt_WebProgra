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
    $st = $db->prepare("SELECT ArtikelNr, Bezeichnung, Hersteller, Füllmenge, Preis, Kategorie, Mindestbestand, Bestellmenge, Liefereinheit FROM artikel WHERE ArtikelNr = :Artikelnummer");
    $st->execute(array(':Artikelnummer' => $Artikelnummer));
    $artikel = $st->fetch(PDO::FETCH_ASSOC);

    echo "Bestellung erfolgreich hinzugefügt.<br>";
    echo "<table border='1'>";
    echo "<tr><th>Artikelnummer</th><td>" . htmlspecialchars($artikel['ArtikelNr']) . "</td></tr>";
    echo "<tr><th>Bezeichnung</th><td>" . htmlspecialchars($artikel['Bezeichnung']) . "</td></tr>";
    echo "<tr><th>Hersteller</th><td>" . htmlspecialchars($artikel['Hersteller']) . "</td></tr>";
    echo "<tr><th>Füllmenge</th><td>" . htmlspecialchars($artikel['Füllmenge']) . "</td></tr>";
    echo "<tr><th>Preis</th><td>" . htmlspecialchars($artikel['Preis']) . "</td></tr>";
    echo "<tr><th>Kategorie</th><td>" . htmlspecialchars($artikel['Kategorie']) . "</td></tr>";
    echo "<tr><th>Mindestbestand</th><td>" . htmlspecialchars($artikel['Mindestbestand']) . "</td></tr>";
    echo "<tr><th>Bestellmenge</th><td>" . htmlspecialchars($artikel['Bestellmenge']) . "</td></tr>";
    echo "<tr><th>Liefereinheit</th><td>" . htmlspecialchars($artikel['Liefereinheit']) . "</td></tr>";
    echo "<tr><th>Menge</th><td>" . htmlspecialchars($Menge) . "</td></tr>";
    echo "<tr><th>Bestelldatum</th><td>" . htmlspecialchars($BestellDatum) . "</td></tr>";
    echo "</table>";
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
echo '<button onclick="window.location.href=\'index.html\'">Zurück</button>';
?>