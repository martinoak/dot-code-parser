# dot-code-parser

Parse tire **DOT codes** (Tire Identification Numbers) into their component
parts: factory/plant code, size code, optional manufacturer block, and the
week + year of manufacture. Includes a bundled lookup of well-known plant
codes to manufacturer names and locations.

A tire DOT code looks like `DOT H3LN JJ1R 0226` and follows the NHTSA
structure:

```
[DOT] [Plant(2-3)] [Size(2)] [Optional(0-4)] [Week(2)] [Year(2)]
```

The TIN was standardized to 13 symbols for new tires in April 2015.

## Requirements

- PHP 8.2+

## Installation

```bash
composer require martinoak/dot-code-parser
```

## Usage

### Parsing

```php
use Martinoak\DotCodeParser\DotCodeParser;

$parser = new DotCodeParser();

$dot = $parser->parse('DOT 1HD 2A 021X 1225');

$dot->factoryCode;  // "1HD"
$dot->sizeCode;     // "2A"
$dot->optionalCode; // "021X"
$dot->week;         // 12
$dot->year;         // 2025
$dot->plantName;    // "Michelin Italiana — Cuneo, Italy"
$dot->brand();      // "michelin"
$dot->dateCode();   // "1225"
```

Input is normalized automatically — a leading `DOT` prefix, spaces and other
separators are stripped, and the code is uppercased. So all of these parse
identically:

```php
$parser->parse('H3LN JJ1R 0226');
$parser->parse('DOT H3LN JJ1R 0226');
$parser->parse('h3lnjj1r0226');
```

### Handling invalid input

`parse()` throws `InvalidDotCodeException` on malformed input:

```php
use Martinoak\DotCodeParser\InvalidDotCodeException;

try {
    $parser->parse('not-a-code');
} catch (InvalidDotCodeException $e) {
    // handle it
}
```

Prefer `tryParse()` when you'd rather get `null` than an exception:

```php
$dot = $parser->tryParse($userInput); // DotCode|null
```

### The `DotCode` value object

`DotCode` is immutable. Available data and helpers:

| Member            | Type      | Description                                   |
|-------------------|-----------|-----------------------------------------------|
| `$factoryCode`    | `string`  | Plant code (2 or 3 chars)                     |
| `$sizeCode`       | `string`  | Tire size code (2 chars)                      |
| `$optionalCode`   | `string`  | Optional manufacturer block (0–4 chars)       |
| `$week`           | `int`     | Week of manufacture (1–53)                    |
| `$year`           | `int`     | Full year of manufacture, e.g. `2025`         |
| `$plantName`      | `?string` | Resolved plant/manufacturer, or `null`        |
| `dateCode()`      | `string`  | Reconstructed `WWYY` date block, e.g. `1225`  |
| `brand()`         | `?string` | Normalized brand slug, or `null`              |
| `toArray()`       | `array`   | All of the above as an array                  |

`brand()` returns a normalized slug (e.g. `michelin`, `continental`,
`nokian`) derived from the plant name, mapping sub-brands to their parent
group (e.g. `Dębica` → `goodyear`, `Metzeler` → `pirelli`). It returns
`null` for unknown plants — useful as a stable key for mapping to a logo.

## Plant code lookup

The bundled `PlantCodes` table maps DOT plant codes to manufacturer +
location for the major makers (Michelin, Bridgestone, Goodyear, Continental,
Pirelli, Hankook, Nokian, Barum, and more). Both the legacy 2-symbol codes
and the newer NHTSA 3-symbol codes are covered.

```php
use Martinoak\DotCodeParser\PlantCodes;

PlantCodes::name('1HD'); // "Michelin Italiana — Cuneo, Italy"
PlantCodes::name('ZZZ'); // null
PlantCodes::all();       // array<string, string> of the whole table
```

Codes not in the table resolve to `null` — the raw factory code is still
returned by the parser, so parsing degrades gracefully. The authoritative,
complete list is published free by NHTSA vPIC (GetEquipmentPlantCodes).

## Testing

```bash
composer install
composer test
```

## License

Released under the [MIT License](LICENSE).
