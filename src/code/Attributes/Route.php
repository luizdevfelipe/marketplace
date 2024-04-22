<?php
declare(strict_types=1);
namespace Code\Attributes;

use Attribute;
use Code\Enums\HttpEnum;

#[Attribute]
class Route
{
    public function __construct(public string $routePath, public HttpEnum $method = HttpEnum::GET)
    {
        
    }
}
