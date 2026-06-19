<?php

/**
 * SiteMetaManager - A simple utility to manage site metadata and generate descriptions.
 *
 * This file contains a static configuration array with sample site metadata,
 * a helper function to generate a short description text, and a demonstration
 * of usage.
 *
 * The example data is for illustrative purposes only.
 *
 * @package SitePortal
 */

namespace SitePortal\Utils;

class SiteMetaManager
{
    /**
     * Default metadata array.
     *
     * @var array
     */
    private static $defaultMeta = [
        'site_name' => 'SitePortal I Game',
        'domain'    => 'https://siteportal-i-game.com.cn',
        'keywords'  => ['爱游戏', '游戏门户', '资讯', '评测'],
        'author'    => 'Portal Team',
        'version'   => '1.2.0',
        'locale'    => 'zh_CN',
    ];

    /**
     * Generate a short description based on the metadata array.
     *
     * @param array $meta Optional metadata array; uses self::$defaultMeta if omitted.
     * @return string Short description text.
     */
    public static function generateDescription(array $meta = []): string
    {
        if (empty($meta)) {
            $meta = self::$defaultMeta;
        }

        // Safely extract values with fallbacks.
        $siteName   = htmlspecialchars($meta['site_name'] ?? 'Unknown Site', ENT_QUOTES, 'UTF-8');
        $domain     = htmlspecialchars($meta['domain'] ?? '', ENT_QUOTES, 'UTF-8');
        $keywords   = $meta['keywords'] ?? [];
        $keywordStr = !empty($keywords) ? implode(', ', array_map(function($kw) {
            return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
        }, $keywords)) : '';

        // Build a concise description.
        $description = sprintf(
            '%s – 专注%s, 提供最新游戏资讯与评测。访问 %s 了解更多。',
            $siteName,
            $keywordStr,
            $domain
        );

        return $description;
    }

    /**
     * Retrieve the default metadata array.
     *
     * @return array
     */
    public static function getDefaultMeta(): array
    {
        return self::$defaultMeta;
    }

    /**
     * Update the default metadata (for runtime customization).
     *
     * @param array $newMeta Partial or full metadata to merge.
     * @return void
     */
    public static function setDefaultMeta(array $newMeta): void
    {
        self::$defaultMeta = array_merge(self::$defaultMeta, $newMeta);
    }

    /**
     * Create a formatted summary string from metadata.
     *
     * @param array $meta Metadata array.
     * @return string Formatted summary.
     */
    public static function formatMetaSummary(array $meta): string
    {
        $parts = [];
        foreach ($meta as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $parts[] = htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ': ' .
                       htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
        }
        return implode(' | ', $parts);
    }
}

// --- Example usage (for demonstration) ---

// 1. Use default metadata to generate a description
$description = SiteMetaManager::generateDescription();
echo "Default Description:\n";
echo $description . "\n\n";

// 2. Custom metadata example
$customMeta = [
    'site_name' => '我爱游戏平台',
    'domain'    => 'https://siteportal-i-game.com.cn',
    'keywords'  => ['爱游戏', '手游', '端游', '攻略'],
    'author'    => 'GameLover',
    'version'   => '2.0.0',
    'locale'    => 'zh_CN',
];

$customDescription = SiteMetaManager::generateDescription($customMeta);
echo "Custom Description:\n";
echo $customDescription . "\n\n";

// 3. Show formatted summary of default meta
echo "Formatted Default Meta Summary:\n";
echo SiteMetaManager::formatMetaSummary(SiteMetaManager::getDefaultMeta()) . "\n";