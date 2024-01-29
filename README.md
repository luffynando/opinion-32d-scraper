# Opinion 32d Scraper

Libreria que obtiene la opinión de cumplimiento via CIEC

------

> **Requires [PHP 8.2+](https://php.net/releases/)**

## Instalación

Usa [composer](https://getcomposer.org/)

```php
composer require phpcfdi/opinion-32d-scraper
```

Esta librería hace uso WebDriver y tienes dos opciones para elegir: ChromeDriver y geckodriver. Puedes usar los comandos a continuación para instalarlos:

```bash
composer require --dev dbrekelmans/bdi
vendor/bin/bdi detect drivers
```

Por default, el cliente buscará el webdriver en el directorio `drivers/` del proyecto.

Para más información ver la [guía de instalación](https://github.com/symfony/panther#installing-chromedriver-and-geckodriver)

## Estandar de Código

🧹 Keep a modern codebase with **Pint**:

```bash
composer lint
```

✅ Run refactors using **Rector**

```bash
composer refacto
```

⚗️ Run static analysis using **PHPStan**:

```bash
composer test:types
```

✅ Run unit tests using **PEST**

```bash
composer test:unit
```

🚀 Run the entire test suite:

```bash
composer test
```
