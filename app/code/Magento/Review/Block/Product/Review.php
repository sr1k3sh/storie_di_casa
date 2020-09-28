<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Review\Block\Product;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;

/**
 * Product Review Tab
 *
 * @api
 * @author     Magento Core Team <core@magentocommerce.com>
 * @since 100.0.2
 */
class Review extends Template implements IdentityInterface
{

        /**
     * Review model
     *
     * @var \Magento\Review\Model\Review
     */
    protected $_objectReview;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Review resource model
     *
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $_reviewsColFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Review\Model\Review $reviewFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_reviewsColFactory = $collectionFactory;
        $this->_objectReview = $reviewFactory;
        parent::__construct($context, $data);

        $this->setTabTitle();
    }

    /**
     * Get current product id
     *
     * @return null|int
     */
    public function getProductId()
    {
        $product = $this->_coreRegistry->registry('product');
        return $product ? $product->getId() : null;
    }

    /**
     * Get URL for ajax call
     *
     * @return string
     */
    public function getProductReviewUrl()
    {
        return $this->getUrl(
            'review/product/listAjax',
            [
                '_secure' => $this->getRequest()->isSecure(),
                'id' => $this->getProductId(),
            ]
        );
    }

    /**
     * Set tab title
     *
     * @return void
     */
    public function setTabTitle()
    {
        $title = $this->getCollectionSize()
            ? __('Reviews %1', '<span class="counter">' . $this->getCollectionSize() . '</span>')
            : __('Reviews');
        $this->setTitle($title);
    }

    /**
     * Get size of reviews collection
     *
     * @return int
     */
    public function getCollectionSize()
    {
        $collection = $this->_reviewsColFactory->create()->addStoreFilter(
            $this->_storeManager->getStore()->getId()
        )->addStatusFilter(
            \Magento\Review\Model\Review::STATUS_APPROVED
        )->addEntityFilter(
            'product',
            $this->getProductId()
        );

        return $collection->getSize();
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\Magento\Review\Model\Review::CACHE_TAG];
    }

    public function getAllStar($pid)
    {
        $review=$this->_objectReview->getCollection()
                ->addFieldToFilter('main_table.status_id', 1)
                ->addEntityFilter('product', $pid)          //$pid = > your current product ID
                ->addStoreFilter($this->_storeManager->getStore()->getId())
                ->addFieldToSelect('review_id');

        $review->getSelect()->columns('detail.detail_id')->joinInner(
            ['vote' => $review->getTable('rating_option_vote')], 'main_table.review_id = vote.review_id', array('review_value' => 'vote.value')
        );

        $review->getSelect()->order('review_value DESC');
        $review->getSelect()->columns('count(vote.vote_id) as total_vote')->group('review_value');
        for ($i = 5; $i >= 1; $i--) {
            $arrRatings[$i]['value'] = 0;
        }

        foreach ($review as $_result) {
            $arrRatings[$_result['review_value']]['value'] = $_result['total_vote'];
        }
        return $arrRatings;
    }

    public function getTotalRating()
    {
        $reviewCount = $this->getProductId()->getRatingSummary()->getReviewsCount();
        return $reviewCount;
    }
}
