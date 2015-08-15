(function() {
    'use strict';

    $('#sort_rating, #sort_price, #sort_name').change(function() {
        $(this).parent().submit();
    });
})();