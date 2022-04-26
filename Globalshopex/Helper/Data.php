<?php
namespace Gsx\Globalshopex\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    public const MERCHANT_ID = 'gsx_globalshopex/general/gsxmerchantid';
    public const ENABLE_CLEAR_CART = 'gsx_globalshopex/general/gsx_enableclearcart';
    public const NAME_RESTRICTED_ITEM = 'gsx_globalshopex/general/gsx_name_field_restricted';
    public const LOCAL_SHIPPING_EXP = 'gsx_globalshopex/general/gsx_local_shippingexp';
    public const LOCAL_SHIPPING = 'gsx_globalshopex/general/gsx_local_shipping';
    public const IFRAME_ACTIVE = 'gsx_globalshopex/general/gsx_iframeactive';
    public const ENABLE_COMPONENT = 'gsx_globalshopex/general/gsx_active';
    public const LIVE_COMPONENT = 'gsx_globalshopex/general/gsx_is_live';
    public const CSS_CLASS_BUTTON = 'gsx_globalshopex/general/gsx_cssclassbutton';
    public const PATH_IMAGE = 'gsx_globalshopex/general/gsx_pathimage';
    public const STYLE_TAG = 'gsx_globalshopex/general/gsx_styletag';
    public const ENABLE_HTTPS = 'gsx_globalshopex/general/gsx_enablehttps';
    public const ENABLE_TRACKING = 'gsx_globalshopex/general/gsx_tracking_enable';

    /**
     * Check if clear cart option is enabled.
     */
    public function isClearCartEnable()
    {
        return $this->scopeConfig->getValue(self::ENABLE_CLEAR_CART, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the merchant ID.
     */
    public function getMerchantID()
    {
        return $this->scopeConfig->getValue(self::MERCHANT_ID, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the names of restricted items.
     */
    public function getNameRestrictedItem()
    {
        return $this->scopeConfig
        ->getValue(self::NAME_RESTRICTED_ITEM, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the local shipping exp value.
     */
    public function getLocalshippingEXP()
    {
        return $this->scopeConfig->getValue(self::LOCAL_SHIPPING_EXP, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the local shipping value.
     */
    public function getLocalshipping()
    {
        return $this->scopeConfig->getValue(self::LOCAL_SHIPPING, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the global shopex component is enabled.
     */
    public function isEnabledComponent()
    {
        return $this->scopeConfig->getValue(self::ENABLE_COMPONENT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the international component is live.
     */
    public function isLiveComponent()
    {
        return $this->scopeConfig->getValue(self::LIVE_COMPONENT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the name button css classnames.
     */
    public function getNamebuttonCssClassName()
    {
        return $this->scopeConfig->getValue(self::CSS_CLASS_BUTTON, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the path to image.
     */
    public function getPathImage()
    {
        return $this->scopeConfig->getValue(self::PATH_IMAGE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get extended styles.
     */
    public function getStyleExtend()
    {
        return $this->scopeConfig->getValue(self::STYLE_TAG, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the https is enabled on the website.
     */
    public function isEnableHttps()
    {
        return $this->scopeConfig->getValue(self::ENABLE_HTTPS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the tracking page is enabled.
     */
    public function isTrackingEnable()
    {
        return $this->scopeConfig->getValue(self::ENABLE_TRACKING, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Returns formatted string of item description and attributes.
     *
     * @param Object $item
     */
    public function buildItemDescription($item)
    {

        $crlf = "\n";
        $valueSeperator = " - ";
        $output = $this->htmlEscape($item->getName()) . $crlf;

        $options = $this->getProductOptions($item);
        if (count($options)) {
            $countOptions = count($options);
            for ($c = 0; $c < $countOptions; $c++) {

                if (is_array($options[$c]["value"])) {
                    $output .= " [ " . $options[$c]["label"] . ": " . strip_tags(
                        implode($valueSeperator, $options[$c]["value"])
                    ) . " ] ";
                } else {
                    $output .= " [ " . $options[$c]["label"] . ": " . strip_tags($options[$c]["value"]) . " ] ";
                }

                $output .= $crlf;
            }
        }

        // addition of links for downloadable products
        //
        if ($this->getLinks($item)) {
            $output .= " [ " . strip_tags($this->getLinksTitle($item));
            foreach ($this->getLinks($item) as $link) {
                $output .= " ( " . strip_tags($link->getTitle()) . " ) ";
            }
            $output .= " ] " . $crlf;
        }
        return $output;
    }

    /**
     * Validate if the product is valid using name.
     *
     * @param String $productName
     */
    public function validateProductByName($productName)
    {
 //skincarebyalana
        $restrictedCategories = ["Essie", "OPI", "Young Nails", "CND", "Deborah Lippmann", "Nailuv"];
        foreach ($restrictedCategories as $value) {
            $length = strlen($value);
            $name = substr($productName, 0, $length);
            if (strcasecmp($name, $value) === 0) {
                return false;
            }
        }
        return true;
    }
}
