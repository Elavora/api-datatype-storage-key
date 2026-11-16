<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\StorageKey\Tests;

use Elavora\Api\DataTypes\Storage\StorageKey;
use Elavora\Api\Framework\Contracts\DescribesType;
use PHPUnit\Framework\TestCase;

/**
 * Documentacao do tipo para o OPTIONS publico.
 *
 * @see docs/USO.md
 */
final class DocumentedTypeTest extends TestCase
{
    private const ALLOWED_KEYS = ['type', 'format', 'mask', 'pattern', 'enum', 'example', 'description'];

    public function testImplementsDescribesType(): void
    {
        self::assertTrue(is_subclass_of(StorageKey::class, DescribesType::class));
    }

    public function testDocumentedTypeUsesOnlyAllowedKeys(): void
    {
        $documented = StorageKey::documentedType();

        self::assertArrayHasKey('type', $documented);
        self::assertSame([], array_diff(array_keys($documented), self::ALLOWED_KEYS));
    }

    public function testExampleIsValid(): void
    {
        $documented = StorageKey::documentedType();

        self::assertArrayHasKey('example', $documented);
        self::assertTrue(StorageKey::isValid($documented['example']));

        if (isset($documented['pattern'])) {
            self::assertSame(1, preg_match('~' . $documented['pattern'] . '~', (string) $documented['example']));
        }
    }
}
