$(function () {
	$("#img_03").imageLens({ imageSrc: "../rede.png",lensSize: 250 });
});

(function($)
{
        $.fn.blink = function(options)
        {
                var defaults = { delay:500 };
                var options = $.extend(defaults, options);

                return this.each(function()
                {
                        var obj = $(this);
                        setInterval(function()
                        {
                                if($(obj).css("visibility") == "visible")
                                {
                                        $(obj).css('visibility','hidden');
                                }
                                else
                                {
                                        $(obj).css('visibility','visible');
                                }
                        }, options.delay);
                });
        }
}(jQuery))

$(document).ready(function()
{
        //$('.alerta').blink(); // default is 500ms blink interval.
        $('.alerta1').blink({delay:200}); // causes a 100ms blink interval.
        $('.alerta2').blink({delay:200}); // causes a 100ms blink interval.
        $('.alerta3').blink({delay:200}); // causes a 100ms blink interval.
        $('.alerta4').blink({delay:200}); // causes a 100ms blink interval.
        $('.alerta5').blink({delay:200}); // causes a 100ms blink interval.
});

