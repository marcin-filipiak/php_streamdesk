# StreamDesk – Content Aggregator

StreamDesk to uniwersalny agregator treści, który umożliwia wyświetlanie obrazów, filmów, materiałów z YouTube, osadzonych stron, komunikatów METAR oraz prognozy pogody w formie siatki kart w przeglądarce. Projekt posiada centralną konfigurację w PHP, system pluginów oraz plik JSON opisujący wszystkie kategorie i źródła. Dostępny jest także moduł edytora z panelem pomocy, który umożliwia modyfikację pliku JSON oraz podgląd dostępnych pluginów bezpośrednio z poziomu przeglądarki po podaniu hasła.

## Funkcjonalności

* Obsługa różnych typów mediów przez system pluginów: obrazy, wideo, YouTube, iframe, METAR, pogoda.
* Automatyczne przełączanie na domyślny obraz, gdy źródło jest offline.
* Responsywna siatka kart oparta na Bootstrap.
* Konfiguracja ustawień globalnych w jednym miejscu (config.php).
* Edytowalny plik JSON z kategoriami i źródłami.
* Wbudowany moduł edytora JSON z panelem pomocy i listą pluginów.
* System pluginów – każdy plugin zawiera opis, użycie i przykład.

## Instalacja

1. Skopiuj projekt na serwer obsługujący PHP 7.4+.
2. Upewnij się, że rozszerzenie `json` jest dostępne.
3. Dostęp do modułu konfiguracyjnego jest realizowany za pomocą sesji, konieczne może być połączenie SSL.
4. Struktura katalogów:

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
├─ plugins/
│  ├─ PluginManager.php
│  ├─ type-iframe.php
│  ├─ type-image.php
│  ├─ type-metar.php
│  ├─ type-video.php
│  ├─ type-weather.php
│  └─ type-youtube.php
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
define('SITE_TITLE', 'StreamDesk');
define('NAVBAR_BRAND', 'StreamDesk');
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

# System pluginów

Każdy plugin to osobny plik `type-*.php` w katalogu `plugins/`. Plugin definiuje typ, nazwę, opis, instrukcję użycia, przykład oraz funkcję renderującą. Pliki są automatycznie ładowane przez `PluginManager`.

## Dostępne pluginy

| Typ | Nazwa | Opis |
|-----|-------|------|
| `image` | Image | Wyświetla obraz z opcjonalnym fallbackiem offline |
| `video` | Video | Odtwarza plik wideo MP4 |
| `youtube` | YouTube | Osadza film z YouTube |
| `iframe` | Iframe | Osadza zewnętrzną stronę w ramce iframe |
| `metar` | METAR | Wyświetla komunikat METAR dla lotniska ICAO |
| `weather` | Pogoda | Prognoza pogody z Open-Meteo (dziś/jutro) |

## Tworzenie własnego pluginu

Utwórz plik `type-nazwa.php` w katalogu `plugins/` zwracający tablicę:

```php
<?php

return [
    'type' => 'nazwa',
    'name' => 'Nazwa widoczna',
    'description' => 'Krótki opis.',
    'usage' => 'Instrukcja użycia.',
    'example' => '{"type":"nazwa","url":"..."}',
    'render' => function (array $item, string $category): string {
        // $item – pojedynczy element z JSON (url, location, day, itp.)
        // $category – nazwa kategorii
        return '<div>...wyrenderowana treść...</div>';
    },
];
```

---

# Moduł Edytora JSON

W projekcie dostępny jest moduł służący do edycji pliku `data.json` bezpośrednio z przeglądarki.

## Jak wejść do edytora?

Przejdź pod adres twojego serwisu StreamDesk i dodaj w adresie parametr `op=editor`:

```
http://twojaDomena.test/index.php?op=editor
```

### Zachowanie edytora:

* jeżeli użytkownik nie jest zalogowany – pojawia się formularz z hasłem
* jeśli hasło jest błędne – wyświetlany jest komunikat
* po poprawnym wpisaniu hasła – użytkownik zostaje zalogowany i może edytować JSON
* po zalogowaniu widoczny jest panel "Dostępne pluginy" z opisem, użyciem i przykładem dla każdego pluginu
* zapis odbywa się przyciskiem „Zapisz"
* po zapisie użytkownik wraca na stronę główną
* w przypadku błędu walidacji JSON lub problemu z zapisem pliku wyświetlany jest komunikat

---

# Plik JSON (`data.json`)

Plik `data.json` zawiera wszystkie zdefiniowane linki i kategorie.

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
          "location": "EPKK",
          "type": "metar",
          "refresh": 300
        },
        {
          "location": "Warsaw",
          "type": "weather",
          "day": "today"
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

  * `url` / `location` – adres zasobu lub lokalizacja (zależnie od pluginu)
  * `type` – identyfikator pluginu (`image`, `video`, `youtube`, `iframe`, `metar`, `weather`)
  * `refresh` – (opcjonalnie) czas odświeżania w sekundach
  * `day` – (dla pluginu `weather`) `"today"` lub `"tomorrow"`