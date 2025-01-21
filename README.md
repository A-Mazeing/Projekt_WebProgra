# Projekt Dokumentation

## TODO Liste
- [ ] Dokumentation durchlesen
- [X] Get to Post 
- [ ] Erstellen von einem Plan
- [ ] Erstellen ER Diagramm
- [X] Erweitern der Datenbank
- [X] index.html auskommentieren
- [X] fertig.php auskommentieren
- [X] suchergebnis.php auskommentieren
- [X] hinzufügen.php auskommentieren
- [X] leeren.php auskommentieren
- [X] Anzeigen.php auskommentieren

## Übersicht
Dieses Projekt bietet eine Benutzeroberfläche zum Suchen von Artikeln, Anzeigen des Warenkorbs und Leeren des Warenkorbs. Es enthält Formulare für jede dieser Aktionen und verwendet PHP und JavaScript, um Formularübermittlungen zu verarbeiten.

## Struktur

### `index.html`
Diese HTML-Datei bietet die Hauptbenutzeroberfläche.

#### Aufbau
- **HTML-Kopf**
    - Setzt die Zeichenkodierung auf UTF-8.
    - Enthält einen Link zur `style.css`-Datei für das Styling.

- **Body**
    - Enthält ein `div` mit der Klasse `container`, das den gesamten Inhalt umschließt.
    - **Überschrift**
        - Ein `h1`-Element mit dem Titel "Artikel Suchen".
    - **Formulare**
        - **Suchformular**
            - `id`: `searchForm`
            - `action`: `suchergebnis.php`
            - `method`: `get`
            - Enthält Eingabefelder für den Suchbegriff und die Kundennummer.
            - Ein Absende-Button mit der Beschriftung "Suchergebnis".
        - **Warenkorb anzeigen Formular**
            - `id`: `anzeigenForm`
            - `action`: `Anzeigen.php`
            - `method`: `get`
            - Enthält ein verstecktes Eingabefeld für die Kundennummer.
            - Ein Absende-Button mit der Beschriftung "Anzeigen".
        - **Warenkorb leeren Formular**
            - `id`: `leerenForm`
            - `action`: `leeren.php`
            - `method`: `get`
            - Enthält ein verstecktes Eingabefeld für die Kundennummer.
            - Ein Absende-Button mit der Beschriftung "Leeren" und der Klasse `button`.

- **JavaScript**
    - Fügt den Formularen Ereignislistener hinzu, um die Kundennummer in den versteckten Eingabefeldern vor der Übermittlung zu setzen.
    - **Ereignislistener**
        - **Suchformular**
            - Setzt die Kundennummer für das Formular zum Anzeigen des Warenkorbs.
        - **Warenkorb anzeigen Formular**
            - Setzt die Kundennummer für das Formular zum Anzeigen des Warenkorbs.
        - **Warenkorb leeren Formular**
            - Setzt die Kundennummer für das Formular zum Leeren des Warenkorbs.

### `fertig.php`
Diese PHP-Datei verarbeitet die Bestellung eines Artikels, fügt die Bestellung in die Datenbank ein und zeigt die Details der Bestellung an.

#### Aufbau
- **Einbindung der Datenbank-Konfigurationsdatei**
    - `include 'config.php';`

- **Abrufen der POST-Daten**
    - `Artikelnummer`, `KundenNr`, `Menge`, `BestellDatum`

- **Verbindung zur Datenbank herstellen**
    - Verwendung von `PDO` für die Datenbankverbindung und Fehlerbehandlung.

- **SQL-Abfragen**
    - Einfügen der Bestellung in die Tabelle `bestellung`.
    - Abrufen der Artikeldetails aus der Tabelle `artikel`.

- **HTML-Ausgabe**
    - Anzeige der Bestelldetails in einer HTML-Tabelle.
    - Button zum Zurückkehren zur `index.html`.

### `suchergebnis.php`
Diese PHP-Datei verarbeitet die Suchanfrage nach Artikeln und zeigt die Suchergebnisse an.

#### Aufbau
- **Einbindung der Datenbank-Konfigurationsdatei**
    - `include 'config.php';`

- **Abrufen der GET-Daten**
    - `search`, `kundennummer`

- **Verbindung zur Datenbank herstellen**
    - Verwendung von `PDO` für die Datenbankverbindung und Fehlerbehandlung.

- **SQL-Abfrage**
    - Abrufen der Artikel, deren Bezeichnung dem Suchbegriff entspricht.

- **HTML-Ausgabe**
    - Anzeige der Suchergebnisse in einer HTML-Tabelle.
    - Link zum Hinzufügen des Artikels in den Warenkorb.
    - Button zum Zurückkehren zur `index.html`.

### `hinzufügen.php`
Diese PHP-Datei zeigt die Details eines ausgewählten Artikels an und ermöglicht das Hinzufügen des Artikels in den Warenkorb.

#### Aufbau
- **Einbindung der Datenbank-Konfigurationsdatei**
    - `include 'config.php';`

- **Abrufen der GET-Daten**
    - `Artikelnummer`, `kundennummer`

- **Verbindung zur Datenbank herstellen**
    - Verwendung von `PDO` für die Datenbankverbindung und Fehlerbehandlung.

- **SQL-Abfrage**
    - Abrufen der Artikeldetails aus der Tabelle `artikel`.

- **HTML-Ausgabe**
    - Anzeige der Artikeldetails in einer HTML-Tabelle.
    - Formular zum Hinzufügen des Artikels in den Warenkorb.
    - Button zum Zurückkehren zur `index.html`.

### `leeren.php`
Diese PHP-Datei löscht alle Bestellungen eines Kunden aus der Datenbank.

#### Aufbau
- **Einbindung der Datenbank-Konfigurationsdatei**
    - `include 'config.php';`

- **Abrufen der GET-Daten**
    - `kundennummer`

- **Verbindung zur Datenbank herstellen**
    - Verwendung von `PDO` für die Datenbankverbindung und Fehlerbehandlung.

- **SQL-Abfrage**
    - Löschen aller Bestellungen des Kunden aus der Tabelle `bestellung`.

- **HTML-Ausgabe**
    - Bestätigung der Löschung.
    - Button zum Zurückkehren zur `index.html`.

### `Anzeigen.php`
Diese PHP-Datei zeigt alle Bestellungen eines Kunden an.

#### Aufbau
- **Einbindung der Datenbank-Konfigurationsdatei**
    - `include 'config.php';`

- **Abrufen der GET-Daten**
    - `kundennummer`

- **Verbindung zur Datenbank herstellen**
    - Verwendung von `PDO` für die Datenbankverbindung und Fehlerbehandlung.

- **SQL-Abfrage**
    - Abrufen aller Bestellungen des Kunden aus der Tabelle `bestellung` und Verknüpfung mit der Tabelle `artikel`.

- **HTML-Ausgabe**
    - Anzeige der Bestellungen in einer HTML-Tabelle.
    - Link zum Löschen eines Artikels aus dem Warenkorb.
    - Button zum Zurückkehren zur `index.html`.

### `config.php`
Diese PHP-Datei enthält die Konfigurationsdaten für die Verbindung zur MySQL-Datenbank.

#### Aufbau
- **Datenbankkonfiguration**
    - `servername`, `username`, `password`, `dbname`

### `loeschen.php`
Diese PHP-Datei löscht einen bestimmten Artikel aus dem Warenkorb eines Kunden.

#### Aufbau
- **Einbindung der Datenbank-Konfigurationsdatei**
    - `include 'config.php';`

- **Abrufen der GET-Daten**
    - `Artikelnummer`

- **Verbindung zur Datenbank herstellen**
    - Verwendung von `PDO` für die Datenbankverbindung und Fehlerbehandlung.

- **SQL-Abfrage**
    - Löschen des Artikels aus der Tabelle `bestellung`.

- **HTML-Ausgabe**
    - Bestätigung der Löschung.
    - Button zum Zurückkehren zur `index.html`.

## Abhängigkeiten
- **CSS**
    - `style.css`: Bietet das Styling für die HTML-Elemente.
- **Datenbank**
    - Verbindung zur MySQL-Datenbank über `config.php`.

## Hinweise
- Stellen Sie sicher, dass die `config.php`-Datei korrekt konfiguriert ist.
- Die JavaScript- und PHP-Dateien setzen das Vorhandensein von Eingabefeldern mit bestimmten IDs und Formularen mit bestimmten IDs voraus.