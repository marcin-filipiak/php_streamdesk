<?php

function fetchWeatherData(string $location): ?array {
    if (preg_match('/^(-?\d+\.?\d*),(-?\d+\.?\d*)$/', $location, $m)) {
        $lat = $m[1];
        $lon = $m[2];
        $cityName = $location;
    } else {
        $geoUrl = 'https://geocoding-api.open-meteo.com/v1/search?name=' . urlencode($location) . '&count=1&language=pl&format=json';
        $geoContext = stream_context_create(['http' => ['timeout' => 5]]);
        $geoResult = @file_get_contents($geoUrl, false, $geoContext);
        if ($geoResult === false) return null;
        $geoData = json_decode($geoResult, true);
        if (empty($geoData['results'][0])) return null;
        $lat = $geoData['results'][0]['latitude'];
        $lon = $geoData['results'][0]['longitude'];
        $cityName = $geoData['results'][0]['name'];
        $country = $geoData['results'][0]['country'] ?? '';
        if (!empty($geoData['results'][0]['admin1'])) {
            $cityName .= ', ' . $geoData['results'][0]['admin1'];
        }
    }

    $weatherUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&daily=temperature_2m_max,temperature_2m_min,weathercode,precipitation_sum,wind_speed_10m_max&timezone=auto&forecast_days=2";
    $weatherContext = stream_context_create(['http' => ['timeout' => 5]]);
    $weatherResult = @file_get_contents($weatherUrl, false, $weatherContext);
    if ($weatherResult === false) return null;
    $weatherData = json_decode($weatherResult, true);
    if (empty($weatherData['daily'])) return null;

    return [
        'city' => $cityName,
        'daily' => $weatherData['daily'],
    ];
}

function weatherCodeToIcon(int $code): string {
    if ($code === 0) return '☀️';
    if ($code <= 3) return '⛅';
    if ($code <= 48) return '🌫️';
    if ($code <= 57) return '🌦️';
    if ($code <= 67) return '🌧️';
    if ($code <= 77) return '🌨️';
    if ($code <= 82) return '🌧️';
    if ($code <= 86) return '🌨️';
    return '⛈️';
}

function weatherCodeToLabel(int $code): string {
    if ($code === 0) return 'Bezchmurnie';
    if ($code <= 3) return 'Częściowo pochmurnie';
    if ($code <= 48) return 'Mgła';
    if ($code <= 57) return 'Mżawka';
    if ($code <= 67) return 'Deszcz';
    if ($code <= 77) return 'Śnieg';
    if ($code <= 82) return 'Deszcz';
    if ($code <= 86) return 'Śnieg';
    return 'Burza';
}

return [
    'type' => 'weather',
    'name' => 'Pogoda',
    'description' => 'Wyświetla prognozę pogody dla wybranej lokalizacji. Opcjonalnie można wybrać dzień.',
    'usage' => 'W polu "location" podaj nazwę miasta (np. Warsaw) lub współrzędne (np. 52.237,21.017). Dodaj "day": "today" lub "day": "tomorrow" aby wybrać konkretny dzień.',
    'example' => '{"type":"weather","location":"Warsaw","day":"today"}',
    'render' => function (array $item, string $category): string {
        $location = trim($item['location'] ?? $item['url'] ?? '');
        $data = fetchWeatherData($location);

        if ($data === null) {
            $loc = htmlspecialchars($location);
            return '<div class="p-2 text-center h-100 d-flex flex-column justify-content-center">
                <div class="h5 mb-1">🌤️ Pogoda</div>
                <div class="text-muted small">Brak danych dla: ' . $loc . '</div>
            </div>';
        }

        $city = htmlspecialchars($data['city']);
        $days = $data['daily'];
        $dayIndexes = [];

        $dayParam = $item['day'] ?? '';
        if ($dayParam === 'today') {
            $dayIndexes = [0];
        } elseif ($dayParam === 'tomorrow') {
            $dayIndexes = [1];
        } else {
            $dayIndexes = [0, 1];
        }

        $dayLabels = ['Dziś', 'Jutro'];
        $output = '<div class="p-2 h-100">';
        $output .= '<div class="text-center fw-bold mb-2">' . $city . '</div>';

        foreach ($dayIndexes as $i) {
            if ($i >= count($days['time'])) continue;
            $tMax = $days['temperature_2m_max'][$i];
            $tMin = $days['temperature_2m_min'][$i];
            $code = $days['weathercode'][$i];
            $precip = $days['precipitation_sum'][$i] ?? 0;
            $wind = $days['wind_speed_10m_max'][$i] ?? 0;
            $icon = weatherCodeToIcon($code);
            $label = weatherCodeToLabel($code);

            $output .= '<div class="d-flex align-items-center mb-2 pb-2 border-bottom">';
            $output .= '<div class="text-center me-2" style="font-size:1.8rem">' . $icon . '</div>';
            $output .= '<div class="flex-grow-1">';
            $output .= '<div class="fw-bold">' . $dayLabels[$i] . '</div>';
            $output .= '<div class="small text-muted">' . $label . '</div>';
            $output .= '<div class="small">' . $tMin . '°C / ' . $tMax . '°C</div>';
            $output .= '<div class="small text-muted">💧 ' . number_format($precip, 1) . ' mm | 💨 ' . round($wind) . ' km/h</div>';
            $output .= '</div></div>';
        }

        $output .= '</div>';
        return $output;
    },
];