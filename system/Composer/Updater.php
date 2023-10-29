<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Composer;
class Updater{
    public static function updateFiles(): void {
        if (getenv('LM_DEBUG_MODE') === false) {
            self::checkAndCopyFile('.env', 'samples/.env');
            self::checkAndCopyFile('meta.config.json', 'samples/meta.config.json');
            self::checkAndCopyFile('app/Controllers/Config/Session.php', 'samples/Session.php');
            self::checkAndCopyFile('app/Controllers/Global.php', 'samples/Global.php');
            self::checkAndCopyFile('app/Controllers/Application.php', 'samples/Application.php');
           // self::checkAndCopyFile('system/autoload.api.php', 'samples/autoload.api.php');
           // self::checkAndCopyFile('public/index.php', 'samples/index.php');
            self::checkAndCopyFile('public/.htaccess', 'samples/.htaccess');
            self::checkAndCopyFile('public/robots.txt', 'samples/robots.txt');
           //self::checkAndCopyDirectory('public/api', 'samples/api');
           // self::checkAndCreateDirectory('public/assets/');
        }
    }

    public static function renameProjectRoot(): void {
        $composerJsonPath = __DIR__ . '/../composer.json';
        if(file_exists($composerJsonPath)){
            $projectDir = dirname(dirname(dirname($composerJsonPath)));
            $composerData = json_decode(file_get_contents($composerJsonPath), true);
            $projectDestination = dirname($projectDir) . "/my-project.com";
            if (isset($composerData['name'])) {
                list($vendor, $name) = explode("/", $composerData['name']);
                if ($name === basename($projectDir) && rename($projectDir, $projectDestination)){
                    echo "Renamed project directory to my-project.com\n";
                }
            }
        }
    }    
         

    public static function moveProjectToRoot(): void {
        $composerJsonPath = __DIR__ . '/../composer.json';
        if (file_exists($composerJsonPath)) {
            $composerData = json_decode(file_get_contents($composerJsonPath), true);
            if (!isset($composerData['name'])) {
                return;
            }
            $projectDir = dirname(dirname(dirname($composerJsonPath)));
            list($vendor, $name) = explode("/", $composerData['name']);
            if ($name === basename($projectDir)) {
                $documentRoot = basename(dirname(dirname(dirname(realpath(__DIR__)))));
                $projectDestination = dirname($projectDir);
                $projectDestinationName = basename($projectDestination);

                if ($projectDestinationName === $documentRoot) {

                    if(rename($projectDir, "{$projectDestination}/my-project.com")){
                        echo "Renamed project directory to my-project.com\n";
                    }
                }else{
                    self::checkAndMoveDirectory($projectDestination, $projectDir);
                }
            }
            
        }
    }

    private static function checkAndCopyFile(string $destination, string $source): void
    {
        if (!file_exists($destination)) {
            copy($source, $destination);
            echo "Copied: $source to $destination\n";
        }
    }

    private static function checkAndMoveDirectory(string $destination, string $source): void
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true); 
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

    private static function checkAndCopyDirectory(string $destination, string $source): void
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true); 
            echo "Created directory: $destination\n";
        }

        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $srcFile = "$source/$file";
                $dstFile = "$destination/$file";
                if (!is_dir($srcFile) && !file_exists($dstFile)) {
                    copy($srcFile, $dstFile);
                    echo "Copied: $srcFile to $dstFile\n";
                } else if(is_dir($srcFile)){
                    self::checkAndCopyDirectory($dstFile, $srcFile);
                }
            }
        }
    }



    private static function checkAndCreateDirectory(string $directory): void
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); 
            echo "Created directory: $directory\n";
        }
    }
}
