<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use OpenApiGenerator\Types\ItemsType;
use OpenApiGenerator\Types\RequestBodyType;
use JsonSerializable;
use OpenApiGenerator\Types\SchemaType;

/**
 * The entire request body where you can specify the return type and a schema
 */
#[Attribute]
class RequestBody implements JsonSerializable
{
    private ?Schema $schema = null;

    public function __construct(
        private ?string $type = null,
        private ?string $schemaType = SchemaType::OBJECT,
        private ?string $ref = null
    ) {
        $this->type ??= RequestBodyType::JSON;

        if ($ref) {
            $this->schema = new Schema($schemaType);

            if ($schemaType === SchemaType::OBJECT) {
                $this->schema->addProperty(new RefProperty($ref));
            } elseif ($schemaType === SchemaType::ARRAY) {
                $this->schema->addProperty(new PropertyItems(ItemsType::REF, $ref));
            }
        }
    }

    public function setSchema(Schema $schema): void
    {
        $this->schema = $schema;
    }

    public function empty(): bool
    {
        return !$this->schema;
    }

    public function jsonSerialize(): array
    {
        if (!$this->schema) {
            return [];
        }

        // TODO: deal with media content or any other Types (cf. $this->type)
        return ['content' => $this->schema];
    }
}
