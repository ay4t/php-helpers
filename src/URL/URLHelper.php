<?php

namespace Ay4t\Helper\URL;

/**
 * URL Helper Class
 * Provides various URL manipulation and validation methods
 * 
 * @package Ay4t\Helper\URL
 * @author Ayatulloh Ahad R
 */
class URLHelper implements \Ay4t\Helper\Interface\FormatterInterface
{
    /** @var string */
    private $url;

    /** @var array */
    private $components;

    /**
     * Set the URL to be processed
     * 
     * @param string $url
     * @return self
     */
    public function set(string $url)
    {
        $this->url = $url;
        $this->components = parse_url($url);
        return $this;
    }

    /**
     * Check if URL is valid
     * 
     * @param bool $strict Use stricter validation
     * @return bool
     */
    public function isValid(bool $strict = false): bool
    {
        if ($strict) {
            return filter_var($this->url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) !== false;
        }
        
        return filter_var($this->url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Get specific component of the URL
     * 
     * @param string $component Component name (scheme, host, port, user, pass, path, query, fragment)
     * @return string|null
     */
    public function getComponent(string $component)
    {
        return $this->components[$component] ?? null;
    }

    /**
     * Get all URL components
     * 
     * @return array
     */
    public function getAllComponents(): array
    {
        return $this->components;
    }

    /**
     * Add or update query parameters
     * 
     * @param array $params Parameters to add/update
     * @return string
     */
    public function addQueryParams(array $params): string
    {
        $query = [];
        
        // Parse existing query string
        if (isset($this->components['query'])) {
            parse_str($this->components['query'], $query);
        }
        
        // Merge with new params
        $query = array_merge($query, $params);
        
        // Rebuild URL
        return $this->buildUrl(['query' => http_build_query($query)]);
    }

    /**
     * Remove query parameters
     * 
     * @param array $params Parameters to remove
     * @return string
     */
    public function removeQueryParams(array $params): string
    {
        if (!isset($this->components['query'])) {
            return $this->url;
        }

        parse_str($this->components['query'], $query);
        
        foreach ($params as $param) {
            unset($query[$param]);
        }

        return $this->buildUrl(['query' => empty($query) ? null : http_build_query($query)]);
    }

    /**
     * Get query parameters as array
     * 
     * @return array
     */
    public function getQueryParams(): array
    {
        if (!isset($this->components['query'])) {
            return [];
        }

        parse_str($this->components['query'], $params);
        return $params;
    }

    /**
     * Check if URL is HTTPS
     * 
     * @return bool
     */
    public function isHttps(): bool
    {
        return isset($this->components['scheme']) && 
               strtolower($this->components['scheme']) === 'https';
    }

    /**
     * Convert to HTTPS
     * 
     * @return string
     */
    public function toHttps(): string
    {
        return $this->buildUrl(['scheme' => 'https']);
    }

    /**
     * Convert to HTTP
     * 
     * @return string
     */
    public function toHttp(): string
    {
        return $this->buildUrl(['scheme' => 'http']);
    }

    /**
     * Get domain without subdomain
     * 
     * @return string|null
     */
    public function getDomain()
    {
        if (!isset($this->components['host'])) {
            return null;
        }

        $parts = explode('.', $this->components['host']);
        
        if (count($parts) >= 2) {
            return implode('.', array_slice($parts, -2));
        }

        return $this->components['host'];
    }

    /**
     * Get subdomain
     * 
     * @return string|null
     */
    public function getSubdomain()
    {
        if (!isset($this->components['host'])) {
            return null;
        }

        $parts = explode('.', $this->components['host']);
        
        if (count($parts) > 2) {
            return implode('.', array_slice($parts, 0, -2));
        }

        return null;
    }

    /**
     * Normalize URL
     * 
     * @return string
     */
    public function normalize(): string
    {
        // Remove default ports
        if (isset($this->components['port'])) {
            if (($this->components['scheme'] === 'http' && $this->components['port'] === 80) ||
                ($this->components['scheme'] === 'https' && $this->components['port'] === 443)) {
                unset($this->components['port']);
            }
        }

        // Ensure path starts with /
        if (isset($this->components['path'])) {
            $this->components['path'] = '/' . ltrim($this->components['path'], '/');
        }

        return $this->buildUrl();
    }

    /**
     * Check if URL is relative
     * 
     * @return bool
     */
    public function isRelative(): bool
    {
        return !isset($this->components['scheme']) && 
               !isset($this->components['host']);
    }

    /**
     * Make URL absolute
     * 
     * @param string $baseUrl Base URL to use
     * @return string
     */
    public function makeAbsolute(string $baseUrl): string
    {
        if (!$this->isRelative()) {
            return $this->url;
        }

        $base = new self();
        $base->set($baseUrl);
        $baseComponents = $base->getAllComponents();

        // Start with base components
        $absolute = $baseComponents;

        // Add path
        if (isset($this->components['path'])) {
            if (isset($baseComponents['path'])) {
                $absolute['path'] = dirname($baseComponents['path']) . '/' . ltrim($this->components['path'], '/');
            } else {
                $absolute['path'] = $this->components['path'];
            }
        }

        // Add query and fragment
        if (isset($this->components['query'])) {
            $absolute['query'] = $this->components['query'];
        }
        if (isset($this->components['fragment'])) {
            $absolute['fragment'] = $this->components['fragment'];
        }

        return $this->buildUrl($absolute);
    }

    /**
     * Build URL from components
     * 
     * @param array $components Optional components to override
     * @return string
     */
    private function buildUrl(array $components = []): string
    {
        $final = array_merge($this->components, $components);
        
        $url = '';
        
        if (isset($final['scheme'])) {
            $url .= $final['scheme'] . '://';
        }
        
        if (isset($final['user'])) {
            $url .= $final['user'];
            if (isset($final['pass'])) {
                $url .= ':' . $final['pass'];
            }
            $url .= '@';
        }
        
        if (isset($final['host'])) {
            $url .= $final['host'];
        }
        
        if (isset($final['port'])) {
            $url .= ':' . $final['port'];
        }
        
        if (isset($final['path'])) {
            $url .= $final['path'];
        }
        
        if (isset($final['query'])) {
            $url .= '?' . $final['query'];
        }
        
        if (isset($final['fragment'])) {
            $url .= '#' . $final['fragment'];
        }
        
        return $url;
    }
}
