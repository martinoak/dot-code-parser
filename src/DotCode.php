<?php

declare(strict_types=1);

namespace Martinoak\DotCodeParser;

/**
 * Immutable, structured result of parsing a tire DOT code.
 */
final class DotCode
{
    public function __construct(
        public readonly string $factoryCode,
        public readonly string $sizeCode,
        public readonly string $optionalCode,
        public readonly int $week,
        public readonly int $year,
        public readonly ?string $manufacturer,
        public readonly ?string $plantName,
    ) {
    }

    /**
     * The four-digit manufacture date block, e.g. "0226".
     */
    public function dateCode(): string
    {
        return sprintf('%02d%02d', $this->week, $this->year % 100);
    }

    /**
     * A normalized manufacturer brand slug derived from the plant name
     * (e.g. "michelin", "continental", "nokian"), or null when the plant is
     * unknown or the brand can't be recognised. Intended as a stable key for
     * mapping to a brand logo asset.
     */
    public function brand(): ?string
    {
        if ($this->plantName === null) {
            return null;
        }

        $name = strtolower($this->plantName);

        // Ordered longest/most-specific first so sub-brands resolve to their
        // parent group's logo where that's the recognisable mark.
        $brands = [
            'bfgoodrich' => 'michelin',
            'uniroyal' => 'michelin',
            'michelin' => 'michelin',
            'firestone' => 'bridgestone',
            'bridgestone' => 'bridgestone',
            'dębica' => 'goodyear',
            'debica' => 'goodyear',
            'dunlop' => 'goodyear',
            'goodyear' => 'goodyear',
            'barum' => 'barum',
            'semperit' => 'continental',
            'general' => 'continental',
            'continental' => 'continental',
            'metzeler' => 'pirelli',
            'pirelli' => 'pirelli',
            'hankook' => 'hankook',
            'yokohama' => 'yokohama',
            'cooper' => 'cooper',
            'apollo' => 'apollo',
            'vredestein' => 'apollo',
            'sumitomo' => 'sumitomo',
            'titan' => 'titan',
            'carlisle' => 'carlstar',
            'carlstar' => 'carlstar',
            'tornel' => 'jk',
            'mitas' => 'mitas',
            'nokian' => 'nokian',
        ];

        foreach ($brands as $needle => $slug) {
            if (str_contains($name, $needle)) {
                return $slug;
            }
        }

        return null;
    }

    /**
     * @return array{
     *     factoryCode: string,
     *     sizeCode: string,
     *     optionalCode: string,
     *     week: int,
     *     year: int,
     *     plantName: ?string,
     *     brand: ?string
     * }
     */
    public function toArray(): array
    {
        return [
            'factoryCode' => $this->factoryCode,
            'sizeCode' => $this->sizeCode,
            'optionalCode' => $this->optionalCode,
            'week' => $this->week,
            'year' => $this->year,
            'plantName' => $this->plantName,
            'brand' => $this->brand(),
        ];
    }
}
