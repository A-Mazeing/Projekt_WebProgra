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
    $st = $db->prepare("SELECT ArtikelNr, Bezeichnung, Hersteller, Füllmenge, Preis, Kategorie, Mindestbestand, Bestellmenge, Liefereinheit FROM artikel WHERE ArtikelNr = :Artikelnummer");
    if ($st->execute(array(':Artikelnummer' => $Artikelnummer))) {
        $rows = $st->rowCount();
        $cols = $st->columnCount();
        if ($rows > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            for ($i = 0; $i < $cols; $i++) {
                $meta = $st->getColumnMeta($i);
                echo "<th>" . $meta['name'] . "</th>";
            }
            echo "</tr>";
            foreach ($st as $erg) {
                echo "<tr>";
                for ($i = 0; $i < $cols; $i++) {
                    echo "<td>" . $erg[$i] . "</td>";
                }
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

<form action="fertig.php" method="post">
    <input type="hidden" name="Artikelnummer" value="<?php echo htmlspecialchars($Artikelnummer); ?>">
    <input type="hidden" name="kundennummer" value="<?php echo htmlspecialchars($KundenNummer); ?>">
    <label for="menge">Menge:</label>
    <input type="number" id="menge" name="menge" required>
    <button type="submit">Bestellen</button>
</form>