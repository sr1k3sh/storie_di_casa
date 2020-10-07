<?php
namespace StorieCasa\SubCategoryWidget\Block\Widget;

class SubCategoryWidget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'widget/subcategorywidget.phtml';

     /**
    * \Magento\Catalog\Model\CategoryFactory $categoryFactory
    */
    protected $_categoryFactory;

    protected $_categoryRepository;

    /**
 * @param \Magento\Framework\Registry $registry
 */

    protected $_registry;

    /**
    * @param \Magento\Framework\View\Element\Template\Context $context
    * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
    * @param array $data
    */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
        ) {
            $this->_categoryFactory = $categoryFactory;
            $this->_categoryRepository = $categoryRepository;
            $this->_registry = $registry;
            parent::__construct($context);
        }

    /**
    * Retrieve current store categories
    *
    * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
    */
    public function getCategoryCollection()
    {
        $category = $this->_categoryFactory->create();
        
        $rootCatID = NULL;
        if($this->getData('parentcat') > 0)
            $rootCatID = $this->getData('parentcat'); 
        else
            $rootCatID = $this->_storeManager->getStore()->getRootCategoryId();

        $category->load($rootCatID);
        $childCategories = $category->getChildrenCategories()->addAttributeToSelect('image');
        return $childCategories;
    }

    public function getSubCategory(){
        $category = $this->_registry->registry('current_category');
        $a=$category->getId();
        $categoryObj = $this->_categoryRepository->get($a);
        $subcategories = $categoryObj->getChildrenCategories();
        return $subcategories;

    }

}