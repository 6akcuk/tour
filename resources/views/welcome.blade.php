@extends('layouts.welcome')

@section('footer_javascript')
    <script>
        $(document).ready(function() {
            $('div.geo_search').html('\
            <div class="col-md-4">\
                <div class="form-group">\
                    <label>State</label>\
                    <select class="form-control" name="state"><option value="">All states</option></select>\
                </div>\
            </div>\
            <div class="col-md-4">\
                <div class="form-group">\
                    <label>Region</label>\
                    <select class="form-control" name="region"><option value="">All Regions</option></select>\
                </div>\
            </div>\
            <div class="col-md-4">\
                <div class="form-group">\
                    <label>City</label>\
                    <select class="form-control" name="city"><option value="">All Cities</option></select>\
                </div>\
            </div>\
            ');

            $.getJSON('/js/prepopulatelocations.json', function(response) {
                window['locations'] = response;

                $.each(locations, function(state, data) {
                    $('<option>'+ state + '</option>').appendTo('select[name="state"]');
                });
            });

            $('select[name="state"]').change(function() {
               renderRegions($(this).val());
            });
            $('select[name="region"]').change(function() {
                var state = $(this).parent().parent().prev().find('select').val();
                renderCities(state, $(this).val());
            });

            function renderRegions(state) {
                $('select[name="region"]').html('<option value="">All Regions</option>');

                $.each(locations[state], function(region, data) {
                    $('<option>'+ region + '</option>').appendTo('select[name="region"]');
                });
            }
            function renderCities(state, region) {
                $('select[name="city"]').html('<option value="">All Cities</option>');

                $.each(locations[state][region].cities, function(i, city) {
                    $('<option>'+ city + '</option>').appendTo('select[name="city"]');
                });
            }
        });

        var loaded = {};

        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            $(e.relatedTarget.hash + '_top').hide();

            var $new = $(e.target.hash + '_top');
            $new.show();

            if (!loaded[e.target.hash]) {
                $.getJSON('/index/' + e.target.hash.replace(/#/, ''), function (response) {
                    $new.children('div.row').html(response.view);
                    $(e.target.hash + '_num').text(response.numberOfResults);

                    loaded[e.target.hash] = true;
                });
            }
        })
    </script>
@endsection