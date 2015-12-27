
$(function() {

    if(Modernizr.history){

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
                        });
                        $("ul.mainnav a").removeClass("current");
                        $("ul.mainnav a[href$='"+href+"']").addClass("current");
                    });
                });
                console.log('begin function');
			    calcLeftWrapper();
			    console.log('end function');
    }
    
    $(window).bind('popstate', function(){
       _link = location.pathname.replace(/^.*[\\\/]/, '');
       loadContent(_link);
    });

}

    
});

$( document ).ready(calcLeftWrapper());

$(window).resize(function(){
	calcLeftWrapper();
});

function calcLeftWrapper(){
	var divWidth = $('.original-width').width(); 
	var divPosit = $('.original-width').offset();
	var vph      = $(window).height();
	var element  = '.leftwrapper';
	var height   = vph - divPosit.top - 15;
	console.log(divWidth+'px en '+divPosit.left+'px');
	$(element).css({
	    'width': divWidth,
	    'left': divPosit.left,
	    'top': divPosit.top,
	    'height': height,
	    'display': 'block',
	});
}