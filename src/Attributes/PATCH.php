<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\Pure;

#[Attribute]
class PATCH extends Route {
    #[Pure]
    public function __construct(string $route, array $tags = [], string $summary = '', string $operationId = '')
    {
        parent::__construct(self::PATCH, $route, $tags, $summary, $operationId);
    }
}
