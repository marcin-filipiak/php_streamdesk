<?php

return [
    'type' => 'video',
    'name' => 'Video',
    'description' => 'Odtwarza plik wideo (MP4) z natywnym sterownikiem przeglądarki.',
    'usage' => 'W polu "url" podaj bezpośredni link do pliku MP4.',
    'example' => '{"type":"video","url":"https://example.com/video.mp4"}',
    'render' => function (array $item, string $category): string {
        $url = htmlspecialchars($item['url']);

        return '<video class="card-img" controls>
            <source src="' . $url . '" type="video/mp4">
            Twoja przeglądarka nie wspiera wideo.
        </video>';
    },
];
