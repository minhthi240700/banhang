$ = jQuery;

var windowWidth = $(this).width();
if (windowWidth < 849) {
    $('.sort-cate-left-label').click(function() {
        $('.quick-sort-block').toggleClass('new-class');
        if ($('.quick-sort-block').hasClass('new-class')) {
            $('.quick-sort-block').slideDown();
        } else {
            $('.quick-sort-block').slideUp();
        }
    });
}

var activeItem = localStorage.getItem('activeSortItem');
if (activeItem) {
    $('.btn-quick-sort').removeClass('active');
    $('a[href="' + activeItem + '"]').parent().addClass('active');
}

$('.btn-quick-sort').on('click', function(e) {
    var selectedItem = $(this).find('a').attr('href');
    localStorage.setItem('activeSortItem', selectedItem);

    $('.btn-quick-sort').removeClass('active');
    $(this).addClass('active');

    location.reload();
});

function js_custom_price_pt() {
    var m = $('.product-price-container').html();
    $('.single_variation_wrap').change(function() {
        $('.woocommerce-variation-price').hide();
        var p = $('.single_variation_wrap').find('.woocommerce-variation-price').html();
        $('.product-price-container').html(p);
    });
    $('body').on('click', '.reset_variations', function(event) {
        $('.product-price-container').html(m);
    });
}
js_custom_price_pt();   
