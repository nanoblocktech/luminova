<?php declare(strict_types = 1);

// odsl-/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v1',
   'data' => 
  array (
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Database/Connection.php' => 
    array (
      0 => 'ff8145c5a3a6075eef00ad985b4a93f36b16f55f',
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
      0 => '300be9b2987b78103c0e360963d49ed2b5b96f5e',
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
      0 => '487c6659a19c6844b13600c1f1e29709c9297fc5',
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
      0 => '2819f3d3c225988c46d9146879e48ab95b8b6a41',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cache/FileCache.php' => 
    array (
      0 => 'f322037de7afab6969e3d421f5ac041127031bc9',
      1 => 
      array (
        0 => 'luminova\\cache\\filecache',
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
      0 => '7bd74d2d0f3850ef1c2a76bafd5fa9df6d2c5e99',
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
      0 => 'f8e6f8919689bdf551abca4b235e9e3018b1cb50',
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
      0 => 'b25706a4a5a099037a134de26972e1d47097de8a',
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
      0 => '97f2fb30dca98d6bedbbfe54052d6ff7b7237fc8',
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
      0 => 'e60def6ebcaf4ff4ae0ea712dbea781a888fa6e1',
      1 => 
      array (
        0 => 'luminova\\config\\dotenv',
      ),
      2 => 
      array (
        0 => 'luminova\\config\\register',
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
      0 => 'c250db258d27c8e604b25ce09fb0d564f6d2d172',
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
      0 => '6312370413b2a78a20630543cd04c7bcda65c0a3',
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
        17 => 'luminova\\config\\root',
        18 => 'luminova\\config\\getrootdirectory',
        19 => 'luminova\\config\\filterpath',
        20 => 'luminova\\config\\get',
        21 => 'luminova\\config\\set',
        22 => 'luminova\\config\\getvariables',
        23 => 'luminova\\config\\getstring',
        24 => 'luminova\\config\\getint',
        25 => 'luminova\\config\\getboolean',
        26 => 'luminova\\config\\getmixednull',
        27 => 'luminova\\config\\variabletonotation',
        28 => 'luminova\\config\\copyright',
        29 => 'luminova\\config\\version',
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
      0 => '071fe7e537d4696afcde6b4596895980c0f95280',
      1 => 
      array (
        0 => 'luminova\\security\\inputvalidator',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\validateentries',
        1 => 'luminova\\security\\validatefield',
        2 => 'luminova\\security\\listtoarray',
        3 => 'luminova\\security\\listinarray',
        4 => 'luminova\\security\\geterrors',
        5 => 'luminova\\security\\geterror',
        6 => 'luminova\\security\\geterrorfield',
        7 => 'luminova\\security\\geterrorline',
        8 => 'luminova\\security\\getcurrenterrorinfo',
        9 => 'luminova\\security\\getcurrenterrorfield',
        10 => 'luminova\\security\\geterrorbyindices',
        11 => 'luminova\\security\\adderror',
        12 => 'luminova\\security\\setrules',
        13 => 'luminova\\security\\addrule',
        14 => 'luminova\\security\\setmessages',
        15 => 'luminova\\security\\addmessage',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/Csrf.php' => 
    array (
      0 => 'fed63a401c7c01bf92a6aead3464758221d48d2b',
      1 => 
      array (
        0 => 'luminova\\security\\csrf',
      ),
      2 => 
      array (
        0 => 'luminova\\security\\generatetoken',
        1 => 'luminova\\security\\tokenstorage',
        2 => 'luminova\\security\\savetoken',
        3 => 'luminova\\security\\hastoken',
        4 => 'luminova\\security\\hascookie',
        5 => 'luminova\\security\\refreshtoken',
        6 => 'luminova\\security\\gettoken',
        7 => 'luminova\\security\\inputtoken',
        8 => 'luminova\\security\\metatoken',
        9 => 'luminova\\security\\validatetoken',
        10 => 'luminova\\security\\cleartoken',
        11 => 'luminova\\security\\__call',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Security/ValidatorInterface.php' => 
    array (
      0 => 'aa2536e5cad3df0b198f0739ce7c52c826fbe6fc',
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
      0 => '5b0dedfc9742461d63840b0da5cb2422feed2d6a',
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
      0 => 'b4aff10034f7f779cd67ffdf58eb5ba7870c280e',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Template/TemplateTrait.php' => 
    array (
      0 => '7957de0687e886cd8d309f2e6a3bc2155c04fb2d',
      1 => 
      array (
        0 => 'luminova\\template\\templatetrait',
      ),
      2 => 
      array (
        0 => 'luminova\\template\\initialize',
        1 => 'luminova\\template\\__get',
        2 => 'luminova\\template\\getclass',
        3 => 'luminova\\template\\hasclass',
        4 => 'luminova\\template\\setlevel',
        5 => 'luminova\\template\\setoptimizebase',
        6 => 'luminova\\template\\setcompressignorecodeblock',
        7 => 'luminova\\template\\setbasepath',
        8 => 'luminova\\template\\getrootdir',
        9 => 'luminova\\template\\settemplatepath',
        10 => 'luminova\\template\\settemplateengin',
        11 => 'luminova\\template\\gettemplateengin',
        12 => 'luminova\\template\\setfolder',
        13 => 'luminova\\template\\addignoreoptimizer',
        14 => 'luminova\\template\\render',
        15 => 'luminova\\template\\redirect',
        16 => 'luminova\\template\\redirectto',
        17 => 'luminova\\template\\headerlocation',
        18 => 'luminova\\template\\setdocumentroot',
        19 => 'luminova\\template\\registerclass',
        20 => 'luminova\\template\\setattributes',
        21 => 'luminova\\template\\getcontents',
        22 => 'luminova\\template\\getbaseviewfolder',
        23 => 'luminova\\template\\getbaseerrorviewfolder',
        24 => 'luminova\\template\\getbaseoptimizerfolder',
        25 => 'luminova\\template\\cache',
        26 => 'luminova\\template\\respond',
        27 => 'luminova\\template\\renderviewcontent',
        28 => 'luminova\\template\\displaycompressedcontent',
        29 => 'luminova\\template\\renderwithminification',
        30 => 'luminova\\template\\requestheaders',
        31 => 'luminova\\template\\view',
        32 => 'luminova\\template\\shouldoptimize',
        33 => 'luminova\\template\\calculatelevel',
        34 => 'luminova\\template\\gettemplatebaseuri',
        35 => 'luminova\\template\\handleexception',
        36 => 'luminova\\template\\totitle',
        37 => 'luminova\\template\\addtitlesuffix',
      ),
      3 => 
      array (
        0 => 'ALLOW_ACCESS',
        1 => 'SHOW_DEBUG_BACKTRACE',
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Template/Smarty.php' => 
    array (
      0 => '1e2b33c22c0c6cbb0a506fa53006d73ef08783d5',
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
      0 => 'f8217ba3042fed9c0175aeadc7b16c8d57275d00',
      1 => 
      array (
        0 => 'luminova\\template\\template',
      ),
      2 => 
      array (
        0 => 'luminova\\template\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Library/Importer.php' => 
    array (
      0 => '5fb151bbfd6d305d753f949e27ef8715f5e64fb3',
      1 => 
      array (
        0 => 'luminova\\library\\importer',
      ),
      2 => 
      array (
        0 => 'luminova\\library\\import',
      ),
      3 => 
      array (
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
      0 => '9e2e71375cff1c30805b4f3420e90f951f8797fa',
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
      0 => '07ae6451416b592bce346d579fa92e53228cff7f',
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
        5 => 'luminova\\exceptions\\highlightfile',
        6 => 'luminova\\exceptions\\highlightcolor',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Time/Time.php' => 
    array (
      0 => '9ac3d136a0df4d596998611fa89de8423205786d',
      1 => 
      array (
        0 => 'luminova\\time\\time',
      ),
      2 => 
      array (
        0 => 'luminova\\time\\__construct',
        1 => 'luminova\\time\\settimezone',
        2 => 'luminova\\time\\now',
        3 => 'luminova\\time\\parse',
        4 => 'luminova\\time\\today',
        5 => 'luminova\\time\\yesterday',
        6 => 'luminova\\time\\getyear',
        7 => 'luminova\\time\\getmonth',
        8 => 'luminova\\time\\getday',
        9 => 'luminova\\time\\gethour',
        10 => 'luminova\\time\\getminute',
        11 => 'luminova\\time\\getsecond',
        12 => 'luminova\\time\\getdayofyear',
        13 => 'luminova\\time\\getweekofmonth',
        14 => 'luminova\\time\\getweekofyear',
        15 => 'luminova\\time\\getdayofweek',
        16 => 'luminova\\time\\getquarter',
        17 => 'luminova\\time\\isdaylightsaving',
        18 => 'luminova\\time\\issamelocal',
        19 => 'luminova\\time\\getutc',
        20 => 'luminova\\time\\gettimezonename',
        21 => 'luminova\\time\\getutcobject',
        22 => 'luminova\\time\\tolocalizedstring',
        23 => 'luminova\\time\\todatetime',
        24 => 'luminova\\time\\frominstance',
        25 => 'luminova\\time\\fromtimestamp',
        26 => 'luminova\\time\\fromdate',
        27 => 'luminova\\time\\fromtime',
        28 => 'luminova\\time\\createfrom',
        29 => 'luminova\\time\\tomorrow',
        30 => 'luminova\\time\\fromformat',
        31 => 'luminova\\time\\calendar',
        32 => 'luminova\\time\\days',
        33 => 'luminova\\time\\ago',
        34 => 'luminova\\time\\daysuffix',
        35 => 'luminova\\time\\isrelative',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Time/Task.php' => 
    array (
      0 => '6daeadcdb8a2370b78b226d7435ac6db45823df4',
      1 => 
      array (
        0 => 'luminova\\time\\task',
      ),
      2 => 
      array (
        0 => 'luminova\\time\\create',
        1 => 'luminova\\time\\isactive',
        2 => 'luminova\\time\\isopen',
        3 => 'luminova\\time\\expired',
        4 => 'luminova\\time\\campaignexpired',
        5 => 'luminova\\time\\hasexpired',
        6 => 'luminova\\time\\haspassed',
        7 => 'luminova\\time\\format',
        8 => 'luminova\\time\\todatetime',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Languages/Translator.php' => 
    array (
      0 => 'f16c7f103fe4f8b232cf08f797c56a5b82e34f64',
      1 => 
      array (
        0 => 'luminova\\languages\\translator',
      ),
      2 => 
      array (
        0 => 'luminova\\languages\\__construct',
        1 => 'luminova\\languages\\setlocale',
        2 => 'luminova\\languages\\getlocale',
        3 => 'luminova\\languages\\load',
        4 => 'luminova\\languages\\get',
        5 => 'luminova\\languages\\replaceplaceholders',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Sessions/SessionManager.php' => 
    array (
      0 => '3fcb74f04e444bd70ab916fb88062b1c48e7f19a',
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
      0 => 'fbf6141a2ef81f84ddc67023b701d0cf69cc6f84',
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
        7 => 'luminova\\sessions\\getmanager',
        8 => 'luminova\\sessions\\setstorage',
        9 => 'luminova\\sessions\\get',
        10 => 'luminova\\sessions\\getfrom',
        11 => 'luminova\\sessions\\setto',
        12 => 'luminova\\sessions\\online',
        13 => 'luminova\\sessions\\set',
        14 => 'luminova\\sessions\\add',
        15 => 'luminova\\sessions\\remove',
        16 => 'luminova\\sessions\\clear',
        17 => 'luminova\\sessions\\has',
        18 => 'luminova\\sessions\\start',
        19 => 'luminova\\sessions\\synchronize',
        20 => 'luminova\\sessions\\goonline',
        21 => 'luminova\\sessions\\ipchanged',
        22 => 'luminova\\sessions\\sessionconfigure',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Sessions/SessionInterface.php' => 
    array (
      0 => '7aec888d0922cdd74abad15e88eb0a13f5027068',
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
      0 => '5e2e5584731f5e6168f586b27768d4f8f4c75389',
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
        20 => 'luminova\\sessions\\savecontent',
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
      0 => '109380389e1e81ec013b8faf549495dff3718ac2',
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
        4 => 'luminova\\http\\getarray',
        5 => 'luminova\\http\\getput',
        6 => 'luminova\\http\\getdelete',
        7 => 'luminova\\http\\getoption',
        8 => 'luminova\\http\\getpatch',
        9 => 'luminova\\http\\gethead',
        10 => 'luminova\\http\\getconnect',
        11 => 'luminova\\http\\gettrace',
        12 => 'luminova\\http\\getpropfind',
        13 => 'luminova\\http\\getmkcol',
        14 => 'luminova\\http\\getcopy',
        15 => 'luminova\\http\\getmove',
        16 => 'luminova\\http\\getlock',
        17 => 'luminova\\http\\getunlock',
        18 => 'luminova\\http\\getbody',
        19 => 'luminova\\http\\getbodyasobject',
        20 => 'luminova\\http\\getfile',
        21 => 'luminova\\http\\getfiles',
        22 => 'luminova\\http\\parsefiles',
        23 => 'luminova\\http\\getmethod',
        24 => 'luminova\\http\\getcontenttype',
        25 => 'luminova\\http\\parserequestbody',
        26 => 'luminova\\http\\getauthorization',
        27 => 'luminova\\http\\getauthbearer',
        28 => 'luminova\\http\\iscommandline',
        29 => 'luminova\\http\\issecure',
        30 => 'luminova\\http\\isajax',
        31 => 'luminova\\http\\geturi',
        32 => 'luminova\\http\\getbrowser',
        33 => 'luminova\\http\\parseuseragent',
        34 => 'luminova\\http\\getuseragent',
        35 => 'luminova\\http\\hasheader',
        36 => 'luminova\\http\\header',
        37 => 'luminova\\http\\getheaders',
        38 => 'luminova\\http\\getheader',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Http/Header.php' => 
    array (
      0 => '3473b4ffe6fe8dc346991f31e032e16043e080d0',
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
      0 => '411f713f030b861a1bb9c8b33f2781ef1eb7cc02',
      1 => 
      array (
        0 => 'luminova\\functions\\functions',
      ),
      2 => 
      array (
        0 => 'luminova\\functions\\toname',
        1 => 'luminova\\functions\\matchin',
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
        18 => 'luminova\\functions\\formatphone',
        19 => 'luminova\\functions\\is_email_or_phone',
        20 => 'luminova\\functions\\isphonenumber',
        21 => 'luminova\\functions\\strongpassword',
        22 => 'luminova\\functions\\hashpassword',
        23 => 'luminova\\functions\\verifypassword',
        24 => 'luminova\\functions\\averagerating',
        25 => 'luminova\\functions\\money',
        26 => 'luminova\\functions\\fixed',
        27 => 'luminova\\functions\\discount',
        28 => 'luminova\\functions\\addinterest',
        29 => 'luminova\\functions\\hoursrange',
        30 => 'luminova\\functions\\daysinmonth',
        31 => 'luminova\\functions\\sanitizeinput',
        32 => 'luminova\\functions\\tohtmlentities',
        33 => 'luminova\\functions\\escape',
        34 => 'luminova\\functions\\removesubdomain',
        35 => 'luminova\\functions\\removemaindomain',
        36 => 'luminova\\functions\\tokebabcase',
        37 => 'luminova\\functions\\truncate',
        38 => 'luminova\\functions\\base64_url_encode',
        39 => 'luminova\\functions\\base64_url_decode',
        40 => 'luminova\\functions\\striptext',
        41 => 'luminova\\functions\\maskemail',
        42 => 'luminova\\functions\\mask',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Functions/Document.php' => 
    array (
      0 => '9a2e6666cc74875dfdc67b20cd7b3ae4c14788fa',
      1 => 
      array (
        0 => 'luminova\\functions\\document',
      ),
      2 => 
      array (
        0 => 'luminova\\functions\\badges',
        1 => 'luminova\\functions\\buttonbadges',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Functions/Escaper.php' => 
    array (
      0 => '143f6fe7af94728c37d3e07aa2243d9d689558f3',
      1 => 
      array (
        0 => 'luminova\\functions\\escaper',
      ),
      2 => 
      array (
        0 => 'luminova\\functions\\__construct',
        1 => 'luminova\\functions\\__call',
        2 => 'luminova\\functions\\getencoding',
        3 => 'luminova\\functions\\escapehtml',
        4 => 'luminova\\functions\\escapehtmlattr',
        5 => 'luminova\\functions\\escapejs',
        6 => 'luminova\\functions\\escapecss',
        7 => 'luminova\\functions\\toutf8',
        8 => 'luminova\\functions\\fromutf8',
        9 => 'luminova\\functions\\isutf8',
        10 => 'luminova\\functions\\convertencoding',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Functions/Files.php' => 
    array (
      0 => '9b95b8936ab9ac47425f896db8a697c3bd883b42',
      1 => 
      array (
        0 => 'luminova\\functions\\files',
      ),
      2 => 
      array (
        0 => 'luminova\\functions\\copy',
        1 => 'luminova\\functions\\download',
        2 => 'luminova\\functions\\remove',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Functions/IPAddress.php' => 
    array (
      0 => 'ab1c5c8547b6d0e5bf1b76bd96474600bb50b659',
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
      0 => '451f55119665a29594fe85347104d12f7dd474a6',
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
      0 => '9ee9879b48f365d26cf17e362c9fb33c1e659924',
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
      0 => 'e1408034d85f2e1e9dc7331455a83c6d673ca7f8',
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
        42 => 'luminova\\command\\hascommand',
        43 => 'luminova\\command\\printhelp',
        44 => 'luminova\\command\\getstatuscode',
        45 => 'luminova\\command\\header',
        46 => 'luminova\\command\\phpscript',
      ),
      3 => 
      array (
        0 => 'STDOUT',
        1 => 'STDIN',
        2 => 'STDERR',
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Commands.php' => 
    array (
      0 => '984f7862aaa6a7678020108072fc928afd02a830',
      1 => 
      array (
        0 => 'luminova\\command\\commands',
      ),
      2 => 
      array (
        0 => 'luminova\\command\\run',
        1 => 'luminova\\command\\getcommand',
        2 => 'luminova\\command\\has',
        3 => 'luminova\\command\\get',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Console.php' => 
    array (
      0 => 'f395ef2166aa163a063c32de621c95fc426921b5',
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
      0 => '56b9c46375f60e2b71e6c7f430017ba0a22b7509',
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
        4 => 'luminova\\command\\novakit\\savefile',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Command/Novakit/Server.php' => 
    array (
      0 => '4418c65d186aac706f55bc98dfc900d8d9e5fe3d',
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
      0 => '292261a4936bcabe93d6f8bda779e3fcfbdc6633',
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
      0 => '6517fe36960ad9b774c960c52c61287799dcebc1',
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
      0 => 'dc6f40c4e281c233ff06fdc891e2037bd16198e9',
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
      0 => 'ffcc3182c5ee924aeaf922b2b9ceaac4f5cc6060',
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
      0 => 'f7d60fc8bdedbe7911f4f266d6017fe8a18eab0d',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Application/Services.php' => 
    array (
      0 => '756a443d2812d19d1d18c90a754bfc9c85bb9c11',
      1 => 
      array (
        0 => 'luminova\\application\\services',
      ),
      2 => 
      array (
        0 => 'luminova\\application\\get',
        1 => 'luminova\\application\\__callstatic',
        2 => 'luminova\\application\\create',
        3 => 'luminova\\application\\has',
        4 => 'luminova\\application\\remove',
        5 => 'luminova\\application\\rest',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Routing/Bootstrap.php' => 
    array (
      0 => '1ff2ce69269d4c0942f9ad15be8a8cb2e0b4d36a',
      1 => 
      array (
        0 => 'luminova\\routing\\bootstrap',
      ),
      2 => 
      array (
        0 => 'luminova\\routing\\__construct',
        1 => 'luminova\\routing\\getname',
        2 => 'luminova\\routing\\geterrorhandler',
        3 => 'luminova\\routing\\getinstances',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Routing/Router.php' => 
    array (
      0 => '415926a18162eba5d88164c2a0426203624e8a9d',
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
        14 => 'luminova\\routing\\discover',
        15 => 'luminova\\routing\\iswebinstance',
        16 => 'luminova\\routing\\addnamespace',
        17 => 'luminova\\routing\\run',
        18 => 'luminova\\routing\\runascli',
        19 => 'luminova\\routing\\runashttp',
        20 => 'luminova\\routing\\seterrorhandler',
        21 => 'luminova\\routing\\triggererror',
        22 => 'luminova\\routing\\handlewebsite',
        23 => 'luminova\\routing\\handlecommand',
        24 => 'luminova\\routing\\processfindmatches',
        25 => 'luminova\\routing\\execute',
        26 => 'luminova\\routing\\reflectionclassloader',
        27 => 'luminova\\routing\\invokecommandargs',
        28 => 'luminova\\routing\\getstatus',
        29 => 'luminova\\routing\\getnamespaces',
        30 => 'luminova\\routing\\patternmatches',
        31 => 'luminova\\routing\\getbasepath',
        32 => 'luminova\\routing\\getview',
        33 => 'luminova\\routing\\getviewuri',
        34 => 'luminova\\routing\\getarrayviews',
        35 => 'luminova\\routing\\getviewposition',
        36 => 'luminova\\routing\\getfirstview',
        37 => 'luminova\\routing\\getlastview',
        38 => 'luminova\\routing\\getsecondtolastview',
        39 => 'luminova\\routing\\parsepatternvalue',
        40 => 'luminova\\routing\\setbasepath',
        41 => 'luminova\\routing\\getcommandname',
        42 => 'luminova\\routing\\resetroutes',
      ),
      3 => 
      array (
        0 => 'CLI_ENVIRONMENT',
        1 => 'STDOUT',
        2 => 'STDIN',
        3 => 'STDERR',
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Errors/Codes.php' => 
    array (
      0 => 'cb35e73a4402a8ba32298b42f15b868cea76384f',
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
      0 => 'b1260677575e03bfb7cc37946fce94a1e954d8c0',
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
      0 => 'aaa951fbc944508ce95b71e30650f12f5ad07e98',
      1 => 
      array (
        0 => 'luminova\\controllers\\controller',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Controllers/ViewController.php' => 
    array (
      0 => 'ab9d21de8391a841bca4d361bb5033e9cc2f6eb1',
      1 => 
      array (
        0 => 'luminova\\controllers\\viewcontroller',
      ),
      2 => 
      array (
        0 => 'luminova\\controllers\\request',
        1 => 'luminova\\controllers\\validate',
        2 => 'luminova\\controllers\\app',
        3 => 'luminova\\controllers\\library',
        4 => 'luminova\\controllers\\view',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Email/Clients/PHPMailer.php' => 
    array (
      0 => '269356965a08dfe906a3c42b10dbeb65e14f5633',
      1 => 
      array (
        0 => 'luminova\\email\\clients\\phpmailer',
      ),
      2 => 
      array (
        0 => 'luminova\\email\\clients\\__construct',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Email/Clients/MailClientInterface.php' => 
    array (
      0 => 'd001d4a60860edbf1a324071cb294c85a50e7039',
      1 => 
      array (
        0 => 'luminova\\email\\clients\\mailclientinterface',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Email/Clients/NovaMailer.php' => 
    array (
      0 => 'a44064ae7c37db08216f4f9fdb7d62a057573bfc',
      1 => 
      array (
        0 => 'luminova\\email\\clients\\novamailer',
      ),
      2 => 
      array (
        0 => 'luminova\\email\\clients\\__construct',
        1 => 'luminova\\email\\clients\\addaddress',
        2 => 'luminova\\email\\clients\\addcc',
        3 => 'luminova\\email\\clients\\addbcc',
        4 => 'luminova\\email\\clients\\addreplyto',
        5 => 'luminova\\email\\clients\\setfrom',
        6 => 'luminova\\email\\clients\\addattachment',
        7 => 'luminova\\email\\clients\\send',
        8 => 'luminova\\email\\clients\\smtp_mail',
        9 => 'luminova\\email\\clients\\smtpget',
        10 => 'luminova\\email\\clients\\getheaders',
        11 => 'luminova\\email\\clients\\sendwithoutattachment',
        12 => 'luminova\\email\\clients\\sendwithattachment',
        13 => 'luminova\\email\\clients\\issmtp',
        14 => 'luminova\\email\\clients\\ismail',
        15 => 'luminova\\email\\clients\\ishtml',
        16 => 'luminova\\email\\clients\\fileisaccessible',
        17 => 'luminova\\email\\clients\\ispermittedpath',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Email/Mailer.php' => 
    array (
      0 => '1fdfc982ec9ced12728ac55e39740b4fa6ea3e99',
      1 => 
      array (
        0 => 'luminova\\email\\mailer',
      ),
      2 => 
      array (
        0 => 'luminova\\email\\__construct',
        1 => 'luminova\\email\\getclient',
        2 => 'luminova\\email\\getinstance',
        3 => 'luminova\\email\\addaddress',
        4 => 'luminova\\email\\addreplyto',
        5 => 'luminova\\email\\addcc',
        6 => 'luminova\\email\\addbcc',
        7 => 'luminova\\email\\setfrom',
        8 => 'luminova\\email\\setbody',
        9 => 'luminova\\email\\setaltbody',
        10 => 'luminova\\email\\setsubject',
        11 => 'luminova\\email\\addattachment',
        12 => 'luminova\\email\\send',
        13 => 'luminova\\email\\initialize',
        14 => 'luminova\\email\\shoulddebug',
        15 => 'luminova\\email\\getencryptiontype',
        16 => 'luminova\\email\\getcharset',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Email/Exceptions/MailerException.php' => 
    array (
      0 => '5b1d24a6fe5b8be7b8ecb532bb801622b8ef9193',
      1 => 
      array (
        0 => 'luminova\\email\\exceptions\\mailerexception',
      ),
      2 => 
      array (
        0 => 'luminova\\email\\exceptions\\throwwith',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseApplication.php' => 
    array (
      0 => 'e9c3cb86da16755aa67b8db963de4c541eac39f4',
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
      0 => '318d1af607686738237a5c2c7fb4b5c99a7698db',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseFunction.php' => 
    array (
      0 => '1eafc17264ca2728e933baf7d14cd656af8bc6d6',
      1 => 
      array (
        0 => 'luminova\\base\\basefunction',
      ),
      2 => 
      array (
        0 => 'luminova\\base\\files',
        1 => 'luminova\\base\\ip',
        2 => 'luminova\\base\\document',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseConfig.php' => 
    array (
      0 => 'c1272ba08574af94be3f98bcab645809c34629da',
      1 => 
      array (
        0 => 'luminova\\base\\baseconfig',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseController.php' => 
    array (
      0 => '8bf127aaf00a1bf181f69ea13c18a71ab9755c12',
      1 => 
      array (
        0 => 'luminova\\base\\basecontroller',
      ),
      2 => 
      array (
        0 => 'luminova\\base\\__construct',
        1 => 'luminova\\base\\__get',
        2 => 'luminova\\base\\__isset',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Base/BaseViewController.php' => 
    array (
      0 => '79acef17722ca432d3da13b8561bfe3ef72eeb03',
      1 => 
      array (
        0 => 'luminova\\base\\baseviewcontroller',
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
      0 => '38a0703e49d774dd9ca8567087b439d74d6b391d',
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
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cookies/Cookie.php' => 
    array (
      0 => '8a265b102152a5fab93cf79c634d0af3f5893565',
      1 => 
      array (
        0 => 'luminova\\cookies\\cookie',
      ),
      2 => 
      array (
        0 => 'luminova\\cookies\\__construct',
        1 => 'luminova\\cookies\\setoptions',
        2 => 'luminova\\cookies\\set',
        3 => 'luminova\\cookies\\setvalue',
        4 => 'luminova\\cookies\\get',
        5 => 'luminova\\cookies\\delete',
        6 => 'luminova\\cookies\\has',
        7 => 'luminova\\cookies\\getname',
        8 => 'luminova\\cookies\\getoptions',
        9 => 'luminova\\cookies\\getvalue',
        10 => 'luminova\\cookies\\getdomain',
        11 => 'luminova\\cookies\\getprefix',
        12 => 'luminova\\cookies\\getexpiry',
        13 => 'luminova\\cookies\\getexpirystring',
        14 => 'luminova\\cookies\\hasexpired',
        15 => 'luminova\\cookies\\getmaxage',
        16 => 'luminova\\cookies\\getpath',
        17 => 'luminova\\cookies\\getsamesite',
        18 => 'luminova\\cookies\\issecure',
        19 => 'luminova\\cookies\\ishttponly',
        20 => 'luminova\\cookies\\israw',
        21 => 'luminova\\cookies\\getstring',
        22 => 'luminova\\cookies\\tostring',
        23 => 'luminova\\cookies\\getid',
        24 => 'luminova\\cookies\\getprefixedname',
        25 => 'luminova\\cookies\\setfromstring',
        26 => 'luminova\\cookies\\parsestring',
        27 => 'luminova\\cookies\\passoption',
        28 => 'luminova\\cookies\\hasprefix',
        29 => 'luminova\\cookies\\getcontents',
        30 => 'luminova\\cookies\\isjson',
        31 => 'luminova\\cookies\\savecontent',
        32 => 'luminova\\cookies\\saveglobal',
        33 => 'luminova\\cookies\\totimestamp',
        34 => 'luminova\\cookies\\__tostring',
        35 => 'luminova\\cookies\\toarray',
        36 => 'luminova\\cookies\\validatename',
        37 => 'luminova\\cookies\\validateprefix',
        38 => 'luminova\\cookies\\validatesamesite',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cookies/CookieInterface.php' => 
    array (
      0 => '66aae7aabc455cf918d4c663f641aeab446f3aa6',
      1 => 
      array (
        0 => 'luminova\\cookies\\cookieinterface',
      ),
      2 => 
      array (
        0 => 'luminova\\cookies\\set',
        1 => 'luminova\\cookies\\setvalue',
        2 => 'luminova\\cookies\\get',
        3 => 'luminova\\cookies\\has',
        4 => 'luminova\\cookies\\delete',
        5 => 'luminova\\cookies\\setoptions',
        6 => 'luminova\\cookies\\setfromstring',
        7 => 'luminova\\cookies\\getid',
        8 => 'luminova\\cookies\\getprefix',
        9 => 'luminova\\cookies\\getprefixedname',
        10 => 'luminova\\cookies\\getname',
        11 => 'luminova\\cookies\\getvalue',
        12 => 'luminova\\cookies\\getexpiry',
        13 => 'luminova\\cookies\\getexpirystring',
        14 => 'luminova\\cookies\\hasexpired',
        15 => 'luminova\\cookies\\getmaxage',
        16 => 'luminova\\cookies\\getpath',
        17 => 'luminova\\cookies\\getdomain',
        18 => 'luminova\\cookies\\issecure',
        19 => 'luminova\\cookies\\ishttponly',
        20 => 'luminova\\cookies\\getsamesite',
        21 => 'luminova\\cookies\\israw',
        22 => 'luminova\\cookies\\getoptions',
        23 => 'luminova\\cookies\\getstring',
        24 => 'luminova\\cookies\\tostring',
        25 => 'luminova\\cookies\\hasprefix',
        26 => 'luminova\\cookies\\__tostring',
        27 => 'luminova\\cookies\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    '/Applications/XAMPP/xamppfiles/htdocs/luminova.com/system/Cookies/Exception/CookieException.php' => 
    array (
      0 => '4615d8b06d8516a16a7261c2de4eea829f584d48',
      1 => 
      array (
        0 => 'luminova\\cookies\\exception\\cookieexception',
      ),
      2 => 
      array (
        0 => 'luminova\\cookies\\exception\\throwwith',
      ),
      3 => 
      array (
      ),
    ),
  ),
));