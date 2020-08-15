<?php
/**
 * Bss Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   Bss
 * @package    Bss_ProductsWidgetSlider
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Bss Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */

namespace Bss\ProductsWidgetSlider\Block;

use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class GetData extends ProductsList
{
    const DEFAULT_WEBSITE = 0;
    const DEFAULT_SHOW_PRICE = false;
    const DEFAULT_SHOW_CART = false;
    const DEFAULT_SHOW_WISH_LIST = false;
    const DEFAULT_SHOW_COMPARE = false;
    const DEFAULT_SHOW_OUT_OF_STOCK = false;
    const DEFAULT_COLLECTION_SORT_BY = 'name';
    const DEFAULT_COLLECTION_ORDER = 'ASC';
    const DEFAULT_SHOW_AS_SLIDER = false;
    const DEFAULT_PRODUCTS_PER_SLIDE = 5;
    const DEFAULT_SHOW_NAV_BAR = true;
    const DEFAULT_SHOW_PREV_NEXT = true;
    const DEFAULT_AUTO_EVERY = 0;

    /**
     * @var bssHelper|\Bss\ProductsWidgetSlider\Helper\Data
     */
    protected $bssHelper;

    /**
     * @var \Magento\Catalog\Block\Product\ListProduct
     */
    protected $listProduct;

    /**
     * @var \Bss\ProductsWidgetSlider\Model\ResourceModel\GetStockStatus
     */
    protected $getStockStatus;

    /**
     * @var \Magento\Catalog\Helper\Output
     */
    protected $Output;

    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $postHelper;

    /**
     * @var \Magento\Wishlist\Helper\Data
     */
    protected $wishListHelper;

    /**
     * @var \Magento\Catalog\Helper\Product\Compare
     */
    protected $compareHelper;

    /**
     * @var PriceCurrency
     */
    private $priceCurrency;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrencyInterface;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * GetData constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder
     * @param \Magento\CatalogWidget\Model\Rule $rule
     * @param \Magento\Catalog\Block\Product\ListProduct $listProduct
     * @param \Magento\Widget\Helper\Conditions $conditionsHelper
     * @param \Bss\ProductsWidgetSlider\Model\ResourceModel\GetStockStatus $bssGetStockStatus
     * @param \Bss\ProductsWidgetSlider\Helper\Data $bssHelper
     * @param \Magento\Catalog\Helper\Output $Output
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param PriceCurrencyInterface $priceCurrencyInterface
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder,
        \Magento\CatalogWidget\Model\Rule $rule,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Magento\Widget\Helper\Conditions $conditionsHelper,
        \Bss\ProductsWidgetSlider\Model\ResourceModel\GetStockStatus $bssGetStockStatus,
        \Bss\ProductsWidgetSlider\Helper\Data $bssHelper,
        \Magento\Catalog\Helper\Output $Output,
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        priceCurrencyInterface $priceCurrencyInterface,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $conditionsHelper,
            $data
        );
        $this->listProduct = $listProduct;
        $this->getStockStatus = $bssGetStockStatus;
        $this->bssHelper = $bssHelper;
        $this->Output = $Output;
        $this->postHelper = $postHelper;
        $this->productMetadata = $productMetadata;
        $this->wishListHelper = $context->getWishlistHelper();
        $this->compareHelper = $context->getCompareProduct();
        $this->priceCurrencyInterface = $priceCurrencyInterface;
    }

    /**
     * Get post parameters
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getAddToCartPostParamsAjax($product)
    {
        return $this->listProduct->getAddToCartPostParams($product);
    }

    /**
     * @return mixed
     */
    public function getEnableConfig()
    {
        return $this->bssHelper->getEnable();
    }

    /**
     * @param $product
     * @param $attributeHtml
     * @param $attributeName
     * @return string
     */
    public function productAttribute($product, $attributeHtml, $attributeName)
    {
        return $this->Output->productAttribute($product, $attributeHtml, $attributeName);
    }

    /**
     * @param $url
     * @param array $data
     * @return string
     */
    public function getPostData($url, array $data = [])
    {
        return $this->postHelper->getPostData($url, $data);
    }

    /**
     * @return bool
     */
    public function isAllow()
    {
        return $this->wishListHelper->isAllow();
    }

    public function getPostDataParams($product)
    {
        return $this->compareHelper->getPostDataParams($product);
    }

    /**
     * @return $this
     */
    public function setCache()
    {
        return $this->setData('cache_lifetime', '0');
    }

    /**
     * @return string
     */
    public function genKey()
    {
        $key = uniqid();
        return $key;
    }

    /**
     * Get Widget Name
     *
     * @return string
     */
    public function getWidgetName()
    {
        if (!$this->hasData('title')) {
            $this->setData('title');
        }
        return $this->getData('title');
    }

    /**
     * Return website id
     *
     * @return int
     */
    public function getWebsiteID()
    {
        if (!$this->hasData('websiteID')) {
            $this->setData('websiteID', self::DEFAULT_WEBSITE);
        }
        return $this->getData('websiteID');
    }

    /**
     * Get From Date Value
     *
     * @return string
     */
    public function getFromDate()
    {
        if (!$this->hasData('from_date')) {
            $this->setData('from_date');
        }
        return $this->getData('from_date');
    }

    /**
     * Get From To Value
     *
     * @return string
     */
    public function getToDate()
    {
        if (!$this->hasData('to_date')) {
            $this->setData('to_date');
        }
        return $this->getData('to_date');
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        if (!$this->hasData('collection_sort_by')) {
            $this->setData('collection_sort_by', self::DEFAULT_COLLECTION_SORT_BY);
        }
        return $this->getData('collection_sort_by');
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        if (!$this->hasData('collection_sort_order')) {
            $this->setData('collection_sort_order', self::DEFAULT_COLLECTION_ORDER);
        }
        return $this->getData('collection_sort_order');
    }

    /**
     * Get Show Product Price
     *
     * @return bool
     */
    public function getShowPrice()
    {
        if (!$this->hasData('show_price')) {
            $this->setData('show_price', self::DEFAULT_SHOW_PRICE);
        }
        return $this->getData('show_price');
    }

    /**
     * Get Show Add to Cart Button
     *
     * @return bool
     */
    public function getShowCart()
    {
        if (!$this->hasData('show_add_to_cart')) {
            $this->setData('show_add_to_cart', self::DEFAULT_SHOW_CART);
        }
        return $this->getData('show_add_to_cart');
    }

    /**
     * Get Show Add to WishList Button
     *
     * @return bool
     */
    public function getShowWishList()
    {
        if (!$this->hasData('show_add_to_wishlist')) {
            $this->setData('show_add_to_wishlist', self::DEFAULT_SHOW_WISH_LIST);
        }
        return $this->getData('show_add_to_wishlist');
    }

    /**
     * Get Show Add to Compare Button
     *
     * @return bool
     */
    public function getShowCompare()
    {
        if (!$this->hasData('show_add_to_compare')) {
            $this->setData('show_add_to_compare', self::DEFAULT_SHOW_COMPARE);
        }
        return $this->getData('show_add_to_compare');
    }

    /**
     * Get Show out of Stock Product
     *
     * @return bool
     */
    public function getShowOutOfStock()
    {
        if (!$this->hasData('show_out_of_stock')) {
            $this->setData('show_out_of_stock', self::DEFAULT_SHOW_OUT_OF_STOCK);
        }
        return $this->getData('show_out_of_stock');
    }

    /**
     * Get Show Product List as Slider
     *
     * @return bool
     */
    public function getShowSlider()
    {
        if (!$this->hasData('show_as_slider')) {
            $this->setData('show_as_slider', self::DEFAULT_SHOW_AS_SLIDER);
        }
        return $this->getData('show_as_slider');
    }

    /**
     * Get Number of Products per Slide
     *
     * @return int
     */
    public function getProductsPerSlide()
    {
        if (!$this->hasData('products_per_slide')) {
            $this->setData('products_per_slide', self::DEFAULT_PRODUCTS_PER_SLIDE);
        }
        return $this->getData('products_per_slide');
    }

    /**
     * Get Show the Navigation Dots
     *
     * @return bool
     */
    public function getShowSlideNavigation()
    {
        if (!$this->hasData('show_slider_navigation')) {
            $this->setData('show_slider_navigation', self::DEFAULT_SHOW_NAV_BAR);
        }
        if ($this->getData('show_slider_navigation') == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get Show the Prev/Next Button
     *
     * @return bool
     */
    public function getShowArrows()
    {
        if (!$this->hasData('show_arrows')) {
            $this->setData('show_arrows', self::DEFAULT_SHOW_PREV_NEXT);
        }
        if ($this->getData('show_arrows') == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get Auto Timer
     *
     * @return int
     */
    public function getAutoPlaySlideEvery()
    {
        if (!$this->hasData('auto_every')) {
            $this->setData('auto_every', self::DEFAULT_AUTO_EVERY);
        }
        return $this->getData('auto_every');
    }

    /**
     * @return string
     */
    public function dateRange()
    {
        $fromDate = $this->getFromDate();
        $toDate = $this->getToDate();
        $sqlQuery='';
        if ($fromDate !='' && $toDate !='') {
            if (strtotime($toDate) < strtotime($fromDate)) {
                $sqlQuery .=" AND aggregation.period BETWEEN '{$toDate}' AND '{$fromDate}'";
            } else {
                $sqlQuery .=" AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'";
            }
        }
        if ($fromDate !='' && $toDate =='') {
            $sqlQuery .=" AND aggregation.period >= '{$fromDate}'";
        }
        if ($fromDate =='' && $toDate !='') {
            $sqlQuery .=" AND aggregation.period <= '{$toDate}'";
        }
        return $sqlQuery;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPagerHtmlBss()
    {
        if ($this->showPager() && $this->getProductCollection()->getSize() > $this->getProductsPerPage()) {
            if (!$this->pager) {
                $this->pager = $this->getLayout()->createBlock(
                    \Magento\Catalog\Block\Product\Widget\Html\Pager::class,
                    'widget.products.list.pager.mostview'
                );

                $this->pager->setUseContainer(true)
                    ->setShowAmounts(true)
                    ->setShowPerPage(false)
                    ->setPageVarName($this->getData('page_var_name'))
                    ->setLimit($this->getProductsPerPage())
                    ->setTotalLimit($this->getProductsCount())
                    ->setCollection($this->getProductCollection());
            }
            if ($this->pager instanceof \Magento\Framework\View\Element\AbstractBlock) {
                return $this->pager->toHtml();
            }
        }
        return '';
    }

    /**
     * @param $collection
     * @param $showOutOfStock
     * @return mixed
     */
    public function getStockStatus($collection, $showOutOfStock)
    {
        return $this->getStockStatus->getStockStatus($collection, $showOutOfStock);
    }

    /**
     * Compare Version
     * @param $version
     * @return bool
     */
    protected function compareVersion($version)
    {
        $versionCurrent =  $this->productMetadata->getVersion();
        if (version_compare($versionCurrent, $version) === 1 || version_compare($versionCurrent, $version) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCacheKeyInfo()
    {
        $conditions = $this->getData('conditions')
            ? $this->getData('conditions')
            : $this->getData('conditions_encoded');
        if ($this->compareVersion("2.1.0") === true) {
            return [
                'CATALOG_PRODUCTS_LIST_WIDGET',
                $this->getPriceCurrency()->getCurrency()->getCode(),
                $this->_storeManager->getStore()->getId(),
                $this->_design->getDesignTheme()->getId(),
                $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP),
                intval($this->getRequest()->getParam($this->getData('page_var_name'), 1)),
                $this->getProductsPerPage(),
                $conditions,
                \Magento\Framework\App\ObjectManager::getInstance()
                    ->get(\Magento\Framework\Serialize\Serializer\Json::class)
                    ->serialize($this->getRequest()->getParams())
            ];
        } else {
            return [
                'CATALOG_PRODUCTS_LIST_WIDGET',
                $this->priceCurrencyInterface->getCurrencySymbol(),
                $this->_storeManager->getStore()->getId(),
                $this->_design->getDesignTheme()->getId(),
                $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP),
                intval($this->getRequest()->getParam($this->getData('page_var_name'), 1)),
                $this->getProductsPerPage(),
                $conditions,
                serialize($this->getRequest()->getParams())
            ];
        }
    }

    /**
     * @return PriceCurrencyInterface
     */
    private function getPriceCurrency()
    {
        if ($this->priceCurrency === null) {
            $this->priceCurrency = $this->priceCurrencyInterface;
        }
        return $this->priceCurrency;
    }
}
