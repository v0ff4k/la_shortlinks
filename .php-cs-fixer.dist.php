<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@auto' => true,
        'ordered_traits' => false, // not resort traits !
        '@auto:risky' => true
    ])
    //  by default, Fixer looks for `*.php` files excluding `./vendor/` - here, you can groom this config
    ->setFinder(
        (new Finder())
            //  root folder to check
            ->in(__DIR__)
            //  additional files, eg bin entry file
            // ->append([__DIR__.'/bin-entry-file'])
            //  folders to exclude, if any
            ->exclude(['vendor', 'docker', '.git', 'storage', 'public', 'bootstrap/cache'])
            //  path patterns to exclude, if any
            // ->notPath([/* ... */])
            //  extra configs
            // ->ignoreDotFiles(false) // true by default in v3, false in v4 or future mode
            ->ignoreVCS(true) // true by default
    )
;
