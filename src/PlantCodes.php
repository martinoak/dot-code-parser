<?php

declare(strict_types=1);

namespace Martinoak\DotCodeParser;

/**
 * Bundled lookup of tire plant (factory) codes to their manufacturer/plant.
 *
 * This is starter "hard data" — a small set of well-known, publicly documented
 * codes. The authoritative, complete list is published free by NHTSA vPIC
 * (GetEquipmentPlantCodes). Extend the MAP below with your own entries; codes
 * not present here simply resolve to null (the raw factory code is still shown).
 *
 * Codes are matched case-insensitively (stored uppercase).
 */
final class PlantCodes
{
    /**
     * @var array<string, string>
     *
     * Keys are DOT plant codes (uppercased). Both the legacy 2-symbol codes and
     * the NHTSA 3-symbol replacements (phased in from 2015, mandatory after
     * April 2025) are included where documented, so a lookup succeeds regardless
     * of which form is molded on the tire. Names are the current plant
     * owner/operator with location. Cross-referenced from the U.S. DOT plant
     * code list (via Tire Business), NHTSA vPIC, and public DOT decoders.
     */
    private const MAP = [
        // --- Michelin group (Michelin, BFGoodrich, Uniroyal, Kleber, Kormoran) ---
        'AP' => 'Michelin — Ardmore, Oklahoma, USA',
        '1AP' => 'Michelin — Ardmore, Oklahoma, USA',
        'BE' => 'Michelin — Tuscaloosa, Alabama, USA',
        '1BE' => 'Michelin — Tuscaloosa, Alabama, USA',
        'BF' => 'Michelin — Fort Wayne, Indiana, USA',
        '1BF' => 'Michelin — Fort Wayne, Indiana, USA',
        'M3' => 'Michelin — Greenville, South Carolina, USA',
        '1M3' => 'Michelin — Greenville, South Carolina, USA',
        '4M' => 'Michelin — Greenville, South Carolina, USA',
        '14M' => 'Michelin — Greenville, South Carolina, USA',
        '2X' => 'Michelin — Lexington, South Carolina, USA',
        'M5' => 'Michelin — Bridgewater, Nova Scotia, Canada',
        '1M5' => 'Michelin — Bridgewater, Nova Scotia, Canada',
        'A1' => 'Michelin — Poitiers, France',
        '1A1' => 'Michelin — Poitiers, France',
        'B1' => 'Michelin — La Roche-sur-Yon, France',
        '1B1' => 'Michelin — La Roche-sur-Yon, France',
        'FJ' => 'Michelin — France',
        '1FJ' => 'Michelin — France',
        '5E' => 'Michelin — Le Puy-en-Velay, France',
        '15E' => 'Michelin — Le Puy-en-Velay, France',
        'FF' => 'Michelin — France',
        'DK' => 'Michelin — Blanzy, France',
        '1DK' => 'Michelin — Blanzy, France',
        'FT' => 'Michelin — Bad Kreuznach, Germany',
        '1FT' => 'Michelin — Bad Kreuznach, Germany',
        'FX' => 'Michelin — Leeuw-St.-Pierre, Belgium',
        '1FX' => 'Michelin — Leeuw-St.-Pierre, Belgium',
        'B7' => 'Michelin — Stoke-on-Trent, United Kingdom',
        '1B7' => 'Michelin — Stoke-on-Trent, United Kingdom',
        'ED' => 'Nihon Michelin — Ota, Gunma, Japan',
        '1ED' => 'Nihon Michelin — Ota, Gunma, Japan',
        '7V' => 'Michelin Shenyang — Shanghai, China',
        '17V' => 'Michelin Shenyang — Shanghai, China',
        '22' => 'Michelin — Davydovo, Russia',
        '122' => 'Michelin — Davydovo, Russia',
        'C1' => 'Michelin (Nigeria) — Port Harcourt, Nigeria',
        '1C1' => 'Michelin (Nigeria) — Port Harcourt, Nigeria',
        'K0' => 'Michelin — Korea',
        '1K0' => 'Michelin — Korea',
        'HA' => 'Michelin — Aranda, Spain',
        '1HA' => 'Michelin — Aranda, Spain',
        'HB' => 'Michelin — Lasarte, Spain',
        '1HB' => 'Michelin — Lasarte, Spain',
        'HD' => 'Michelin Italiana — Cuneo, Italy',
        '1HD' => 'Michelin Italiana — Cuneo, Italy',
        'HE' => 'Michelin Italiana — Italy',
        '1HE' => 'Michelin Italiana — Italy',

        // --- Bridgestone group (Bridgestone, Firestone, Dayton) ---
        '1C' => 'Bridgestone/Firestone — USA',
        'AE' => 'Bridgestone — Santander, Spain',
        '1AE' => 'Bridgestone — Santander, Spain',
        '15C' => 'Bridgestone Hispania — Bilbao, Spain',
        '5C' => 'Bridgestone Hispania — Bilbao, Spain',
        'A7' => 'Bridgestone — Bangkok, Thailand',
        '1A7' => 'Bridgestone — Bangkok, Thailand',
        'A8' => 'Bridgestone — Jakarta, Indonesia',
        '1A8' => 'Bridgestone — Jakarta, Indonesia',
        'C5' => 'Bridgestone — Poznań, Poland',
        '1C5' => 'Bridgestone — Poznań, Poland',
        'JY' => 'Bridgestone — Stargard Szczeciński, Poland',
        '1JY' => 'Bridgestone — Stargard Szczeciński, Poland',
        '1U' => 'Bridgestone (Tianjin) — China',
        'DH' => 'Bridgestone',
        '1DH' => 'Bridgestone',

        // --- Goodyear group (Goodyear, Dunlop, Debica, Fulda, Sava, Kelly) ---
        'M6' => 'Goodyear — USA',
        '1M6' => 'Goodyear — USA',
        'A5' => 'TC Dębica (Goodyear) — Dębica, Poland',
        '1A5' => 'TC Dębica (Goodyear) — Dębica, Poland',
        'CO' => 'Goodyear — Adapazarı, Turkey',
        'C01' => 'Goodyear — Adapazarı, Turkey',
        '7L' => 'Goodyear — China',
        '17L' => 'Goodyear — China',
        '1T' => 'Goodyear — Parang, Marikina, Philippines',
        '4B' => 'Goodyear Canada — Napanee, Ontario, Canada',
        '14B' => 'Goodyear Canada — Napanee, Ontario, Canada',
        '1NW' => 'Goodyear (South Africa)',
        'NW' => 'Goodyear (South Africa)',
        '1NY' => 'Goodyear (Thailand)',
        'NY' => 'Goodyear (Thailand)',

        // --- Continental group (Continental, General, Uniroyal, Semperit, Barum) ---
        'AF' => 'Continental — Lousada, Portugal',
        '1AF' => 'Continental — Lousada, Portugal',
        'A3' => 'Continental Tire North America — Mount Vernon, Illinois, USA',
        '1A3' => 'Continental Tire North America — Mount Vernon, Illinois, USA',
        'B2' => 'Continental',
        '1B2' => 'Continental',

        // --- Pirelli group (Pirelli, Metzeler) ---
        'XA' => 'Pirelli Pneumatici — Bollate, Italy',
        '1XA' => 'Pirelli Pneumatici — Bollate, Italy',
        '8U' => 'Pirelli Tyre — Bicocca, Milan, Italy',
        '18U' => 'Pirelli Tyre — Bicocca, Milan, Italy',
        'HT' => 'Pirelli — Settimo Torinese, Italy',
        '1HT' => 'Pirelli — Settimo Torinese, Italy',
        'CE' => 'Pirelli Germany — Höchst/Odenwald, Germany',
        '1CE' => 'Pirelli Germany — Höchst/Odenwald, Germany',
        'EB' => 'Metzeler (Pirelli) — Odenwald, Germany',
        '1EB' => 'Metzeler (Pirelli) — Odenwald, Germany',
        '51' => 'Pirelli Tyre — Yanzhou, Shandong, China',
        '151' => 'Pirelli Tyre — Yanzhou, Shandong, China',
        '1B' => 'Pirelli de Venezuela — Valencia, Venezuela',
        '11B' => 'Pirelli de Venezuela — Valencia, Venezuela',

        // --- Hankook ---
        'BB' => 'Hankook — Chongqing, China',
        '1BB' => 'Hankook — Chongqing, China',
        'BC' => 'Hankook — Cikarang, Bekasi, Indonesia',
        '1BC' => 'Hankook — Cikarang, Bekasi, Indonesia',
        'BJ' => 'Hankook — Huaiyin, Jiangsu, China',
        '1BJ' => 'Hankook — Huaiyin, Jiangsu, China',

        // --- Yokohama ---
        '4U' => 'Yokohama Tire Philippines — Clark Field, Pampanga, Philippines',
        '14U' => 'Yokohama Tire Philippines — Clark Field, Pampanga, Philippines',

        // --- Cooper ---
        'AT' => 'Cooper — Melksham, England',
        '1AT' => 'Cooper — Melksham, England',

        // --- Apollo / Vredestein ---
        'A6' => 'Apollo Tyres — Kerala, India',
        '1A6' => 'Apollo Tyres — Kerala, India',

        // --- Sumitomo ---
        'AH' => 'Sumitomo — Çankırı, Turkey',
        '1AH' => 'Sumitomo — Çankırı, Turkey',

        // --- Titan ---
        'A9' => 'Titan Tire — Bryan, Ohio, USA',
        '1A9' => 'Titan Tire — Bryan, Ohio, USA',

        // --- Carlstar / Carlisle ---
        'C4' => 'Carlisle Tire & Wheel — Clinton, Tennessee, USA',
        '1C4' => 'The Carlstar Group — Clinton, Tennessee, USA',

        // --- JK Tyres ---
        'AG' => 'JK Tornel — Tacuba, Mexico',
        '2A6' => 'JK Tornel — Tacuba, Mexico',

        // --- Czech Republic plants ---
        'HW' => 'Continental Barum — Otrokovice, Czech Republic',
        '1HW' => 'Continental Barum — Otrokovice, Czech Republic',
        '54' => 'Mitas — Otrokovice, Czech Republic',
        '154' => 'Mitas — Otrokovice, Czech Republic',

        // --- Nokian ---
        'YL' => 'Nokian Tyres — Nokia, Finland',
        '1YL' => 'Nokian Tyres — Nokia, Finland',
        '03B' => 'Nokian Tyres — Dayton, Tennessee, USA',
        '60' => 'Nokian Tyres — Vsevolozhsk, Russia',
        '160' => 'Nokian Tyres — Vsevolozhsk, Russia',

        // --- Various China plants ---
        'AA' => 'Tianjin Normandy Rubber — Tianjin, China',
        '1AA' => 'Tianjin Normandy Rubber — Tianjin, China',
        'AB' => 'Weifang Rubber Factory — Weifang, Shandong, China',
        '1AB' => 'Weifang Rubber Factory — Weifang, Shandong, China',
        'AC' => 'Shandong Huasheng Rubber — Dongying, Shandong, China',
        '1AC' => 'Shandong Huasheng Rubber — Dongying, Shandong, China',
        'AD' => 'Shandong Yongfeng Tyres — Linyi, Shandong, China',
        '1AD' => 'Shandong Yongfeng Tyres — Linyi, Shandong, China',
        'AR' => 'OJSC Yaroslavl — Yaroslavl, Russia',
        '1AR' => 'OJSC Yaroslavl — Yaroslavl, Russia',
    ];

    /**
     * @var array<string, string>
     *
     * Simple manufacturer names extracted from the full plant descriptions.
     */
    private const MANUFACTURERS = [
        'AP' => 'Michelin',
        '1AP' => 'Michelin',
        'BE' => 'Michelin',
        '1BE' => 'Michelin',
        'BF' => 'Michelin',
        '1BF' => 'Michelin',
        'M3' => 'Michelin',
        '1M3' => 'Michelin',
        '4M' => 'Michelin',
        '14M' => 'Michelin',
        '2X' => 'Michelin',
        'M5' => 'Michelin',
        '1M5' => 'Michelin',
        'A1' => 'Michelin',
        '1A1' => 'Michelin',
        'B1' => 'Michelin',
        '1B1' => 'Michelin',
        'FJ' => 'Michelin',
        '1FJ' => 'Michelin',
        '5E' => 'Michelin',
        '15E' => 'Michelin',
        'FF' => 'Michelin',
        'DK' => 'Michelin',
        '1DK' => 'Michelin',
        'FT' => 'Michelin',
        '1FT' => 'Michelin',
        'FX' => 'Michelin',
        '1FX' => 'Michelin',
        'B7' => 'Michelin',
        '1B7' => 'Michelin',
        'ED' => 'Nihon Michelin',
        '1ED' => 'Nihon Michelin',
        '7V' => 'Michelin Shenyang',
        '17V' => 'Michelin Shenyang',
        '22' => 'Michelin',
        '122' => 'Michelin',
        'C1' => 'Michelin (Nigeria)',
        '1C1' => 'Michelin (Nigeria)',
        'K0' => 'Michelin',
        '1K0' => 'Michelin',
        'HA' => 'Michelin',
        '1HA' => 'Michelin',
        'HB' => 'Michelin',
        '1HB' => 'Michelin',
        'HD' => 'Michelin Italiana',
        '1HD' => 'Michelin Italiana',
        'HE' => 'Michelin Italiana',
        '1HE' => 'Michelin Italiana',
        '1C' => 'Bridgestone/Firestone',
        'AE' => 'Bridgestone',
        '1AE' => 'Bridgestone',
        '15C' => 'Bridgestone Hispania',
        '5C' => 'Bridgestone Hispania',
        'A7' => 'Bridgestone',
        '1A7' => 'Bridgestone',
        'A8' => 'Bridgestone',
        '1A8' => 'Bridgestone',
        'C5' => 'Bridgestone',
        '1C5' => 'Bridgestone',
        'JY' => 'Bridgestone',
        '1JY' => 'Bridgestone',
        '1U' => 'Bridgestone (Tianjin)',
        'DH' => 'Bridgestone',
        '1DH' => 'Bridgestone',
        'M6' => 'Goodyear',
        '1M6' => 'Goodyear',
        'A5' => 'TC Dębica (Goodyear)',
        '1A5' => 'TC Dębica (Goodyear)',
        'CO' => 'Goodyear',
        'C01' => 'Goodyear',
        '7L' => 'Goodyear',
        '17L' => 'Goodyear',
        '1T' => 'Goodyear',
        '4B' => 'Goodyear Canada',
        '14B' => 'Goodyear Canada',
        '1NW' => 'Goodyear (South Africa)',
        'NW' => 'Goodyear (South Africa)',
        '1NY' => 'Goodyear (Thailand)',
        'NY' => 'Goodyear (Thailand)',
        'AF' => 'Continental',
        '1AF' => 'Continental',
        'A3' => 'Continental Tire North America',
        '1A3' => 'Continental Tire North America',
        'B2' => 'Continental',
        '1B2' => 'Continental',
        'XA' => 'Pirelli Pneumatici',
        '1XA' => 'Pirelli Pneumatici',
        '8U' => 'Pirelli Tyre',
        '18U' => 'Pirelli Tyre',
        'HT' => 'Pirelli',
        '1HT' => 'Pirelli',
        'CE' => 'Pirelli Germany',
        '1CE' => 'Pirelli Germany',
        'EB' => 'Metzeler (Pirelli)',
        '1EB' => 'Metzeler (Pirelli)',
        '51' => 'Pirelli Tyre',
        '151' => 'Pirelli Tyre',
        '1B' => 'Pirelli de Venezuela',
        '11B' => 'Pirelli de Venezuela',
        'BB' => 'Hankook',
        '1BB' => 'Hankook',
        'BC' => 'Hankook',
        '1BC' => 'Hankook',
        'BJ' => 'Hankook',
        '1BJ' => 'Hankook',
        '4U' => 'Yokohama Tire Philippines',
        '14U' => 'Yokohama Tire Philippines',
        'AT' => 'Cooper',
        '1AT' => 'Cooper',
        'A6' => 'Apollo Tyres',
        '1A6' => 'Apollo Tyres',
        'AH' => 'Sumitomo',
        '1AH' => 'Sumitomo',
        'A9' => 'Titan Tire',
        '1A9' => 'Titan Tire',
        'C4' => 'Carlisle Tire & Wheel',
        '1C4' => 'The Carlstar Group',
        'AG' => 'JK Tornel',
        '2A6' => 'JK Tornel',
        'HW' => 'Continental Barum',
        '1HW' => 'Continental Barum',
        '54' => 'Mitas',
        '154' => 'Mitas',
        'YL' => 'Nokian Tyres',
        '1YL' => 'Nokian Tyres',
        '03B' => 'Nokian Tyres',
        '60' => 'Nokian Tyres',
        '160' => 'Nokian Tyres',
        'AA' => 'Tianjin Normandy Rubber',
        '1AA' => 'Tianjin Normandy Rubber',
        'AB' => 'Weifang Rubber Factory',
        '1AB' => 'Weifang Rubber Factory',
        'AC' => 'Shandong Huasheng Rubber',
        '1AC' => 'Shandong Huasheng Rubber',
        'AD' => 'Shandong Yongfeng Tyres',
        '1AD' => 'Shandong Yongfeng Tyres',
        'AR' => 'OJSC Yaroslavl',
        '1AR' => 'OJSC Yaroslavl',
    ];

    /**
     * Resolve a factory code to a plant/manufacturer name, or null if unknown.
     */
    public static function name(string $factoryCode): ?string
    {
        return self::MAP[strtoupper($factoryCode)] ?? null;
    }

    /**
     * Resolve a factory code to a simple manufacturer name, or null if unknown.
     */
    public static function manufacturer(string $factoryCode): ?string
    {
        return self::MANUFACTURERS[strtoupper($factoryCode)] ?? null;
    }

    /**
     * @return array<string, string>
     */
    public static function all(): array
    {
        return self::MAP;
    }

    /**
     * @return array<string, string>
     */
    public static function allManufacturers(): array
    {
        return self::MANUFACTURERS;
    }
}
