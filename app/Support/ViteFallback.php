<?php

namespace App\Support;

use Illuminate\Support\Facades\Vite;
use Illuminate\Foundation\ViteManifestNotFoundException;

class ViteFallback
{
    /**
     * Generate Vite assets with fallback when manifest is not found
     */
    public static function withFallback($entrypoints = ['resources/css/app.css', 'resources/js/app.js'])
    {
        try {
            // Try to use Vite normally
            return Vite::withEntryPoints($entrypoints);
        } catch (ViteManifestNotFoundException $e) {
            // Fallback to basic asset URLs when manifest is not found
            return self::generateFallbackUrls($entrypoints);
        }
    }

    /**
     * Generate fallback URLs when manifest is not available
     */
    protected static function generateFallbackUrls($entrypoints)
    {
        $urls = [];
        
        foreach ($entrypoints as $entrypoint) {
            $filename = pathinfo($entrypoint, PATHINFO_FILENAME);
            
            // Generate predictable filenames based on entrypoint
            if (str_ends_with($entrypoint, '.css')) {
                $urls[$entrypoint] = mix($entrypoint, 'public');
            } elseif (str_ends_with($entrypoint, '.js')) {
                $urls[$entrypoint] = mix($entrypoint, 'public');
            } else {
                $urls[$entrypoint] = asset($entrypoint);
            }
        }
        
        return (object) [
            'asset' => function ($path) use ($urls) {
                return $urls[$path] ?? asset($path);
            },
            'when' => function ($callback) {
                return $this;
            },
            'useBuild' => function () {
                return $this;
            },
            'withEntryPoints' => function ($entrypoints) {
                return self::generateFallbackUrls($entrypoints);
            },
            'preloadAssets' => function () {
                return [];
            },
            'toHtml' => function () use ($urls) {
                $html = '';
                foreach ($urls as $path => $url) {
                    if (str_ends_with($path, '.css')) {
                        $html .= '<link rel="stylesheet" href="' . $url . '">';
                    } elseif (str_ends_with($path, '.js')) {
                        $html .= '<script src="' . $url . '"></script>';
                    }
                }
                return $html;
            },
            '__toString' => function () use ($urls) {
                return $this->toHtml();
            },
        ];
    }

    /**
     * Check if manifest exists
     */
    public static function manifestExists()
    {
        try {
            Vite::withEntryPoints(['resources/js/app.js']);
            return true;
        } catch (ViteManifestNotFoundException $e) {
            return false;
        }
    }

    /**
     * Create a new ViteFallback instance
     */
    public static function make()
    {
        return new self();
    }

    /**
     * Handle dynamic method calls to the fallback object
     */
    public function __call($method, $parameters)
    {
        if ($method === 'withEntryPoints') {
            return self::withFallback($parameters[0] ?? ['resources/css/app.css', 'resources/js/app.js']);
        }
        
        if ($method === 'toHtml') {
            try {
                // Try to use Vite normally
                return Vite::withEntryPoints(['resources/css/app.css', 'resources/js/app.js'])->toHtml();
            } catch (ViteManifestNotFoundException $e) {
                // Return empty string as fallback
                return '';
            }
        }
        
        return $this;
    }

    /**
     * Generate manifest file if it doesn't exist
     */
    public static function generateManifest()
    {
        $manifestPath = public_path('build/manifest.json');
        
        if (!file_exists($manifestPath)) {
            $manifest = [
                'resources/css/app.css' => [
                    'file' => 'assets/app.css',
                    'src' => 'resources/css/app.css',
                    'isEntry' => true,
                    'name' => 'app',
                    'names' => ['app.css']
                ],
                'resources/js/app.js' => [
                    'file' => 'assets/app.js',
                    'src' => 'resources/js/app.js',
                    'isEntry' => true,
                    'name' => 'app'
                ]
            ];
            
            file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            
            return true;
        }
        
        return false;
    }
}