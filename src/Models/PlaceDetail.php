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
use Cawa\Orm\SerializableTrait;

class PlaceDetail extends GeocoderResult
{
    use SerializableTrait;

    /**
     * @param array $data
     *
     * @return static
     */
    protected static function map(array &$data)
    {
        /** @var PlaceDetail $return */
        $return = parent::map($data);
        $return->name = self::extract($data, 'name');
        $return->phone = self::extract($data, 'international_phone_number');
        $return->website = self::extract($data, 'website');
        $return->rating = self::extract($data, 'rating');

        if (isset($data['photos'])) {
            foreach (self::extract($data, 'photos') as $current) {
                $return->photos[] = new Photo(
                    $current['width'],
                    $current['height'],
                    $current['html_attributions'],
                    $current['photo_reference'] ?? null
                );
            }
        }

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

        if (isset($data['opening_hours'])) {
            foreach (self::extract($data, 'opening_hours/periods') as $current) {
                $open = new DateTime();
                $open->setWeekendDays($current['open']['day']);
                $open->hour($current['open']['hours']);
                $open->minute($current['open']['minutes']);
                $open->second(0);

                $close = new DateTime();
                $close->setWeekendDays($current['close']['day']);
                $close->hour($current['close']['hours']);
                $close->minute($current['close']['minutes']);
                $close->second(0);

                $return->openingHours[] = new OpeningHoursPeriod($open, $close);
            }
        }

        return $return;
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
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
     * @var Photo[]
     */
    private $photos = [];

    /**
     * @return Photo[]
     */
    public function getPhotos() : array
    {
        return $this->photos;
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
     * @return array
     */
    public function getOpeningHours() : array
    {
        return $this->openingHours;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->getSerializableData($this);
    }
}
