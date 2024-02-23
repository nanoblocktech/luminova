<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9c155849e043191fc1df7e0b46712cd7
{
    public static $files = array (
        '036818047735a62ec8bdc87789995c53' => __DIR__ . '/../../..' . '/libraries/sys/functions.php',
        '773985666f96db74a126e1a489bb49f3' => __DIR__ . '/../../..' . '/libraries/sys/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'L' => 
        array (
            'Luminova\\' => 9,
        ),
        'A' => 
        array (
            'App\\Controllers\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Luminova\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/system',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/app/Controllers',
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\Application' => __DIR__ . '/../../..' . '/app/Controllers/Application.php',
        'App\\Controllers\\Command' => __DIR__ . '/../../..' . '/app/Controllers/Command.php',
        'App\\Controllers\\Config\\Config' => __DIR__ . '/../../..' . '/app/Controllers/Config/Config.php',
        'App\\Controllers\\Config\\Cookie' => __DIR__ . '/../../..' . '/app/Controllers/Config/Cookie.php',
        'App\\Controllers\\Config\\Session' => __DIR__ . '/../../..' . '/app/Controllers/Config/Session.php',
        'App\\Controllers\\Config\\Template' => __DIR__ . '/../../..' . '/app/Controllers/Config/Template.php',
        'App\\Controllers\\Utils\\Func' => __DIR__ . '/../../..' . '/app/Controllers/Utils/Func.php',
        'App\\Controllers\\Welcome' => __DIR__ . '/../../..' . '/app/Controllers/Welcome.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Luminova\\Application\\Application' => __DIR__ . '/../../..' . '/system/Application/Application.php',
        'Luminova\\Application\\Services' => __DIR__ . '/../../..' . '/system/Application/Services.php',
        'Luminova\\Arrays\\ArrayCountable' => __DIR__ . '/../../..' . '/system/Arrays/ArrayCountable.php',
        'Luminova\\Arrays\\ArrayInput' => __DIR__ . '/../../..' . '/system/Arrays/ArrayInput.php',
        'Luminova\\Arrays\\Arrays' => __DIR__ . '/../../..' . '/system/Arrays/Arrays.php',
        'Luminova\\Base\\BaseApplication' => __DIR__ . '/../../..' . '/system/Base/BaseApplication.php',
        'Luminova\\Base\\BaseCommand' => __DIR__ . '/../../..' . '/system/Base/BaseCommand.php',
        'Luminova\\Base\\BaseConfig' => __DIR__ . '/../../..' . '/system/Base/BaseConfig.php',
        'Luminova\\Base\\BaseController' => __DIR__ . '/../../..' . '/system/Base/BaseController.php',
        'Luminova\\Base\\BaseFunction' => __DIR__ . '/../../..' . '/system/Base/BaseFunction.php',
        'Luminova\\Base\\BaseModel' => __DIR__ . '/../../..' . '/system/Base/BaseModel.php',
        'Luminova\\Base\\BaseViewController' => __DIR__ . '/../../..' . '/system/Base/BaseViewController.php',
        'Luminova\\Cache\\Cache' => __DIR__ . '/../../..' . '/system/Cache/Cache.php',
        'Luminova\\Cache\\Compress' => __DIR__ . '/../../..' . '/system/Cache/Compress.php',
        'Luminova\\Cache\\FileCache' => __DIR__ . '/../../..' . '/system/Cache/FileCache.php',
        'Luminova\\Cache\\FileCacheItem' => __DIR__ . '/../../..' . '/system/Cache/FileCacheItem.php',
        'Luminova\\Cache\\MemoryCache' => __DIR__ . '/../../..' . '/system/Cache/MemoryCache.php',
        'Luminova\\Cache\\Optimizer' => __DIR__ . '/../../..' . '/system/Cache/Optimizer.php',
        'Luminova\\Command\\Colors' => __DIR__ . '/../../..' . '/system/Command/Colors.php',
        'Luminova\\Command\\Commands' => __DIR__ . '/../../..' . '/system/Command/Commands.php',
        'Luminova\\Command\\Console' => __DIR__ . '/../../..' . '/system/Command/Console.php',
        'Luminova\\Command\\Novakit\\AvailableCommands' => __DIR__ . '/../../..' . '/system/Command/Novakit/AvailableCommands.php',
        'Luminova\\Command\\Novakit\\Database' => __DIR__ . '/../../..' . '/system/Command/Novakit/Database.php',
        'Luminova\\Command\\Novakit\\Generators' => __DIR__ . '/../../..' . '/system/Command/Novakit/Generators.php',
        'Luminova\\Command\\Novakit\\Help' => __DIR__ . '/../../..' . '/system/Command/Novakit/Help.php',
        'Luminova\\Command\\Novakit\\Lists' => __DIR__ . '/../../..' . '/system/Command/Novakit/Lists.php',
        'Luminova\\Command\\Novakit\\Server' => __DIR__ . '/../../..' . '/system/Command/Novakit/Server.php',
        'Luminova\\Command\\Terminal' => __DIR__ . '/../../..' . '/system/Command/Terminal.php',
        'Luminova\\Command\\TerminalGenerator' => __DIR__ . '/../../..' . '/system/Command/TerminalGenerator.php',
        'Luminova\\Command\\TextUtils' => __DIR__ . '/../../..' . '/system/Command/TextUtils.php',
        'Luminova\\Composer\\BaseComposer' => __DIR__ . '/../../..' . '/system/Composer/BaseComposer.php',
        'Luminova\\Composer\\Builder' => __DIR__ . '/../../..' . '/system/Composer/Builder.php',
        'Luminova\\Composer\\Updater' => __DIR__ . '/../../..' . '/system/Composer/Updater.php',
        'Luminova\\Config\\Configuration' => __DIR__ . '/../../..' . '/system/Config/Configuration.php',
        'Luminova\\Config\\Database' => __DIR__ . '/../../..' . '/system/Config/Database.php',
        'Luminova\\Config\\DotEnv' => __DIR__ . '/../../..' . '/system/Config/DotEnv.php',
        'Luminova\\Config\\PHPStanRules' => __DIR__ . '/../../..' . '/system/Config/PHPStanRules.php',
        'Luminova\\Config\\SystemPaths' => __DIR__ . '/../../..' . '/system/Config/SystemPaths.php',
        'Luminova\\Controllers\\Controller' => __DIR__ . '/../../..' . '/system/Controllers/Controller.php',
        'Luminova\\Controllers\\ViewController' => __DIR__ . '/../../..' . '/system/Controllers/ViewController.php',
        'Luminova\\Cookies\\Cookie' => __DIR__ . '/../../..' . '/system/Cookies/Cookie.php',
        'Luminova\\Cookies\\CookieInterface' => __DIR__ . '/../../..' . '/system/Cookies/CookieInterface.php',
        'Luminova\\Cookies\\Exception\\CookieException' => __DIR__ . '/../../..' . '/system/Cookies/Exception/CookieException.php',
        'Luminova\\Database\\Columns' => __DIR__ . '/../../..' . '/system/Database/Columns.php',
        'Luminova\\Database\\Connection' => __DIR__ . '/../../..' . '/system/Database/Connection.php',
        'Luminova\\Database\\Drivers\\DriversInterface' => __DIR__ . '/../../..' . '/system/Database/Drivers/DriversInterface.php',
        'Luminova\\Database\\Drivers\\MySqlDriver' => __DIR__ . '/../../..' . '/system/Database/Drivers/MySqlDriver.php',
        'Luminova\\Database\\Drivers\\PdoDriver' => __DIR__ . '/../../..' . '/system/Database/Drivers/PdoDriver.php',
        'Luminova\\Database\\Query' => __DIR__ . '/../../..' . '/system/Database/Query.php',
        'Luminova\\Database\\Results\\Statements' => __DIR__ . '/../../..' . '/system/Database/Results/Statements.php',
        'Luminova\\Email\\Mailer' => __DIR__ . '/../../..' . '/system/Email/Mailer.php',
        'Luminova\\Errors\\Codes' => __DIR__ . '/../../..' . '/system/Errors/Codes.php',
        'Luminova\\Errors\\Error' => __DIR__ . '/../../..' . '/system/Errors/Error.php',
        'Luminova\\Exceptions\\AppException' => __DIR__ . '/../../..' . '/system/Exceptions/AppException.php',
        'Luminova\\Exceptions\\ClassException' => __DIR__ . '/../../..' . '/system/Exceptions/ClassException.php',
        'Luminova\\Exceptions\\DatabaseException' => __DIR__ . '/../../..' . '/system/Exceptions/DatabaseException.php',
        'Luminova\\Exceptions\\ErrorException' => __DIR__ . '/../../..' . '/system/Exceptions/ErrorException.php',
        'Luminova\\Exceptions\\FileException' => __DIR__ . '/../../..' . '/system/Exceptions/FileException.php',
        'Luminova\\Exceptions\\InvalidException' => __DIR__ . '/../../..' . '/system/Exceptions/InvalidException.php',
        'Luminova\\Exceptions\\InvalidObjectException' => __DIR__ . '/../../..' . '/system/Exceptions/InvalidObjectException.php',
        'Luminova\\Exceptions\\LuminovaException' => __DIR__ . '/../../..' . '/system/Exceptions/LuminovaException.php',
        'Luminova\\Exceptions\\NotFoundException' => __DIR__ . '/../../..' . '/system/Exceptions/NotFoundException.php',
        'Luminova\\Exceptions\\RuntimeException' => __DIR__ . '/../../..' . '/system/Exceptions/RuntimeException.php',
        'Luminova\\Exceptions\\ValidationException' => __DIR__ . '/../../..' . '/system/Exceptions/ValidationException.php',
        'Luminova\\Exceptions\\ViewNotFoundException' => __DIR__ . '/../../..' . '/system/Exceptions/ViewNotFoundException.php',
        'Luminova\\Functions\\Document' => __DIR__ . '/../../..' . '/system/Functions/Document.php',
        'Luminova\\Functions\\Escaper' => __DIR__ . '/../../..' . '/system/Functions/Escaper.php',
        'Luminova\\Functions\\Files' => __DIR__ . '/../../..' . '/system/Functions/Files.php',
        'Luminova\\Functions\\Functions' => __DIR__ . '/../../..' . '/system/Functions/Functions.php',
        'Luminova\\Functions\\IPAddress' => __DIR__ . '/../../..' . '/system/Functions/IPAddress.php',
        'Luminova\\Http\\AsyncClientInterface' => __DIR__ . '/../../..' . '/system/Http/AsyncClientInterface.php',
        'Luminova\\Http\\Client\\Curl' => __DIR__ . '/../../..' . '/system/Http/Client/Curl.php',
        'Luminova\\Http\\Client\\Guzzle' => __DIR__ . '/../../..' . '/system/Http/Client/Guzzle.php',
        'Luminova\\Http\\CurlAsyncClient' => __DIR__ . '/../../..' . '/system/Http/CurlAsyncClient.php',
        'Luminova\\Http\\GuzzleAsyncClient' => __DIR__ . '/../../..' . '/system/Http/GuzzleAsyncClient.php',
        'Luminova\\Http\\Header' => __DIR__ . '/../../..' . '/system/Http/Header.php',
        'Luminova\\Http\\Network' => __DIR__ . '/../../..' . '/system/Http/Network.php',
        'Luminova\\Http\\NetworkAsync' => __DIR__ . '/../../..' . '/system/Http/NetworkAsync.php',
        'Luminova\\Http\\NetworkClientInterface' => __DIR__ . '/../../..' . '/system/Http/NetworkClientInterface.php',
        'Luminova\\Http\\NetworkRequest' => __DIR__ . '/../../..' . '/system/Http/NetworkRequest.php',
        'Luminova\\Http\\NetworkResponse' => __DIR__ . '/../../..' . '/system/Http/NetworkResponse.php',
        'Luminova\\Http\\Request' => __DIR__ . '/../../..' . '/system/Http/Request.php',
        'Luminova\\Languages\\Translator' => __DIR__ . '/../../..' . '/system/Languages/Translator.php',
        'Luminova\\Library\\Importer' => __DIR__ . '/../../..' . '/system/Library/Importer.php',
        'Luminova\\Logger\\Logger' => __DIR__ . '/../../..' . '/system/Logger/Logger.php',
        'Luminova\\Logger\\LoggerAware' => __DIR__ . '/../../..' . '/system/Logger/LoggerAware.php',
        'Luminova\\Logger\\NovaLogger' => __DIR__ . '/../../..' . '/system/Logger/NovaLogger.php',
        'Luminova\\Models\\Model' => __DIR__ . '/../../..' . '/system/Models/Model.php',
        'Luminova\\Models\\PushMessage' => __DIR__ . '/../../..' . '/system/Models/PushMessage.php',
        'Luminova\\Notifications\\FirebasePusher' => __DIR__ . '/../../..' . '/system/Notifications/FirebasePusher.php',
        'Luminova\\Notifications\\FirebaseRealtime' => __DIR__ . '/../../..' . '/system/Notifications/FirebaseRealtime.php',
        'Luminova\\Routing\\Bootstrap' => __DIR__ . '/../../..' . '/system/Routing/Bootstrap.php',
        'Luminova\\Routing\\Router' => __DIR__ . '/../../..' . '/system/Routing/Router.php',
        'Luminova\\Security\\Csrf' => __DIR__ . '/../../..' . '/system/Security/Csrf.php',
        'Luminova\\Security\\Encryption\\AES' => __DIR__ . '/../../..' . '/system/Security/Encryption/AES.php',
        'Luminova\\Security\\Encryption\\EncryptionInterface' => __DIR__ . '/../../..' . '/system/Security/Encryption/EncryptionInterface.php',
        'Luminova\\Security\\InputValidator' => __DIR__ . '/../../..' . '/system/Security/InputValidator.php',
        'Luminova\\Security\\ValidatorInterface' => __DIR__ . '/../../..' . '/system/Security/ValidatorInterface.php',
        'Luminova\\Seo\\Meta' => __DIR__ . '/../../..' . '/system/Seo/Meta.php',
        'Luminova\\Sessions\\CookieManager' => __DIR__ . '/../../..' . '/system/Sessions/CookieManager.php',
        'Luminova\\Sessions\\Session' => __DIR__ . '/../../..' . '/system/Sessions/Session.php',
        'Luminova\\Sessions\\SessionInterface' => __DIR__ . '/../../..' . '/system/Sessions/SessionInterface.php',
        'Luminova\\Sessions\\SessionManager' => __DIR__ . '/../../..' . '/system/Sessions/SessionManager.php',
        'Luminova\\Template\\Smarty' => __DIR__ . '/../../..' . '/system/Template/Smarty.php',
        'Luminova\\Template\\Template' => __DIR__ . '/../../..' . '/system/Template/Template.php',
        'Luminova\\Time\\Task' => __DIR__ . '/../../..' . '/system/Time/Task.php',
        'Luminova\\Time\\Time' => __DIR__ . '/../../..' . '/system/Time/Time.php',
        'Luminova\\Utils\\Queue' => __DIR__ . '/../../..' . '/system/Utils/Queue.php',
        'Psr\\Log\\AbstractLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/AbstractLogger.php',
        'Psr\\Log\\InvalidArgumentException' => __DIR__ . '/..' . '/psr/log/Psr/Log/InvalidArgumentException.php',
        'Psr\\Log\\LogLevel' => __DIR__ . '/..' . '/psr/log/Psr/Log/LogLevel.php',
        'Psr\\Log\\LoggerAwareInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareInterface.php',
        'Psr\\Log\\LoggerAwareTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareTrait.php',
        'Psr\\Log\\LoggerInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerInterface.php',
        'Psr\\Log\\LoggerTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerTrait.php',
        'Psr\\Log\\NullLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/NullLogger.php',
        'Psr\\Log\\Test\\DummyTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/DummyTest.php',
        'Psr\\Log\\Test\\LoggerInterfaceTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
        'Psr\\Log\\Test\\TestLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/TestLogger.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9c155849e043191fc1df7e0b46712cd7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9c155849e043191fc1df7e0b46712cd7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9c155849e043191fc1df7e0b46712cd7::$classMap;

        }, null, ClassLoader::class);
    }
}
