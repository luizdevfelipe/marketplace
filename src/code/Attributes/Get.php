<?php
declare(strict_types=1);
namespace Code\Attributes;

use Attribute;
use Code\Enums\HttpEnum;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Get extends Route
{
    public function __construct(string $routePath)
    {
        parent::__construct($routePath, HttpEnum::GET);
    }
}
