# 3D-Druck Shop – Modul 151 Projekt

Dies ist ein Webprojekt im Rahmen des Moduls 151. Die Anwendung ist ein einfacher Online-Shop für 3D-Druck-Produkte. Registrierte Benutzer können eigene Produkte erfassen, bearbeiten und löschen. Die Applikation wurde mit PHP, HTML, CSS und einer MySQL-Datenbank umgesetzt.

## 📦 Features

- ✅ Benutzer-Registrierung & Login mit Session-Management
- ✅ Passwort-Hashing mit `password_hash()` (C11)
- ✅ Passwort ändern für eingeloggte Benutzer (C15)
- ✅ Produkte erfassen, bearbeiten und löschen (C16–C18)
- ✅ Schutz vor SQL-Injection mit `PDO::prepare()` (C19)
- ✅ Schutz vor Script-Injection mit `htmlspecialchars()` (C7)
- ✅ Schutz vor Session-Fixation & Hijacking (C10)
- ✅ Getrennter DB-User mit eingeschränkten Rechten (C12)

## 🛠️ Technologien

- HTML5 & CSS3
- PHP 8.x
- MySQL (phpMyAdmin)
- PDO für Datenbankzugriffe
- Session & Security-Techniken

## 📁 Projektstruktur

/php ├── login.php ├── register.php ├── logout.php ├── products.php ├── edit_product.php ├── delete_product.php ├── change_password.php ├── config.php ├── session_check.php

/css ├── styles.css

## 🔒 Sicherheit

- Alle Datenbankabfragen sind mit Prepared Statements ausgeführt.
- Passwörter werden mit `password_hash()` gespeichert.
- Session-ID wird bei Login regeneriert.
- Session-Daten wie IP und User-Agent werden validiert.
- XSS wird durch `htmlspecialchars()` verhindert.
- Es wird ein eingeschränkter Datenbankbenutzer verwendet (nur SELECT, INSERT, UPDATE, DELETE).

## 👤 Benutzerrollen

- **Benutzer:** kann sich registrieren, anmelden, Produkte verwalten, Passwort ändern
- **(Optional) Admin:** Struktur für Admin-Login vorhanden, aktuell aber ohne Funktion

## 🧪 Testen

1. Datenbankstruktur importieren (SQL-Datei nicht enthalten)
2. Zugangsdaten in `config.php` anpassen
3. Projekt lokal (z. B. mit XAMPP) im `htdocs`-Verzeichnis starten
4. Seite aufrufen: `http://localhost/DeinProjektOrdner/`

## 👨‍💻 Autoren

- Marco Frey
- Florian Brügger

Modul 151 – Web-Applikationen mit Datenbankanbindung

## 🗃️ SQL-Struktur

```sql
-- Tabelle: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabelle: products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);