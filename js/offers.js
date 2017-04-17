jQuery(document).ready(function($) {

    // init
    $('.category-selector').first().addClass('active');
    $('.category-container').first().addClass('active');

    $('.category-selector').on("click", function(){
        var category_id = "#" + $(this).attr('data-category-id');

        // remove active class
        $('.category-selector').removeClass('active');
        $('.category-container').removeClass('active');

        // add active class to the new category
        $(this).addClass('active');
        $(category_id).addClass('active');
    });



});
