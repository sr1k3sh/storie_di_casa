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

define([
        "jquery", "slick"
    ],
    function($)
    {
        return function(slider){
            var key = slider.key;
            var productsPerSlide;
            /** @namespace slider.productPerSlide */
            productsPerSlide  = slider.productPerSlide;
            var slidesToShow = productsPerSlide*1;
            /** @namespace slider.showNavigation */
            var showNavigation = slider.showNavigation;
            if(showNavigation == 0) {
                showNavigation = false;
            } else {
                showNavigation = true;
            }
            /** @namespace slider.showArrows */
            var showArrows = slider.showArrows;
            if(showArrows == 0){
                showArrows = false;
            } else {
                showArrows = true;
            }
            /** @namespace slider.autoplayEvery */
            var autoplayEvery = slider.autoplayEvery;
            var autoplayEveryConvert;
            autoplayEveryConvert = autoplayEvery * 1000;
            var autoPlay= false;
            if (autoplayEvery > 0){
                autoPlay = true;
            }
            $(document).ready(function () {
                $('.'+'bss-slick-slider'+key).not('.slick-initialized').slick({
                    dots: showNavigation,
                    arrows: showArrows,
                    infinite: true,
                    adaptiveHeight: true,
                    slidesToShow: slidesToShow,
                    slidesToScroll: slidesToShow,
                    speed: 800,
                    autoplay: autoPlay,
                    autoplaySpeed: autoplayEveryConvert,
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                arrows: false,
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                dots: false,
                                arrows: false,
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                dots: false,
                                arrows: false,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        }
    }
);