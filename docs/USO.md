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

$chave = StorageKey::from('documents\\report.pdf');
$normalizado = $chave->value(); // "documents/report.pdf"
```

## Principais pontos de entrada

- `Elavora\Api\DataTypes\Storage\StorageKey`

## API publica

`StorageKey` e uma classe `final readonly` que estende `Elavora\Api\DataTypes\Filesystem\FilePath` (do pacote
`elavora/api-datatype-file-path`). Ela herda do core o contrato abaixo.

| Metodo | Retorno | O que faz |
| --- | --- | --- |
| `StorageKey::from(mixed $value)` | `StorageKey` | valida e cria a instancia, ja com o valor normalizado |
| `StorageKey::isValid(mixed $value)` | `bool` | diz se o valor e uma chave valida, sem lancar excecao |
| `$chave->value()` | `string` | o valor normalizado |
| `$chave->jsonSerialize()` | `string` | o mesmo valor, para `json_encode` |
| `(string) $chave` | `string` | o mesmo valor, como texto |

### Regras

A chave e uma string e passa por esta ordem:

1. **Normalizacao:** `trim` nas pontas e troca de cada `\` por `/`.
2. **Chave relativa:** depois da normalizacao, nao pode comecar com `/`.
3. **Caminho de arquivo:** o valor normalizado precisa ser um caminho de arquivo valido para o `FilePath`
   (pastas validas e, no fim, um nome de arquivo valido). As regras de nomes de pasta e de arquivo ficam nos pacotes
   `elavora/api-datatype-folder-name` e `elavora/api-datatype-file-name`. Texto vazio e invalido.

Valor que nao e string (por exemplo `123`, `null` ou um array) e invalido.

| Entrada | Valida? | `value()` |
| --- | --- | --- |
| `documents/report.pdf` | sim | `documents/report.pdf` |
| `documents\report.pdf` | sim | `documents/report.pdf` |
| `  documents/report.pdf  ` | sim | `documents/report.pdf` |
| `/documents/report.pdf` | nao | |
| `\documents\report.pdf` | nao (vira `/documents/report.pdf`) | |
| `''` (texto vazio) | nao | |
| `123` (inteiro) | nao | |
| `null` | nao | |

### Erros

`StorageKey::from(...)` com valor invalido lanca `InvalidArgumentException` (a do PHP, `\InvalidArgumentException`),
com a mensagem `Valor invalido para Elavora\Api\DataTypes\Storage\StorageKey.`. `StorageKey::isValid(...)` nunca lanca.

```php
StorageKey::from('/documents/report.pdf');
// InvalidArgumentException: Valor invalido para Elavora\Api\DataTypes\Storage\StorageKey.
```

## Quebras da versão 1.0.0

Estas duas mudancas vem do `elavora/api-datatype-core` 2.0 e valem para todos os datatypes 1.0.

1. **O construtor nao e mais publico.** A criacao e so por `StorageKey::from(...)`. Antes (`0.x`), valia:

   ```php
   $chave = new StorageKey('documents/report.pdf'); // nao funciona mais: erro de visibilidade
   $chave = StorageKey::from('documents/report.pdf'); // correto
   ```

2. **Entrada invalida lanca `InvalidArgumentException`** com a mensagem `Valor invalido para <classe>.`, onde
   `<classe>` e o nome completo da classe (aqui, `Elavora\Api\DataTypes\Storage\StorageKey`). Quem captura a excecao
   da versao anterior precisa conferir o tipo e a mensagem.

A regra de validacao e a normalizacao de `StorageKey` nao mudam.

## Dependencias de runtime

- PHP 8.3 ou superior
- `elavora/api-datatype-file-path` `^1.0` (que traz o `elavora/api-datatype-core` `^2.0`, e este, o
  `elavora/api-framework` `^2.0`)

## Validacao no projeto consumidor

Depois de instalar o pacote, rode os testes da aplicacao consumidora.

Para validar o pacote isoladamente (testes, lint e PHPStan, e como reproduzir o CI), veja
[Desenvolvimento e testes](DESENVOLVIMENTO.md). A automacao, as versoes e os arquivos de qualidade do repositorio estao em
[Automacao do repositorio](AUTOMACAO.md).

## Observacoes

- Mantenha regras de produto fora deste pacote.
- Prefira configurar extensoes no bootstrap da aplicacao.
- Instale apenas os modulos que a aplicacao realmente usa.
