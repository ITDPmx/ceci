!function(){$(function(){var i=null,n=null,s=null,e=null,o=null,l=function(){i.on("init",function(){$(this).css("opacity",1)}),i.slick({arrows:!1,autoplay:!0,autoplaySpeed:6e3,dots:!0,infinite:!1,slidesToScroll:1,slidesToShow:1})};o=$(window),e=$(window).height(),n=$(".js-home-slider-container"),i=$(".js-home-slider"),s=$(".js-slide"),s.css("height",e+"px"),o.on("resize",function(o){o.preventDefault(),e=$(window).height(),n.css("height",e+"px"),i.css("height",e+"px"),s.css("height",e+"px")}),l()})}(jQuery);