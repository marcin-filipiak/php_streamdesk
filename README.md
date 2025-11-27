# StreamDesk – Content Aggregator

StreamDesk to uniwersalny agregator treści, który umożliwia wyświetlanie obrazów, filmów, materiałów z YouTube oraz osadzonych stron w formie siatki kart w przeglądarce. Projekt pozwala łatwo zarządzać źródłami danych i kategoriami poprzez plik JSON oraz centralną konfigurację w PHP.

## Funkcjonalności

* Obsługa różnych typów mediów: obrazy, wideo, YouTube, iframe.
* Automatyczne przełączanie na domyślny obraz, gdy źródło jest offline.
* Responsywny układ kart w siatce z wykorzystaniem Bootstrap.
* Łatwa konfiguracja globalnych ustawień projektu w pliku `config.php`.
* Możliwość dodawania nowych kategorii i źródeł w pliku JSON.

## Instalacja

1. Skopiuj projekt na serwer PHP.
2. Upewnij się, że masz włączone PHP 7.4+ i obsługę `json`.
3. Struktura katalogów powinna wyglądać:

```
streamdesk/
├─ assets/
│  ├─ css/
│  │  └─ styles.css
│  └─ img/
│     ├─ logo.svg
│     └─ offline-icon.jpg
├─ config.php
├─ data.json
├─ model/
│  └─ DataModel.php
├─ controller/
│  └─ DashboardController.php
└─ view/
   └─ dashboard.php
```

## Konfiguracja (`config.php`)

W pliku `config.php` definiuje się stałe globalne używane w projekcie:

```php
<?php
// Adres bazowy aplikacji
define('BASE_URL', '/streamdesk');

// Domyślny obrazek, gdy media są offline
define('DEFAULT_OFFLINE', BASE_URL . '/assets/img/offline-icon.jpg');

// Teksty wyświetlane w nagłówku i w tytule strony
define('SITE_TITLE', 'StreamDesk – Content Aggregator');
define('NAVBAR_BRAND', 'StreamDesk');
?>
```

* `BASE_URL` – adres bazowy aplikacji (przydaje się przy generowaniu ścieżek do zasobów).
* `DEFAULT_OFFLINE` – obraz wyświetlany, gdy media są niedostępne.
* `SITE_TITLE` – tytuł strony w `<title>`.
* `NAVBAR_BRAND` – tekst wyświetlany w pasku nawigacyjnym.

## Plik JSON (`data.json`)

Plik `data.json` definiuje źródła linków i mediów. Struktura przykładowa:

```json
{
  "links": {
    "Example Link 1": "https://example.com/page1",
    "Example Link 2": "https://example.com/page2"
  },
  "media": {
    "Category_1": {
      "source": "https://source.example.com/",
      "items": [
        {
          "url": "https://example.com/image1.jpg",
          "type": "image",
          "refresh": 10
        },
        {
          "url": "https://example.com/video1.mp4",
          "type": "video",
          "refresh": 30
        },
        {
          "url": "https://youtu.be/exampleID",
          "type": "youtube",
          "refresh": 60
        },
        {
          "url": "https://example.com/embed.html",
          "type": "iframe",
          "refresh": 60
        }
      ]
    },
    "Category_2": {
      "source": "https://another-source.example.com/",
      "items": [
        {
          "url": "https://another-source.example.com/image.png",
          "type": "image",
          "refresh": 15
        }
      ]
    }
  }
}
```

### Opis pól JSON:

* `links` – lista linków do zewnętrznych źródeł, wyświetlanych w pasku nawigacyjnym.
* `media` – główne kategorie z mediami.

  * `source` – strona źródłowa danej kategorii.
  * `items` – tablica elementów multimedialnych.

    * `url` – adres zasobu.
    * `type` – typ zasobu (`image`, `video`, `youtube`, `iframe`).
    * `refresh` – czas odświeżania w sekundach (opcjonalnie, można wykorzystać w JS do automatycznego reload).


