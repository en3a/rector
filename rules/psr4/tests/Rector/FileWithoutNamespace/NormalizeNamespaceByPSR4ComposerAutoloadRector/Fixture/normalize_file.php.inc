<?php

namespace Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source;

class SomeClassTest
{
    public function test()
    {
        $someClass = new SomeClass();
    }
}

?>
-----
<?php

namespace Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Fixture;

class SomeClassTest
{
    public function test()
    {
        $someClass = new \Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\SomeClass();
    }
}

?>
