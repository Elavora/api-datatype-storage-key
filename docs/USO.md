# Guia de uso

`StorageKey` valida caminhos relativos de arquivo para uso como chaves de storage.

```php
use Elavora\Api\DataTypes\Storage\StorageKey;

$chave = StorageKey::from('documents\\report.pdf');

echo $chave->value(); // documents/report.pdf
```

Espacos externos sao removidos e separadores `\` sao convertidos para `/`. Caminhos absolutos e valores rejeitados por `FilePath` nao sao aceitos.

Para verificar uma entrada sem criar uma instancia:

```php
if (StorageKey::isValid($entrada)) {
    $chave = StorageKey::from($entrada);
}
```

## Validacao do pacote

Execute os comandos a partir da raiz do clone:

```bash
docker run --rm -v "${PWD}:/workspace" -w /workspace composer:2 composer update --no-interaction --no-progress --prefer-dist
docker run --rm -v "${PWD}:/workspace" -w /workspace composer:2 composer check
```
