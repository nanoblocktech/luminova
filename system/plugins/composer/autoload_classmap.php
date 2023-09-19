<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname(dirname($vendorDir));

return array(
    'App\\Controllers\\Application' => $baseDir . '/app/Controllers/Application.php',
    'App\\Controllers\\Config' => $baseDir . '/app/Controllers/Config.php',
    'App\\Controllers\\Func' => $baseDir . '/app/Controllers/Func.php',
    'App\\Controllers\\HelloWorld' => $baseDir . '/app/Controllers/HelloWorld.php',
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Luminova\\Arrays\\ArrayInput' => $baseDir . '/system/Arrays/ArrayInput.php',
    'Luminova\\BaseController' => $baseDir . '/system/BaseController.php',
    'Luminova\\Cache\\Compress' => $baseDir . '/system/Cache/Compress.php',
    'Luminova\\Cache\\FileCache' => $baseDir . '/system/Cache/FileCache.php',
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
    'Luminova\\Database\\Mysqli' => $baseDir . '/system/Database/Mysqli.php',
    'Luminova\\Database\\Pdo' => $baseDir . '/system/Database/Pdo.php',
    'Luminova\\Database\\Query' => $baseDir . '/system/Database/Query.php',
    'Luminova\\Exceptions\\ClassNotFoundException' => $baseDir . '/system/Exceptions/ClassNotFoundException.php',
    'Luminova\\Exceptions\\DatabaseException' => $baseDir . '/system/Exceptions/DatabaseException.php',
    'Luminova\\Exceptions\\FileNotFoundException' => $baseDir . '/system/Exceptions/FileNotFoundException.php',
    'Luminova\\Exceptions\\InvalidArgumentException' => $baseDir . '/system/Exceptions/InvalidArgumentException.php',
    'Luminova\\Exceptions\\PageNotFoundException' => $baseDir . '/system/Exceptions/PageNotFoundException.php',
    'Luminova\\Functions\\FunctionInterface' => $baseDir . '/system/Functions/FunctionInterface.php',
    'Luminova\\Functions\\Functions' => $baseDir . '/system/Functions/Functions.php',
    'Luminova\\Logger\\FileLogger' => $baseDir . '/system/Logger/FileLogger.php',
    'Luminova\\Logger\\LoggerInterface' => $baseDir . '/system/Logger/LoggerInterface.php',
    'Luminova\\Router\\BaseRouter' => $baseDir . '/system/Router/BaseRouter.php',
    'Luminova\\Router\\Router' => $baseDir . '/system/Router/Router.php',
    'Luminova\\Security\\Csrf' => $baseDir . '/system/Security/Csrf.php',
    'Luminova\\Seo\\Meta' => $baseDir . '/system/Seo/Meta.php',
    'Luminova\\Sessions\\Session' => $baseDir . '/system/Sessions/Session.php',
    'Luminova\\Template\\Template' => $baseDir . '/system/Template/Template.php',
    'Luminova\\Tests\\Tests' => $baseDir . '/tests/Tests.php',
    'PHPStan\\ExtensionInstaller\\GeneratedConfig' => $vendorDir . '/phpstan/extension-installer/src/GeneratedConfig.php',
    'PHPStan\\ExtensionInstaller\\Plugin' => $vendorDir . '/phpstan/extension-installer/src/Plugin.php',
    'Peterujah\\NanoBlock\\Cache' => $vendorDir . '/peterujah/cache/src/Cache.php',
    'Peterujah\\NanoBlock\\Functions' => $vendorDir . '/peterujah/php-functions/src/Functions.php',
    'PhpParser\\Builder' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder.php',
    'PhpParser\\BuilderFactory' => $vendorDir . '/nikic/php-parser/lib/PhpParser/BuilderFactory.php',
    'PhpParser\\BuilderHelpers' => $vendorDir . '/nikic/php-parser/lib/PhpParser/BuilderHelpers.php',
    'PhpParser\\Builder\\ClassConst' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/ClassConst.php',
    'PhpParser\\Builder\\Class_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Class_.php',
    'PhpParser\\Builder\\Declaration' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Declaration.php',
    'PhpParser\\Builder\\EnumCase' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/EnumCase.php',
    'PhpParser\\Builder\\Enum_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Enum_.php',
    'PhpParser\\Builder\\FunctionLike' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/FunctionLike.php',
    'PhpParser\\Builder\\Function_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Function_.php',
    'PhpParser\\Builder\\Interface_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Interface_.php',
    'PhpParser\\Builder\\Method' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Method.php',
    'PhpParser\\Builder\\Namespace_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Namespace_.php',
    'PhpParser\\Builder\\Param' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Param.php',
    'PhpParser\\Builder\\Property' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Property.php',
    'PhpParser\\Builder\\TraitUse' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/TraitUse.php',
    'PhpParser\\Builder\\TraitUseAdaptation' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/TraitUseAdaptation.php',
    'PhpParser\\Builder\\Trait_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Trait_.php',
    'PhpParser\\Builder\\Use_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Builder/Use_.php',
    'PhpParser\\Comment' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Comment.php',
    'PhpParser\\Comment\\Doc' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Comment/Doc.php',
    'PhpParser\\ConstExprEvaluationException' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ConstExprEvaluationException.php',
    'PhpParser\\ConstExprEvaluator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ConstExprEvaluator.php',
    'PhpParser\\Error' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Error.php',
    'PhpParser\\ErrorHandler' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ErrorHandler.php',
    'PhpParser\\ErrorHandler\\Collecting' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ErrorHandler/Collecting.php',
    'PhpParser\\ErrorHandler\\Throwing' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ErrorHandler/Throwing.php',
    'PhpParser\\Internal\\DiffElem' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Internal/DiffElem.php',
    'PhpParser\\Internal\\Differ' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Internal/Differ.php',
    'PhpParser\\Internal\\PrintableNewAnonClassNode' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Internal/PrintableNewAnonClassNode.php',
    'PhpParser\\Internal\\TokenStream' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Internal/TokenStream.php',
    'PhpParser\\JsonDecoder' => $vendorDir . '/nikic/php-parser/lib/PhpParser/JsonDecoder.php',
    'PhpParser\\Lexer' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer.php',
    'PhpParser\\Lexer\\Emulative' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/Emulative.php',
    'PhpParser\\Lexer\\TokenEmulator\\AttributeEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/AttributeEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\CoaleseEqualTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/CoaleseEqualTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\EnumTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/EnumTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\ExplicitOctalEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/ExplicitOctalEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\FlexibleDocStringEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/FlexibleDocStringEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\FnTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/FnTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\KeywordEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/KeywordEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\MatchTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/MatchTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\NullsafeTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/NullsafeTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\NumericLiteralSeparatorEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/NumericLiteralSeparatorEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\ReadonlyFunctionTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/ReadonlyFunctionTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\ReadonlyTokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/ReadonlyTokenEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\ReverseEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/ReverseEmulator.php',
    'PhpParser\\Lexer\\TokenEmulator\\TokenEmulator' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Lexer/TokenEmulator/TokenEmulator.php',
    'PhpParser\\NameContext' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NameContext.php',
    'PhpParser\\Node' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node.php',
    'PhpParser\\NodeAbstract' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeAbstract.php',
    'PhpParser\\NodeDumper' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeDumper.php',
    'PhpParser\\NodeFinder' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeFinder.php',
    'PhpParser\\NodeTraverser' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeTraverser.php',
    'PhpParser\\NodeTraverserInterface' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeTraverserInterface.php',
    'PhpParser\\NodeVisitor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor.php',
    'PhpParser\\NodeVisitorAbstract' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitorAbstract.php',
    'PhpParser\\NodeVisitor\\CloningVisitor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor/CloningVisitor.php',
    'PhpParser\\NodeVisitor\\FindingVisitor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor/FindingVisitor.php',
    'PhpParser\\NodeVisitor\\FirstFindingVisitor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor/FirstFindingVisitor.php',
    'PhpParser\\NodeVisitor\\NameResolver' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor/NameResolver.php',
    'PhpParser\\NodeVisitor\\NodeConnectingVisitor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor/NodeConnectingVisitor.php',
    'PhpParser\\NodeVisitor\\ParentConnectingVisitor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/NodeVisitor/ParentConnectingVisitor.php',
    'PhpParser\\Node\\Arg' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Arg.php',
    'PhpParser\\Node\\Attribute' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Attribute.php',
    'PhpParser\\Node\\AttributeGroup' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/AttributeGroup.php',
    'PhpParser\\Node\\ComplexType' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/ComplexType.php',
    'PhpParser\\Node\\Const_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Const_.php',
    'PhpParser\\Node\\Expr' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr.php',
    'PhpParser\\Node\\Expr\\ArrayDimFetch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ArrayDimFetch.php',
    'PhpParser\\Node\\Expr\\ArrayItem' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ArrayItem.php',
    'PhpParser\\Node\\Expr\\Array_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Array_.php',
    'PhpParser\\Node\\Expr\\ArrowFunction' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ArrowFunction.php',
    'PhpParser\\Node\\Expr\\Assign' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Assign.php',
    'PhpParser\\Node\\Expr\\AssignOp' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp.php',
    'PhpParser\\Node\\Expr\\AssignOp\\BitwiseAnd' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/BitwiseAnd.php',
    'PhpParser\\Node\\Expr\\AssignOp\\BitwiseOr' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/BitwiseOr.php',
    'PhpParser\\Node\\Expr\\AssignOp\\BitwiseXor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/BitwiseXor.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Coalesce' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Coalesce.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Concat' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Concat.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Div' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Div.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Minus' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Minus.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Mod' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Mod.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Mul' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Mul.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Plus' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Plus.php',
    'PhpParser\\Node\\Expr\\AssignOp\\Pow' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/Pow.php',
    'PhpParser\\Node\\Expr\\AssignOp\\ShiftLeft' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/ShiftLeft.php',
    'PhpParser\\Node\\Expr\\AssignOp\\ShiftRight' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignOp/ShiftRight.php',
    'PhpParser\\Node\\Expr\\AssignRef' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/AssignRef.php',
    'PhpParser\\Node\\Expr\\BinaryOp' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\BitwiseAnd' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/BitwiseAnd.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\BitwiseOr' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/BitwiseOr.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\BitwiseXor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/BitwiseXor.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\BooleanAnd' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/BooleanAnd.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\BooleanOr' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/BooleanOr.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Coalesce' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Coalesce.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Concat' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Concat.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Div' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Div.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Equal' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Equal.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Greater' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Greater.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\GreaterOrEqual' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/GreaterOrEqual.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Identical' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Identical.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\LogicalAnd' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/LogicalAnd.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\LogicalOr' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/LogicalOr.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\LogicalXor' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/LogicalXor.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Minus' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Minus.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Mod' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Mod.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Mul' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Mul.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\NotEqual' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/NotEqual.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\NotIdentical' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/NotIdentical.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Plus' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Plus.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Pow' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Pow.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\ShiftLeft' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/ShiftLeft.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\ShiftRight' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/ShiftRight.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Smaller' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Smaller.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\SmallerOrEqual' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/SmallerOrEqual.php',
    'PhpParser\\Node\\Expr\\BinaryOp\\Spaceship' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BinaryOp/Spaceship.php',
    'PhpParser\\Node\\Expr\\BitwiseNot' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BitwiseNot.php',
    'PhpParser\\Node\\Expr\\BooleanNot' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/BooleanNot.php',
    'PhpParser\\Node\\Expr\\CallLike' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/CallLike.php',
    'PhpParser\\Node\\Expr\\Cast' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast.php',
    'PhpParser\\Node\\Expr\\Cast\\Array_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/Array_.php',
    'PhpParser\\Node\\Expr\\Cast\\Bool_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/Bool_.php',
    'PhpParser\\Node\\Expr\\Cast\\Double' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/Double.php',
    'PhpParser\\Node\\Expr\\Cast\\Int_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/Int_.php',
    'PhpParser\\Node\\Expr\\Cast\\Object_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/Object_.php',
    'PhpParser\\Node\\Expr\\Cast\\String_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/String_.php',
    'PhpParser\\Node\\Expr\\Cast\\Unset_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Cast/Unset_.php',
    'PhpParser\\Node\\Expr\\ClassConstFetch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ClassConstFetch.php',
    'PhpParser\\Node\\Expr\\Clone_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Clone_.php',
    'PhpParser\\Node\\Expr\\Closure' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Closure.php',
    'PhpParser\\Node\\Expr\\ClosureUse' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ClosureUse.php',
    'PhpParser\\Node\\Expr\\ConstFetch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ConstFetch.php',
    'PhpParser\\Node\\Expr\\Empty_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Empty_.php',
    'PhpParser\\Node\\Expr\\Error' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Error.php',
    'PhpParser\\Node\\Expr\\ErrorSuppress' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ErrorSuppress.php',
    'PhpParser\\Node\\Expr\\Eval_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Eval_.php',
    'PhpParser\\Node\\Expr\\Exit_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Exit_.php',
    'PhpParser\\Node\\Expr\\FuncCall' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/FuncCall.php',
    'PhpParser\\Node\\Expr\\Include_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Include_.php',
    'PhpParser\\Node\\Expr\\Instanceof_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Instanceof_.php',
    'PhpParser\\Node\\Expr\\Isset_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Isset_.php',
    'PhpParser\\Node\\Expr\\List_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/List_.php',
    'PhpParser\\Node\\Expr\\Match_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Match_.php',
    'PhpParser\\Node\\Expr\\MethodCall' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/MethodCall.php',
    'PhpParser\\Node\\Expr\\New_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/New_.php',
    'PhpParser\\Node\\Expr\\NullsafeMethodCall' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/NullsafeMethodCall.php',
    'PhpParser\\Node\\Expr\\NullsafePropertyFetch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/NullsafePropertyFetch.php',
    'PhpParser\\Node\\Expr\\PostDec' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/PostDec.php',
    'PhpParser\\Node\\Expr\\PostInc' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/PostInc.php',
    'PhpParser\\Node\\Expr\\PreDec' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/PreDec.php',
    'PhpParser\\Node\\Expr\\PreInc' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/PreInc.php',
    'PhpParser\\Node\\Expr\\Print_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Print_.php',
    'PhpParser\\Node\\Expr\\PropertyFetch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/PropertyFetch.php',
    'PhpParser\\Node\\Expr\\ShellExec' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/ShellExec.php',
    'PhpParser\\Node\\Expr\\StaticCall' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/StaticCall.php',
    'PhpParser\\Node\\Expr\\StaticPropertyFetch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/StaticPropertyFetch.php',
    'PhpParser\\Node\\Expr\\Ternary' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Ternary.php',
    'PhpParser\\Node\\Expr\\Throw_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Throw_.php',
    'PhpParser\\Node\\Expr\\UnaryMinus' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/UnaryMinus.php',
    'PhpParser\\Node\\Expr\\UnaryPlus' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/UnaryPlus.php',
    'PhpParser\\Node\\Expr\\Variable' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Variable.php',
    'PhpParser\\Node\\Expr\\YieldFrom' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/YieldFrom.php',
    'PhpParser\\Node\\Expr\\Yield_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Expr/Yield_.php',
    'PhpParser\\Node\\FunctionLike' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/FunctionLike.php',
    'PhpParser\\Node\\Identifier' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Identifier.php',
    'PhpParser\\Node\\IntersectionType' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/IntersectionType.php',
    'PhpParser\\Node\\MatchArm' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/MatchArm.php',
    'PhpParser\\Node\\Name' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Name.php',
    'PhpParser\\Node\\Name\\FullyQualified' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Name/FullyQualified.php',
    'PhpParser\\Node\\Name\\Relative' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Name/Relative.php',
    'PhpParser\\Node\\NullableType' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/NullableType.php',
    'PhpParser\\Node\\Param' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Param.php',
    'PhpParser\\Node\\Scalar' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar.php',
    'PhpParser\\Node\\Scalar\\DNumber' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/DNumber.php',
    'PhpParser\\Node\\Scalar\\Encapsed' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/Encapsed.php',
    'PhpParser\\Node\\Scalar\\EncapsedStringPart' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/EncapsedStringPart.php',
    'PhpParser\\Node\\Scalar\\LNumber' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/LNumber.php',
    'PhpParser\\Node\\Scalar\\MagicConst' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Class_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Class_.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Dir' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Dir.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\File' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/File.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Function_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Function_.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Line' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Line.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Method' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Method.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Namespace_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Namespace_.php',
    'PhpParser\\Node\\Scalar\\MagicConst\\Trait_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/MagicConst/Trait_.php',
    'PhpParser\\Node\\Scalar\\String_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Scalar/String_.php',
    'PhpParser\\Node\\Stmt' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt.php',
    'PhpParser\\Node\\Stmt\\Break_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Break_.php',
    'PhpParser\\Node\\Stmt\\Case_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Case_.php',
    'PhpParser\\Node\\Stmt\\Catch_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Catch_.php',
    'PhpParser\\Node\\Stmt\\ClassConst' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/ClassConst.php',
    'PhpParser\\Node\\Stmt\\ClassLike' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/ClassLike.php',
    'PhpParser\\Node\\Stmt\\ClassMethod' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/ClassMethod.php',
    'PhpParser\\Node\\Stmt\\Class_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Class_.php',
    'PhpParser\\Node\\Stmt\\Const_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Const_.php',
    'PhpParser\\Node\\Stmt\\Continue_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Continue_.php',
    'PhpParser\\Node\\Stmt\\DeclareDeclare' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/DeclareDeclare.php',
    'PhpParser\\Node\\Stmt\\Declare_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Declare_.php',
    'PhpParser\\Node\\Stmt\\Do_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Do_.php',
    'PhpParser\\Node\\Stmt\\Echo_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Echo_.php',
    'PhpParser\\Node\\Stmt\\ElseIf_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/ElseIf_.php',
    'PhpParser\\Node\\Stmt\\Else_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Else_.php',
    'PhpParser\\Node\\Stmt\\EnumCase' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/EnumCase.php',
    'PhpParser\\Node\\Stmt\\Enum_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Enum_.php',
    'PhpParser\\Node\\Stmt\\Expression' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Expression.php',
    'PhpParser\\Node\\Stmt\\Finally_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Finally_.php',
    'PhpParser\\Node\\Stmt\\For_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/For_.php',
    'PhpParser\\Node\\Stmt\\Foreach_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Foreach_.php',
    'PhpParser\\Node\\Stmt\\Function_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Function_.php',
    'PhpParser\\Node\\Stmt\\Global_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Global_.php',
    'PhpParser\\Node\\Stmt\\Goto_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Goto_.php',
    'PhpParser\\Node\\Stmt\\GroupUse' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/GroupUse.php',
    'PhpParser\\Node\\Stmt\\HaltCompiler' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/HaltCompiler.php',
    'PhpParser\\Node\\Stmt\\If_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/If_.php',
    'PhpParser\\Node\\Stmt\\InlineHTML' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/InlineHTML.php',
    'PhpParser\\Node\\Stmt\\Interface_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Interface_.php',
    'PhpParser\\Node\\Stmt\\Label' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Label.php',
    'PhpParser\\Node\\Stmt\\Namespace_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Namespace_.php',
    'PhpParser\\Node\\Stmt\\Nop' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Nop.php',
    'PhpParser\\Node\\Stmt\\Property' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Property.php',
    'PhpParser\\Node\\Stmt\\PropertyProperty' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/PropertyProperty.php',
    'PhpParser\\Node\\Stmt\\Return_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Return_.php',
    'PhpParser\\Node\\Stmt\\StaticVar' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/StaticVar.php',
    'PhpParser\\Node\\Stmt\\Static_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Static_.php',
    'PhpParser\\Node\\Stmt\\Switch_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Switch_.php',
    'PhpParser\\Node\\Stmt\\Throw_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Throw_.php',
    'PhpParser\\Node\\Stmt\\TraitUse' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/TraitUse.php',
    'PhpParser\\Node\\Stmt\\TraitUseAdaptation' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/TraitUseAdaptation.php',
    'PhpParser\\Node\\Stmt\\TraitUseAdaptation\\Alias' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/TraitUseAdaptation/Alias.php',
    'PhpParser\\Node\\Stmt\\TraitUseAdaptation\\Precedence' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/TraitUseAdaptation/Precedence.php',
    'PhpParser\\Node\\Stmt\\Trait_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Trait_.php',
    'PhpParser\\Node\\Stmt\\TryCatch' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/TryCatch.php',
    'PhpParser\\Node\\Stmt\\Unset_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Unset_.php',
    'PhpParser\\Node\\Stmt\\UseUse' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/UseUse.php',
    'PhpParser\\Node\\Stmt\\Use_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/Use_.php',
    'PhpParser\\Node\\Stmt\\While_' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/Stmt/While_.php',
    'PhpParser\\Node\\UnionType' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/UnionType.php',
    'PhpParser\\Node\\VarLikeIdentifier' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/VarLikeIdentifier.php',
    'PhpParser\\Node\\VariadicPlaceholder' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Node/VariadicPlaceholder.php',
    'PhpParser\\Parser' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Parser.php',
    'PhpParser\\ParserAbstract' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ParserAbstract.php',
    'PhpParser\\ParserFactory' => $vendorDir . '/nikic/php-parser/lib/PhpParser/ParserFactory.php',
    'PhpParser\\Parser\\Multiple' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Parser/Multiple.php',
    'PhpParser\\Parser\\Php5' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Parser/Php5.php',
    'PhpParser\\Parser\\Php7' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Parser/Php7.php',
    'PhpParser\\Parser\\Tokens' => $vendorDir . '/nikic/php-parser/lib/PhpParser/Parser/Tokens.php',
    'PhpParser\\PrettyPrinterAbstract' => $vendorDir . '/nikic/php-parser/lib/PhpParser/PrettyPrinterAbstract.php',
    'PhpParser\\PrettyPrinter\\Standard' => $vendorDir . '/nikic/php-parser/lib/PhpParser/PrettyPrinter/Standard.php',
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
