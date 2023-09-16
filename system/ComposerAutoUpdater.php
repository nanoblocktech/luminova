<?php 
namespace Luminova;
class ComposerAutoUpdater{

    public static function updateFiles() {
        self::checkAndCopyFile('.env', 'samples/.env');
        self::checkAndCopyFile('meta.config.json', 'samples/meta.config.json');
        self::checkAndCopyFile('app/Controllers/Config.php', 'samples/Config.php');
        self::checkAndCopyFile('app/Controllers/Func.php', 'samples/Func.php');
        self::checkAndCopyFile('system/autoload.api.php', 'samples/autoload.api.php');
        self::checkAndCopyFile('public/index.php', 'samples/index.php');
        self::checkAndCopyFile('public/.htaccess', 'samples/.htaccess');
        self::checkAndCopyFile('public/robots.txt', 'samples/robots.txt');
        self::checkAndCopyDirectory('public/api/', 'samples/api/');
        self::checkAndCreateDirectory('public/assets/');
    }

    private static function checkAndCopyFile($destination, $source)
    {
        if (!file_exists($destination)) {
            copy($source, $destination);
            echo "Copied: $source to $destination\n";
        }
    }

    private static function checkAndCopyDirectory($destination, $source)
    {
        if (!is_dir($destination)) {
            mkdir($destination);
            echo "Created directory: $destination\n";
        }

        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $srcFile = "$source/$file";
                $dstFile = "$destination/$file";
                if (!file_exists($dstFile)) {
                    copy($srcFile, $dstFile);
                    echo "Copied: $srcFile to $dstFile\n";
                }
            }
        }
    }

    private static function checkAndCreateDirectory($directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory);
            echo "Created directory: $directory\n";
        }
    }
}
