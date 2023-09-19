<?php declare(strict_types = 1);
$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$node \\(PhpParser\\\\Node\\\\Stmt\\) of method Luminova\\\\Config\\\\PHPStanRules\\:\\:processNode\\(\\) should be contravariant with parameter \\$node \\(PhpParser\\\\Node\\) of method PHPStan\\\\Rules\\\\Rule\\<PhpParser\\\\Node\\>\\:\\:processNode\\(\\)$#',
	'count' => 1,
	'path' => __DIR__ . '/system/Config/PHPStanRules.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];