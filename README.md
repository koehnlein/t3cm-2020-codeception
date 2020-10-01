# Codeception-Einstieg

Notizen zur Codeception-Eintiegs-Session beim [TYPO3 Camp Munich #t3cm](https://www.typo3camp-munich.de) am 27. September 2020.

## Installation

Am besten über composer, unbedingt mit `--dev`-Attribut. Alternativ kann man auf <https://codeception.com/install> auch eine phar-Datei laden.

```
composer require codeception/codeception --dev
```

Erster Befehl, um alle notwendigen Dateien anzulegen:

```
vendor/bin/codecept bootstrap
```

Anschließend evtl. die Module bereinigen, z.B. phpbrowser raus und webdriver rein.

```
composer remove codeception/module-phpbrowser
composer require codeception/module-webdriver --dev
```

## Module für Browser-Tests

Datei `tests/acceptance.suite.yml` anpassen. Block `PhpBrowser` entfernen, stattdessen ...

```yaml
  ...
    - WebDriver:
        url: https://tests.example.org/
        browser: chrome
```

### Unterschiedliche Test-Möglichkeiten

* PhpBrowser: simpel
* PhantomJS
* Webdriver: Echte Browser
    * Chrome
    * Firefox
    * Safari
    * ...

### Webdriver-Requirements

Muss einmalig auf dem Test-Rechner installiert werden, nicht pro Projekt nötig.

* den Browser, mit dem ich testen will
* WebDriver für den Browser (z.B. chromedriver, geckodriver), z.B. in `/usr/local/bin` ablegen
* Selenium-Server (z.B. `brew install selenium-server-standalone`)

Oder ein fertiges Docker-Image mit Selenium und dem gewünschten Browser: <https://github.com/SeleniumHQ/docker-selenium#quick-start>

## Test anlegen

```
vendor/bin/codecept generate:cest acceptance <ClassName>
```

In der angelegten Klasse/Datei können beliebig viele public functions angelegt werden. Die Funktion `_before()` wird automatisch vor jedem Test ausgeführt. Mit Aufrufen von `$I->wantTo()` und `$I->expectTo()` können die Tests, bzw. die Ausgabe der Tests stukturiert werden. 

```php
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/foo/');
        $I->waitForText('foo');
    }

    public function showAnything(AcceptanceTester $I)
    {
        $I->wantTo('click button 1');
        $I->click('.element1');
        $I->expectTo('see a specific text');
        $I->see('Lorem ipsum');
    }

    public function showAndHideAnything(AcceptanceTester $I)
    {
        $I->wantTo('click button 1');
        $I->click('.element1');
        $I->expectTo('see a specific text');
        $I->see('Lorem ipsum');

        $I->wantTo('click button 1 a second time');
        $I->click('.element1');
        $I->expectTo('not see the specific text anymore');
        $I->dontSee('Lorem ipsum');
    }
```

## Test ausführen

Alle Acceptance-Tests:

```
vendor/bin/codecept run acceptance
```

Bestimmte Klassen:

```
vendor/bin/codecept run acceptance <WhateverCest>
```

HTML-Report generieren:

```
vendor/bin/codecept run acceptance --html
```

## Weitere Möglichkeiten/Module/Ideen

* [DB](https://github.com/Codeception/module-db):  
    Inhalte vor/nach Tests in Datenbank prüfen, evtl. User-Daten vor Login in Datenbank schreiben, User-Daten nach Registrierung löschen, ...
* [MailHog](https://github.com/ericmartel/codeception-email-mailhog):  
    Ausgehende Mails parsen/prüfen
* Eigene Module:  
   z.B. Erfolg von Newsletter-Registrierung via Newsletter-Dienstleister-API testen
