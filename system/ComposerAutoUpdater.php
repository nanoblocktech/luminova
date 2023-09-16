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

    public static function moveProjectToRoot() {
        $composerJsonPath = __DIR__ . '/composer.json';
        if(file_exists($composerJsonPath)){
            $projectDir = dirname($composerJsonPath);
            $composerData = json_decode(file_get_contents($composerJsonPath), true);
        
            if (isset($composerData['name'])) {
                list($vendor, $name) = explode("/", $composerData['name']);
                if ($name === basename($projectDir)) {
                    self::checkAndMoveDirectory($projectDir, '../');
                }
            }
        }
    }    

    private static function checkAndCopyFile($destination, $source)
    {
        if (!file_exists($destination)) {
            copy($source, $destination);
            echo "Copied: $source to $destination\n";
        }
    }

    private static function checkAndMoveDirectory($destination, $source)
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
                if (!is_dir($srcFile)) {
                    rename($srcFile, $dstFile);
                    echo "Moved: $srcFile to $dstFile\n";
                } else {
                    self::checkAndMoveDirectory($dstFile, $srcFile); 
                }
            }
        }

        rmdir($source);
        echo "Removed directory: $source\n";
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
                if (!is_dir($srcFile)) {
                    copy($srcFile, $dstFile);
                    echo "Copied: $srcFile to $dstFile\n";
                } else {
                    self::checkAndCopyDirectory($dstFile, $srcFile);
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
