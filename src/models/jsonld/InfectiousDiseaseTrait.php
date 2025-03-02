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
 * Trait for InfectiousDisease.
 *
 * @author    nystudio107
 * @package   Seomatic
 * @see       https://schema.org/InfectiousDisease
 */

trait InfectiousDiseaseTrait
{
    
    /**
     * The class of infectious agent (bacteria, prion, etc.) that causes the
     * disease.
     *
     * @var InfectiousAgentClass
     */
    public $infectiousAgentClass;

    /**
     * The actual infectious agent, such as a specific bacterium.
     *
     * @var string|Text
     */
    public $infectiousAgent;

    /**
     * How the disease spreads, either as a route or vector, for example 'direct
     * contact', 'Aedes aegypti', etc.
     *
     * @var string|Text
     */
    public $transmissionMethod;

}
