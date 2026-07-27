# api-datatype-storage-key

[![Packagist Version](https://img.shields.io/packagist/v/elavora/api-datatype-storage-key.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatype-storage-key)
[![PHP Version](https://img.shields.io/packagist/php-v/elavora/api-datatype-storage-key.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatype-storage-key)
[![Composer Quality](https://github.com/Elavora/api-datatype-storage-key/actions/workflows/quality.yml/badge.svg?branch=main)](https://github.com/Elavora/api-datatype-storage-key/actions/workflows/quality.yml)
[![CodeQL](https://github.com/Elavora/api-datatype-storage-key/actions/workflows/codeql.yml/badge.svg?branch=main)](https://github.com/Elavora/api-datatype-storage-key/actions/workflows/codeql.yml)
[![License](https://img.shields.io/packagist/l/elavora/api-datatype-storage-key.svg?style=flat-square)](https://packagist.org/packages/elavora/api-datatype-storage-key)

DataType imutavel para validar e normalizar chaves relativas de storage.

## Requisitos

- PHP 8.3 ou superior.
- Demais requisitos declarados em [`composer.json`](composer.json).

## Instalacao

```bash
composer require elavora/api-datatype-storage-key
```

## Inicio rapido

```php
use Elavora\Api\DataTypes\Storage\StorageKey;

$valor = StorageKey::from('documents/report.pdf');
$normalizado = $valor->value();
```

`$normalizado` contem `documents/report.pdf`. Separadores invertidos sao convertidos para `/`.

## Documentacao

Consulte o [guia de uso](docs/USO.md) para detalhes e validacao local.
