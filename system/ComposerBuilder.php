<?php

namespace Luminova;

class ComposerBuilder
{

    private static $projectFiles = [
        "/app",
        "/system",
        "/public",
        "/resources",
        ".env",
        "composer.json",
        "meta.config.json"
    ];
    
    private static $systemIgnoreFiles = [
        "/system/log",
        "/system/plugins/phpstan",
        "/system/plugins/bin/php-parse",
        "/system/plugins/bin/phpstan",
        "/system/plugins/bin/phpstan.phar",
        "/system/plugins/nikic",
        "/system/plugins/peterujah/php-functions",
        "/phpstan.includes.php",
        "/phpstan.neon",
        "/builder.phar",
        "/command.phar",
        "/composer.lock",
        "/LICENSE",
        "/README.md",
        "/.DS_Store"
    ];

    private static $projectIgnoreFiles = [
        "composer.lock",
        "LICENSE",
        "LICENSE.txt",
        "LICENSE.md",
        "README",
        "README.md",
        "README.txt",
        ".DS_Store",
        ".fleet",
        ".idea",
        ".vscode",
        ".git"
    ];

    public static function zipProjectFolder($zipFileName)
    {
        self::$systemIgnoreFiles[] = $zipFileName;
        $zip = new \ZipArchive();
        try {
            if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \Exception("Error creating zip file.");
                echo "Error creating project archive file.\n";
                die(0);
            }

            echo "Creating a zip archive for the project...\n";
            self::addToZip($zip, '.', '');
            echo "Archiving project...\n";
            $zip->close();

            echo "Project archive exported successfully: $zipFileName\n";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    private static function addToZip($zip, $folder, $zipFolder)
    {
        echo "Scanning folder: $folder\n";
        $files = scandir($folder);

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $filePath = $folder . '/' . $file;
            $relativePath = $zipFolder . '/' . $file;
            //$relativePath = $zipFolder === '' ? $file : $zipFolder . '/' . $file; 
            echo "Processing: $filePath\n";
            if (is_dir($filePath)) {
                if (self::shouldBeIncluded($relativePath) && !self::shouldBeIgnored($relativePath)) {
                    echo "Adding directory: " . basename($relativePath) . "\n";
                    $zip->addEmptyDir($relativePath);
                    self::addToZip($zip, $filePath, $relativePath);
                } else {
                    echo "Skipping folder: " . basename($relativePath) . "\n";
                }
            } else {
                if (!self::shouldBeIgnored($relativePath) && !self::shouldBeSkipped(basename($relativePath))) {
                    echo "Adding file: " . basename($relativePath) . "\n";
                    $zip->addFile($filePath, $relativePath);
                } else {
                    echo "Skipping file: " . basename($relativePath) . "\n";
                }
            }

        }
    }

    private static function shouldBeIncluded($path)
    {
        foreach (self::$projectFiles as $projectFile) {
            if (fnmatch($projectFile, $path) || self::isParentOrEqual($projectFile, $path) ) {
                return true;
            }
        }
        return false;
    }

    private static function shouldBeIgnored($path)
    {
        foreach (self::$systemIgnoreFiles as $ignoreFile) {
            if (fnmatch($ignoreFile, $path)) {
                return true;
            }
        }
        return false;
    }

    private static function shouldBeSkipped($path)
    {
        foreach (self::$projectIgnoreFiles as $skipFile) {
            if (fnmatch(strtolower($skipFile), strtolower($path))) {
                return true;
            }
        }
        return false;
    }

    private static function isParentOrEqual($path1, $path2) {
        $parts1 = explode('/', trim($path1, '/'));
        $parts2 = explode('/', trim($path2, '/'));
        $minLength = min(count($parts1), count($parts2));
        for ($i = 0; $i < $minLength; $i++) {
            if ($parts1[$i] !== $parts2[$i]) {
                return false;
            }
        }
        return true; 
    }
}
