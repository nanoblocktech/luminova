<?php
declare(strict_types=1);
namespace Luminova\Config;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Use_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class PHPStanRules implements Rule
{
    public function getNodeType(): string
    {
        return Stmt::class;
    }

    /**
     * @param Stmt $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        $comments = $node->getComments();

        if ($comments === []) {
            return $errors;
        }

        foreach ($comments as $comment) {
            if (! $comment instanceof Doc) {
                continue;
            }

            $previous = $node->getAttribute('previous');

            while ($previous) {
                if ($previous instanceof Use_) {
                    $errors[] = 'Use statement must be located after license docblock';
                    break;
                }

                $previous = $previous->getAttribute('previous');
            }
        }

        // Check for variable naming convention
        if ($node instanceof Variable || $node instanceof VariableNode) {
            $variableName = ($node instanceof Variable) ? $node->name : $node->getOriginalNode()->name;
            
            if (strpos($variableName, '_') !== false) {
                $errors[] = sprintf(
                    'Variable name "%s" contains underscores. Use camelCase instead.',
                    $variableName
                );
            }
        }

        return $errors;
    }
}