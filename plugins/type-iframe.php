<?php

return [
    'type' => 'iframe',
    'name' => 'Iframe',
    'description' => 'Osadza zewnętrzną stronę w ramce iframe.',
    'usage' => 'W polu "url" podaj adres strony do osadzenia. Opcjonalnie dodaj "refresh": true, aby ramka odświeżała się automatycznie.',
    'example' => '{"type":"iframe","url":"https://example.com"}',
    'render' => function (array $item, string $category): string {
        $url = htmlspecialchars($item['url']);
        $refreshClass = !empty($item['refresh']) ? ' js-refresh-iframe' : '';

        return '<iframe class="card-img' . $refreshClass . '" src="' . $url . '"></iframe>
            <div class="mt-1 text-center">
                <a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary">Otwórz w nowej karcie</a>
            </div>';
    },
];
