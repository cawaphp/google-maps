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

namespace Cawa\GoogleMaps\Models;

use Cawa\Date\DateTime;

class PlaceDetail extends Place
{
    /**
     * @param array $data
     *
     * @return $this|self
     */
    protected static function map(array &$data)
    {
        /** @var PlaceDetail $return */
        $return = parent::map($data);
        $return->phone = self::extract($data, 'international_phone_number');
        $return->website = self::extract($data, 'website');
        $return->rating = self::extract($data, 'rating');

        if (isset($data['reviews'])) {
            foreach (self::extract($data, 'reviews') as $current) {
                $return->reviews[] = new Review(
                    $current['author_name'],
                    $current['language'],
                    $current['rating'],
                    $current['text'],
                    $current['time'],
                    $current['author_url'] ?? null
                );
            }
        }

        if (isset($data['opening_hours']['periods'])) {
            foreach (self::extract($data, 'opening_hours/periods') as $current) {
                if (isset($current['open']) && isset($current['close'])) {
                    list($hour, $min) = self::extractHourMin($current['open']);
                    $open = new DateTime();
                    $open->setTimezone('UTC');
                    $open->next($current['open']['day']);
                    $open->hour($hour);
                    $open->minute($min);
                    $open->second(0);
                    $open->addMinutes(-$return->utcOffset);
                    $open->setTimezone(date_default_timezone_get());

                    list($hour, $min) = self::extractHourMin($current['close']);
                    $close = new DateTime();
                    $close->setTimezone('UTC');
                    $close->next($current['close']['day']);
                    $close->hour($hour);
                    $close->minute($min);
                    $close->second(0);
                    $close->addMinutes(-$return->utcOffset);
                    $close->setTimezone(date_default_timezone_get());

                    $return->openingHours[] = new OpeningHoursPeriod($open, $close);
                }
            }
        }

        return $return;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private static function extractHourMin(array $data) : array
    {
        if (isset($data['hours'])) {
            return [$data['hours'], $data['minutes']];
        } else {
            return [substr($data['time'], 0, 2), substr($data['time'], 2, 2)];
        }
    }

    /**
     * @var string
     */
    private $phone;

    /**
     * @return string
     */
    public function getPhone() : string
    {
        return $this->phone;
    }

    /**
     * @var string
     */
    private $website;

    /**
     * @return string
     */
    public function getWebsite() : string
    {
        return $this->website;
    }

    /**
     * @var float
     */
    private $rating;

    /**
     * @return float
     */
    public function getRating() : float
    {
        return $this->rating;
    }

    /**
     * @var Review[]
     */
    private $reviews = [];

    /**
     * @return Review[]
     */
    public function getReviews() : array
    {
        return $this->reviews;
    }

    /**
     * @var array
     */
    private $openingHours = [];

    /**
     * @return array|OpeningHoursPeriod[]
     */
    public function getOpeningHours() : array
    {
        return $this->openingHours;
    }
}
