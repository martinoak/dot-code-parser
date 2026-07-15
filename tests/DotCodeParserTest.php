<?php

declare(strict_types=1);

use Martinoak\DotCodeParser\DotCode;
use Martinoak\DotCodeParser\DotCodeParser;
use Martinoak\DotCodeParser\InvalidDotCodeException;

beforeEach(function () {
    $this->parser = new DotCodeParser();
});

it('parses the reference spaced code', function () {
    $dot = $this->parser->parse('H3LN JJ1R 0226');

    expect($dot->factoryCode)->toBe('H3')
        ->and($dot->sizeCode)->toBe('LN')
        ->and($dot->optionalCode)->toBe('JJ1R')
        ->and($dot->week)->toBe(2)
        ->and($dot->year)->toBe(2026);
});

it('resolves the plant name for a known factory code', function () {
    $dot = $this->parser->parse('APLN JJ1R 0226');

    expect($dot->factoryCode)->toBe('AP')
        ->and($dot->plantName)->toBe('Michelin — Ardmore, Oklahoma, USA');
});

it('resolves the brand slug from the plant name', function () {
    expect($this->parser->parse('APLN JJ1R 0226')->brand())->toBe('michelin')
        ->and($this->parser->parse('1HW LN 0225')->brand())->toBe('barum')
        ->and($this->parser->parse('YL LN 0225')->brand())->toBe('nokian');
});

it('maps sub-brands to their parent group slug', function () {
    // TC Dębica resolves to the Goodyear group logo.
    expect($this->parser->parse('A5 LN 0225')->brand())->toBe('goodyear');
});

it('leaves the brand null for an unknown plant', function () {
    expect($this->parser->parse('ZZZAB123X4025')->brand())->toBeNull();
});

it('parses a modern 13-symbol TIN with a 3-char plant code', function () {
    $dot = $this->parser->parse('1HD2A021X1225');

    expect($dot->factoryCode)->toBe('1HD')
        ->and($dot->sizeCode)->toBe('2A')
        ->and($dot->optionalCode)->toBe('021X')
        ->and($dot->week)->toBe(12)
        ->and($dot->year)->toBe(2025)
        ->and($dot->plantName)->toBe('Michelin Italiana — Cuneo, Italy');
});

it('infers a 3-char plant from body length for an unknown modern TIN', function () {
    // ZZZ is not in the table, but the 9-char body forces a 3-char plant
    // (3 + size 2 + optional 4), since the optional block is capped at 4.
    $dot = $this->parser->parse('ZZZAB123X4025');

    expect($dot->factoryCode)->toBe('ZZZ')
        ->and($dot->sizeCode)->toBe('AB')
        ->and($dot->optionalCode)->toBe('123X')
        ->and($dot->week)->toBe(40)
        ->and($dot->year)->toBe(2025)
        ->and($dot->plantName)->toBeNull();
});

it('parses the Michelin example with a DOT prefix', function () {
    $dot = $this->parser->parse('DOT T7D3 1BH 3218');

    expect($dot->factoryCode)->toBe('T7')
        ->and($dot->sizeCode)->toBe('D3')
        ->and($dot->optionalCode)->toBe('1BH')
        ->and($dot->week)->toBe(32)
        ->and($dot->year)->toBe(2018);
});

it('parses a code with no optional block', function () {
    $dot = $this->parser->parse('B9WC 1909');

    expect($dot->factoryCode)->toBe('B9')
        ->and($dot->sizeCode)->toBe('WC')
        ->and($dot->optionalCode)->toBe('')
        ->and($dot->week)->toBe(19)
        ->and($dot->year)->toBe(2009);
});

it('parses an unspaced code', function () {
    $dot = $this->parser->parse('H3LNJJ1R0226');

    expect($dot->factoryCode)->toBe('H3')
        ->and($dot->sizeCode)->toBe('LN')
        ->and($dot->week)->toBe(2)
        ->and($dot->year)->toBe(2026);
});

it('leaves the plant name null for unknown factory codes', function () {
    $dot = $this->parser->parse('ZZWC 1909');

    expect($dot->factoryCode)->toBe('ZZ')
        ->and($dot->plantName)->toBeNull();
});

it('exposes the reconstructed date code', function () {
    $dot = $this->parser->parse('H3LN JJ1R 0226');

    expect($dot->dateCode())->toBe('0226');
});

it('returns null from tryParse for invalid input', function () {
    expect($this->parser->tryParse('nonsense'))->toBeNull()
        ->and($this->parser->tryParse(''))->toBeNull()
        ->and($this->parser->tryParse('H3LN JJ1R 0026'))->toBeNull();
});

it('throws for invalid input', function () {
    $this->parser->parse('nope');
})->throws(InvalidDotCodeException::class);

it('returns an immutable value object', function () {
    expect($this->parser->parse('B9WC 1909'))->toBeInstanceOf(DotCode::class);
});
