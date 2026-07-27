<?php

class PluginManager {
    private array $plugins = [];

    public function __construct(string $pluginsDir) {
        foreach (glob($pluginsDir . '/type-*.php') as $file) {
            $plugin = require $file;
            if (is_array($plugin) && isset($plugin['type'], $plugin['render'])) {
                $this->plugins[$plugin['type']] = $plugin;
            }
        }
    }

    public function has(string $type): bool {
        return isset($this->plugins[$type]);
    }

    public function render(string $type, array $item, string $category): string {
        if (!$this->has($type)) {
            return '<p class="text-danger small mb-0">Nieznany typ: ' . htmlspecialchars($type) . '</p>';
        }
        return ($this->plugins[$type]['render'])($item, $category);
    }

    public function getAll(): array {
        $list = [];
        foreach ($this->plugins as $type => $plugin) {
            $list[] = [
                'type' => $plugin['type'],
                'name' => $plugin['name'] ?? $type,
                'description' => $plugin['description'] ?? '',
                'usage' => $plugin['usage'] ?? '',
                'example' => $plugin['example'] ?? '',
            ];
        }
        return $list;
    }
}
