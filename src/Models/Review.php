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

class Review
{
    /**
     * @param string $authorName
     * @param string $authorUrl
     * @param string $language
     * @param int $rating
     * @param string $text
     * @param int $date
     */
    public function __construct(
        string $authorName,
        string $authorUrl = null,
        string $language,
        int $rating,
        string $text,
        int $date
    )
    {
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->language = $language;
        $this->rating = $rating;
        $this->text = $text;
        $this->date = DateTime::createFromTimestamp($date);
    }

    /**
     * @var string
     */
    private $authorName;

    /**
     * @return string
     */
    public function getAuthorName() : string
    {
        return $this->authorName;
    }

    /**
     * @var string
     */
    private $authorUrl;

    /**
     * @return string
     */
    public function getAuthorUrl() : string
    {
        return $this->authorUrl;
    }

    /**
     * @var string
     */
    private $language;

    /**
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @var int
     */
    private $rating;

    /**
     * @return int
     */
    public function getRating() : int
    {
        return $this->rating;
    }

    /**
     * @var string
     */
    private $text;

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @return DateTime
     */
    public function getDate() : DateTime
    {
        return $this->date;
    }
}
