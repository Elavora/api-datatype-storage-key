<?php

declare(strict_types=1);

namespace Elavora\Api\DataTypes\Storage;

use Elavora\Api\DataTypes\Filesystem\FilePath;
use Elavora\Api\Framework\Contracts\DescribesType;

final readonly class StorageKey extends FilePath implements DescribesType
{
    /**
     * Descreve o tipo para a documentacao publica (OPTIONS).
     *
     * @return array<string, mixed>
     */
    public static function documentedType(): array
    {
        return [
            'type' => 'string',
            'description' => 'Chave relativa de arquivo no storage, com pastas separadas por "/" e sem barra inicial. '
                . 'Barras invertidas sao normalizadas para "/". Cada pasta e o nome do arquivo precisam ser validos.',
            'example' => 'documents/report.pdf',
        ];
    }

    protected static function normalize(mixed $value): string
    {
        return str_replace('\\', '/', trim((string) $value));
    }

    /**
     * Verifica se o valor e uma chave relativa valida para storage.
     */
    public static function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $normalized = self::normalize($value);

        return !str_starts_with($normalized, '/') && parent::isValid($normalized);
    }
}
