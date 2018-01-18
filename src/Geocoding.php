<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\GoogleMaps;

use Cawa\GoogleMaps\Models\GeocoderResult;

class Geocoding extends AbstractClient
{
    /**
     * @param string $address
     *
     * @return GeocoderResult[]
     */
    public static function addressLookup(string $address) : array
    {
        $data = self::query('/geocode/json', [
            'address' => $address,
        ]);

        $return = [];
        foreach ($data['results'] as $current) {
            $return[] = GeocoderResult::parse($current);
        }

        return $return;
    }

    /**
     * @param float $lat
     * @param float $long
     *
     * @return GeocoderResult[]
     */
    public static function coordinateLookup(float $lat, float $long) : array
    {
        $data = self::query('/geocode/json', [
            'lat' => $lat,
            'lng' => $long,
        ]);

        $return = [];
        foreach ($data['results'] as $current) {
            $return[] = GeocoderResult::parse($current);
        }

        return $return;
    }
}
