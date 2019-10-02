<?php declare(strict_types=1);

namespace Rector\CodingStyle\Rector\Namespace_;

use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Name;
use Rector\CodingStyle\Node\NameImporter;
use Rector\Rector\AbstractRector;
use Rector\RectorDefinition\CodeSample;
use Rector\RectorDefinition\RectorDefinition;

/**
 * @see \Rector\CodingStyle\Tests\Rector\Namespace_\ImportFullyQualifiedNamesRector\ImportFullyQualifiedNamesRectorTest
 */
final class ImportFullyQualifiedNamesRector extends AbstractRector
{
    /**
     * @var bool
     */
    private $shouldImportDocBlocks = true;

    /**
     * @var bool
     */
    private $shouldImportRootNamespaceClasses = true;

    /**
     * @var NameImporter
     */
    private $nameImporter;

    public function __construct(
        NameImporter $nameImporter,
        bool $shouldImportDocBlocks = true,
        bool $shouldImportRootNamespaceClasses = true
    ) {
        $this->nameImporter = $nameImporter;
        $this->shouldImportDocBlocks = $shouldImportDocBlocks;
        $this->shouldImportRootNamespaceClasses = $shouldImportRootNamespaceClasses;
    }

    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition('Import fully qualified names to use statements', [
            new CodeSample(
                <<<'PHP'
class SomeClass
{
    public function create()
    {
          return SomeAnother\AnotherClass;
    }
}
PHP
                ,
                <<<'PHP'
use SomeAnother\AnotherClass;

class SomeClass
{
    public function create()
    {
          return AnotherClass;
    }
}
PHP
            ),
        ]);
    }

    /**
     * @return string[]
     */
    public function getNodeTypes(): array
    {
        return [Name::class, Node::class];
    }

    /**
     * @param Name|Node $node
     */
    public function refactor(Node $node): ?Node
    {
        // Importing root namespace classes (like \DateTime) is optional
        if (! $this->shouldImportRootNamespaceClasses) {
            $name = $this->getName($node);
            if (Strings::startsWith($name, '\\') && substr_count($name, '\\') === 1) {
                return null;
            }
        }

        $this->useAddingCommander->analyseFileInfoUseStatements($node);

        if ($node instanceof Name) {
            return $this->nameImporter->importName($node);
        }

        // process doc blocks
        if ($this->shouldImportDocBlocks) {
            $this->docBlockManipulator->importNames($node);
            return $node;
        }

        return null;
    }
}
