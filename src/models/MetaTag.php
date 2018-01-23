<?php
/**
 * SEOmatic plugin for Craft CMS 3.x
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\seomatic\models;

use nystudio107\seomatic\Seomatic;
use nystudio107\seomatic\base\MetaItem;
use nystudio107\seomatic\helpers\ArrayHelper;
use nystudio107\seomatic\helpers\MetaValue as MetaValueHelper;

use Craft;

use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */
class MetaTag extends MetaItem
{
    // Constants
    // =========================================================================

    const ITEM_TYPE = 'MetaTag';

    const UNIQUEKEYS_TAGS = [
        'og:see_also',
        'og:image',
        'og:image:type',
        'og:image:height',
        'og:image:width',
    ];

    // Static Methods
    // =========================================================================

    /**
     * @param string $tagType
     * @param array $config
     *
     * @return null|MetaTag
     */
    public static function create($tagType = null, array $config = [])
    {
        $model = null;
        // Variablize the keys so that they coincide with our property names
        foreach ($config as $key => $value) {
            ArrayHelper::rename($config, $key, Inflector::variablize($key));
        }
        $className = MetaTag::class;
        if ($tagType) {
            // Potentially load a sub-type of MetaTag
            $tagClassName = 'nystudio107\\seomatic\\models\\metatag\\' . ucfirst($tagType) . 'Tag';
            /** @var $model MetaTag */
            if (class_exists($tagClassName)) {
                $className = $tagClassName;
            }
        }
        $model = new $className($config);

        return $model;
    }

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $charset;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $httpEquiv;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $property;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->key)) {
            $this->key = $this->name ?? $this->property ?? $this->httpEquiv;
            // $this keys for specific tags
            if (in_array($this->name, self::UNIQUEKEYS_TAGS)) {
                $this->uniqueKeys = true;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            [['charset', 'content', 'httpEquiv', 'name', 'property'], 'string'],
            [['name'], 'required', 'on' => ['warning']]
        ]);

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        if ($this->scenario === 'default') {
        }

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function prepForRender(&$data): bool
    {
        $shouldRender = parent::prepForRender($data);
        if ($shouldRender) {
            $scenario = $this->scenario;
            $this->setScenario('render');
            $data = $this->tagAttributes();
            $this->setScenario($scenario);
            MetaValueHelper::parseArray($data);
            // Only render if there's more than one attribute
            if (count($data) > 1) {
                // devMode
                if (Seomatic::$devMode) {
                }
            } else {
                $error = Craft::t(
                    'seomatic',
                    '{tagtype} tag `{key}` did not render because it is missing attributes.',
                    ['tagtype' => 'Meta', 'key' => $this->key]
                );
                Craft::error($error, __METHOD__);
                $shouldRender = false;
            }
        }

        return $shouldRender;
    }

    /**
     * @inheritdoc
     */
    public function render($params = []): string
    {
        $html = '';
        $options = $this->tagAttributes();
        ksort($options);
        if ($this->prepForRender($options)) {
            $html = Html::tag('meta', '', $options);
        }

        return $html;
    }
}
