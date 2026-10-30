<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\StorageKey\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Campos do composer.json do pacote depois do upgrade para o api-datatype-file-path 1.0.
 *
 * @see docs/USO.md
 * @see docs/AUTOMACAO.md#composerjson
 */
final class ComposerJsonTest extends TestCase
{
    /** @var array<string, mixed> */
    private array $composer;

    protected function setUp(): void
    {
        $this->composer = json_decode(
            (string) file_get_contents(dirname(__DIR__) . '/composer.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );
    }

    public function testRequiresPhp83(): void
    {
        self::assertSame('>=8.3', $this->composer['require']['php'] ?? null);
    }

    public function testRequiresDatatypeFilePath1(): void
    {
        self::assertSame('^1.0', $this->composer['require']['elavora/api-datatype-file-path'] ?? null);
    }

    public function testDoesNotRequireDatatypeCoreDirectly(): void
    {
        self::assertArrayNotHasKey('elavora/api-datatype-core', $this->composer['require'] ?? []);
    }

    public function testBranchAliasIs10Dev(): void
    {
        self::assertSame('1.0-dev', $this->composer['extra']['branch-alias']['dev-main'] ?? null);
    }

    public function testAutoloadIsUnchanged(): void
    {
        self::assertSame(
            ['Elavora\\Api\\DataTypes\\Storage\\' => 'src/'],
            $this->composer['autoload']['psr-4'] ?? null,
        );
    }

    public function testHasNoRepositories(): void
    {
        self::assertArrayNotHasKey('repositories', $this->composer);
    }
}
