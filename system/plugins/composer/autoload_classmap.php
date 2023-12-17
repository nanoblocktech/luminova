<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname(dirname($vendorDir));

return array(
    'App\\Controllers\\Application' => $baseDir . '/app/Controllers/Application.php',
    'App\\Controllers\\Command' => $baseDir . '/app/Controllers/Command.php',
    'App\\Controllers\\Config\\Session' => $baseDir . '/app/Controllers/Config/Session.php',
    'App\\Controllers\\Welcome' => $baseDir . '/app/Controllers/Welcome.php',
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Luminova\\Application\\Application' => $baseDir . '/system/Application/Application.php',
    'Luminova\\Arrays\\ArrayCountable' => $baseDir . '/system/Arrays/ArrayCountable.php',
    'Luminova\\Arrays\\ArrayInput' => $baseDir . '/system/Arrays/ArrayInput.php',
    'Luminova\\Arrays\\Arrays' => $baseDir . '/system/Arrays/Arrays.php',
    'Luminova\\Base\\BaseApplication' => $baseDir . '/system/Base/BaseApplication.php',
    'Luminova\\Base\\BaseCommand' => $baseDir . '/system/Base/BaseCommand.php',
    'Luminova\\Base\\BaseController' => $baseDir . '/system/Base/BaseController.php',
    'Luminova\\Base\\BaseModel' => $baseDir . '/system/Base/BaseModel.php',
    'Luminova\\Cache\\Cache' => $baseDir . '/system/Cache/Cache.php',
    'Luminova\\Cache\\Compress' => $baseDir . '/system/Cache/Compress.php',
    'Luminova\\Cache\\FileCacheItem' => $baseDir . '/system/Cache/FileCacheItem.php',
    'Luminova\\Cache\\FileSystemCache' => $baseDir . '/system/Cache/FileSystemCache.php',
    'Luminova\\Cache\\MemoryCache' => $baseDir . '/system/Cache/MemoryCache.php',
    'Luminova\\Cache\\Optimizer' => $baseDir . '/system/Cache/Optimizer.php',
    'Luminova\\Command\\Colors' => $baseDir . '/system/Command/Colors.php',
    'Luminova\\Command\\Commands' => $baseDir . '/system/Command/Commands.php',
    'Luminova\\Command\\Console' => $baseDir . '/system/Command/Console.php',
    'Luminova\\Command\\Terminal' => $baseDir . '/system/Command/Terminal.php',
    'Luminova\\Command\\TerminalGenerator' => $baseDir . '/system/Command/TerminalGenerator.php',
    'Luminova\\Command\\TextUtils' => $baseDir . '/system/Command/TextUtils.php',
    'Luminova\\Composer\\BaseComposer' => $baseDir . '/system/Composer/BaseComposer.php',
    'Luminova\\Composer\\Builder' => $baseDir . '/system/Composer/Builder.php',
    'Luminova\\Composer\\Updater' => $baseDir . '/system/Composer/Updater.php',
    'Luminova\\Config\\Configuration' => $baseDir . '/system/Config/Configuration.php',
    'Luminova\\Config\\Database' => $baseDir . '/system/Config/Database.php',
    'Luminova\\Config\\DotEnv' => $baseDir . '/system/Config/DotEnv.php',
    'Luminova\\Config\\PHPStanRules' => $baseDir . '/system/Config/PHPStanRules.php',
    'Luminova\\Config\\SystemPaths' => $baseDir . '/system/Config/SystemPaths.php',
    'Luminova\\Controllers\\Controller' => $baseDir . '/system/Controllers/Controller.php',
    'Luminova\\Database\\Columns' => $baseDir . '/system/Database/Columns.php',
    'Luminova\\Database\\Conn' => $baseDir . '/system/Database/Conn.php',
    'Luminova\\Database\\DatabaseInterface' => $baseDir . '/system/Database/DatabaseInterface.php',
    'Luminova\\Database\\Drivers\\MySqlDriver' => $baseDir . '/system/Database/Drivers/MySqlDriver.php',
    'Luminova\\Database\\Drivers\\PdoDriver' => $baseDir . '/system/Database/Drivers/PdoDriver.php',
    'Luminova\\Database\\Query' => $baseDir . '/system/Database/Query.php',
    'Luminova\\Email\\Mailer' => $baseDir . '/system/Email/Mailer.php',
    'Luminova\\Errors\\Codes' => $baseDir . '/system/Errors/Codes.php',
    'Luminova\\Exceptions\\AppException' => $baseDir . '/system/Exceptions/AppException.php',
    'Luminova\\Exceptions\\ClassException' => $baseDir . '/system/Exceptions/ClassException.php',
    'Luminova\\Exceptions\\DatabaseException' => $baseDir . '/system/Exceptions/DatabaseException.php',
    'Luminova\\Exceptions\\ErrorException' => $baseDir . '/system/Exceptions/ErrorException.php',
    'Luminova\\Exceptions\\FileException' => $baseDir . '/system/Exceptions/FileException.php',
    'Luminova\\Exceptions\\InvalidException' => $baseDir . '/system/Exceptions/InvalidException.php',
    'Luminova\\Exceptions\\InvalidObjectException' => $baseDir . '/system/Exceptions/InvalidObjectException.php',
    'Luminova\\Exceptions\\LuminovaException' => $baseDir . '/system/Exceptions/LuminovaException.php',
    'Luminova\\Exceptions\\NotFoundException' => $baseDir . '/system/Exceptions/NotFoundException.php',
    'Luminova\\Exceptions\\RuntimeException' => $baseDir . '/system/Exceptions/RuntimeException.php',
    'Luminova\\Exceptions\\ValidationException' => $baseDir . '/system/Exceptions/ValidationException.php',
    'Luminova\\Exceptions\\ViewNotFoundException' => $baseDir . '/system/Exceptions/ViewNotFoundException.php',
    'Luminova\\Functions\\Functions' => $baseDir . '/system/Functions/Functions.php',
    'Luminova\\Http\\AsyncClientInterface' => $baseDir . '/system/Http/AsyncClientInterface.php',
    'Luminova\\Http\\Client\\Curl' => $baseDir . '/system/Http/Client/Curl.php',
    'Luminova\\Http\\Client\\Guzzle' => $baseDir . '/system/Http/Client/Guzzle.php',
    'Luminova\\Http\\CurlAsyncClient' => $baseDir . '/system/Http/CurlAsyncClient.php',
    'Luminova\\Http\\GuzzleAsyncClient' => $baseDir . '/system/Http/GuzzleAsyncClient.php',
    'Luminova\\Http\\Header' => $baseDir . '/system/Http/Header.php',
    'Luminova\\Http\\Network' => $baseDir . '/system/Http/Network.php',
    'Luminova\\Http\\NetworkAsync' => $baseDir . '/system/Http/NetworkAsync.php',
    'Luminova\\Http\\NetworkClientInterface' => $baseDir . '/system/Http/NetworkClientInterface.php',
    'Luminova\\Http\\NetworkRequest' => $baseDir . '/system/Http/NetworkRequest.php',
    'Luminova\\Http\\NetworkResponse' => $baseDir . '/system/Http/NetworkResponse.php',
    'Luminova\\Http\\Request' => $baseDir . '/system/Http/Request.php',
    'Luminova\\Languages\\Translator' => $baseDir . '/system/Languages/Translator.php',
    'Luminova\\Logger\\Logger' => $baseDir . '/system/Logger/Logger.php',
    'Luminova\\Logger\\LoggerAware' => $baseDir . '/system/Logger/LoggerAware.php',
    'Luminova\\Logger\\LoggerInterface' => $baseDir . '/system/Logger/LoggerInterface.php',
    'Luminova\\Models\\Model' => $baseDir . '/system/Models/Model.php',
    'Luminova\\Models\\PushMessage' => $baseDir . '/system/Models/PushMessage.php',
    'Luminova\\Notifications\\FirebasePusher' => $baseDir . '/system/Notifications/FirebasePusher.php',
    'Luminova\\Notifications\\FirebaseRealtime' => $baseDir . '/system/Notifications/FirebaseRealtime.php',
    'Luminova\\Routing\\Bootstrap' => $baseDir . '/system/Routing/Bootstrap.php',
    'Luminova\\Routing\\Router' => $baseDir . '/system/Routing/Router.php',
    'Luminova\\Security\\Csrf' => $baseDir . '/system/Security/Csrf.php',
    'Luminova\\Security\\Encryption\\AES' => $baseDir . '/system/Security/Encryption/AES.php',
    'Luminova\\Security\\Encryption\\EncryptionInterface' => $baseDir . '/system/Security/Encryption/EncryptionInterface.php',
    'Luminova\\Security\\InputValidator' => $baseDir . '/system/Security/InputValidator.php',
    'Luminova\\Security\\ValidatorInterface' => $baseDir . '/system/Security/ValidatorInterface.php',
    'Luminova\\Seo\\Meta' => $baseDir . '/system/Seo/Meta.php',
    'Luminova\\Sessions\\CookieManager' => $baseDir . '/system/Sessions/CookieManager.php',
    'Luminova\\Sessions\\Session' => $baseDir . '/system/Sessions/Session.php',
    'Luminova\\Sessions\\SessionInterface' => $baseDir . '/system/Sessions/SessionInterface.php',
    'Luminova\\Sessions\\SessionManager' => $baseDir . '/system/Sessions/SessionManager.php',
    'Luminova\\Template\\Template' => $baseDir . '/system/Template/Template.php',
    'Luminova\\Time\\Task' => $baseDir . '/system/Time/Task.php',
    'Luminova\\Utils\\Queue' => $baseDir . '/system/Utils/Queue.php',
    'Psr\\Log\\AbstractLogger' => $vendorDir . '/psr/log/Psr/Log/AbstractLogger.php',
    'Psr\\Log\\InvalidArgumentException' => $vendorDir . '/psr/log/Psr/Log/InvalidArgumentException.php',
    'Psr\\Log\\LogLevel' => $vendorDir . '/psr/log/Psr/Log/LogLevel.php',
    'Psr\\Log\\LoggerAwareInterface' => $vendorDir . '/psr/log/Psr/Log/LoggerAwareInterface.php',
    'Psr\\Log\\LoggerAwareTrait' => $vendorDir . '/psr/log/Psr/Log/LoggerAwareTrait.php',
    'Psr\\Log\\LoggerInterface' => $vendorDir . '/psr/log/Psr/Log/LoggerInterface.php',
    'Psr\\Log\\LoggerTrait' => $vendorDir . '/psr/log/Psr/Log/LoggerTrait.php',
    'Psr\\Log\\NullLogger' => $vendorDir . '/psr/log/Psr/Log/NullLogger.php',
    'Psr\\Log\\Test\\DummyTest' => $vendorDir . '/psr/log/Psr/Log/Test/DummyTest.php',
    'Psr\\Log\\Test\\LoggerInterfaceTest' => $vendorDir . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
    'Psr\\Log\\Test\\TestLogger' => $vendorDir . '/psr/log/Psr/Log/Test/TestLogger.php',
);
