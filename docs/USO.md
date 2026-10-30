# Guia de uso

DataType de chave de storage para aplicacoes Elavora API.

## Instalacao

```bash
composer require elavora/api-datatype-storage-key
```

## Quando usar

- Validar e normalizar valores antes de chegar na regra de negocio.
- Evitar passar strings soltas entre services, DTOs e persistencia.
- Reutilizar a mesma validacao em controllers, comandos e testes.

## Exemplo rapido

```php
use Elavora\Api\DataTypes\Storage\StorageKey;

$valor = new StorageKey('exemplo');
$normalizado = $valor->value();
```

## Principais pontos de entrada

- `Elavora\Api\DataTypes\Storage\StorageKey`

## Dependencias de runtime

- `elavora/api-datatype-file-path` `^0.1`

## Validacao no projeto consumidor

Depois de instalar o pacote, rode os testes da aplicacao consumidora.

Para validar o pacote isoladamente (testes, lint e PHPStan, e como reproduzir o CI), veja
[Desenvolvimento e testes](DESENVOLVIMENTO.md). A automacao, as versoes e os arquivos de qualidade do repositorio estao em
[Automacao do repositorio](AUTOMACAO.md).

## Observacoes

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensoes no bootstrap da aplicacao.
- Instale apenas os modulos que a aplicacao realmente usa.
