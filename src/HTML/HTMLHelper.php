<?php

namespace Ay4t\Helper\HTML;

/**
 * HTML Helper Class
 * Provides methods for generating and manipulating HTML elements safely
 * 
 * @package Ay4t\Helper\HTML
 * @author Ayatulloh Ahad R
 */
class HTMLHelper implements \Ay4t\Helper\Interface\FormatterInterface
{
    /** @var array */
    private $attributes = [];

    /** @var string */
    private $content;

    /** @var array */
    private $voidElements = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
        'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];

    /**
     * Set the content to be processed
     * 
     * @param string $content
     * @return self
     */
    public function set($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set HTML attributes
     * 
     * @param array $attributes
     * @return self
     */
    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Create HTML element
     * 
     * @param string $tag HTML tag name
     * @param array $attributes Element attributes
     * @param string|null $content Element content
     * @return string
     */
    public function element(string $tag, array $attributes = [], string $content = null): string
    {
        $tag = strtolower($tag);
        
        // Merge with existing attributes
        $attributes = array_merge($this->attributes, $attributes);
        
        // Build attributes string
        $attributesStr = $this->buildAttributesString($attributes);
        
        // Use content parameter if provided, otherwise use internal content
        $content = $content ?? $this->content;
        
        // Handle void elements
        if (in_array($tag, $this->voidElements)) {
            return "<{$tag}{$attributesStr}>";
        }
        
        return "<{$tag}{$attributesStr}>" . $content . "</{$tag}>";
    }

    /**
     * Create link element
     * 
     * @param string $href URL
     * @param string|null $text Link text
     * @param array $attributes Additional attributes
     * @return string
     */
    public function link(string $href, ?string $text = null, array $attributes = []): string
    {
        $attributes['href'] = $href;
        return $this->element('a', $attributes, $text ?? $href);
    }

    /**
     * Create image element
     * 
     * @param string $src Image URL
     * @param string $alt Alt text
     * @param array $attributes Additional attributes
     * @return string
     */
    public function image(string $src, string $alt = '', array $attributes = []): string
    {
        return $this->element('img', array_merge([
            'src' => $src,
            'alt' => $alt
        ], $attributes));
    }

    /**
     * Create script element
     * 
     * @param string $src Script URL
     * @param array $attributes Additional attributes
     * @return string
     */
    public function script(string $src, array $attributes = []): string
    {
        return $this->element('script', array_merge([
            'src' => $src
        ], $attributes));
    }

    /**
     * Create style element
     * 
     * @param string $href Stylesheet URL
     * @param array $attributes Additional attributes
     * @return string
     */
    public function style(string $href, array $attributes = []): string
    {
        return $this->element('link', array_merge([
            'rel' => 'stylesheet',
            'href' => $href
        ], $attributes));
    }

    /**
     * Create meta tag
     * 
     * @param array $attributes Meta attributes
     * @return string
     */
    public function meta(array $attributes): string
    {
        return $this->element('meta', $attributes);
    }

    /**
     * Create form element
     * 
     * @param string $action Form action URL
     * @param string $method Form method
     * @param array $attributes Additional attributes
     * @return string
     */
    public function form(string $action, string $method = 'POST', array $attributes = []): string
    {
        return $this->element('form', array_merge([
            'action' => $action,
            'method' => strtoupper($method)
        ], $attributes), $this->content);
    }

    /**
     * Create input element
     * 
     * @param string $type Input type
     * @param string $name Input name
     * @param string $value Input value
     * @param array $attributes Additional attributes
     * @return string
     */
    public function input(string $type, string $name, string $value = '', array $attributes = []): string
    {
        return $this->element('input', array_merge([
            'type' => $type,
            'name' => $name,
            'value' => $value
        ], $attributes));
    }

    /**
     * Create select element
     * 
     * @param string $name Select name
     * @param array $options Select options [value => label]
     * @param string|array $selected Selected value(s)
     * @param array $attributes Additional attributes
     * @return string
     */
    public function select(string $name, array $options, $selected = '', array $attributes = []): string
    {
        $selected = (array)$selected;
        
        $optionsHtml = '';
        foreach ($options as $value => $label) {
            $optionAttributes = ['value' => $value];
            if (in_array($value, $selected)) {
                $optionAttributes['selected'] = 'selected';
            }
            $optionsHtml .= $this->element('option', $optionAttributes, $label);
        }
        
        return $this->element('select', array_merge([
            'name' => $name
        ], $attributes), $optionsHtml);
    }

    /**
     * Create textarea element
     * 
     * @param string $name Textarea name
     * @param string $value Textarea value
     * @param array $attributes Additional attributes
     * @return string
     */
    public function textarea(string $name, string $value = '', array $attributes = []): string
    {
        return $this->element('textarea', array_merge([
            'name' => $name
        ], $attributes), $value);
    }

    /**
     * Create button element
     * 
     * @param string $text Button text
     * @param string $type Button type
     * @param array $attributes Additional attributes
     * @return string
     */
    public function button(string $text, string $type = 'button', array $attributes = []): string
    {
        return $this->element('button', array_merge([
            'type' => $type
        ], $attributes), $text);
    }

    /**
     * Create table element
     * 
     * @param array $data Table data
     * @param array|null $headers Table headers
     * @param array $attributes Additional attributes
     * @return string
     */
    public function table(array $data, ?array $headers = null, array $attributes = []): string
    {
        $html = '';
        
        // Add headers if provided
        if ($headers !== null) {
            $headerHtml = '';
            foreach ($headers as $header) {
                $headerHtml .= $this->element('th', [], $header);
            }
            $html .= $this->element('tr', [], $headerHtml);
            $html = $this->element('thead', [], $html);
        }
        
        // Add data rows
        $bodyHtml = '';
        foreach ($data as $row) {
            $rowHtml = '';
            foreach ($row as $cell) {
                $rowHtml .= $this->element('td', [], $cell);
            }
            $bodyHtml .= $this->element('tr', [], $rowHtml);
        }
        $html .= $this->element('tbody', [], $bodyHtml);
        
        return $this->element('table', $attributes, $html);
    }

    /**
     * Escape HTML special characters
     * 
     * @param string $text Text to escape
     * @return string
     */
    public function escape(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Build HTML attributes string
     * 
     * @param array $attributes
     * @return string
     */
    private function buildAttributesString(array $attributes): string
    {
        $html = '';
        
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $html .= " {$key}";
            } elseif ($value !== false && $value !== null) {
                $html .= " {$key}=\"" . $this->escape($value) . "\"";
            }
        }
        
        return $html;
    }
}
