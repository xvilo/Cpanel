
$(function() {
	var enableIt = false;
    //if(Modernizr.history){
	if(enableIt){
    var newHash      = "",
        $mainContent = $("#main-content"),
        $pageWrap    = $("#page-wrap"),
        baseHeight   = 0,
        $el;

    $pageWrap.height($pageWrap.height());
    baseHeight = $pageWrap.height() - $mainContent.height();

    $("ul.mainnav").delegate("a", "click", function() {
        _link = $(this).attr("href");
        history.pushState(null, null, _link);
        loadContent(_link);
        return false;
    });

    function loadContent(href){
        $mainContent
                .find("#guts")
                .fadeOut(200, function() {
                    $mainContent.hide().load(href + " #guts", function() {
                        $mainContent.fadeIn(200, function() {
                            $pageWrap.animate({
                                height: baseHeight + $mainContent.height() + "px"
                            });
                            calcLeftWrapper(); /* fn call */
                        });
                        $("ul.mainnav a").removeClass("current");
                        $("ul.mainnav a[href$='"+href+"']").addClass("current");
                    });
                });
    }

    $(window).bind('popstate', function(){
       _link = location.pathname.replace(/^.*[\\\/]/, '');
       loadContent(_link);
    });

}


});

$(document).ready(function() {
    calcLeftWrapper();
});
$(window).resize(function() {
    calcLeftWrapper();
});

function calcLeftWrapper() {
    var $original = $('.original-width');
    var $divWidth = $original.width();
    var $divPosit = $original.offset();
    var $vph = $(window).height();
    var $element = $('.leftwrapper');
    var $height = $vph - $divPosit.top - 15;
    $element.css({
        'width': $divWidth,
        'left': $divPosit.left,
        'top': $divPosit.top,
        'height': $height,
    });
    $element.delay(500).fadeIn(200, function() {
	    });
}

jQuery("#userdetails-phone").intlTelInput();

function prepareButton() {
    var count = 0;
    $('#add').click(function(event) {
	    event.preventDefault();
	    var content = document.querySelector('#tempproduct').content;
		count++;
		console.log('products['+count+'][]');
	    console.log(content);
	    var found = $($(content).children()[0]).find("input");
		found.attr("name", 'products['+count+'][]');
	    document.querySelector('#products').appendChild(
	    document.importNode(content, true));
    });
}
prepareButton();