(function() {
    'use strict';

    $('#sort_rating, #sort_price').change(function() {
        $(this).parent().submit();
    });
})();