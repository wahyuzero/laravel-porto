<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateOgImage extends Command
{
    protected $signature = 'og:generate';
    protected $description = 'Generate OG image (social preview) for the site';

    public function handle(): int
    {
        $width = 1200;
        $height = 630;

        $img = imagecreatetruecolor($width, $height);

        // Colors
        $bgColor = imagecolorallocate($img, 13, 17, 23);       // #0d1117
        $greenColor = imagecolorallocate($img, 63, 185, 80);    // #3fb950
        $grayColor = imagecolorallocate($img, 139, 148, 158);   // #8b949e
        $blueColor = imagecolorallocate($img, 88, 166, 255);    // #58a6ff
        $borderColor = imagecolorallocate($img, 48, 54, 61);    // #30363d
        $barColor = imagecolorallocate($img, 33, 38, 45);       // #21262d
        $white = imagecolorallocate($img, 201, 209, 217);       // #c9d1d9
        $redDot = imagecolorallocate($img, 248, 81, 73);
        $yellowDot = imagecolorallocate($img, 210, 153, 34);
        $greenDot = imagecolorallocate($img, 63, 185, 80);

        // Background
        imagefilledrectangle($img, 0, 0, $width, $height, $bgColor);

        // Border
        imagerectangle($img, 20, 20, $width - 20, $height - 20, $borderColor);

        // Terminal bar
        imagefilledrectangle($img, 20, 20, $width - 20, 60, $barColor);
        imagefilledellipse($img, 50, 40, 12, 12, $redDot);
        imagefilledellipse($img, 72, 40, 12, 12, $yellowDot);
        imagefilledellipse($img, 94, 40, 12, 12, $greenDot);

        // Use default font (GD built-in)
        $font = 5; // largest built-in font

        // Terminal title
        $title = 'frugaldev - bash - 80x24';
        $titleX = ($width - strlen($title) * imagefontwidth($font)) / 2;
        imagestring($img, $font, (int) $titleX, 32, $title, $grayColor);

        // Prompt
        imagestring($img, $font, 60, 120, 'visitor@frugaldev:~$ cat README.md', $grayColor);

        // Main title - FrugalDev (large, using multiple lines of font 5)
        $mainTitle = 'FrugalDev';
        // Draw larger text by scaling
        $bigImg = imagecreatetruecolor(strlen($mainTitle) * imagefontwidth($font), imagefontheight($font));
        imagefill($bigImg, 0, 0, $bgColor);
        imagestring($bigImg, $font, 0, 0, $mainTitle, $greenColor);
        $scaledW = strlen($mainTitle) * imagefontwidth($font) * 5;
        $scaledH = imagefontheight($font) * 5;
        $destX = ($width - $scaledW) / 2;
        imagecopyresized($img, $bigImg, (int) $destX, 180, 0, 0, $scaledW, $scaledH, imagesx($bigImg), imagesy($bigImg));
        imagedestroy($bigImg);

        // Tagline
        $tagline = 'Build more. Bloat less.';
        $tagX = ($width - strlen($tagline) * imagefontwidth($font)) / 2;
        imagestring($img, $font, (int) $tagX, 320, $tagline, $grayColor);

        // Separator line
        imageline($img, 300, 370, 900, 370, $borderColor);

        // Description
        $desc = 'Full Stack Developer Portfolio';
        $descX = ($width - strlen($desc) * imagefontwidth($font)) / 2;
        imagestring($img, $font, (int) $descX, 400, $desc, $blueColor);

        // Tech tags
        $tags = ['Laravel', 'PHP', 'SQLite', 'Docker', 'Linux', 'JS', 'Python'];
        $tagStartX = ($width - count($tags) * 90) / 2;
        foreach ($tags as $i => $tag) {
            $tx = (int) $tagStartX + $i * 90;
            imagerectangle($img, $tx, 450, $tx + 80, 478, $blueColor);
            $ttx = $tx + (80 - strlen($tag) * imagefontwidth(3)) / 2;
            imagestring($img, 3, (int) $ttx, 457, $tag, $blueColor);
        }

        // Bottom prompt with cursor
        imagestring($img, $font, 60, 540, 'visitor@frugaldev:~$ _', $grayColor);

        // Save
        $path = public_path('img/og-image.png');
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        imagepng($img, $path);
        imagedestroy($img);

        $this->info("OG image generated: {$path}");
        return 0;
    }
}
