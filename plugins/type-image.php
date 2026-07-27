<?php

return [
    'type' => 'image',
    'name' => 'Image',
    'description' => 'Wyświetla obraz z opcjonalnym fallbackiem offline.',
    'usage' => 'W polu "url" podaj bezpośredni link do obrazu (jpg, png, gif, webp).',
    'example' => '{"type":"image","url":"https://example.com/image.jpg"}',
    'render' => function (array $item, string $category): string {
        $url = htmlspecialchars($item['url']);
        $cat = htmlspecialchars($category);
        $offline = DEFAULT_OFFLINE;
        $viewUrl = 'index.php?op=viewimage&img=' . urlencode($item['url']);

        return '<a href="' . $viewUrl . '">
            <img class="card-img img-fluid"
                 src="' . $url . '"
                 alt="' . $cat . '"
                 loading="lazy"
                 onerror="this.onerror=null;this.src=\'' . $offline . '\';">
            </a>';
    },
];
