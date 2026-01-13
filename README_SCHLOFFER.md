# ITL1_2_aufgabe_hugeframework
Author: Schloffer Lisa | 2025/26

## Aus welchen Bausteinen besteht das Framework?
Aus:
Config
Core
Controller
Model
View
Public
DB

## Wie sieht die DB aus
Die Datenbank vom Huge Framework ist relationale SQL-basiert und sehr einfach gehalten. Typischerweise gibt es:

Users/Tables für Benutzer-Accounts

Sessions für Login-Sessions

Config/Settings für Framework-Einstellungen


## Wozu dient der public Ordner?
Enthält alles, was öffentlich zugänglich ist (CSS, JS, Bilder, Fonts).
index.php im public-Ordner ist meist der Front Controller, der alle Requests weiterleitet.

## Beschreibe folgende Bausteine:
Config → enthält Konfigurationsdateien (Datenbank, Pfade, Einstellungen)

Core → Kern des Frameworks, z. B. Router, Basis-Controller, Basis-Model

Controller → steuert die Logik, empfängt Requests, ruft Models auf und gibt Views aus

Model → Schnittstelle zur Datenbank, Geschäftslogik, Datenabfragen

View → Templates, HTML-Ausgabe

## Wie sieht der Konstruktor in PHP Klassen aus?
```
class User {
    public function __construct($name) {
        $this->name = $name;
    }
}
```

## Wozu dient die Variable $this?

$this referenziert die aktuelle Instanz der Klasse.


## Vorteile der Verwendung von OOP in PHP

Strukturierung: Bessere Organisation von Code

Wiederverwendbarkeit: Klassen und Methoden können mehrfach genutzt werden

Kapselung: Zugriff auf Daten kontrollierbar

Erweiterbarkeit: Vererbung und Polymorphismus

Lesbarkeit: Klarere Trennung von Funktionalitäten


## Datenkapselungsmethoden in PHP

public → von überall zugänglich

protected → nur innerhalb der Klasse und Unterklassen

private → nur innerhalb der Klasse selbst

## Wie sehen abstrakte Klassen aus?

```
abstract class Animal {
    abstract public function makeSound();

    public function eat() {
        echo "Eating...";
    }
}

class Dog extends Animal {
    public function makeSound() {
        echo "Woof!";
    }
}
```

## Umsetzung - Aufgabe 6

Entfernung der Captcha und der E-Mail Verifikation

![Captcha entfernt](/_pictures/entfernung.png)

Um die Captcha und die E-Mail Verifikation zu entfernen habe ich einen Teil vom Code im "RegisterController" und im "RegisterModel" entfernt.

![Register Button entfernt](/_pictures/entfernt_register_button.png)
![User anlegen über Admin Account.](/_pictures/user_anlegen_admin.png)
Dann wurde das Register Formualr aus dem Login-Bereich entfernt und ist nun über einem Button im Admin-Account aufrufbar.



## Umsetzung - Aufgabe 7

Erstellung der Tabelle für die User Gruppen

![Erstellung Tabelle](/_pictures/erstellung_tabelle.png)

Überprüfung, ob die Rollen angezeigt werden

![Rollen angezeigt](/_pictures/rollen.png)

Bearbeitung der Rollen möglich
![Berarbeitun möglich](/_pictures/erfolgreich_rollen_bearbeiten.png)

Und noch js-table eingefügt für das Styling.

![Fertig](/_pictures/fertig.png)


## Umsetzung - Aufgabe 8 

Erstellung des Messagers

Diese Aufgabe war definitiv herausfordenter als die anderen. 

Begonnen haben wir damit, eine Tabelle mit den Konversationen zu erstellen. 

Beim Header haben wir oben einen weiteren Button eingefügt, um eben auf den Messager zu zugreifen. 

