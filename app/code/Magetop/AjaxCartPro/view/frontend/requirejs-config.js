var config = {
    map: {
        '*': {
			'magetopSidebar': 'Magetop_AjaxCartPro/js/sidebar',
            'catalogAddToCart': 'Magetop_AjaxCartPro/js/catalog-add-to-cart',
			'catalogAddToCompare': 'Magetop_AjaxCartPro/js/catalog-add-to-compare',
            'Magento_Catalog/js/catalog-add-to-cart': 'Magetop_AjaxCartPro/js/catalog-add-to-cart',
			'quickShop': 'Magetop_AjaxCartPro/js/quickshop'
        },
		'shim': {
    		'Magetop_AjaxCartPro/js/catalog-add-to-cart': ['catalogAddToCart'],
			'Magetop_AjaxCartPro/js/catalog-add-to-compare': ['mage/dataPost']
    	}
    }
};
