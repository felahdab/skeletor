<?php

namespace App\Console\Commands\Utility;

use Illuminate\Contracts\Filesystem\Filesystem;
use Spatie\GoogleFonts\GoogleFonts;
use Illuminate\Support\Str;

class SkeletorGoogleFonts extends GoogleFonts
{
    public function __construct(
        public Filesystem $filesystem,
        public string $path,
        public bool $inline,
        public bool $fallback,
        public string $userAgent,
        public array $fonts,
        public string $basedomain,
    ) {
    }

    protected function extractPprodFontUrls(string $css): array
    {
        $matches = [];
        $re = '/url\(('. $this->basedomain . '\/[^)]+)\)/';
        preg_match_all($re, $css, $matches);

        return $matches[1] ?? [];
    }

    public function adjustUrls()
    {
        foreach ($this->fonts as $url) {
            $css = $this->filesystem->get($this->path($url, 'fonts.css'));
            foreach ($this->extractPprodFontUrls($css) as $fontUrl) {
                $start = Str::before($fontUrl, '/public/');

                $newFontUrl = Str::replace(
                    $start,
                    env('APP_URL') . '/' . config('skeletor.prefixe_instance'),
                    $fontUrl
                );

                $css = Str::replace($fontUrl, $newFontUrl, $css);
            }

            $this->filesystem->put($this->path($url, 'fonts.css'), $css);
        }
    }
}
