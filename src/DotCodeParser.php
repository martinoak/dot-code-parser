<?php

declare(strict_types=1);

namespace Martinoak\DotCodeParser;

/**
 * Parses tire DOT codes into their component parts.
 *
 * Structure (per NHTSA / Michelin):
 *   [DOT] [Plant(2-3)][Size(2)][Optional(0-4)] [Week(2)][Year(2)]
 *
 * The trailing four digits are always week + year. The leading block is
 * plant + size (+ optional manufacturer code). Plant codes default to two
 * characters; three-character plants are recognised via the bundled table.
 *
 * Examples:
 *   "H3LN JJ1R 0226" => plant H3, size LN, optional JJ1R, week 02, year 2026
 *   "DOT T7D3 1BH 3218" => plant T7, size D3, optional 1BH, week 32, year 2018
 */
final class DotCodeParser
{
    /**
     * Parse a DOT code, throwing on invalid input.
     *
     * @throws InvalidDotCodeException
     */
    public function parse(string $code): DotCode
    {
        $result = $this->tryParse($code);

        if ($result === null) {
            throw InvalidDotCodeException::forCode($code);
        }

        return $result;
    }

    /**
     * Parse a DOT code, returning null instead of throwing on invalid input.
     */
    public function tryParse(string $code): ?DotCode
    {
        $normalized = $this->normalize($code);

        if (! preg_match('/^([A-Z0-9]+?)(\d{2})(\d{2})$/', $normalized, $m)) {
            return null;
        }

        [, $body, $week, $year] = $m;

        // The body holds plant(2-3) + size(2) + optional(0-4).
        if (strlen($body) < 4) {
            return null;
        }

        $plantLength = $this->plantLength($body);
        $factoryCode = substr($body, 0, $plantLength);
        $sizeCode = substr($body, $plantLength, 2);
        $optionalCode = substr($body, $plantLength + 2);

        if (strlen($sizeCode) !== 2 || strlen($optionalCode) > 4) {
            return null;
        }

        $week = (int) $week;

        if ($week < 1 || $week > 53) {
            return null;
        }

        return new DotCode(
            factoryCode: $factoryCode,
            sizeCode: $sizeCode,
            optionalCode: $optionalCode,
            week: $week,
            year: $this->fullYear((int) $year),
            plantName: PlantCodes::name($factoryCode),
        );
    }

    /**
     * Strip whitespace and an optional leading "DOT" prefix, uppercase the rest.
     */
    private function normalize(string $code): string
    {
        $code = strtoupper(trim($code));
        $code = preg_replace('/^DOT[\s-]*/', '', $code) ?? $code;

        return (string) preg_replace('/[^A-Z0-9]/', '', $code);
    }

    /**
     * Decide whether the plant code is 2 or 3 chars.
     *
     * The body holds plant + size(2) + optional(0-4). Prefer a known plant from
     * the bundled table (checking the 3-char prefix first, then the 2-char one).
     * When neither is known, fall back to the body length: an optional block is
     * capped at 4 chars, so a body of 9 chars can only be plant(3)+size(2)+
     * optional(4) — a 2-char plant would need a 5-char optional. This lets the
     * parser handle valid 13-symbol TINs whose plant isn't in the table yet.
     */
    private function plantLength(string $body): int
    {
        $canBeThree = strlen($body) - 2 >= 3;

        if ($canBeThree && PlantCodes::name(substr($body, 0, 3)) !== null) {
            return 3;
        }

        if (PlantCodes::name(substr($body, 0, 2)) !== null) {
            return 2;
        }

        // Unknown plant: infer from body length. Optional block is <= 4, so a
        // 9-char body must have a 3-char plant (3 + 2 + 4).
        if (strlen($body) - 2 - 4 > 2) {
            return 3;
        }

        return 2;
    }

    /**
     * Expand a two-digit year to a full year. Years greater than the current
     * two-digit year map to the 1900s (pre-2000 tires), matching the DOT spec's
     * ambiguity resolution used by common decoders.
     */
    private function fullYear(int $twoDigit): int
    {
        $currentTwoDigit = (int) date('y');

        return $twoDigit <= $currentTwoDigit
            ? 2000 + $twoDigit
            : 1900 + $twoDigit;
    }
}
