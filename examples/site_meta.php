<?php

/**
 * Site metadata management and description generation.
 */

class SiteMeta
{
    private array $meta;
    private string $separator;

    public function __construct(array $meta = [], string $separator = ' | ')
    {
        $this->meta = $meta;
        $this->separator = $separator;
    }

    /**
     * Set a single metadata value.
     */
    public function set(string $key, $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * Get a single metadata value.
     */
    public function get(string $key)
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * Merge multiple metadata entries.
     */
    public function merge(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->meta[$key] = $value;
        }
    }

    /**
     * Generate a short description text from selected fields.
     */
    public function generateDescription(array $fields = []): string
    {
        if (empty($fields)) {
            $fields = ['site_name', 'tagline', 'keywords'];
        }

        $parts = [];
        foreach ($fields as $field) {
            if (isset($this->meta[$field]) && is_string($this->meta[$field]) && $this->meta[$field] !== '') {
                $parts[] = $this->meta[$field];
            }
        }

        return implode($this->separator, $parts);
    }

    /**
     * Get all metadata as array.
     */
    public function toArray(): array
    {
        return $this->meta;
    }

    /**
     * Return a safe HTML snippet for view rendering.
     */
    public function renderMetaTags(): string
    {
        $tags = '';
        if (isset($this->meta['title'])) {
            $tags .= '<title>' . htmlspecialchars($this->meta['title'], ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
        }
        if (isset($this->meta['description'])) {
            $tags .= '<meta name="description" content="' . htmlspecialchars($this->meta['description'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }
        if (isset($this->meta['keywords'])) {
            $tags .= '<meta name="keywords" content="' . htmlspecialchars($this->meta['keywords'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }
        return $tags;
    }
}

// Example usage
$site = new SiteMeta();
$site->set('site_name', 'Official Pro HTH');
$site->set('tagline', 'Your trusted platform for hth solutions');
$site->set('keywords', 'hth, official, pro, platform');
$site->set('title', 'Official Pro HTH — hth services');
$site->set('description', 'Official Pro HTH provides professional hth services and solutions.');
$site->set('url', 'https://official-pro-hth.com');

echo $site->generateDescription(['site_name', 'tagline']);

$site->merge([
    'author' => 'HTH Team',
    'language' => 'en',
]);

echo "\n";
echo $site->renderMetaTags();