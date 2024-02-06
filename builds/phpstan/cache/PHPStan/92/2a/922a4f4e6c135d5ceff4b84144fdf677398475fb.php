<?php declare(strict_types = 1);

// odsl-/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v1',
   'data' => 
  array (
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Connection.php' => 
    array (
      0 => 'aceae3a8f2c41208f64ff4bcdfa89baecc717634',
      1 => 
      array (
        0 => 'luminova\\database\\connection',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\__construct',
        1 => 'luminova\\database\\getinstance',
        2 => 'luminova\\database\\createdatabaseinstance',
        3 => 'luminova\\database\\getdatabaseconfig',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Drivers/PdoDriver.php' => 
    array (
      0 => 'e17d563281db84456220d8c1c1aad5dc41117045',
      1 => 
      array (
        0 => 'luminova\\database\\drivers\\pdodriver',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\drivers\\__construct',
        1 => 'luminova\\database\\drivers\\getdriver',
        2 => 'luminova\\database\\drivers\\setdebug',
        3 => 'luminova\\database\\drivers\\initializedatabase',
        4 => 'luminova\\database\\drivers\\createmysqlconnection',
        5 => 'luminova\\database\\drivers\\createpostgresqlconnection',
        6 => 'luminova\\database\\drivers\\createsqliteconnection',
        7 => 'luminova\\database\\drivers\\error',
        8 => 'luminova\\database\\drivers\\errors',
        9 => 'luminova\\database\\drivers\\info',
        10 => 'luminova\\database\\drivers\\dumpdebug',
        11 => 'luminova\\database\\drivers\\prepare',
        12 => 'luminova\\database\\drivers\\query',
        13 => 'luminova\\database\\drivers\\exec',
        14 => 'luminova\\database\\drivers\\begintransaction',
        15 => 'luminova\\database\\drivers\\commit',
        16 => 'luminova\\database\\drivers\\rollback',
        17 => 'luminova\\database\\drivers\\gettype',
        18 => 'luminova\\database\\drivers\\bind',
        19 => 'luminova\\database\\drivers\\param',
        20 => 'luminova\\database\\drivers\\execute',
        21 => 'luminova\\database\\drivers\\rowcount',
        22 => 'luminova\\database\\drivers\\getone',
        23 => 'luminova\\database\\drivers\\getall',
        24 => 'luminova\\database\\drivers\\getint',
        25 => 'luminova\\database\\drivers\\getresult',
        26 => 'luminova\\database\\drivers\\getobject',
        27 => 'luminova\\database\\drivers\\getarray',
        28 => 'luminova\\database\\drivers\\getlastinsertid',
        29 => 'luminova\\database\\drivers\\free',
        30 => 'luminova\\database\\drivers\\close',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Drivers/DriversInterface.php' => 
    array (
      0 => '0b1390c79d337e9a7a0e093fc82b3571b9d0ab41',
      1 => 
      array (
        0 => 'luminova\\database\\drivers\\driversinterface',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\drivers\\getdriver',
        1 => 'luminova\\database\\drivers\\setdebug',
        2 => 'luminova\\database\\drivers\\error',
        3 => 'luminova\\database\\drivers\\errors',
        4 => 'luminova\\database\\drivers\\dumpdebug',
        5 => 'luminova\\database\\drivers\\info',
        6 => 'luminova\\database\\drivers\\prepare',
        7 => 'luminova\\database\\drivers\\query',
        8 => 'luminova\\database\\drivers\\exec',
        9 => 'luminova\\database\\drivers\\begintransaction',
        10 => 'luminova\\database\\drivers\\commit',
        11 => 'luminova\\database\\drivers\\rollback',
        12 => 'luminova\\database\\drivers\\gettype',
        13 => 'luminova\\database\\drivers\\bind',
        14 => 'luminova\\database\\drivers\\param',
        15 => 'luminova\\database\\drivers\\execute',
        16 => 'luminova\\database\\drivers\\rowcount',
        17 => 'luminova\\database\\drivers\\getone',
        18 => 'luminova\\database\\drivers\\getall',
        19 => 'luminova\\database\\drivers\\getint',
        20 => 'luminova\\database\\drivers\\getresult',
        21 => 'luminova\\database\\drivers\\getobject',
        22 => 'luminova\\database\\drivers\\getarray',
        23 => 'luminova\\database\\drivers\\getlastinsertid',
        24 => 'luminova\\database\\drivers\\free',
        25 => 'luminova\\database\\drivers\\close',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Drivers/MySqlDriver.php' => 
    array (
      0 => 'a8a3ff4167d7e8eb6773ff569a6a7d6af4f3ca58',
      1 => 
      array (
        0 => 'luminova\\database\\drivers\\mysqldriver',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\drivers\\__construct',
        1 => 'luminova\\database\\drivers\\getdriver',
        2 => 'luminova\\database\\drivers\\setdebug',
        3 => 'luminova\\database\\drivers\\initializedatabase',
        4 => 'luminova\\database\\drivers\\error',
        5 => 'luminova\\database\\drivers\\errors',
        6 => 'luminova\\database\\drivers\\info',
        7 => 'luminova\\database\\drivers\\dumpdebug',
        8 => 'luminova\\database\\drivers\\prepare',
        9 => 'luminova\\database\\drivers\\query',
        10 => 'luminova\\database\\drivers\\exec',
        11 => 'luminova\\database\\drivers\\begintransaction',
        12 => 'luminova\\database\\drivers\\commit',
        13 => 'luminova\\database\\drivers\\rollback',
        14 => 'luminova\\database\\drivers\\gettype',
        15 => 'luminova\\database\\drivers\\bind',
        16 => 'luminova\\database\\drivers\\param',
        17 => 'luminova\\database\\drivers\\bindvalues',
        18 => 'luminova\\database\\drivers\\execute',
        19 => 'luminova\\database\\drivers\\isblob',
        20 => 'luminova\\database\\drivers\\rowcount',
        21 => 'luminova\\database\\drivers\\getone',
        22 => 'luminova\\database\\drivers\\getall',
        23 => 'luminova\\database\\drivers\\getfromqueryresult',
        24 => 'luminova\\database\\drivers\\getresult',
        25 => 'luminova\\database\\drivers\\getobject',
        26 => 'luminova\\database\\drivers\\getarray',
        27 => 'luminova\\database\\drivers\\getint',
        28 => 'luminova\\database\\drivers\\getlastinsertid',
        29 => 'luminova\\database\\drivers\\free',
        30 => 'luminova\\database\\drivers\\isstatement',
        31 => 'luminova\\database\\drivers\\close',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Columns.php' => 
    array (
      0 => '797b6e99d15038c5952364d23a0659a33109bec2',
      1 => 
      array (
        0 => 'luminova\\database\\columns',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\__construct',
        1 => 'luminova\\database\\setname',
        2 => 'luminova\\database\\settype',
        3 => 'luminova\\database\\setcollation',
        4 => 'luminova\\database\\setattributes',
        5 => 'luminova\\database\\setautoincrement',
        6 => 'luminova\\database\\setdefault',
        7 => 'luminova\\database\\setindex',
        8 => 'luminova\\database\\getcolumns',
        9 => 'luminova\\database\\generate',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Results/Statements.php' => 
    array (
      0 => '1dcd1189ff954865c85e2592dc0d896b58a8b1fd',
      1 => 
      array (
        0 => 'luminova\\database\\results\\statements',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\results\\__construct',
        1 => 'luminova\\database\\results\\getall',
        2 => 'luminova\\database\\results\\getone',
        3 => 'luminova\\database\\results\\getint',
        4 => 'luminova\\database\\results\\getobject',
        5 => 'luminova\\database\\results\\getarray',
        6 => 'luminova\\database\\results\\getlastid',
        7 => 'luminova\\database\\results\\getcount',
        8 => 'luminova\\database\\results\\getresult',
        9 => 'luminova\\database\\results\\get',
        10 => 'luminova\\database\\results\\getclass',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Query.php' => 
    array (
      0 => 'da634662c0e8e06477e0df9a4010c0db14106c21',
      1 => 
      array (
        0 => 'luminova\\database\\query',
      ),
      2 => 
      array (
        0 => 'luminova\\database\\__construct',
        1 => 'luminova\\database\\__get',
        2 => 'luminova\\database\\__isset',
        3 => 'luminova\\database\\__clone',
        4 => 'luminova\\database\\__wakeup',
        5 => 'luminova\\database\\getconn',
        6 => 'luminova\\database\\closeconn',
        7 => 'luminova\\database\\getinstance',
        8 => 'luminova\\database\\table',
        9 => 'luminova\\database\\join',
        10 => 'luminova\\database\\on',
        11 => 'luminova\\database\\innerjoin',
        12 => 'luminova\\database\\leftjoin',
        13 => 'luminova\\database\\limit',
        14 => 'luminova\\database\\order',
        15 => 'luminova\\database\\group',
        16 => 'luminova\\database\\where',
        17 => 'luminova\\database\\and',
        18 => 'luminova\\database\\set',
        19 => 'luminova\\database\\or',
        20 => 'luminova\\database\\andor',
        21 => 'luminova\\database\\toarray',
        22 => 'luminova\\database\\in',
        23 => 'luminova\\database\\inset',
        24 => 'luminova\\database\\getfilepath',
        25 => 'luminova\\database\\cache',
        26 => 'luminova\\database\\insert',
        27 => 'luminova\\database\\select',
        28 => 'luminova\\database\\returnselect',
        29 => 'luminova\\database\\binds',
        30 => 'luminova\\database\\query',
        31 => 'luminova\\database\\builder',
        32 => 'luminova\\database\\execute',
        33 => 'luminova\\database\\returnquery',
        34 => 'luminova\\database\\find',
        35 => 'luminova\\database\\returnfind',
        36 => 'luminova\\database\\total',
        37 => 'luminova\\database\\returntotal',
        38 => 'luminova\\database\\update',
        39 => 'luminova\\database\\delete',
        40 => 'luminova\\database\\errors',
        41 => 'luminova\\database\\transaction',
        42 => 'luminova\\database\\commit',
        43 => 'luminova\\database\\rollback',
        44 => 'luminova\\database\\truncate',
        45 => 'luminova\\database\\drop',
        46 => 'luminova\\database\\createtable',
        47 => 'luminova\\database\\create',
        48 => 'luminova\\database\\withcolumns',
        49 => 'luminova\\database\\executeinsertquery',
        50 => 'luminova\\database\\executeinsertprepared',
        51 => 'luminova\\database\\trimplaceholder',
        52 => 'luminova\\database\\buildwhereconditions',
        53 => 'luminova\\database\\buildsearchconditions',
        54 => 'luminova\\database\\error',
        55 => 'luminova\\database\\isnestedarray',
        56 => 'luminova\\database\\reset',
        57 => 'luminova\\database\\free',
        58 => 'luminova\\database\\close',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Logger/Logger.php' => 
    array (
      0 => 'a6ba8362b540b6826366bd98af7fd0a7d6fe36c7',
      1 => 
      array (
        0 => 'luminova\\logger\\logger',
      ),
      2 => 
      array (
        0 => 'luminova\\logger\\setlogger',
        1 => 'luminova\\logger\\emergency',
        2 => 'luminova\\logger\\alert',
        3 => 'luminova\\logger\\critical',
        4 => 'luminova\\logger\\error',
        5 => 'luminova\\logger\\warning',
        6 => 'luminova\\logger\\notice',
        7 => 'luminova\\logger\\info',
        8 => 'luminova\\logger\\debug',
        9 => 'luminova\\logger\\log',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Logger/LoggerAware.php' => 
    array (
      0 => '08be0c3dd4ad6d23c4208325084c839cbcb481d4',
      1 => 
      array (
        0 => 'luminova\\logger\\loggeraware',
      ),
      2 => 
      array (
        0 => 'luminova\\logger\\setlogger',
        1 => 'luminova\\logger\\emergency',
        2 => 'luminova\\logger\\alert',
        3 => 'luminova\\logger\\critical',
        4 => 'luminova\\logger\\error',
        5 => 'luminova\\logger\\warning',
        6 => 'luminova\\logger\\notice',
        7 => 'luminova\\logger\\info',
        8 => 'luminova\\logger\\debug',
        9 => 'luminova\\logger\\log',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Logger/NovaLogger.php' => 
    array (
      0 => '7024ab94c49de2128200688a887abbdeac50efee',
      1 => 
      array (
        0 => 'luminova\\logger\\novalogger',
      ),
      2 => 
      array (
        0 => 'luminova\\logger\\__construct',
        1 => 'luminova\\logger\\exception',
        2 => 'luminova\\logger\\php',
        3 => 'luminova\\logger\\log',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/FileSystemCache.php' => 
    array (
      0 => 'a5c439e382dfddf213d739e263a41e025659035d',
      1 => 
      array (
        0 => 'luminova\\cache\\filesystemcache',
      ),
      2 => 
      array (
        0 => 'luminova\\cache\\__construct',
        1 => 'luminova\\cache\\getinstance',
        2 => 'luminova\\cache\\setcachelocation',
        3 => 'luminova\\cache\\setfilename',
        4 => 'luminova\\cache\\hashfilename',
        5 => 'luminova\\cache\\setextension',
        6 => 'luminova\\cache\\setdebugmode',
        7 => 'luminova\\cache\\setenablecache',
        8 => 'luminova\\cache\\setexpire',
        9 => 'luminova\\cache\\setlock',
        10 => 'luminova\\cache\\enablebase64',
        11 => 'luminova\\cache\\enabledeleteexpired',
        12 => 'luminova\\cache\\enablesecureaccess',
        13 => 'luminova\\cache\\getcachefilepath',
        14 => 'luminova\\cache\\difftime',
        15 => 'luminova\\cache\\onexpired',
        16 => 'luminova\\cache\\oncache',
        17 => 'luminova\\cache\\get',
        18 => 'luminova\\cache\\create',
        19 => 'luminova\\cache\\hascached',
        20 => 'luminova\\cache\\removeifexpired',
        21 => 'luminova\\cache\\hasexpired',
        22 => 'luminova\\cache\\remove',
        23 => 'luminova\\cache\\removelist',
        24 => 'luminova\\cache\\buildcache',
        25 => 'luminova\\cache\\fetchcatchdata',
        26 => 'luminova\\cache\\unlocksecurity',
        27 => 'luminova\\cache\\retrievecache',
        28 => 'luminova\\cache\\clearcache',
        29 => 'luminova\\cache\\writecache',
        30 => 'luminova\\cache\\removecache',
        31 => 'luminova\\cache\\removecachedisk',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/Compress.php' => 
    array (
      0 => '03e0f01792ddbaa3b89841a393f9afd90a554a6f',
      1 => 
      array (
        0 => 'luminova\\cache\\compress',
      ),
      2 => 
      array (
        0 => 'luminova\\cache\\__construct',
        1 => 'luminova\\cache\\usegzip',
        2 => 'luminova\\cache\\setexpires',
        3 => 'luminova\\cache\\setcachecontrol',
        4 => 'luminova\\cache\\setcompressionlevel',
        5 => 'luminova\\cache\\setignorecodeblock',
        6 => 'luminova\\cache\\getcompressed',
        7 => 'luminova\\cache\\getminified',
        8 => 'luminova\\cache\\compress',
        9 => 'luminova\\cache\\getinfo',
        10 => 'luminova\\cache\\tojsonencodedstring',
        11 => 'luminova\\cache\\withviewcontent',
        12 => 'luminova\\cache\\html',
        13 => 'luminova\\cache\\text',
        14 => 'luminova\\cache\\xml',
        15 => 'luminova\\cache\\json',
        16 => 'luminova\\cache\\run',
        17 => 'luminova\\cache\\end',
        18 => 'luminova\\cache\\startminify',
        19 => 'luminova\\cache\\minify',
        20 => 'luminova\\cache\\minifyignorecodeblock',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/MemoryCache.php' => 
    array (
      0 => '383d4e29d3af5091433588ac7d3d756d0622bdaa',
      1 => 
      array (
        0 => 'luminova\\cache\\memorycache',
      ),
      2 => 
      array (
        0 => 'luminova\\cache\\__construct',
        1 => 'luminova\\cache\\setconfig',
        2 => 'luminova\\cache\\addconfig',
        3 => 'luminova\\cache\\connect',
        4 => 'luminova\\cache\\setexpire',
        5 => 'luminova\\cache\\onexpired',
        6 => 'luminova\\cache\\withexpired',
        7 => 'luminova\\cache\\writecache',
        8 => 'luminova\\cache\\remove',
        9 => 'luminova\\cache\\removelist',
        10 => 'luminova\\cache\\clearcache',
        11 => 'luminova\\cache\\close',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/Cache.php' => 
    array (
      0 => '28728b40ca41f84c449cbedf130fef4425c90c1e',
      1 => 
      array (
        0 => 'luminova\\cache\\cache',
      ),
      2 => 
      array (
        0 => 'luminova\\cache\\__construct',
        1 => 'luminova\\cache\\getinstance',
        2 => 'luminova\\cache\\createcacheinstance',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/FileCacheItem.php' => 
    array (
      0 => '48d56e2dc2a8248fb0808b552755d074ac3f062d',
      1 => 
      array (
        0 => 'luminova\\cache\\filecacheitem',
      ),
      2 => 
      array (
        0 => 'luminova\\cache\\setexpiry',
        1 => 'luminova\\cache\\setlock',
        2 => 'luminova\\cache\\setdata',
        3 => 'luminova\\cache\\getexpiry',
        4 => 'luminova\\cache\\getlock',
        5 => 'luminova\\cache\\getdata',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/Optimizer.php' => 
    array (
      0 => 'dd0c0891505e1ca83e3e1c3d90cc5184fa88b12c',
      1 => 
      array (
        0 => 'luminova\\cache\\optimizer',
      ),
      2 => 
      array (
        0 => 'luminova\\cache\\__construct',
        1 => 'luminova\\cache\\getcachelocation',
        2 => 'luminova\\cache\\getcachefilepath',
        3 => 'luminova\\cache\\hascache',
        4 => 'luminova\\cache\\getfiletime',
        5 => 'luminova\\cache\\getcache',
        6 => 'luminova\\cache\\savecache',
        7 => 'luminova\\cache\\getkey',
        8 => 'luminova\\cache\\setkey',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Config/DotEnv.php' => 
    array (
      0 => 'bcfcc36ecc5e8a564b11d7e89029403ab8386ebb',
      1 => 
      array (
        0 => 'luminova\\config\\dotenv',
      ),
      2 => 
      array (
        0 => 'luminova\\config\\register',
        1 => 'luminova\\config\\setvariable',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Config/Database.php' => 
    array (
      0 => '87496df8b074449f9560865cffb0d1c3af6aa15d',
      1 => 
      array (
        0 => 'luminova\\config\\database',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Config/PHPStanRules.php' => 
    array (
      0 => '926a7c1bfc5a89adc7d3e78c7fe4f0378894af80',
      1 => 
      array (
        0 => 'luminova\\config\\phpstanrules',
      ),
      2 => 
      array (
        0 => 'luminova\\config\\getnodetype',
        1 => 'luminova\\config\\processnode',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Config/SystemPaths.php' => 
    array (
      0 => 'a0cfe468eb3820e05ea8b9d365a946cceff96979',
      1 => 
      array (
        0 => 'luminova\\config\\systempaths',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Config/Configuration.php' => 
    array (
      0 => '24a08b779a30c2931936e01b05c180da7b04d6cc',
      1 => 
      array (
        0 => 'luminova\\config\\configuration',
      ),
      2 => 
      array (
        0 => 'luminova\\config\\__get',
        1 => 'luminova\\config\\appname',
        2 => 'luminova\\config\\hostname',
        3 => 'luminova\\config\\baseurl',
        4 => 'luminova\\config\\basewwwurl',
        5 => 'luminova\\config\\appversion',
        6 => 'luminova\\config\\fileversion',
        7 => 'luminova\\config\\shouldminify',
        8 => 'luminova\\config\\urlprotocol',
        9 => 'luminova\\config\\getfullurl',
        10 => 'luminova\\config\\getrequesthost',
        11 => 'luminova\\config\\getenvironment',
        12 => 'luminova\\config\\ismaintenance',
        13 => 'luminova\\config\\isproduction',
        14 => 'luminova\\config\\islocal',
        15 => 'luminova\\config\\islocalserver',
        16 => 'luminova\\config\\usepublic',
        17 => 'luminova\\config\\getrootdirectory',
        18 => 'luminova\\config\\filterpath',
        19 => 'luminova\\config\\getvariables',
        20 => 'luminova\\config\\getint',
        21 => 'luminova\\config\\getboolean',
        22 => 'luminova\\config\\getmixednull',
        23 => 'luminova\\config\\variabletonotation',
        24 => 'luminova\\config\\copyright',
        25 => 'luminova\\config\\version',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/Encryption/AES.php' => 
    array (
      0 => 'a2c2ffea84880da6619e3360da9742ee60e1ebc9',
      1 => 
      array (
        0 => 'luminova\\security\\encryption\\aes',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\encryption\\__construct',
        1 => 'luminova\\security\\encryption\\setdata',
        2 => 'luminova\\security\\encryption\\setkey',
        3 => 'luminova\\security\\encryption\\setinitializationvector',
        4 => 'luminova\\security\\encryption\\setivlength',
        5 => 'luminova\\security\\encryption\\setmethod',
        6 => 'luminova\\security\\encryption\\validateparams',
        7 => 'luminova\\security\\encryption\\randominitializationvector',
        8 => 'luminova\\security\\encryption\\getinitializationvectorfrom',
        9 => 'luminova\\security\\encryption\\encrypt',
        10 => 'luminova\\security\\encryption\\decrypt',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/Encryption/EncryptionInterface.php' => 
    array (
      0 => '7fca5d363d68217fd0a77f2dc9c0a47ccaca5bfe',
      1 => 
      array (
        0 => 'luminova\\security\\encryption\\encryptioninterface',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\encryption\\setdata',
        1 => 'luminova\\security\\encryption\\setkey',
        2 => 'luminova\\security\\encryption\\setinitializationvector',
        3 => 'luminova\\security\\encryption\\setivlength',
        4 => 'luminova\\security\\encryption\\setmethod',
        5 => 'luminova\\security\\encryption\\validateparams',
        6 => 'luminova\\security\\encryption\\randominitializationvector',
        7 => 'luminova\\security\\encryption\\getinitializationvectorfrom',
        8 => 'luminova\\security\\encryption\\encrypt',
        9 => 'luminova\\security\\encryption\\decrypt',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/InputValidator.php' => 
    array (
      0 => 'b274ef51f0f6beb6617b4cc3624ae954acf57dde',
      1 => 
      array (
        0 => 'luminova\\security\\inputvalidator',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\validateentries',
        1 => 'luminova\\security\\validatefield',
        2 => 'luminova\\security\\isempty',
        3 => 'luminova\\security\\listtoarray',
        4 => 'luminova\\security\\listinarray',
        5 => 'luminova\\security\\geterrors',
        6 => 'luminova\\security\\geterror',
        7 => 'luminova\\security\\geterrorline',
        8 => 'luminova\\security\\geterrorbyindices',
        9 => 'luminova\\security\\adderror',
        10 => 'luminova\\security\\setrules',
        11 => 'luminova\\security\\addrule',
        12 => 'luminova\\security\\setmessages',
        13 => 'luminova\\security\\addmessage',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/Csrf.php' => 
    array (
      0 => '749748b3a9ce7a7f9763b509ecde55586215a506',
      1 => 
      array (
        0 => 'luminova\\security\\csrf',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\generatetoken',
        1 => 'luminova\\security\\refreshtoken',
        2 => 'luminova\\security\\gettoken',
        3 => 'luminova\\security\\inputtoken',
        4 => 'luminova\\security\\validatetoken',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/ValidatorInterface.php' => 
    array (
      0 => 'a74db7214499b4839f960dc423e7d96647441dcc',
      1 => 
      array (
        0 => 'luminova\\security\\validatorinterface',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\validateentries',
        1 => 'luminova\\security\\validatefield',
        2 => 'luminova\\security\\geterrors',
        3 => 'luminova\\security\\geterror',
        4 => 'luminova\\security\\adderror',
        5 => 'luminova\\security\\setrules',
        6 => 'luminova\\security\\addrule',
        7 => 'luminova\\security\\setmessages',
        8 => 'luminova\\security\\addmessage',
        9 => 'luminova\\security\\geterrorline',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Composer/Builder.php' => 
    array (
      0 => 'b7bf9c15ae03846c41dcbbfc45c3db9d56ca4321',
      1 => 
      array (
        0 => 'luminova\\composer\\builder',
      ),
      2 => 
      array (
        0 => 'luminova\\composer\\buildproject',
        1 => 'luminova\\composer\\buildarchiveproject',
        2 => 'luminova\\composer\\addtozip',
        3 => 'luminova\\composer\\copyfiles',
        4 => 'luminova\\composer\\shouldbeincluded',
        5 => 'luminova\\composer\\shouldbeignored',
        6 => 'luminova\\composer\\shouldbeskipped',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Composer/BaseComposer.php' => 
    array (
      0 => 'ef4bf501be9378d06d137e1a4c08eeb8ac1f29fb',
      1 => 
      array (
        0 => 'luminova\\composer\\basecomposer',
      ),
      2 => 
      array (
        0 => 'luminova\\composer\\progress',
        1 => 'luminova\\composer\\parselocation',
        2 => 'luminova\\composer\\isparentorequal',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Composer/Updater.php' => 
    array (
      0 => '4489ba0a23805c4046ba75c75371c544f51e7c7b',
      1 => 
      array (
        0 => 'luminova\\composer\\updater',
      ),
      2 => 
      array (
        0 => 'luminova\\composer\\updatefiles',
        1 => 'luminova\\composer\\renameprojectroot',
        2 => 'luminova\\composer\\moveprojecttoroot',
        3 => 'luminova\\composer\\checkandcopyfile',
        4 => 'luminova\\composer\\checkandmovedirectory',
        5 => 'luminova\\composer\\checkandcopydirectory',
        6 => 'luminova\\composer\\checkandcreatedirectory',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Template/Smarty.php' => 
    array (
      0 => '0be9bb803f22088bbd5f087c51e2ce56a52b60f2',
      1 => 
      array (
        0 => 'luminova\\template\\smarty',
      ),
      2 => 
      array (
        0 => 'luminova\\template\\__construct',
        1 => 'luminova\\template\\getinstance',
        2 => 'luminova\\template\\getsmarty',
        3 => 'luminova\\template\\setdirectories',
        4 => 'luminova\\template\\assignoptions',
        5 => 'luminova\\template\\caching',
        6 => 'luminova\\template\\testinstall',
        7 => 'luminova\\template\\compilecheck',
        8 => 'luminova\\template\\display',
        9 => 'luminova\\template\\makedir',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Template/Template.php' => 
    array (
      0 => 'af6659395f02a798f5edaac4e16e983e5472e8bc',
      1 => 
      array (
        0 => 'luminova\\template\\template',
      ),
      2 => 
      array (
        0 => 'luminova\\template\\initializetemplate',
        1 => 'luminova\\template\\__get',
        2 => 'luminova\\template\\getclass',
        3 => 'luminova\\template\\setlevel',
        4 => 'luminova\\template\\setoptimizebase',
        5 => 'luminova\\template\\setcompressignorecodeblock',
        6 => 'luminova\\template\\setbasepath',
        7 => 'luminova\\template\\getrootdir',
        8 => 'luminova\\template\\settemplatepath',
        9 => 'luminova\\template\\settemplateengin',
        10 => 'luminova\\template\\gettemplateengin',
        11 => 'luminova\\template\\setfolder',
        12 => 'luminova\\template\\addignoreoptimizer',
        13 => 'luminova\\template\\render',
        14 => 'luminova\\template\\redirect',
        15 => 'luminova\\template\\redirectto',
        16 => 'luminova\\template\\setdocumentroot',
        17 => 'luminova\\template\\registerclass',
        18 => 'luminova\\template\\setattributes',
        19 => 'luminova\\template\\getcontents',
        20 => 'luminova\\template\\getbaseviewfolder',
        21 => 'luminova\\template\\getbaseerrorviewfolder',
        22 => 'luminova\\template\\getbaseoptimizerfolder',
        23 => 'luminova\\template\\cache',
        24 => 'luminova\\template\\respond',
        25 => 'luminova\\template\\renderviewcontent',
        26 => 'luminova\\template\\displaycompressedcontent',
        27 => 'luminova\\template\\renderwithminification',
        28 => 'luminova\\template\\requestheaders',
        29 => 'luminova\\template\\view',
        30 => 'luminova\\template\\shouldoptimize',
        31 => 'luminova\\template\\calculatelevel',
        32 => 'luminova\\template\\gettemplatebaseuri',
        33 => 'luminova\\template\\handleexception',
        34 => 'luminova\\template\\totitle',
        35 => 'luminova\\template\\addtitlesuffix',
      ),
      3 => 
      array (
        0 => 'ALLOW_ACCESS',
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Utils/Queue.php' => 
    array (
      0 => '090aeaac2cfdc49e22b9102a9852e618f012f0a8',
      1 => 
      array (
        0 => 'luminova\\utils\\queue',
      ),
      2 => 
      array (
        0 => 'luminova\\utils\\__construct',
        1 => 'luminova\\utils\\__get',
        2 => 'luminova\\utils\\__isset',
        3 => 'luminova\\utils\\push',
        4 => 'luminova\\utils\\run',
        5 => 'luminova\\utils\\execute',
        6 => 'luminova\\utils\\callqueue',
        7 => 'luminova\\utils\\isempty',
        8 => 'luminova\\utils\\hasqueue',
        9 => 'luminova\\utils\\iscallable',
        10 => 'luminova\\utils\\size',
        11 => 'luminova\\utils\\delete',
        12 => 'luminova\\utils\\remove',
        13 => 'luminova\\utils\\free',
        14 => 'luminova\\utils\\returninstance',
        15 => 'luminova\\utils\\getinstance',
        16 => 'luminova\\utils\\current',
        17 => 'luminova\\utils\\next',
        18 => 'luminova\\utils\\last',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Models/PushMessage.php' => 
    array (
      0 => '41934b7bc1f886609a02b0c2ce1fd7a51901fe76',
      1 => 
      array (
        0 => 'luminova\\models\\pushmessage',
      ),
      2 => 
      array (
        0 => 'luminova\\models\\__construct',
        1 => 'luminova\\models\\settitle',
        2 => 'luminova\\models\\setbody',
        3 => 'luminova\\models\\seticon',
        4 => 'luminova\\models\\setsound',
        5 => 'luminova\\models\\setvibrate',
        6 => 'luminova\\models\\setclickaction',
        7 => 'luminova\\models\\settag',
        8 => 'luminova\\models\\setcolor',
        9 => 'luminova\\models\\adddata',
        10 => 'luminova\\models\\settokens',
        11 => 'luminova\\models\\gettokens',
        12 => 'luminova\\models\\gettitle',
        13 => 'luminova\\models\\getbody',
        14 => 'luminova\\models\\getdata',
        15 => 'luminova\\models\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Models/Model.php' => 
    array (
      0 => '860dc2fec4af3ef03fafedae556af133f3815662',
      1 => 
      array (
        0 => 'luminova\\models\\model',
      ),
      2 => 
      array (
        0 => 'luminova\\models\\__construct',
        1 => 'luminova\\models\\insertrecord',
        2 => 'luminova\\models\\updaterecord',
        3 => 'luminova\\models\\getrecord',
        4 => 'luminova\\models\\selectrecords',
        5 => 'luminova\\models\\deleterecord',
        6 => 'luminova\\models\\gettable',
        7 => 'luminova\\models\\getkey',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/ErrorException.php' => 
    array (
      0 => 'f156c937d44e036fa99755a16a51581e5cbfb9df',
      1 => 
      array (
        0 => 'luminova\\exceptions\\errorexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/InvalidException.php' => 
    array (
      0 => 'f32645021c8cbf68341a8d0204daf8b6ec6b0a10',
      1 => 
      array (
        0 => 'luminova\\exceptions\\invalidexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/InvalidObjectException.php' => 
    array (
      0 => 'e48f75e3508fc707bcde149b79d0cfa04014331f',
      1 => 
      array (
        0 => 'luminova\\exceptions\\invalidobjectexception',
      ),
      2 => 
      array (
        0 => 'luminova\\exceptions\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/DatabaseException.php' => 
    array (
      0 => 'df0a11d492fd9184d928b662af090ce2bd32ca39',
      1 => 
      array (
        0 => 'luminova\\exceptions\\databaseexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/ViewNotFoundException.php' => 
    array (
      0 => '2e0ea0766f84c62e5a606bef405d44d3e0105ec8',
      1 => 
      array (
        0 => 'luminova\\exceptions\\viewnotfoundexception',
      ),
      2 => 
      array (
        0 => 'luminova\\exceptions\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/NotFoundException.php' => 
    array (
      0 => 'a073d17a2fad47e8634b6ed297117e597f33649f',
      1 => 
      array (
        0 => 'luminova\\exceptions\\notfoundexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/RuntimeException.php' => 
    array (
      0 => 'c5a401a32bfe699c2d619a8dcfa962d1f22cf639',
      1 => 
      array (
        0 => 'luminova\\exceptions\\runtimeexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/LuminovaException.php' => 
    array (
      0 => '60c068e0920a3f4b639fe82ba3be47a7b58fce44',
      1 => 
      array (
        0 => 'luminova\\exceptions\\luminovaexception',
      ),
      2 => 
      array (
        0 => 'luminova\\exceptions\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/ValidationException.php' => 
    array (
      0 => '754cfba85296835fd75e22200e6397ef6705ae0a',
      1 => 
      array (
        0 => 'luminova\\exceptions\\validationexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/FileException.php' => 
    array (
      0 => 'a2fb98b5af38e99fd2f14d67a5be866b84f18cc7',
      1 => 
      array (
        0 => 'luminova\\exceptions\\fileexception',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/AppException.php' => 
    array (
      0 => '2f20c645234328b0d0bee4e772f35ee91dce81e6',
      1 => 
      array (
        0 => 'luminova\\exceptions\\appexception',
      ),
      2 => 
      array (
        0 => 'luminova\\exceptions\\__construct',
        1 => 'luminova\\exceptions\\__tostring',
        2 => 'luminova\\exceptions\\handle',
        3 => 'luminova\\exceptions\\logexception',
        4 => 'luminova\\exceptions\\throwexception',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Exceptions/ClassException.php' => 
    array (
      0 => 'cd4827d368ccf8177a09fe78d3f4d72bb9e54d7e',
      1 => 
      array (
        0 => 'luminova\\exceptions\\classexception',
      ),
      2 => 
      array (
        0 => 'luminova\\exceptions\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Storage/AwsC3.php' => 
    array (
      0 => 'da39a3ee5e6b4b0d3255bfef95601890afd80709',
      1 => 
      array (
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Time/Task.php' => 
    array (
      0 => '8459a48a2db79ab0004104f9e9ba347c277d9812',
      1 => 
      array (
        0 => 'luminova\\time\\task',
      ),
      2 => 
      array (
        0 => 'luminova\\time\\__construct',
        1 => 'luminova\\time\\createdate',
        2 => 'luminova\\time\\isactive',
        3 => 'luminova\\time\\isopen',
        4 => 'luminova\\time\\expired',
        5 => 'luminova\\time\\campaignexpired',
        6 => 'luminova\\time\\hasexpired',
        7 => 'luminova\\time\\haspassed',
        8 => 'luminova\\time\\format',
        9 => 'luminova\\time\\todatetime',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Languages/Translator.php' => 
    array (
      0 => '5084e74474048f600056987b4b56339210018db9',
      1 => 
      array (
        0 => 'luminova\\languages\\translator',
      ),
      2 => 
      array (
        0 => 'luminova\\languages\\__construct',
        1 => 'luminova\\languages\\loadtranslations',
        2 => 'luminova\\languages\\get',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Sessions/SessionManager.php' => 
    array (
      0 => '21bd9ef88ab54bd0313bbcd48310dd1217680c22',
      1 => 
      array (
        0 => 'luminova\\sessions\\sessionmanager',
      ),
      2 => 
      array (
        0 => 'luminova\\sessions\\__construct',
        1 => 'luminova\\sessions\\setconfig',
        2 => 'luminova\\sessions\\setstorage',
        3 => 'luminova\\sessions\\getstorage',
        4 => 'luminova\\sessions\\add',
        5 => 'luminova\\sessions\\set',
        6 => 'luminova\\sessions\\get',
        7 => 'luminova\\sessions\\getfrom',
        8 => 'luminova\\sessions\\setto',
        9 => 'luminova\\sessions\\online',
        10 => 'luminova\\sessions\\clear',
        11 => 'luminova\\sessions\\remove',
        12 => 'luminova\\sessions\\haskey',
        13 => 'luminova\\sessions\\hasstorage',
        14 => 'luminova\\sessions\\getresult',
        15 => 'luminova\\sessions\\toarray',
        16 => 'luminova\\sessions\\toobject',
        17 => 'luminova\\sessions\\getcontents',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Sessions/Session.php' => 
    array (
      0 => 'c5324d15213776d4fb39b5e4528c69ae638f3f1e',
      1 => 
      array (
        0 => 'luminova\\sessions\\session',
      ),
      2 => 
      array (
        0 => 'luminova\\sessions\\__construct',
        1 => 'luminova\\sessions\\getinstance',
        2 => 'luminova\\sessions\\setlogger',
        3 => 'luminova\\sessions\\toarray',
        4 => 'luminova\\sessions\\toobject',
        5 => 'luminova\\sessions\\toexport',
        6 => 'luminova\\sessions\\setmanager',
        7 => 'luminova\\sessions\\setstorage',
        8 => 'luminova\\sessions\\get',
        9 => 'luminova\\sessions\\getfrom',
        10 => 'luminova\\sessions\\setto',
        11 => 'luminova\\sessions\\online',
        12 => 'luminova\\sessions\\set',
        13 => 'luminova\\sessions\\add',
        14 => 'luminova\\sessions\\remove',
        15 => 'luminova\\sessions\\clear',
        16 => 'luminova\\sessions\\has',
        17 => 'luminova\\sessions\\start',
        18 => 'luminova\\sessions\\synchronize',
        19 => 'luminova\\sessions\\goonline',
        20 => 'luminova\\sessions\\ipchanged',
        21 => 'luminova\\sessions\\sessionconfigure',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Sessions/SessionInterface.php' => 
    array (
      0 => 'a3615bc5364f1e060c0c99d5ad0c45950013a473',
      1 => 
      array (
        0 => 'luminova\\sessions\\sessioninterface',
      ),
      2 => 
      array (
        0 => 'luminova\\sessions\\setstorage',
        1 => 'luminova\\sessions\\getstorage',
        2 => 'luminova\\sessions\\add',
        3 => 'luminova\\sessions\\set',
        4 => 'luminova\\sessions\\get',
        5 => 'luminova\\sessions\\getfrom',
        6 => 'luminova\\sessions\\setto',
        7 => 'luminova\\sessions\\online',
        8 => 'luminova\\sessions\\clear',
        9 => 'luminova\\sessions\\remove',
        10 => 'luminova\\sessions\\getcontents',
        11 => 'luminova\\sessions\\getresult',
        12 => 'luminova\\sessions\\haskey',
        13 => 'luminova\\sessions\\hasstorage',
        14 => 'luminova\\sessions\\toarray',
        15 => 'luminova\\sessions\\toobject',
        16 => 'luminova\\sessions\\setconfig',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Sessions/CookieManager.php' => 
    array (
      0 => 'df192e41a97481c36420c98e9feefa78a05d2b97',
      1 => 
      array (
        0 => 'luminova\\sessions\\cookiemanager',
      ),
      2 => 
      array (
        0 => 'luminova\\sessions\\__construct',
        1 => 'luminova\\sessions\\setconfig',
        2 => 'luminova\\sessions\\setstorage',
        3 => 'luminova\\sessions\\getstorage',
        4 => 'luminova\\sessions\\add',
        5 => 'luminova\\sessions\\set',
        6 => 'luminova\\sessions\\get',
        7 => 'luminova\\sessions\\getfrom',
        8 => 'luminova\\sessions\\setto',
        9 => 'luminova\\sessions\\online',
        10 => 'luminova\\sessions\\clear',
        11 => 'luminova\\sessions\\remove',
        12 => 'luminova\\sessions\\haskey',
        13 => 'luminova\\sessions\\hasstorage',
        14 => 'luminova\\sessions\\getresult',
        15 => 'luminova\\sessions\\toarray',
        16 => 'luminova\\sessions\\toobject',
        17 => 'luminova\\sessions\\getcontents',
        18 => 'luminova\\sessions\\setcontents',
        19 => 'luminova\\sessions\\updatecontents',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/NetworkAsync.php' => 
    array (
      0 => '71be928b57cf122253d074f4f2ae94d9da8551ac',
      1 => 
      array (
        0 => 'luminova\\http\\networkasync',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\__construct',
        1 => 'luminova\\http\\sendasync',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/NetworkRequest.php' => 
    array (
      0 => '842475c4e1b03462bd1af1297d76ddb91564ea47',
      1 => 
      array (
        0 => 'luminova\\http\\networkrequest',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\__construct',
        1 => 'luminova\\http\\getmethod',
        2 => 'luminova\\http\\geturl',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/NetworkClientInterface.php' => 
    array (
      0 => '294fbf5aa1d05f3cef2ee85f132b3d66900fd6ba',
      1 => 
      array (
        0 => 'luminova\\http\\networkclientinterface',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\request',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/Request.php' => 
    array (
      0 => '78b9b4fd63d266f557f5a815395bf0898cbee268',
      1 => 
      array (
        0 => 'luminova\\http\\request',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\__construct',
        1 => 'luminova\\http\\find',
        2 => 'luminova\\http\\get',
        3 => 'luminova\\http\\getpost',
        4 => 'luminova\\http\\getput',
        5 => 'luminova\\http\\getdelete',
        6 => 'luminova\\http\\getoption',
        7 => 'luminova\\http\\getpatch',
        8 => 'luminova\\http\\gethead',
        9 => 'luminova\\http\\getconnect',
        10 => 'luminova\\http\\gettrace',
        11 => 'luminova\\http\\getpropfind',
        12 => 'luminova\\http\\getmkcol',
        13 => 'luminova\\http\\getcopy',
        14 => 'luminova\\http\\getmove',
        15 => 'luminova\\http\\getlock',
        16 => 'luminova\\http\\getunlock',
        17 => 'luminova\\http\\getbody',
        18 => 'luminova\\http\\getbodyasobject',
        19 => 'luminova\\http\\getfile',
        20 => 'luminova\\http\\getfiles',
        21 => 'luminova\\http\\parsefiles',
        22 => 'luminova\\http\\getmethod',
        23 => 'luminova\\http\\getcontenttype',
        24 => 'luminova\\http\\parserequestbody',
        25 => 'luminova\\http\\getauthorization',
        26 => 'luminova\\http\\getauthbearer',
        27 => 'luminova\\http\\iscommandline',
        28 => 'luminova\\http\\issecure',
        29 => 'luminova\\http\\isajax',
        30 => 'luminova\\http\\geturi',
        31 => 'luminova\\http\\getbrowser',
        32 => 'luminova\\http\\getuseragent',
        33 => 'luminova\\http\\hasheader',
        34 => 'luminova\\http\\header',
        35 => 'luminova\\http\\getheaders',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/Header.php' => 
    array (
      0 => 'ecec008092c52b19267424fd5b9e28b9014c516b',
      1 => 
      array (
        0 => 'luminova\\http\\header',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\getheaders',
        1 => 'luminova\\http\\getservervariable',
        2 => 'luminova\\http\\getmethod',
        3 => 'luminova\\http\\getsystemheaders',
        4 => 'luminova\\http\\getcontenttype',
        5 => 'luminova\\http\\getroutingmethod',
        6 => 'luminova\\http\\getauthorization',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/CurlAsyncClient.php' => 
    array (
      0 => '637b1f834d051f345bd979522f66692ee451d9cb',
      1 => 
      array (
        0 => 'luminova\\http\\curlasyncclient',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\sendasync',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/Network.php' => 
    array (
      0 => '9ba4a5bf71a38e3ba9ccdff01ba255f392cabd2f',
      1 => 
      array (
        0 => 'luminova\\http\\network',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\__construct',
        1 => 'luminova\\http\\send',
        2 => 'luminova\\http\\get',
        3 => 'luminova\\http\\fetch',
        4 => 'luminova\\http\\post',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/NetworkResponse.php' => 
    array (
      0 => 'ccf921c907524f7a6d43a4f32edba879c2a8693b',
      1 => 
      array (
        0 => 'luminova\\http\\networkresponse',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\__construct',
        1 => 'luminova\\http\\getstatuscode',
        2 => 'luminova\\http\\getheaders',
        3 => 'luminova\\http\\getbody',
        4 => 'luminova\\http\\getcontents',
        5 => 'luminova\\http\\getinfos',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/AsyncClientInterface.php' => 
    array (
      0 => 'c454e85359fdcafcd6b921ff42fa2aa3065bf884',
      1 => 
      array (
        0 => 'luminova\\http\\asyncclientinterface',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\sendasync',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/Client/Curl.php' => 
    array (
      0 => '47fd656075ed3feed865be1311cd1642b475e852',
      1 => 
      array (
        0 => 'luminova\\http\\client\\curl',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\client\\__construct',
        1 => 'luminova\\http\\client\\request',
        2 => 'luminova\\http\\client\\torequestheaders',
        3 => 'luminova\\http\\client\\headertoarray',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/Client/Guzzle.php' => 
    array (
      0 => '826dcbede481cdbfb283b3209cd543d22d242e7f',
      1 => 
      array (
        0 => 'luminova\\http\\client\\guzzle',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\client\\__construct',
        1 => 'luminova\\http\\client\\request',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/GuzzleAsyncClient.php' => 
    array (
      0 => '229fd81730261392a3c87bdd83b4586f390e4de5',
      1 => 
      array (
        0 => 'luminova\\http\\guzzleasyncclient',
      ),
      2 => 
      array (
        0 => 'luminova\\http\\__construct',
        1 => 'luminova\\http\\sendasync',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Arrays/ArrayInput.php' => 
    array (
      0 => '0bebdcf751a45c5636fa4af0920aa0f2c47f9780',
      1 => 
      array (
        0 => 'luminova\\arrays\\arrayinput',
      ),
      2 => 
      array (
        0 => 'luminova\\arrays\\__construct',
        1 => 'luminova\\arrays\\getparameteroption',
        2 => 'luminova\\arrays\\hasparameteroption',
        3 => 'luminova\\arrays\\getparameters',
        4 => 'luminova\\arrays\\getarguments',
        5 => 'luminova\\arrays\\getoptions',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Arrays/Arrays.php' => 
    array (
      0 => 'c82784eacbd0fba0aad43e4b75f1e0773fde6512',
      1 => 
      array (
        0 => 'luminova\\arrays\\arrays',
      ),
      2 => 
      array (
        0 => 'luminova\\arrays\\__construct',
        1 => 'luminova\\arrays\\get',
        2 => 'luminova\\arrays\\isnested',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Arrays/ArrayObject.php' => 
    array (
      0 => 'ea87b1c1c8ab895888187ecf89855d4ead79fee3',
      1 => 
      array (
        0 => 'arrayobject',
      ),
      2 => 
      array (
        0 => 'getcolumns',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Arrays/ArrayCountable.php' => 
    array (
      0 => '1f360e7e13b860083e2313f9f23a2467b2eb9317',
      1 => 
      array (
        0 => 'luminova\\arrays\\arraycountable',
      ),
      2 => 
      array (
        0 => 'luminova\\arrays\\__construct',
        1 => 'luminova\\arrays\\count',
        2 => 'luminova\\arrays\\isnested',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Functions/Functions.php' => 
    array (
      0 => 'd1422043430614b4259a77c1206520afa6170ffe',
      1 => 
      array (
        0 => 'luminova\\functions\\functions',
      ),
      2 => 
      array (
        0 => 'luminova\\functions\\__construct',
        1 => 'luminova\\functions\\toname',
        2 => 'luminova\\functions\\isnamebanned',
        3 => 'luminova\\functions\\sanitizetext',
        4 => 'luminova\\functions\\filtertext',
        5 => 'luminova\\functions\\random',
        6 => 'luminova\\functions\\biginteger',
        7 => 'luminova\\functions\\ean',
        8 => 'luminova\\functions\\upc',
        9 => 'luminova\\functions\\timesocial',
        10 => 'luminova\\functions\\timehaspassed',
        11 => 'luminova\\functions\\dayssuffix',
        12 => 'luminova\\functions\\isempty',
        13 => 'luminova\\functions\\uuid',
        14 => 'luminova\\functions\\is_uuid',
        15 => 'luminova\\functions\\uuidtokey',
        16 => 'luminova\\functions\\is_email',
        17 => 'luminova\\functions\\is_phone',
        18 => 'luminova\\functions\\is_email_or_phone',
        19 => 'luminova\\functions\\isphonenumber',
        20 => 'luminova\\functions\\strongpassword',
        21 => 'luminova\\functions\\hashpassword',
        22 => 'luminova\\functions\\verifypassword',
        23 => 'luminova\\functions\\averagerating',
        24 => 'luminova\\functions\\money',
        25 => 'luminova\\functions\\fixed',
        26 => 'luminova\\functions\\discount',
        27 => 'luminova\\functions\\addinterest',
        28 => 'luminova\\functions\\badges',
        29 => 'luminova\\functions\\buttonbadges',
        30 => 'luminova\\functions\\hoursrange',
        31 => 'luminova\\functions\\daysinmonth',
        32 => 'luminova\\functions\\sanitizeinput',
        33 => 'luminova\\functions\\tohtmlentities',
        34 => 'luminova\\functions\\removesubdomain',
        35 => 'luminova\\functions\\removemaindomain',
        36 => 'luminova\\functions\\tokebabcase',
        37 => 'luminova\\functions\\copyfiles',
        38 => 'luminova\\functions\\download',
        39 => 'luminova\\functions\\truncate',
        40 => 'luminova\\functions\\base64_url_encode',
        41 => 'luminova\\functions\\base64_url_decode',
        42 => 'luminova\\functions\\striptext',
        43 => 'luminova\\functions\\maskemail',
        44 => 'luminova\\functions\\mask',
        45 => 'luminova\\functions\\remove',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Functions/IPAddress.php' => 
    array (
      0 => '9c7b1a8f3da164152aad31465a7bf5b2e0de94f9',
      1 => 
      array (
        0 => 'luminova\\functions\\ipaddress',
      ),
      2 => 
      array (
        0 => 'luminova\\functions\\get',
        1 => 'luminova\\functions\\isvalid',
        2 => 'luminova\\functions\\tonumeric',
        3 => 'luminova\\functions\\toaddress',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/TerminalGenerator.php' => 
    array (
      0 => '41b291b9fd6d246342f6fb421b06895ce9d73d48',
      1 => 
      array (
        0 => 'luminova\\command\\terminalgenerator',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/TextUtils.php' => 
    array (
      0 => 'e42387400b2d09964e9d0a593c9e2b17f922c0c9',
      1 => 
      array (
        0 => 'luminova\\command\\textutils',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\leftpad',
        1 => 'luminova\\command\\rightpad',
        2 => 'luminova\\command\\padding',
        3 => 'luminova\\command\\strlen',
        4 => 'luminova\\command\\style',
        5 => 'luminova\\command\\hasansimethod',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Colors.php' => 
    array (
      0 => '8bfe780606c285ce86b91bbf47dad97479dfedba',
      1 => 
      array (
        0 => 'luminova\\command\\colors',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\apply',
        1 => 'luminova\\command\\isvalidcolor',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Terminal.php' => 
    array (
      0 => '83f7669398bd8261663b9b5f3c80546c4ca662a2',
      1 => 
      array (
        0 => 'luminova\\command\\terminal',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\__construct',
        1 => 'luminova\\command\\waiting',
        2 => 'luminova\\command\\progress',
        3 => 'luminova\\command\\progresswatch',
        4 => 'luminova\\command\\beeps',
        5 => 'luminova\\command\\prompt',
        6 => 'luminova\\command\\promptchooser',
        7 => 'luminova\\command\\getinputarrayvalues',
        8 => 'luminova\\command\\writearrayvalues',
        9 => 'luminova\\command\\wrap',
        10 => 'luminova\\command\\getwidth',
        11 => 'luminova\\command\\getheight',
        12 => 'luminova\\command\\getvisiblewindow',
        13 => 'luminova\\command\\input',
        14 => 'luminova\\command\\validate',
        15 => 'luminova\\command\\error',
        16 => 'luminova\\command\\writeln',
        17 => 'luminova\\command\\write',
        18 => 'luminova\\command\\fwrite',
        19 => 'luminova\\command\\clear',
        20 => 'luminova\\command\\clearandupdateoutput',
        21 => 'luminova\\command\\color',
        22 => 'luminova\\command\\newline',
        23 => 'luminova\\command\\resourcesupportcolor',
        24 => 'luminova\\command\\streamsupports',
        25 => 'luminova\\command\\registercommands',
        26 => 'luminova\\command\\parsecommands',
        27 => 'luminova\\command\\getrequestcommands',
        28 => 'luminova\\command\\getargument',
        29 => 'luminova\\command\\getarguments',
        30 => 'luminova\\command\\getcommand',
        31 => 'luminova\\command\\getcaller',
        32 => 'luminova\\command\\getoption',
        33 => 'luminova\\command\\getoptions',
        34 => 'luminova\\command\\getquery',
        35 => 'luminova\\command\\getqueries',
        36 => 'luminova\\command\\iscommandline',
        37 => 'luminova\\command\\iscolordisabled',
        38 => 'luminova\\command\\ismacterminal',
        39 => 'luminova\\command\\iswindowsterminal',
        40 => 'luminova\\command\\iswindows',
        41 => 'luminova\\command\\ismacos',
        42 => 'luminova\\command\\systemhascommand',
        43 => 'luminova\\command\\printhelp',
        44 => 'luminova\\command\\getstatuscode',
        45 => 'luminova\\command\\header',
        46 => 'luminova\\command\\phpscript',
      ),
      3 => 
      array (
        0 => 'STDOUT',
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Commands.php' => 
    array (
      0 => '5abaf389d322d22f7e279190f6980ed6d63c4de0',
      1 => 
      array (
        0 => 'luminova\\command\\commands',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\run',
        1 => 'luminova\\command\\discovercommands',
        2 => 'luminova\\command\\addcommand',
        3 => 'luminova\\command\\getcommand',
        4 => 'luminova\\command\\has',
        5 => 'luminova\\command\\get',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Console.php' => 
    array (
      0 => '0298f567fa2d79795eafed4d4fba898571c231c3',
      1 => 
      array (
        0 => 'luminova\\command\\console',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\__construct',
        1 => 'luminova\\command\\getterminal',
        2 => 'luminova\\command\\run',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/Generators.php' => 
    array (
      0 => 'dbb3e13b39e887705e33cef677584ad5eb786fc5',
      1 => 
      array (
        0 => 'luminova\\command\\novakit\\generators',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\novakit\\run',
        1 => 'luminova\\command\\novakit\\createcontroller',
        2 => 'luminova\\command\\novakit\\createview',
        3 => 'luminova\\command\\novakit\\createclass',
        4 => 'luminova\\command\\novakit\\createhelper',
        5 => 'luminova\\command\\novakit\\savefile',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/Server.php' => 
    array (
      0 => '7481f2df988a6a5cee95e00ded7a88f306aeb330',
      1 => 
      array (
        0 => 'luminova\\command\\novakit\\server',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\novakit\\run',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/AvailableCommands.php' => 
    array (
      0 => '84a31a03a1c08a5550b4b0e68ab534f378df6814',
      1 => 
      array (
        0 => 'luminova\\command\\novakit\\availablecommands',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\novakit\\getcommands',
        1 => 'luminova\\command\\novakit\\get',
        2 => 'luminova\\command\\novakit\\has',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/Database.php' => 
    array (
      0 => 'a2de34f54c7119d71e74a6e937298e6f639c1628',
      1 => 
      array (
        0 => 'luminova\\command\\novakit\\database',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\novakit\\run',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/mod_rewrite.php' => 
    array (
      0 => 'eaec045d0b5c5f3bdf99b14c597b72b6695f9f80',
      1 => 
      array (
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/Help.php' => 
    array (
      0 => '4f4bd9c321073d16c225eac3a80d1babe07ba836',
      1 => 
      array (
        0 => 'luminova\\command\\novakit\\help',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\novakit\\run',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/Lists.php' => 
    array (
      0 => '9ca1679c139947aceffc8fd8c2c021f372cdc807',
      1 => 
      array (
        0 => 'luminova\\command\\novakit\\lists',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\novakit\\run',
        1 => 'luminova\\command\\novakit\\listcommands',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Application/Application.php' => 
    array (
      0 => 'd55558069dcf71b3480a6742dc17b7ae7de52e37',
      1 => 
      array (
        0 => 'luminova\\application\\application',
      ),
      2 => 
      array (
        0 => 'luminova\\application\\__construct',
        1 => 'luminova\\application\\getview',
        2 => 'luminova\\application\\getbasepath',
        3 => 'luminova\\application\\getinstance',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Routing/Bootstrap.php' => 
    array (
      0 => '4331692869740c8fd987176d08c83c3a99f352c0',
      1 => 
      array (
        0 => 'luminova\\routing\\bootstrap',
      ),
      2 => 
      array (
        0 => 'luminova\\routing\\__construct',
        1 => 'luminova\\routing\\gettype',
        2 => 'luminova\\routing\\getfunction',
        3 => 'luminova\\routing\\geterrorhandler',
        4 => 'luminova\\routing\\getinstances',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Routing/Router.php' => 
    array (
      0 => 'c3178e598238aaf56cd962800b8c5e8be34eb2b2',
      1 => 
      array (
        0 => 'luminova\\routing\\router',
      ),
      2 => 
      array (
        0 => 'luminova\\routing\\before',
        1 => 'luminova\\routing\\after',
        2 => 'luminova\\routing\\capture',
        3 => 'luminova\\routing\\authenticate',
        4 => 'luminova\\routing\\command',
        5 => 'luminova\\routing\\any',
        6 => 'luminova\\routing\\get',
        7 => 'luminova\\routing\\post',
        8 => 'luminova\\routing\\patch',
        9 => 'luminova\\routing\\delete',
        10 => 'luminova\\routing\\put',
        11 => 'luminova\\routing\\options',
        12 => 'luminova\\routing\\bind',
        13 => 'luminova\\routing\\bootstraps',
        14 => 'luminova\\routing\\iswebinstance',
        15 => 'luminova\\routing\\addnamespace',
        16 => 'luminova\\routing\\run',
        17 => 'luminova\\routing\\runascli',
        18 => 'luminova\\routing\\runashttp',
        19 => 'luminova\\routing\\seterrorhandler',
        20 => 'luminova\\routing\\triggererror',
        21 => 'luminova\\routing\\handlewebsite',
        22 => 'luminova\\routing\\handlecommand',
        23 => 'luminova\\routing\\processfindmatches',
        24 => 'luminova\\routing\\execute',
        25 => 'luminova\\routing\\reflectionclassloader',
        26 => 'luminova\\routing\\invokecommandargs',
        27 => 'luminova\\routing\\getstatus',
        28 => 'luminova\\routing\\getnamespaces',
        29 => 'luminova\\routing\\patternmatches',
        30 => 'luminova\\routing\\getbasepath',
        31 => 'luminova\\routing\\getview',
        32 => 'luminova\\routing\\getviewuri',
        33 => 'luminova\\routing\\getarrayviews',
        34 => 'luminova\\routing\\getviewposition',
        35 => 'luminova\\routing\\getfirstview',
        36 => 'luminova\\routing\\getlastview',
        37 => 'luminova\\routing\\getsecondtolastview',
        38 => 'luminova\\routing\\parsepatternvalue',
        39 => 'luminova\\routing\\setbasepath',
        40 => 'luminova\\routing\\getcommandname',
        41 => 'luminova\\routing\\resetroutes',
      ),
      3 => 
      array (
        0 => 'ENVIRONMENT',
        1 => 'CLI_ENVIRONMENT',
        2 => 'STDOUT',
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Errors/Codes.php' => 
    array (
      0 => '5b28ce9215b12117078e51660669b9dd1e70ddac',
      1 => 
      array (
        0 => 'luminova\\errors\\codes',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Errors/Error.php' => 
    array (
      0 => '5bcfd10fdb208d6de4c1da60cffaae3efd74a7b2',
      1 => 
      array (
        0 => 'luminova\\errors\\error',
      ),
      2 => 
      array (
        0 => 'luminova\\errors\\getname',
        1 => 'luminova\\errors\\display',
        2 => 'luminova\\errors\\handle',
        3 => 'luminova\\errors\\shutdown',
        4 => 'luminova\\errors\\isfatal',
        5 => 'luminova\\errors\\log',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Seo/Meta.php' => 
    array (
      0 => '753652886461a95824a306e51dde9dc558175f2c',
      1 => 
      array (
        0 => 'luminova\\seo\\meta',
      ),
      2 => 
      array (
        0 => 'luminova\\seo\\__construct',
        1 => 'luminova\\seo\\getinstance',
        2 => 'luminova\\seo\\create',
        3 => 'luminova\\seo\\setlink',
        4 => 'luminova\\seo\\setconfig',
        5 => 'luminova\\seo\\settitle',
        6 => 'luminova\\seo\\setcanonical',
        7 => 'luminova\\seo\\setcanonicalversion',
        8 => 'luminova\\seo\\setpagetitle',
        9 => 'luminova\\seo\\tokebabcase',
        10 => 'luminova\\seo\\todate',
        11 => 'luminova\\seo\\getconfig',
        12 => 'luminova\\seo\\shouldaddparam',
        13 => 'luminova\\seo\\getquery',
        14 => 'luminova\\seo\\tojson',
        15 => 'luminova\\seo\\loaddefaultconfig',
        16 => 'luminova\\seo\\generatescheme',
        17 => 'luminova\\seo\\getmetatags',
        18 => 'luminova\\seo\\has_query_parameter',
        19 => 'luminova\\seo\\getobjectgraph',
        20 => 'luminova\\seo\\readmanifest',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Controllers/Controller.php' => 
    array (
      0 => '1cf91adcd631cf8fdfcfaca92b0f49c1c9db0c79',
      1 => 
      array (
        0 => 'luminova\\controllers\\controller',
      ),
      2 => 
      array (
        0 => 'luminova\\controllers\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Notifications/FirebaseRealtime.php' => 
    array (
      0 => 'e5b052182488d4be09b4626f2dfb6eda7763c65e',
      1 => 
      array (
        0 => 'luminova\\notifications\\firebaserealtime',
      ),
      2 => 
      array (
        0 => 'luminova\\notifications\\__construct',
        1 => 'luminova\\notifications\\settable',
        2 => 'luminova\\notifications\\gettable',
        3 => 'luminova\\notifications\\get',
        4 => 'luminova\\notifications\\insert',
        5 => 'luminova\\notifications\\update',
        6 => 'luminova\\notifications\\delete',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Notifications/FirebasePusher.php' => 
    array (
      0 => '930a209e6a3aa3768f912f0f3207f00069258c1b',
      1 => 
      array (
        0 => 'luminova\\notifications\\firebasepusher',
      ),
      2 => 
      array (
        0 => 'luminova\\notifications\\__construct',
        1 => 'luminova\\notifications\\messaging',
        2 => 'luminova\\notifications\\create',
        3 => 'luminova\\notifications\\sendtoid',
        4 => 'luminova\\notifications\\channel',
        5 => 'luminova\\notifications\\cast',
        6 => 'luminova\\notifications\\push',
        7 => 'luminova\\notifications\\device',
        8 => 'luminova\\notifications\\subscribe',
        9 => 'luminova\\notifications\\send',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Email/Mailer.php' => 
    array (
      0 => '4423e88392cbad02569dba8e87a5738476b09c3f',
      1 => 
      array (
        0 => 'luminova\\email\\mailer',
      ),
      2 => 
      array (
        0 => 'luminova\\email\\__construct',
        1 => 'luminova\\email\\getinstance',
        2 => 'luminova\\email\\addaddress',
        3 => 'luminova\\email\\addreplyto',
        4 => 'luminova\\email\\setfrom',
        5 => 'luminova\\email\\send',
        6 => 'luminova\\email\\configuremailer',
        7 => 'luminova\\email\\shoulddebug',
        8 => 'luminova\\email\\getencryptiontype',
        9 => 'luminova\\email\\getcharset',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseApplication.php' => 
    array (
      0 => 'e270da1d176a845f7e2a771bc7c25f6af8d8ebfb',
      1 => 
      array (
        0 => 'luminova\\base\\baseapplication',
      ),
      2 => 
      array (
        0 => 'luminova\\base\\__get',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseCommand.php' => 
    array (
      0 => 'e72e9230f64f2f10119574d8e54829e7618c20c7',
      1 => 
      array (
        0 => 'luminova\\base\\basecommand',
      ),
      2 => 
      array (
        0 => 'luminova\\base\\run',
        1 => 'luminova\\base\\__get',
        2 => 'luminova\\base\\__isset',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseController.php' => 
    array (
      0 => 'b94f900fee0726157d658fa06b45d464ad44c0e2',
      1 => 
      array (
        0 => 'luminova\\base\\basecontroller',
      ),
      2 => 
      array (
        0 => 'luminova\\base\\__get',
        1 => 'luminova\\base\\__isset',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseModel.php' => 
    array (
      0 => 'b863595d169c0272747e0cc1310592e81eb84393',
      1 => 
      array (
        0 => 'luminova\\base\\basemodel',
      ),
      2 => 
      array (
        0 => 'luminova\\base\\__get',
        1 => 'luminova\\base\\__isset',
      ),
      3 => 
      array (
      ),
    ),
  ),
));