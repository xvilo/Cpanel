
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

// This identifies your website in the createToken call below
    var stripeResponseHandler = function(status, response) {
      var $form = $('#payment-form');
      if (response.error) {
        // Show the errors on the form
        $form.find('.payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };
    console.log('stripe here');
    $(function($) {
      $('#payment-form').submit(function(e) {
        var $form = $(this);
        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);
        Stripe.card.createToken($form, stripeResponseHandler);
        // Prevent the form from submitting with the default action
        return false;
      });
    });