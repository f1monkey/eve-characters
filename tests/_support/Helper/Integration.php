<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Tests\_support\Helper\ParameterGrabberTrait;
use App\Tests\_support\Helper\RepositoryTrait;

class Integration extends \Codeception\Module
{
    use RepositoryTrait;
    use ParameterGrabberTrait;
}
