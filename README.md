# StreamDesk – Content Aggregator

StreamDesk to uniwersalny agregator treści, który umożliwia wyświetlanie obrazów, filmów, materiałów z YouTube oraz osadzonych stron w formie siatki kart w przeglądarce. Projekt posiada centralną konfigurację w PHP oraz plik JSON opisujący wszystkie kategorie i źródła. Dodano także moduł edytora, który umożliwia modyfikację całego pliku JSON bezpośrednio z poziomu przeglądarki po podaniu hasła.

## Funkcjonalności

* Obsługa różnych typów mediów: obrazy, wideo, YouTube, iframe.
* Automatyczne przełączanie na domyślny obraz, gdy źródło jest offline.
* Responsywna siatka kart oparta na Bootstrap.
* Konfiguracja ustawień globalnych w jednym miejscu (config.php).
* Edytowalny plik JSON z kategoriami i źródłami.
* Wbudowany moduł edytora JSON z autoryzacją hasłem.

## Instalacja

1. Skopiuj projekt na serwer obsługujący PHP 7.4+.
2. Upewnij się, że rozszerzenie `json` jest dostępne.
3. Struktura katalogów:

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
├─ index.php
├─ model/
│  ├─ DataModel.php
│  └─ EditorModel.php
├─ controller/
│  ├─ DashboardController.php
│  └─ EditorController.php
└─ view/
   ├─ dashboard.php
   └─ editor.php
```

---

# Konfiguracja (`config.php`)

W pliku `config.php` znajdują się stałe kontrolujące działanie aplikacji:

```php
<?php
define('BASE_URL', '/streamdesk');
define('DEFAULT_OFFLINE', BASE_URL . '/assets/img/offline-icon.jpg');

define('SITE_TITLE', 'StreamDesk – Content Aggregator');
define('NAVBAR_BRAND', 'StreamDesk');

// Hasło do edytora JSON
define('EDITOR_PASSWORD', '12345');
?>
```

### Zmiana hasła do edytora

Hasło znajduje się w jednej linii:

```
define('EDITOR_PASSWORD', '12345');
```

Wystarczy zmienić wartość w cudzysłowie i zapisać plik.

---

# Moduł Edytora JSON

W projekcie dostępny jest moduł służący do edycji pliku `data.json` bezpośrednio z przeglądarki.

## Jak wejść do edytora?

Przejdź pod adres twojego serwisu Streamdesk i dodaj w adresie parametr "op=editor":

przykład
```
http://twojaDomena.test/index.php?op=editor
```

### Zachowanie edytora:

* jeżeli użytkownik nie jest zalogowany – pojawia się formularz z hasłem
* jeśli hasło jest błędne – wyświetlany jest komunikat
* po poprawnym wpisaniu hasła – użytkownik zostaje zalogowany i może edytować JSON
* zapis odbywa się przyciskiem „Zapisz”
* po zapisie użytkownik wraca na stronę główną

---

# Plik JSON (`data.json`)

Plik `data.json` zawiera wszystkie zdefiniowane linki i kategorie. Projekt odczytuje ten plik przez model i wyświetla zgodnie ze strukturą.

### Przykład:

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
    }
  }
}
```

### Opis pól

* `links` – proste odnośniki pojawiające się w pasku menu.
* `media` – kategorie z zawartością multimedialną.

Każda kategoria zawiera:

* `source` – strona źródłowa kategorii
* `items` – lista elementów multimedialnych

  * `url` – adres konkretnego zasobu
  * `type` – `image`, `video`, `youtube`, albo `iframe`
  * `refresh` – (opcjonalnie) czas odświeżania

