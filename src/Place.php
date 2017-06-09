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

use Cawa\Core\DI;
use Cawa\GoogleMaps\Models\Place as PlaceModel;
use Cawa\GoogleMaps\Models\PlaceDetail;

class Place extends AbstractClient
{
    /**
     * The latitude/longitude around which to retrieve place information.
     * This must be specified as latitude,longitude.
     */
    const PARAM_LOCATION = 'location';

    /**
     * Defines the distance (in meters) within which to return place results.
     * The maximum allowed radius is 50 000 meters.
     * Note that radius must not be included if rankby=distance.
     */
    const PARAM_RADIUS = 'radius';

    /**
     * A term to be matched against all content that Google has indexed for this place,
     * including but not limited to name, type, and address, as well as customer reviews and other third-party content.
     */
    const PARAM_KEYWORD = 'keyword';

    /**
     * The language code, indicating in which language the results should be returned, if possible.
     * Searches are also biased to the selected language;
     * results in the selected language may be given a higher ranking.
     *
     * @see https://developers.google.com/maps/faq#languagesupport
     */
    const PARAM_LANGUAGE = 'language';

    /**
     * Restricts results to only those places within the specified range.
     * Valid values range between 0 (most affordable) to 4 (most expensive), inclusive.
     * The exact amount indicated by a specific value will vary from region to region.
     */
    const PARAM_MINPRICE = 'minprice';
    const PARAM_MAXPRICE = 'maxprice';

    /**
     * One or more terms to be matched against the names of places, separated by a pipe symbol (term1|term2|etc).
     * Results will be restricted to those containing the passed name values.
     * Note that a place may have additional names associated with it, beyond its listed name.
     * The API will try to match the passed name value against all of these names.
     * As a result, places may be returned in the results whose listed names do not match the search term,
     * but whose associated names do.
     */
    const PARAM_NAME = 'name';

    /**
     * Returns only those places that are open for business at the time the query is sent.
     * Places that do not specify opening hours in the Google Places database will not be returned
     * if you include this parameter in your query.
     */
    const PARAM_OPENNOW = 'opennow';

    /**
     * Specifies the order in which results are listed.
     * Note that rankby must not be included if radius (described under Required parameters above) is specified.
     * Possible values are:
     * - prominence (default). This option sorts results based on their importance.
     *       Ranking will favor prominent places within the specified area.
     *       Prominence can be affected by a place's ranking in Google's index, global popularity, and other factors.
     * - distance. This option biases search results in ascending order by their distance from the specified location.
     *       When distance is specified, one or more of keyword, name, or type is required.
     */
    const PARAM_RANKBY = 'rankby';

    /**
     * Restricts the results to places matching the specified type.
     * Only one type may be specified
     * (if more than one type is provided, all types following the first entry are ignored).
     *
     * @see https://developers.google.com/places/supported_types
     */
    const PARAM_TYPE = 'type';

    /**
     * @param array $params
     *
     * @return array|PlaceModel[]
     */
    public static function nearby(array $params = []) : array
    {
        $data = self::query('/place/nearbysearch/json', array_merge($params, [
            'key' => DI::config()->get('googleApi/server'),
        ]));

        $return = [];
        foreach ($data['results'] as $current) {
            $return[] = PlaceModel::parse($current);
        }

        if (isset($data['next_page_token'])) {
            self::$nextPage = [
                'url' => '/place/nearbysearch/json',
                'params' => array_merge([], [
                    'pagetoken' => $data['next_page_token'],
                ]),
            ];
        }

        return $return;
    }

    /**
     * The text string on which to search, for example: "restaurant".
     * The Google Places service will return candidate matches based on this string
     * and order the results based on their perceived relevance.
     * This parameter becomes optional if the type parameter is also used in the search request.
     */
    const PARAM_QUERY = 'query';

    /**
     * @param array $params
     *
     * @return array|PlaceModel[]
     */
    public static function search(array $params = []) : array
    {
        $data = self::query('/place/textsearch/json', array_merge($params, [
            'key' => DI::config()->get('googleApi/server'),
        ]));

        $return = [];
        foreach ($data['results'] as $current) {
            $return[] = PlaceModel::parse($current);
        }

        if (isset($data['next_page_token'])) {
            self::$nextPage = [
                'url' => '/place/textsearch/json',
                'params' => array_merge($params, [
                    'pagetoken' => $data['next_page_token'],
                ]),
            ];
        }

        return $return;
    }

    /**
     * @var array
     */
    private static $nextPage;

    /**
     * @return array|PlaceModel[]
     */
    public static function nextPage()
    {
        if (!self::$nextPage) {
            return [];
        }
        // @see http://stackoverflow.com/a/12825461/1590168 must wait that the token is available
        sleep(2);
        $data = self::query(self::$nextPage['url'], array_merge(self::$nextPage['params'], [
            // 'key' => DI::config()->get('googleApi/server'),
        ]));

        $return = [];
        foreach ($data['results'] as $current) {
            $return[] = PlaceModel::parse($current);
        }

        if (isset($data['next_page_token'])) {
            self::$nextPage['params']['pagetoken'] = $data['next_page_token'];
        }

        return $return;
    }

    /**
     * A textual identifier that uniquely identifies a place, returned from a Place Search.
     */
    const PARAM_PLACEID = 'placeid';

    /**
     * A textual identifier that uniquely identifies a place, returned from a Place Search.
     */
    const PARAM_REFERENCE = 'reference';

    /**
     * @param array $params
     *
     * @return PlaceDetail
     */
    public static function detail(array $params = [])
    {
        $data = self::query('/place/details/json', array_merge($params, [
            'key' => DI::config()->get('googleApi/server'),
        ]));

        if ($data) {
            return PlaceDetail::parse($data['result']);
        }

        return null;
    }
}
