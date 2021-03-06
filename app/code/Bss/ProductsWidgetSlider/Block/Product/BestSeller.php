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

namespace Bss\ProductsWidgetSlider\Block\Product;

use Bss\ProductsWidgetSlider\Model\ResourceModel\BestSellerProduct\GetBestSellerCollection;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class BestSeller extends \Bss\ProductsWidgetSlider\Block\GetData
{
    /**
     * @var GetBestSellerCollection
     */
    protected $getBestSellerCollection;

    /**
     * BestSeller constructor.
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
     * @param GetBestSellerCollection $bssGetBestSellerCollection
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
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        GetBestSellerCollection $bssGetBestSellerCollection,
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
            $listProduct,
            $conditionsHelper,
            $bssGetStockStatus,
            $bssHelper,
            $Output,
            $postHelper,
            $productMetadata,
            $categoryRepository,
            $priceCurrencyInterface,
            $data
        );
        $this->getBestSellerCollection = $bssGetBestSellerCollection;
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createCollection()
    {
        $this->setCache();
        /** @var $collection \Magento\Catalog\Model\ResourceModel\Product\Collection */
        $webSiteId = $this->getWebsiteID();
        $showOutOfStock = $this->getShowOutOfStock();
        $dateRange = $this->dateRange();
        $order = $this->getSortOrder();
        $sortBy = $this->getSortBy();
        $collection = $this->productCollectionFactory->create();
        $bestSellerCollection = $this->productCollectionFactory->create();
        $collection->setFlag('has_stock_status_filter', true);
        $collection = $this->getStockStatus($collection, $showOutOfStock);
        $collection = $this->getBestSellerCollection
            ->getBestSellerCollection($dateRange, $webSiteId, $collection, $bestSellerCollection);
        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());
        $collection->getSelectCountSql($collection, false);
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addAttributeToSelect('*')
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1));
        $conditions = $this->getConditions();
        $conditions->collectValidatedAttributes($collection);
        $this->sqlBuilder->attachConditionToCollection($collection, $conditions);
        if ($sortBy=="name") {
            $collection = $this->_addProductAttributesAndPrices($collection)->addAttributeToSort('name', $order);
        } else {
            $collection->getSelect()->order($sortBy.' '.$order);
        }
        return $collection;
    }
}
