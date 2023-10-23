<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname(dirname($vendorDir));

return array(
    'App\\Controllers\\AppSession' => $baseDir . '/app/Controllers/AppSession.php',
    'App\\Controllers\\Application' => $baseDir . '/app/Controllers/Application.php',
    'App\\Controllers\\Config\\Config' => $baseDir . '/app/Controllers/Config/Config.php',
    'App\\Controllers\\Config\\SessionConfig' => $baseDir . '/app/Controllers/Config/SessionConfig.php',
    'App\\Controllers\\EmailTemplate' => $baseDir . '/app/Controllers/EmailTemplate.php',
    'App\\Controllers\\Func' => $baseDir . '/app/Controllers/Func.php',
    'App\\Controllers\\HelloWorld' => $baseDir . '/app/Controllers/HelloWorld.php',
    'App\\Controllers\\Models\\UserModel' => $baseDir . '/app/Controllers/Models/UserModel.php',
    'App\\Controllers\\UserController' => $baseDir . '/app/Controllers/UserController.php',
    'App\\Controllers\\UserModel' => $baseDir . '/app/Controllers/UserModel.php',
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Luminova\\Arrays\\ArrayInput' => $baseDir . '/system/Arrays/ArrayInput.php',
    'Luminova\\BaseApplication' => $baseDir . '/system/BaseApplication.php',
    'Luminova\\BaseController' => $baseDir . '/system/BaseController.php',
    'Luminova\\Cache\\Cache' => $baseDir . '/system/Cache/Cache.php',
    'Luminova\\Cache\\Compress' => $baseDir . '/system/Cache/Compress.php',
    'Luminova\\Cache\\FileCacheItem' => $baseDir . '/system/Cache/FileCacheItem.php',
    'Luminova\\Cache\\FileSystemCache' => $baseDir . '/system/Cache/FileSystemCache.php',
    'Luminova\\Cache\\MemoryCache' => $baseDir . '/system/Cache/MemoryCache.php',
    'Luminova\\Cache\\Optimizer' => $baseDir . '/system/Cache/Optimizer.php',
    'Luminova\\Command\\AppCommand' => $baseDir . '/system/Command/AppCommand.php',
    'Luminova\\Command\\Create' => $baseDir . '/system/Command/Create.php',
    'Luminova\\Command\\Plugin' => $baseDir . '/system/Command/Plugin.php',
    'Luminova\\Command\\RebuildCommand' => $baseDir . '/system/Command/RebuildCommand.php',
    'Luminova\\Command\\Subscriber' => $baseDir . '/system/Command/Subscriber.php',
    'Luminova\\Composer\\BaseComposer' => $baseDir . '/system/Composer/BaseComposer.php',
    'Luminova\\Composer\\Builder' => $baseDir . '/system/Composer/Builder.php',
    'Luminova\\Composer\\Updater' => $baseDir . '/system/Composer/Updater.php',
    'Luminova\\Config\\BaseConfig' => $baseDir . '/system/Config/BaseConfig.php',
    'Luminova\\Config\\DotEnv' => $baseDir . '/system/Config/DotEnv.php',
    'Luminova\\Config\\PHPStanRules' => $baseDir . '/system/Config/PHPStanRules.php',
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
    'Luminova\\Exceptions\\ValidationException' => $baseDir . '/system/Exceptions/ValidationException.php',
    'Luminova\\Exceptions\\ViewNotFoundException' => $baseDir . '/system/Exceptions/ViewNotFoundException.php',
    'Luminova\\Functions\\FunctionInterface' => $baseDir . '/system/Functions/FunctionInterface.php',
    'Luminova\\Functions\\Functions' => $baseDir . '/system/Functions/Functions.php',
    'Luminova\\Http\\AsyncClientInterface' => $baseDir . '/system/Http/AsyncClientInterface.php',
    'Luminova\\Http\\CurlAsyncClient' => $baseDir . '/system/Http/CurlAsyncClient.php',
    'Luminova\\Http\\CurlClient' => $baseDir . '/system/Http/CurlClient.php',
    'Luminova\\Http\\CurlResponse' => $baseDir . '/system/Http/CurlResponse.php',
    'Luminova\\Http\\GuzzleAsyncClient' => $baseDir . '/system/Http/GuzzleAsyncClient.php',
    'Luminova\\Http\\GuzzleClient' => $baseDir . '/system/Http/GuzzleClient.php',
    'Luminova\\Http\\Header' => $baseDir . '/system/Http/Header.php',
    'Luminova\\Http\\Network' => $baseDir . '/system/Http/Network.php',
    'Luminova\\Http\\NetworkAsync' => $baseDir . '/system/Http/NetworkAsync.php',
    'Luminova\\Http\\NetworkRequest' => $baseDir . '/system/Http/NetworkRequest.php',
    'Luminova\\Http\\Request' => $baseDir . '/system/Http/Request.php',
    'Luminova\\Languages\\Translator' => $baseDir . '/system/Languages/Translator.php',
    'Luminova\\Logger\\Logger' => $baseDir . '/system/Logger/Logger.php',
    'Luminova\\Logger\\LoggerAware' => $baseDir . '/system/Logger/LoggerAware.php',
    'Luminova\\Logger\\LoggerInterface' => $baseDir . '/system/Logger/LoggerInterface.php',
    'Luminova\\Models\\DatabaseConfig' => $baseDir . '/system/Models/DatabaseConfig.php',
    'Luminova\\Models\\Model' => $baseDir . '/system/Models/Model.php',
    'Luminova\\Models\\PushMessage' => $baseDir . '/system/Models/PushMessage.php',
    'Luminova\\Notifications\\FirebasePusher' => $baseDir . '/system/Notifications/FirebasePusher.php',
    'Luminova\\Notifications\\FirebaseRealtime' => $baseDir . '/system/Notifications/FirebaseRealtime.php',
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
    'PHPMailer\\PHPMailer\\DSNConfigurator' => $vendorDir . '/phpmailer/phpmailer/src/DSNConfigurator.php',
    'PHPMailer\\PHPMailer\\Exception' => $vendorDir . '/phpmailer/phpmailer/src/Exception.php',
    'PHPMailer\\PHPMailer\\OAuth' => $vendorDir . '/phpmailer/phpmailer/src/OAuth.php',
    'PHPMailer\\PHPMailer\\OAuthTokenProvider' => $vendorDir . '/phpmailer/phpmailer/src/OAuthTokenProvider.php',
    'PHPMailer\\PHPMailer\\PHPMailer' => $vendorDir . '/phpmailer/phpmailer/src/PHPMailer.php',
    'PHPMailer\\PHPMailer\\POP3' => $vendorDir . '/phpmailer/phpmailer/src/POP3.php',
    'PHPMailer\\PHPMailer\\SMTP' => $vendorDir . '/phpmailer/phpmailer/src/SMTP.php',
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
