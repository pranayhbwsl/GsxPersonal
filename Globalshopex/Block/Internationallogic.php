<?php

namespace Gsx\Globalshopex\Block;

use Magento\Catalog\Helper\Image as ImageHelper;

class Internationallogic extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Gsx\Globalshopex\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Price helper data
     *
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $_priceHelper;

    /**
     * Gsx shopping cart url
     *
     * @var string
     */
    public $GSX_URL = "https://globalshopex.com/shoppingcart.asp";

    /**
     * Magento Cart model object
     *
     * @var Magento\Checkout\Model\Cart
     */
    public $cart;

    /**
     * Helper Image
     *
     * @var ImageHelper
     */
    protected $_imageHelper;

    /**
     * Construct function for international logic
     *
     * @param Magento\Framework\View\Element\Template\Context $context
     * @param Gsx\Globalshopex\Helper\Data $helper
     * @param Magento\Framework\ObjectManagerInterface $objectManager
     * @param Magento\Checkout\Model\Cart $cart
     * @param ImageHelper $imageHelper
     * @param Magento\Framework\Pricing\Helper\Data $priceHelper
     * @param Array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Gsx\Globalshopex\Helper\Data $helper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Checkout\Model\Cart $cart,
        ImageHelper $imageHelper,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->_helper = $helper;
        $this->_objectManager = $objectManager;
        $this->cart = $cart;
        $this->_imageHelper = $imageHelper;
        $this->_priceHelper = $priceHelper;
    }

    /**
     * Provide Merchant Id
     */
    public function getMerchantID()
    {
        return $this->_helper->getMerchantID();
    }

    /**
     * Name of field for restricted items
     */
    public function getNameRestrictedItem()
    {
        return $this->_helper->getNameRestrictedItem();
    }

    /**
     * Global Shopex integration type
     */
    public function getTypeIntegration()
    {
        //return 1 Iframe Integration
        //return  0 Cart To Cart

        //$typeintegration = Mage::getStoreConfig("checkout/globalshopex/typeintegration");
        $typeintegration = "1";
        return $typeintegration;
    }

    /**
     * Local shipping exp form field
     */
    public function getLocalshippingEXP()
    {
        $GSX_Localshipping_EXP = $this->_helper->getLocalshippingEXP();
        if ($GSX_Localshipping_EXP == "") {
            $GSX_Localshipping_EXP = "0";
        }
        // $GSX_Localshipping_EXP = '<input type="hidden"
        // name="LocalShippingEXP" value="' . $GSX_Localshipping_EXP . '" />';
        return $GSX_Localshipping_EXP;
    }

    /**
     * Local shipping form field
     */
    public function getLocalshipping()
    {
        $GSX_Localshipping = $this->_helper->getLocalshipping();
        if ($GSX_Localshipping == "") {
            $GSX_Localshipping = "0";
        }
        // $GSX_Localshipping = '<input type="hidden" name="LocalShipping" value="' . $GSX_Localshipping . '" />';
        return $GSX_Localshipping;
    }

    /**
     * Clear customer cart after the checkout in Globalshopex
     */
    public function isClearCartEnable()
    {
        return $this->_helper->isClearCartEnable();
    }

    /**
     * Check if iframe is active
     */
    public function isiframeActive()
    {
        $active = 1; //Mage::getStoreConfig("checkout/globalshopex/gsx_iframeactive");
        return $active;
    }

    /**
     * Check if component is enabled.
     */
    public function isEnabledComponent()
    {
        $active = $this->_helper->isEnabledComponent();
        return $active;
    }

    /**
     * Check if tracking is enabled.
     */
    public function isTrackingEnable()
    {
        $trackingEnable = $this->_helper->isTrackingEnable();
        return $trackingEnable;
    }

    /**
     * Check if International shipping is live.
     */
    public function isLiveComponent()
    {
        $live = false;
        $is_live = $this->_helper->isLiveComponent();
        if ($is_live == "0") {
            $live = true;
        }

        return $live;
    }

    /**
     * Get css classname for name button.
     */
    public function getNamebuttonCssClassName()
    {
        $cssClassNameDefault = "";
        $gsx_image = trim($this->_helper->getPathImage());
        $cssclassbutton = $this->_helper->getNamebuttonCssClassName();
        if ($gsx_image == "") {
            $version = '2.0';//Mage::getVersion();
            if ($cssclassbutton != "") {
                $cssClassNameDefault = $cssclassbutton;
            } elseif ($version >= "1.4") {
                $cssClassNameDefault = "button btn-checkout";
            } else {
                $cssClassNameDefault = "form-button-alt";
            }
        }
        return $cssClassNameDefault;
    }

    /**
     * Get content for style.
     */
    public function getStyleExtend()
    {

        $gsx_style = "";
        $gsx_style = trim($this->_helper->getStyleExtend());
        return $gsx_style;
    }

    /**
     * Get image button path.
     */
    public function getPathToImageButton()
    {

        $gsx_image = "";
        $gsx_image = trim($this->_helper->getPathImage());
        return $gsx_image;
    }

    /**
     * Get Css for image of button.
     */
    public function getCssForButtonImage()
    {

        $style = "";
        $gsx_image = trim($this->_helper->getPathImage());

        if ($gsx_image != "") {

            $style = "style=\"background-repeat:no-repeat;";
            $style = $style . "px; outline:none; border:none; cursor:pointer;\"";
        }

        return $style;
    }

    /**
     * Get url to iframe page.
     */
    public function urlToIframePage()
    {
        $gsx_enablehttps = trim($this->_helper->isEnableHttps());
        $urlIFrame = $this->getBaseUrl();
        if ($gsx_enablehttps) {
            $urlIFrame = str_replace('http:', 'https:', $this->_storeManager->getStore()->getBaseUrl());
        }
        $urlIFrame = $urlIFrame . "globalshopex/gsx/index";
        return $urlIFrame;
    }

    /*public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }*/

    /**
     * Button text for international customer.
     */
    public function buttonTextInternationalCustomer()
    {

        if (trim($this->_helper->getPathImage()) != "") {
            return "";
        } else {

            return __('International Checkout');
        }
    }

    /*
     * getBundleOptions - Mage_Bundle_Block_Checkout_Cart_Item_Renderer
     *
     */

    /**
     * Get bundle options for glbal shopex.
     *
     * @param Object $item
     * @param Boolean $useCache
     */
    protected function _getBundleOptions($item, $useCache = true)
    {
        $options = [];

        /**
         * @var Mage_Bundle_Model_Product_Type
         */
        $typeInstance = $item->getProduct()->getTypeInstance(true);

        // get bundle options
        $optionsQuoteItemOption = $item->getOptionByCode('bundle_option_ids');
        $bundleOptionsIds = json_decode($optionsQuoteItemOption->getValue());
        if ($bundleOptionsIds) {
            /**
             * Bundle Options
             *
             * @var Mage_Bundle_Model_Mysql4_Option_Collection
             */
            $optionsCollection = $typeInstance->getOptionsByIds($bundleOptionsIds, $item->getProduct());

            // get and add bundle selections collection
            $selectionsQuoteItemOption = $item->getOptionByCode('bundle_selection_ids');

            $selectionsCollection = $typeInstance->getSelectionsByIds(
                json_decode($selectionsQuoteItemOption->getValue()),
                $item->getProduct()
            );

            $bundleOptions = $optionsCollection->appendSelections($selectionsCollection, true);
            foreach ($bundleOptions as $bundleOption) {
                if ($bundleOption->getSelections()) {
                    $option = ['label' => $bundleOption->getTitle(), "value" => []];
                    $bundleSelections = $bundleOption->getSelections();

                    foreach ($bundleSelections as $bundleSelection) {
                        $option['value'][] = $this->_getSelectionQty(
                            $item,
                            $bundleSelection->getSelectionId()
                        ) . ' x ' .
                             $bundleSelection->getName() . ' ' . $this->_priceHelper
                             ->currency($this->_getSelectionFinalPrice($item, $bundleSelection));
                    }

                    $options[] = $option;
                }
            }
        }
        return $options;
    }

    /**
     * Get final price for the selection
     *
     * @param Object $item
     * @param Object $selectionProduct
     */
    public function _getSelectionFinalPrice($item, $selectionProduct)
    {
        $bundleProduct = $item->getProduct();
        return $bundleProduct->getPriceModel()->getSelectionFinalTotalPrice(
            $bundleProduct,
            $selectionProduct,
            $item->getQty(),
            $this->_getSelectionQty($item, $selectionProduct->getSelectionId())
        );
    }

    /**
     * Get selection quantity
     *
     * @param Object $item
     * @param Int $selectionId
     */
    public function _getSelectionQty($item, $selectionId)
    {
        if ($selectionQty = $item->getProduct()->getCustomOption('selection_qty_' . $selectionId)) {
            return $selectionQty->getValue();
        }
        return 0;
    }

    /**
     * Get product attributes
     *
     * @param Object $item
     */
    public function getProductAttributes($item)
    {
        $attributes = $item->getProduct()->getTypeInstance(true)
            ->getSelectedAttributesInfo($item->getProduct());
        return $attributes;
    }

    /**
     * Get links
     *
     * @param Object $item
     */
    public function getLinks($item)
    {
        $itemLinks = [];
        if ($linkIds = $item->getOptionByCode('downloadable_link_ids')) {
            $productLinks = $item->getProduct()->getTypeInstance(true)
                ->getLinks($item->getProduct());
            foreach (explode(',', $linkIds->getValue()) as $linkId) {
                if (isset($productLinks[$linkId])) {
                    $itemLinks[] = $productLinks[$linkId];
                }
            }
        }
        return $itemLinks;
    }

    /**
     * Get link title
     *
     * @param Object $item
     */
    public function getLinksTitle($item)
    {
        if ($item->getProduct()->getLinksTitle()) {
            return $item->getProduct()->getLinksTitle();
        }
    }

    /**
     * Get child product
     *
     * @param Object $item
     */
    public function getChildProduct($item)
    {
        if ($option = $item->getOptionByCode('simple_product')) {
            return $option->getProduct();
        }
        return $item->getProduct();
    }

    /**
     * Get grouped product
     *
     * @param Object $item
     */
    public function getGroupedProduct($item)
    {
        $option = $item->getOptionByCode('product_type');
        if ($option) {
            return $option->getProduct();
        }
        return $item->getProduct();
    }

    /**
     * Get thumbnail for the product
     *
     * @param Object $item
     */
    public function getProductThumbnail($item)
    {

        // begin configurable
        /*if ($item->getProduct()->isConfigurable()) {
            $product = $this->getChildProduct($item);
            if (!$product || !$product->getData('thumbnail') || ($product->getData('thumbnail') == 'no_selection'))
            {//|| (Mage::getStoreConfig(Mage_Checkout_Block_Cart_Item_Renderer_Configurable::CONFIGURABLE_PRODUCT_IMAGE)
                == Mage_Checkout_Block_Cart_Item_Renderer_Configurable::USE_PARENT_IMAGE)) {
                $product = $item->getProduct();
            }
            return Mage::helper('catalog/image')->init($product, 'thumbnail');
        }*/
        // end configurable
        // begin grouped
        /*if ($item->getProduct()->isGrouped()) {
            $product = $item->getProduct();
            if (!$product->getData('thumbnail') || ($product->getData('thumbnail') == 'no_selection'))
            {//|| (Mage::getStoreConfig(Mage_Checkout_Block_Cart_Item_Renderer_Grouped::GROUPED_PRODUCT_IMAGE)
                 == Mage_Checkout_Block_Cart_Item_Renderer_Grouped::USE_PARENT_IMAGE)) {
                $product = $this->getGroupedProduct($item);
            }
            return Mage::helper('catalog/image')->init($product, 'thumbnail');
        }*/
        // end grouped
        $image = 'category_page_grid';

        $productImage = $this->_imageHelper->init($item->getProduct(), $image)->constrainOnly(false)
        ->keepAspectRatio(true)->keepFrame(false)->resize(75)->getUrl();
        return $productImage;
    }

    /**
     * Returns product options and additional attrubutes.
     *
     * @param Object $item
     */
    public function getProductOptions($item)
    {
        $options = [];
        if ($optionIds = $item->getOptionByCode('option_ids')) {
            $options = [];
            foreach (explode(',', $optionIds->getValue()) as $optionId) {
                if ($option = $item->getProduct()->getOptionById($optionId)) {

                    $quoteItemOption = $item->getOptionByCode('option_' . $option->getId());

                    $group = $option->groupFactory($option->getType())
                        ->setOption($option)
                        ->setQuoteItemOption($quoteItemOption);

                    $options[] = [
                        'label' => $option->getTitle(),
                        'value' => $group->getFormattedOptionValue($quoteItemOption->getValue()),
                        'print_value' => $group->getPrintableOptionValue($quoteItemOption->getValue()),
                        'option_id' => $option->getId(),
                        'option_type' => $option->getType(),
                        'custom_view' => $group->isCustomizedView()
                    ];
                }
            }
        }
        if ($addOptions = $item->getOptionByCode('additional_options')) {
            $options = array_merge($options, json_decode($addOptions->getValue()));
        }

        if ($item->getProduct()->getTypeId() ==
         \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            $options = array_merge($this->getProductAttributes($item), $options); // configurable products
        }

        /*
        if ($item->getProduct()->isConfigurable()) {
            $options = array_merge($this->getProductAttributes($item), $options); // configurable products
        }*/

        if ($item->getProduct()->getTypeId() == \Magento\Catalog\Model\Product\Type::TYPE_BUNDLE) {
            $options = array_merge($this->_getBundleOptions($item), $options); // bundle products
        }

        return $options;
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
        $output = "";
        $output .= $item->getName() . $crlf;

        $options = $this->getProductOptions($item);
        if (count($options)) {
            $countOptions = count($options);
            for ($c = 0; $c < $countOptions; $c++) {

                if (is_array($options[$c]["value"])) {
                    $output .= " [ " . $options[$c]["label"] .
                     ": " . strip_tags(implode($valueSeperator, $options[$c]["value"])) . " ] ";
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
            $output .= " ] ";
            $output .= $crlf;
        }
        return $output;
    }

    /**
     * Get product Url.
     *
     * @param Object $item
     */
    public function getProductUrl($item)
    {

        if ($item->getRedirectUrl()) {
            return $item->getRedirectUrl();
        }
        $product = $item->getProduct();
        $option = $item->getOptionByCode('product_type');
        if ($option) {
            $product = $option->getProduct();
        }

        return $product->getUrlModel()->getUrl($product);
    }
}
