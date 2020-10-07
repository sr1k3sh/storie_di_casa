<?php
/**
 * Magetop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the magetop.com license that is
 * available through the world-wide-web at this URL:
 * https://www.magetop.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magetop
 * @package     Magetop_AjaxCartPro
 * @copyright   Copyright (c) Magetop (https://www.magetop.com/)
 * @license     https://www.magetop.com/LICENSE.txt
 */
 
namespace Magetop\AjaxCartPro\Block\Product;
class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
		$html = '<input type="hidden" class="mt-qs-button add_options quickcart_id'.$product->getId().'" value=" '.$product->getId().' " data-url="ajaxcartpro/index/view/id/'.$product->getId().'"/>';
        $renderer = $this->getDetailsRenderer($product->getTypeId());
        if ($renderer) {
            $renderer->setProduct($product);
            return $html.$renderer->toHtml();
        }
        return $html;
    }
}