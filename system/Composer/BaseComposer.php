<?php

namespace Luminova\Composer;
use Luminova\Config\BaseConfig;
class BaseComposer extends BaseConfig
{
    public static function progress(int $totalSteps, callable $taskCallback, ?callable $onCompleteCallback, string $completionMessage): void
    {
        $results = [];
        //$total = 0;
        
        for ($step = 1; $step <= $totalSteps; $step++) {
            $result = $taskCallback($step);
            $results[] = $result;
            $progressMessage = "Processing... Step $step/$totalSteps";
            echo "\r" . str_pad($progressMessage, 80, " ") . "\r";
            flush();
            //$total++;
        }
        
        sleep(1);
        
        echo "\033[32m$completionMessage\033[0m\n";
        //echo "Build operations: $total copied\n";
        
        if ($onCompleteCallback !== null) {
            $onCompleteCallback($results[0], $results);
        }
    }


    public static function parseLocation($path){
        //&& is_dir($path)
        if ($path != null ) {
            $path = ltrim($path, ".");
        }
        return $path;
    }

    public static function isParentOrEqual(string $path1, string $path2): bool
    {
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