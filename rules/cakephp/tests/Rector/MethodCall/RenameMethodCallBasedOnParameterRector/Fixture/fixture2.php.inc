<?php

namespace Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;

function renameMethodCallBasedOnParameterNoop()
{
    $object = new Source\SomeModelType;

    $config = $object->getParam($value);
    $config = $object->getParam('other');
    $object->withParam('other', 'value');
}
