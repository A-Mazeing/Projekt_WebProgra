<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen des Suchbegriffs und der Kundennummer aus der Abfragezeichenfolge
$AName = isset($_GET['search']) ? $_GET['search'] : '';
$KundenNummer = isset($_GET['kundennummer']) ? $_GET['kundennummer'] : '';

// Verbindung zur Datenbank herstellen
try {
    $datenbank = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $datenbank->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten
    $abfrageErgebnis = $datenbank->prepare("SELECT * FROM artikel WHERE Bezeichnung LIKE :AName");
    // vorbereitete SQL-Abfrage ausführen und den Suchbegriff als Parameter übergeben
    if ($abfrageErgebnis->execute(array(':AName' => $AName . "%"))) {
        $rows = $abfrageErgebnis->rowCount();
        $cols = $abfrageErgebnis->columnCount();
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<title>Suchergebnis</title>";
        echo "<link rel='stylesheet' href='style.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Suchergebnis</h1>";
        if ($rows > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            for ($i = 0; $i < $cols; $i++) {
                $meta = $abfrageErgebnis->getColumnMeta($i);
                echo "<th>" . htmlspecialchars($meta['name']) . "</th>";
            }
            echo "<th>&nbsp;</th>";
            echo "</tr>";
            foreach ($abfrageErgebnis as $erg) {
                echo "<tr>";
                for ($i = 0; $i < $cols; $i++) {
                    echo "<td>" . htmlspecialchars($erg[$i]) . "</td>";
                }
                echo "<td><a href='hinzufügen.php?Artikelnummer=" . htmlspecialchars($erg[0]) . "&kundennummer=" . htmlspecialchars($KundenNummer) . "'>In den Warenkorb</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Abfrage liefert keine Datensätze</p>";
        }
        echo "<button onclick=\"window.location.href='index.html'\">Zurück</button>";
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