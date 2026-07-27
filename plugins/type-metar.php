<?php

function fetchMetar(string $code): string {
    $url = 'https://metar.vatsim.net/metar.php?id=' . strtoupper($code);
    $context = stream_context_create(['http' => ['timeout' => 5]]);
    $result = @file_get_contents($url, false, $context);
    return $result !== false ? trim($result) : '';
}

return [
    'type' => 'metar',
    'name' => 'METAR',
    'description' => 'Wyświetla komunikat METAR dla lotniska ICAO (np. EPKK).',
    'usage' => 'W polu "location" wpisz kod ICAO lotniska (4 litery).',
    'example' => '{"type":"metar","location":"EPKK"}',
    'render' => function (array $item, string $category): string {
        $code = strtoupper(trim($item['location'] ?? $item['url'] ?? ''));
        $metar = fetchMetar($code);

        if (!$metar || str_starts_with($metar, 'Error')) {
            return '<div class="p-2 text-center h-100 d-flex flex-column justify-content-center" data-metar-code="' . htmlspecialchars($code) . '">
                <div class="metar-code h5 mb-1">' . htmlspecialchars($code) . '</div>
                <div class="text-muted small">Brak danych METAR</div>
            </div>';
        }

        $escapedMetar = htmlspecialchars($metar);

        return '<div class="p-2 text-center h-100 d-flex flex-column justify-content-center" data-metar-code="' . htmlspecialchars($code) . '">
            <div class="metar-code h5 mb-1">' . htmlspecialchars($code) . '</div>
            <div class="metar-raw small font-monospace text-break">' . $escapedMetar . '</div>
            <div class="mt-1">
                <small class="text-muted metar-time">' . date('H:i:s') . '</small>
            </div>
        </div>';
    },
];
