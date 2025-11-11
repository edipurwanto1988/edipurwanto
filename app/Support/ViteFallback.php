<?php

namespace App\Support;

use Illuminate\Support\Facades\Vite;
use Illuminate\Foundation\ViteManifestNotFoundException;

class ViteFallback
{
    /**
     * Render Vite assets with fallback when manifest is not found
     */
    public static function render($entrypoints = ['resources/css/app.css', 'resources/js/app.js'])
    {
        try {
            // Try to use Vite normally
            return Vite::withEntryPoints($entrypoints)->toHtml();
        } catch (ViteManifestNotFoundException $e) {
            // Fallback to basic asset URLs when manifest is not found
            return self::generateFallbackHtml($entrypoints);
        } catch (\Exception $e) {
            // Handle any other Vite-related errors
            return self::generateFallbackHtml($entrypoints);
        }
    }

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
        } catch (\Exception $e) {
            // Handle any other Vite-related errors
            return self::generateFallbackUrls($entrypoints);
        }
    }

    /**
     * Generate fallback HTML when manifest is not available
     */
    protected static function generateFallbackHtml($entrypoints)
    {
        $html = '';
        
        foreach ($entrypoints as $entrypoint) {
            // Try to use mix() first, then fallback to asset()
            try {
                $url = mix($entrypoint, 'public');
            } catch (\Exception $e) {
                $url = asset($entrypoint);
            }
            
            if (str_ends_with($entrypoint, '.css')) {
                $html .= '<link rel="stylesheet" href="' . $url . '">' . "\n";
            } elseif (str_ends_with($entrypoint, '.js')) {
                $html .= '<script src="' . $url . '"></script>' . "\n";
            }
        }
        
        return $html;
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
                try {
                    $urls[$entrypoint] = mix($entrypoint, 'public');
                } catch (\Exception $e) {
                    $urls[$entrypoint] = asset($entrypoint);
                }
            } elseif (str_ends_with($entrypoint, '.js')) {
                try {
                    $urls[$entrypoint] = mix($entrypoint, 'public');
                } catch (\Exception $e) {
                    $urls[$entrypoint] = asset($entrypoint);
                }
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
                // Return fallback HTML
                return self::generateFallbackHtml(['resources/css/app.css', 'resources/js/app.js']);
            } catch (\Exception $e) {
                // Return fallback HTML for any other error
                return self::generateFallbackHtml(['resources/css/app.css', 'resources/js/app.js']);
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