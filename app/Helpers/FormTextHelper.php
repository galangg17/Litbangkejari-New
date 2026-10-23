<?php

namespace App\Helpers;

class FormTextHelper
{
    /**
     * Parse and render safe rich text: bold, italic, underline, and line breaks.
     * Prevents XSS by escaping HTML entities first, then converting only allowed formatting.
     */
    public static function format(?string $text): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        // 1. Escape all raw input to prevent script injection / XSS
        $safe = e($text);

        // 2. Convert allowed escaped HTML tags
        // Bold: <b> and <strong>
        $safe = preg_replace('/&lt;b&gt;(.*?)&lt;\/b&gt;/is', '<strong>$1</strong>', $safe);
        $safe = preg_replace('/&lt;strong&gt;(.*?)&lt;\/strong&gt;/is', '<strong>$1</strong>', $safe);

        // Italic: <i> and <em>
        $safe = preg_replace('/&lt;i&gt;(.*?)&lt;\/i&gt;/is', '<em>$1</em>', $safe);
        $safe = preg_replace('/&lt;em&gt;(.*?)&lt;\/em&gt;/is', '<em>$1</em>', $safe);

        // Underline: <u>
        $safe = preg_replace('/&lt;u&gt;(.*?)&lt;\/u&gt;/is', '<span style="text-decoration: underline;">$1</span>', $safe);

        // 3. Convert markdown shortcuts
        // **bold**
        $safe = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $safe);
        // *italic*
        $safe = preg_replace('/(?<!\*)\*(?!\*)(.*?)(?<!\*)\*(?!\*)/s', '<em>$1</em>', $safe);
        // __underline__
        $safe = preg_replace('/__(.*?)__/s', '<span style="text-decoration: underline;">$1</span>', $safe);

        // 4. Convert newlines to <br>
        $safe = nl2br($safe);

        return $safe;
    }
}
