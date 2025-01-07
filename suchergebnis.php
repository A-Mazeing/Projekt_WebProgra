<?php
// Einbinden der Datenbank-Konfigurationsdatei
include 'config.php';

// Abrufen des Suchbegriffs und der Kundennummer aus der Abfragezeichenfolge
$AName = isset($_GET['search']) ? $_GET['search'] : '';
$KundenNummer = isset($_GET['kundennummer']) ? $_GET['kundennummer'] : '';

// Verbindung zur Datenbank herstellen
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-Abfrage vorbereiten
    $st = $db->prepare("SELECT * FROM artikel WHERE Bezeichnung LIKE :AName");
    if ($st->execute(array(':AName' => $AName . "%"))) {
        $rows = $st->rowCount();
        $cols = $st->columnCount();
        if ($rows > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            for ($i = 0; $i < $cols; $i++) {
                $meta = $st->getColumnMeta($i);
                echo "<th>" . $meta['name'] . "</th>";
            }
            echo "<th>&nbsp;</th>";
            echo "</tr>";
            foreach ($st as $erg) {
                echo "<tr>";
                for ($i = 0; $i < $cols; $i++) {
                    echo "<td>" . $erg[$i] . "</td>";
                }
                echo "<td><a href='hinzufügen.php?Artikelnummer=" . $erg[0] . "&kundennummer=" . $KundenNummer . "'>In den Warenkorb</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Abfrage liefert keine Datensätze";
        }
    } else {
        echo "Datenbankaufruf fehlgeschlagen";
    }
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>