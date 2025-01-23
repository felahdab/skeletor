<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;

use App\Console\Commands\Utility\SkeletorGoogleFonts;

class SkeletorAdjustGoogleFontsUrlsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:adjust-google-fonts-urls-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Google Fonts urls in fonts.css to take into account the current instance and prefix';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourceDomains = [
            'https:\/\/pprod-ffast.intradef.gouv.fr',
            'http:\/\/localfanlab.el-ahdab.fr',
            'https:\/\/fanlab.el-ahdab.fr',
            'https:\/\/c2n.adalfantln.marine.defensecdd.gouv.fr',
            'https:\/\/pprod.c2n.adalfantln.marine.defensecdd.gouv.fr'
        ];

        foreach ($sourceDomains as $domain) {

            $googleFonts = new SkeletorGoogleFonts(
                filesystem: app()->make(FilesystemManager::class)->disk(config('google-fonts.disk')),
                path: config('google-fonts.path'),
                inline: config('google-fonts.inline'),
                fallback: config('google-fonts.fallback'),
                userAgent: config('google-fonts.user_agent'),
                fonts: config('google-fonts.fonts'),
                basedomain: $domain
            );

            $googleFonts->adjustUrls();
        }
    }
}
