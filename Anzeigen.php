﻿<?php
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

    // SQL-Abfrage vorbereiten, um alle Bestellungen für die Kundennummer abzurufen
    $st = $db->prepare("SELECT bestellung.BestellNr, bestellung.ArtikelNr, artikel.Bezeichnung AS Artikelname, artikel.`Preis in €` AS Einzelpreis, bestellung.Menge AS Bestellmenge
                        FROM bestellung
                        INNER JOIN artikel ON bestellung.ArtikelNr = artikel.ArtikelNr
                        WHERE bestellung.KundenNr = :KundenNummer");
    $st->execute(array(':KundenNummer' => $KundenNummer));
    $bestellungen = $st->fetchAll(PDO::FETCH_ASSOC);

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>Warenkorb anzeigen</title>";
    echo "<link rel='stylesheet' href='style.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    if (count($bestellungen) > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        // Dynamisch die Tabellenköpfe auslesen
        for ($i = 0; $i < $st->columnCount(); $i++) {
            $meta = $st->getColumnMeta($i);
            echo "<th>" . htmlspecialchars($meta['name']) . "</th>";
        }
        echo "<th>Neue Menge</th>";
        echo "<th>Aktualisieren</th>";
        echo "<th>&nbsp;</th>";
        echo "</tr>";
        foreach ($bestellungen as $bestellung) {
            echo "<tr>";
            foreach ($bestellung as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "<td><form method='post' action='aktualisieren.php'><input type='number' name='neueMenge' min='1' required></td>";
            echo "<td><input type='hidden' name='BestellNr' value='" . htmlspecialchars($bestellung['BestellNr']) . "'><input type='hidden' name='KundenNummer' value='" . htmlspecialchars($KundenNummer) . "'><button type='submit'>Aktualisieren</button></form></td>";
            echo "<td><a href='loeschen.php?Artikelnummer=" . htmlspecialchars($bestellung['ArtikelNr']) . "'>Aus Warenkorb löschen</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Es befinden sich keine Artikel im Warenkorb";
    }
    echo "<button onclick=\"window.location.href='index.html'\">Zurück</button>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>