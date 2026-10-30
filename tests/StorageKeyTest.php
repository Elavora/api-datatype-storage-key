<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\StorageKey\Tests;

use Elavora\Api\DataTypes\Filesystem\FilePath;
use Elavora\Api\DataTypes\Storage\StorageKey;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Regras e tabela de docs/USO.md.
 */
final class StorageKeyTest extends TestCase
{
    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function validKeys(): array
    {
        return [
            'ja normalizada' => ['documents/report.pdf', 'documents/report.pdf'],
            'barra invertida' => ['documents\\report.pdf', 'documents/report.pdf'],
            'espacos nas pontas' => ['  documents/report.pdf  ', 'documents/report.pdf'],
        ];
    }

    #[DataProvider('validKeys')]
    public function testValidKeysAreNormalized(string $input, string $expected): void
    {
        self::assertTrue(StorageKey::isValid($input));
        self::assertSame($expected, StorageKey::from($input)->value());
    }

    /**
     * @return array<string, array{0: mixed}>
     */
    public static function invalidKeys(): array
    {
        return [
            'comeca com barra' => ['/documents/report.pdf'],
            'comeca com barra invertida' => ['\\documents\\report.pdf'],
            'texto vazio' => [''],
            'inteiro' => [123],
            'null' => [null],
            'array' => [['documents/report.pdf']],
        ];
    }

    #[DataProvider('invalidKeys')]
    public function testInvalidKeysAreRejected(mixed $input): void
    {
        self::assertFalse(StorageKey::isValid($input));
    }

    #[DataProvider('invalidKeys')]
    public function testFromThrowsInvalidArgumentExceptionWithMessage(mixed $input): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Valor invalido para Elavora\\Api\\DataTypes\\Storage\\StorageKey.');

        StorageKey::from($input);
    }

    public function testJsonSerializeAndStringCastReturnNormalizedValue(): void
    {
        $key = StorageKey::from('documents\\report.pdf');

        self::assertSame('documents/report.pdf', $key->jsonSerialize());
        self::assertSame('"documents\/report.pdf"', json_encode($key));
        self::assertSame('documents/report.pdf', (string) $key);
    }

    public function testExtendsFilePath(): void
    {
        self::assertInstanceOf(FilePath::class, StorageKey::from('documents/report.pdf'));
    }

    public function testIsFinalReadonlyClass(): void
    {
        $class = new ReflectionClass(StorageKey::class);

        self::assertTrue($class->isFinal());
        self::assertTrue($class->isReadOnly());
    }

    public function testConstructorIsNotPublic(): void
    {
        self::assertFalse((new ReflectionClass(StorageKey::class))->isInstantiable());
    }
}
