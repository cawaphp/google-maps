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

namespace Cawa\GoogleMaps\Models;

class Place extends GeocoderResult
{
    /**
     * @param array $data
     *
     * @return static
     */
    protected static function map(array &$data)
    {
        /** @var Place $return */
        $return = parent::map($data);
        $return->name = self::extract($data, 'name');

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
}
