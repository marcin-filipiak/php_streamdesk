<?php

return [
    'type' => 'youtube',
    'name' => 'YouTube',
    'description' => 'Osadza film z YouTube na podstawie ID wyciągniętego z URL.',
    'usage' => 'W polu "url" podaj link do filmu YouTube (dowolny format: youtube.com/watch?v=..., youtu.be/...).',
    'example' => '{"type":"youtube","url":"https://www.youtube.com/watch?v=dQw4w9WgXcQ"}',
    'render' => function (array $item, string $category): string {
        preg_match('/(?:youtu\.be\/|v=|\/embed\/)([a-zA-Z0-9_-]{11})/', $item['url'], $matches);
        $youtubeId = $matches[1] ?? '';

        if (!$youtubeId) {
            return '<p class="text-danger small mb-0">Nieprawidłowy URL YouTube</p>';
        }

        return '<iframe width="600" height="388" align="center"
                src="https://www.youtube.com/embed/' . htmlspecialchars($youtubeId) . '"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>';
    },
];
