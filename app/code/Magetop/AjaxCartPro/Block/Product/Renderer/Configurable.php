<?php
namespace Magetop\AjaxCartPro\Block\Product\Renderer;
class Configurable extends \Magento\Swatches\Block\Product\Renderer\Configurable
{
	const SWATCH_RENDERER_TEMPLATE = 'Magetop_AjaxCartPro::product/view/renderer.phtml';
	const CONFIGURABLE_RENDERER_TEMPLATE = 'Magetop_AjaxCartPro::product/view/type/options/configurable.phtml';
	protected function getRendererTemplate()
    {
        return $this->isProductHasSwatchAttribute() ?
            self::SWATCH_RENDERER_TEMPLATE : self::CONFIGURABLE_RENDERER_TEMPLATE;
    }
    protected function isProductHasSwatchAttribute()
    {
        if (isset($this->isProductHasSwatchAttribute)){
            return $this->isProductHasSwatchAttribute;
        }else{
            return parent::isProductHasSwatchAttribute();
        }
    }
}