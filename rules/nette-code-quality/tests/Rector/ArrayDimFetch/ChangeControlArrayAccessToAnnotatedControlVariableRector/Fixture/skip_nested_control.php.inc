<?php

namespace Rector\NetteCodeQuality\Tests\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector\Fixture;

use Nette\Application\UI\Presenter;

final class SkipNestedControl extends Presenter
{
    public function go()
    {
        if ($this['some-form']->isSubmitted()) {
        }
    }
}
