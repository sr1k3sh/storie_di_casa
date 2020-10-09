<?php
/**
 * @copyright Copyright (c) 2017 www.tigren.com
 */

namespace Tigren\Ajaxcart\Block\Product;

/**
 * Class ConfigurableOption
 * @package Tigren\Ajaxcart\Block\Product
 */
class ConfigurableOption extends \Magento\Framework\View\Element\Template
{

    /**
     * @return mixed
     */
    public function getColorLabel()
    {
        return $this->_request->getParam('colorLabel');
    }

    /**
     * @return mixed
     */
    public function getSizeLabel()
    {
        return $this->_request->getParam('sizeLabel');
    }

        /**
     * @return mixed
     */
    public function getFormatoLabel()
    {
        return $this->_request->getParam('formatoLabel');
    }

            /**
     * @return mixed
     */
    public function getFormatoQty()
    {
        return $this->_request->getParam('formatoQty');
    }

    
        /**
     * @return mixed
     */
    public function getFormatoId()
    {
        return $this->_request->getParam('formato');
    }
}
