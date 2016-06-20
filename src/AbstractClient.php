<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Cawa\GoogleMaps;

use Cawa\Core\DI;
use Cawa\GoogleMaps\Exceptions\InvalidRequest;
use Cawa\GoogleMaps\Exceptions\OverQueryLimit;
use Cawa\GoogleMaps\Exceptions\RequestDenied;
use Cawa\GoogleMaps\Exceptions\Unknown;
use Cawa\HttpClient\HttpClient;
use Cawa\Net\Uri;

class AbstractClient
{
    /**
     * @var HttpClient
     */
    private static $client;

    /**
     * @param string $url
     * @param array $queries
     *
     * @throws InvalidRequest
     * @throws OverQueryLimit
     * @throws RequestDenied
     * @throws Unknown
     *
     * @return array
     */
    protected static function query(string $url, array $queries = []) : array
    {
        if (!self::$client) {
            self::$client = new HttpClient();
            $base = new Uri('https://maps.googleapis.com/maps/api');
            $base->addQuery('key', DI::config()->get('googleMaps/apikey'));

            self::$client->setBaseUri($base);
        }

        $uri = new Uri($url);
        $uri->addQueries($queries);

        $response = self::$client->get($uri->get());
        $data = json_decode($response->getBody(), true);

        if (!($data['status'] == 'OK' || $data['status'] == 'ZERO_RESULTS')) {
            switch ($data['status']) {
                case 'OVER_QUERY_LIMIT':
                    throw new OverQueryLimit($data['error_message'] ?? null);
                case 'REQUEST_DENIED':
                    throw new RequestDenied($data['error_message'] ?? null);
                case 'INVALID_REQUEST':
                    throw new InvalidRequest($data['error_message'] ?? null);
                default:
                    throw new Unknown($data['error_message'] ?? null);
            }
        }

        return $data['results'];
    }
}
