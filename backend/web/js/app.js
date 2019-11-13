$(document).ready(function() {
    $('#submit_case_form').click(function(e) {
        e.preventDefault();
        var producst = $('#case_products_list');
        producst.fadeOut("fast");
        $('#case_creator_form').append(producst);
        $('#case_creator_form').submit();
    });

    $('#move_product2').click(function(e) {
        var select_items = $('#case_products_list .search_product_element').has("input:checked");
        // select_items.find('input').attr('name', 'user_products[id]');
        //$('#user_product_list').append(select_items);
        select_items.clone().appendTo("#user_product_list");
    });
    $('#move_product1').click(function(e) {
        var select_items = $('#user_product_list .search_product_element').has("input:checked");
        select_items.remove();
        //select_items.find('input').attr('name', 'shop_products[]');
        //$('#case_products_list').append(select_items);
    });

    $('#user_profile_submit').click(function(e) {
        e.preventDefault();
        $('#user_product_list input').prop('checked', true);
        var select_items1 = $('#case_products_list .search_product_element'),
            select_items2 = $('#user_product_list .search_product_element');
        select_items1.fadeOut("fast");
        select_items2.fadeOut("fast");
        //$('#user_edit_form').append(select_items1);
        $('#user_edit_form').append(select_items2);

        $('#user_edit_form').submit();
    });
});