<?php
/**
 * SEOmatic plugin for Craft CMS 3
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2022 nystudio107
 */

namespace nystudio107\seomatic\models\jsonld;

/**
 * schema.org version: v14.0-release
 * Trait for SportsEvent.
 *
 * @author    nystudio107
 * @package   Seomatic
 * @see       https://schema.org/SportsEvent
 */

trait SportsEventTrait
{
    
    /**
     * The home team in a sports event.
     *
     * @var Person|SportsTeam
     */
    public $homeTeam;

    /**
     * The away team in a sports event.
     *
     * @var SportsTeam|Person
     */
    public $awayTeam;

    /**
     * A competitor in a sports event.
     *
     * @var Person|SportsTeam
     */
    public $competitor;

    /**
     * A type of sport (e.g. Baseball).
     *
     * @var string|Text|URL
     */
    public $sport;

}
