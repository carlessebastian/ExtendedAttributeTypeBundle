<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Model;

use Akeneo\Pim\Enrichment\Component\Product\Model\AbstractValue;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;

/**
 * Product value for TextCollection atribute type
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TextCollectionValue extends AbstractValue implements ValueInterface
{
    /** @var string[] */
    protected $data;

    /**
     * @param AttributeInterface $attribute
     * @param string             $channel
     * @param string             $locale
     * @param mixed              $data
     */
    public function __construct(AttributeInterface $attribute, $channel, $locale, $data)
    {
        $this->setAttribute($attribute);
        $this->setScope($channel);
        $this->setLocale($locale);

        if (null === $data) {
            $data = [];
        }

        $this->data = $data;
    }

    /**
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $item
     */
    public function removeItem(string $item)
    {
        $data = array_filter($this->data, function ($value) use ($item) {
            return $value !== $item;
        });
        $this->data = array_values($data);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return implode(', ', $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function isEqual(ValueInterface $value): bool
    {
        if (!$value instanceof TextCollectionValue ||
            $this->getScopeCode() !== $value->getScopeCode() ||
            $this->getLocaleCode() !== $value->getLocaleCode()) {
            return false;
        }

        $comparedCollection = $value->getData();
        $thisCollection = $this->getData();

        return count(array_diff($thisCollection, $comparedCollection)) === 0 &&
            count(array_diff($comparedCollection, $thisCollection)) === 0;
    }
}
