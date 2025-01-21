<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen der Artikelnummer und der Kundennummer aus der Abfragezeichenfolge
$Artikelnummer = isset($_GET['Artikelnummer']) ? $_GET['Artikelnummer'] : '';
$KundenNummer = isset($_GET['kundennummer']) ? $_GET['kundennummer'] : '';

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten, um den Artikel abzurufen
    $st = $db->prepare("SELECT ArtikelNr, Bezeichnung, Hersteller, 'Füllmenge in floz', 'Preis in €', Kategorie, Mindestbestand, Bestellmenge, Liefereinheit FROM artikel WHERE ArtikelNr = :Artikelnummer");
    if ($st->execute(array(':Artikelnummer' => $Artikelnummer))) {
        $rows = $st->rowCount();
        $cols = $st->columnCount();
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<title>Artikel hinzufügen</title>";
        echo "<link rel='stylesheet' href='style.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        if ($rows > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            for ($i = 0; $i < $cols; $i++) {
                $meta = $st->getColumnMeta($i);
                echo "<th>" . htmlspecialchars($meta['name']) . "</th>";
            }
            echo "</tr>";
            foreach ($st as $erg) {
                echo "<tr>";
                for ($i = 0; $i < $cols; $i++) {
                    echo "<td>" . htmlspecialchars($erg[$i]) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Abfrage liefert keine Datensätze";
        }
        echo "<form action='fertig.php' method='post'>";
        echo "<input type='hidden' name='Artikelnummer' value='" . htmlspecialchars($Artikelnummer) . "'>";
        echo "<input type='hidden' name='kundennummer' value='" . htmlspecialchars($KundenNummer) . "'>";
        echo "<label for='menge'>Menge:</label>";
        echo "<input type='number' id='menge' name='menge' required>";
        echo "<button type='submit'>Bestellen</button>";
        echo "</form>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Datenbankaufruf fehlgeschlagen";
    }
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>