<?php
/**
 * Site Meta Information
 * 
 * Provides a structured way to store and retrieve site metadata,
 * including the ability to generate short description text.
 */

class SiteMeta
{
    private array $metaData;

    public function __construct(array $config = [])
    {
        $defaults = [
            'site_name' => '乐鱼体育',
            'domain' => 'https://m-online-leyu.com.cn',
            'title' => '乐鱼体育 - 官方平台',
            'description' => '乐鱼体育提供最新体育赛事资讯与娱乐服务',
            'keywords' => ['乐鱼体育', '体育赛事', '在线娱乐'],
            'author' => '乐鱼体育团队',
            'locale' => 'zh_CN',
            'theme_color' => '#1a73e8',
        ];

        $this->metaData = array_merge($defaults, $config);
    }

    /**
     * Get a specific meta field.
     */
    public function get(string $key, $default = null)
    {
        return $this->metaData[$key] ?? $default;
    }

    /**
     * Generate a short description text from meta data.
     */
    public function generateShortDescription(int $maxLength = 120): string
    {
        $parts = [];

        $siteName = $this->metaData['site_name'] ?? '';
        $description = $this->metaData['description'] ?? '';
        $domain = $this->metaData['domain'] ?? '';

        if ($siteName) {
            $parts[] = $siteName;
        }

        if ($description) {
            $parts[] = $description;
        }

        if ($domain) {
            $parts[] = '官网：' . $domain;
        }

        $text = implode(' - ', $parts);

        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength - 3) . '...';
        }

        return $text;
    }

    /**
     * Get all meta data as array.
     */
    public function toArray(): array
    {
        return $this->metaData;
    }

    /**
     * Render HTML meta tags.
     */
    public function renderMetaTags(): string
    {
        $html = '';

        if (!empty($this->metaData['title'])) {
            $html .= '<title>' . htmlspecialchars($this->metaData['title'], ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
        }

        if (!empty($this->metaData['description'])) {
            $html .= '<meta name="description" content="' . htmlspecialchars($this->metaData['description'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }

        if (!empty($this->metaData['keywords'])) {
            $keywords = is_array($this->metaData['keywords']) ? implode(',', $this->metaData['keywords']) : $this->metaData['keywords'];
            $html .= '<meta name="keywords" content="' . htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }

        if (!empty($this->metaData['author'])) {
            $html .= '<meta name="author" content="' . htmlspecialchars($this->metaData['author'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }

        if (!empty($this->metaData['locale'])) {
            $html .= '<meta http-equiv="Content-Language" content="' . htmlspecialchars($this->metaData['locale'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        }

        return $html;
    }
}

// ========== Example usage ==========

$siteConfig = [
    'site_name' => '乐鱼体育',
    'domain' => 'https://m-online-leyu.com.cn',
    'title' => '乐鱼体育 - 专业体育平台',
    'description' => '乐鱼体育为您提供丰富的体育赛事信息和娱乐体验',
    'keywords' => ['乐鱼体育', '体育资讯', '在线娱乐', '赛事直播'],
    'author' => '乐鱼体育运营团队',
];

$meta = new SiteMeta($siteConfig);

// Generate and output the short description
echo "Short Description:\n";
echo $meta->generateShortDescription(100) . "\n\n";

// Output all meta data
echo "Meta Data Array:\n";
print_r($meta->toArray());

// Example of rendering HTML meta tags
echo "\nHTML Meta Tags:\n";
echo $meta->renderMetaTags();