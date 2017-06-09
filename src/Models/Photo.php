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

use Cawa\Core\DI;
use Cawa\Net\Uri;

class Photo
{
    /**
     * @param int $width
     * @param int $height
     * @param string[] $attributions
     * @param string $reference
     */
    public function __construct(int $width, int $height, array $attributions = [], string $reference = null)
    {
        $this->reference = $reference;
        $this->width = $width;
        $this->height = $height;
        $this->attributions = $attributions;
    }

    /**
     * @var string
     */
    private $reference;

    /**
     * string used to identify the photo when you perform a Photo request.
     *
     * @return string
     */
    public function getReference() : string
    {
        return $this->reference;
    }

    /**
     * the maximum width of the image.
     *
     * @var int
     */
    private $width;

    /**
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * @var int
     */
    private $height;

    /**
     * the maximum height of the image.
     *
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * @var string[]
     */
    private $attributions;

    /**
     * contains any required attributions.
     *
     * @return string[]
     */
    public function getAttributions() : array
    {
        return $this->attributions;
    }

    /**
     * @param int $maxWidth
     * @param int $maxHeight
     *
     * @return Uri
     */
    public function getUrl(int $maxWidth = null, int $maxHeight = null) : Uri
    {
        if ($maxWidth && $maxHeight) {
            throw new \InvalidArgumentException("You can't specify maxWidth AND maxHeight");
        }

        $queries = [
            'photoreference' => $this->reference,
            'key' => DI::config()->get('googleMaps/apikey'),
        ];

        if ($maxWidth) {
            $queries['maxwidth'] = (string) $maxWidth;
        }

        if ($maxHeight) {
            $queries['maxheight'] = (string) $maxHeight;
        }

        $uri = new Uri('https://maps.googleapis.com/maps/api/place/photo');
        $uri->addQueries($queries);

        return $uri;
    }
}
