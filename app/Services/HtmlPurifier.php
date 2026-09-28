<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

/** Sanitizes rich-text article HTML before it is rendered without escaping. */
class HtmlPurifier
{
    private const TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'h2', 'h3', 'h4', 'blockquote', 'pre', 'code',
        'ul', 'ol', 'li', 'a', 'img', 'table', 'thead', 'tbody',
        'tr', 'th', 'td', 'figure', 'figcaption', 'hr', 'span', 'div',
    ];

    private const DROP_WITH_CONTENT = [
        'script', 'style', 'iframe', 'object', 'embed', 'svg', 'math',
        'form', 'input', 'button', 'textarea', 'select', 'option',
        'video', 'audio', 'source', 'link', 'meta', 'template',
    ];

    private const ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'th' => ['colspan', 'rowspan'],
        'td' => ['colspan', 'rowspan'],
    ];

    public static function clean(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $previousErrorMode = libxml_use_internal_errors(true);
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->loadHTML(
            '<!doctype html><html><body><div id="fh-sanitizer-root">' . $html . '</div></body></html>',
            LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorMode);

        $root = $document->getElementById('fh-sanitizer-root');
        if (! $root) {
            return '';
        }

        self::sanitizeChildren($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return $clean;
    }

    private static function sanitizeChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $child) {
            if (! $child instanceof DOMElement) {
                if ($child->nodeType !== XML_TEXT_NODE) {
                    $parent->removeChild($child);
                }
                continue;
            }

            $tag = strtolower($child->tagName);
            if (! in_array($tag, self::TAGS, true)) {
                if (in_array($tag, self::DROP_WITH_CONTENT, true)) {
                    $parent->removeChild($child);
                    continue;
                }

                self::sanitizeChildren($child);
                while ($child->firstChild) {
                    $parent->insertBefore($child->firstChild, $child);
                }
                $parent->removeChild($child);
                continue;
            }

            self::sanitizeAttributes($child, $tag);
            self::sanitizeChildren($child);
        }
    }

    private static function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowed = self::ATTRIBUTES[$tag] ?? [];
        if ($element->hasAttribute('class')) {
            $allowed[] = 'class';
        }

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->name);
            $value = trim($attribute->value);

            if (! in_array($name, $allowed, true)) {
                $element->removeAttributeNode($attribute);
                continue;
            }

            if (in_array($name, ['href', 'src'], true) && ! self::isSafeUrl($value, $tag === 'img')) {
                $element->removeAttribute($name);
                continue;
            }

            if (in_array($name, ['width', 'height', 'colspan', 'rowspan'], true)
                && ! preg_match('/^\d{1,4}$/', $value)) {
                $element->removeAttribute($name);
            }
        }

        if ($tag === 'a' && strtolower($element->getAttribute('target')) === '_blank') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function isSafeUrl(string $url, bool $image): bool
    {
        if ($url === '' || preg_match('/[\x00-\x20]/', $url)) {
            return false;
        }

        if (str_starts_with($url, '//') || str_starts_with($url, '/')
            || str_starts_with($url, '#') || str_starts_with($url, './')
            || str_starts_with($url, '../')) {
            return true;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        return $image
            ? in_array($scheme, ['http', 'https'], true)
            : in_array($scheme, ['http', 'https', 'mailto', 'tel'], true);
    }
}
