@extends('layouts.welcome')

@section('footer_javascript')

    <script src="js/icheck.js"></script>
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    </script>

    <style>
        .dd-options {
            max-height: 300px;
        }
    </style>

    <script>
        function showOrHideOptions(el) {
            var curText = $(el).text();

            if (curText == 'More options') {
                $(el).prev().slideDown(function() {
                    $(el).text('Hide options');
                });
            } else {
                $(el).prev().slideUp(function() {
                    $(el).text('More options');
                });
            }
        }

        $(document).ready(function() {
            $('div.geo_search').each(function(i, body) {
                $(body).html('\
                <div style="display: none">\
                    <div class="col-md-4">\
                        <div class="form-group">\
                            <label>State</label>\
                            <select id="state-'+ i + '" class="form-control" name="state"></select>\
                        </div>\
                    </div>\
                    <div class="col-md-4">\
                        <div class="form-group">\
                            <label>Region</label>\
                            <select id="region-'+ i + '" class="form-control" name="region"></select>\
                        </div>\
                    </div>\
                    <div class="col-md-4">\
                        <div class="form-group">\
                            <label>City</label>\
                            <select id="city-'+ i + '" class="form-control" name="city"></select>\
                        </div>\
                    </div>\
                </div>\
                <div class="text-center additional-search" onclick="showOrHideOptions(this)">More options</div>\
                ');
            });

            /*$('div.geo_search').html('\
            <div style="display: none">\
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
            </div>\
            <div class="text-center additional-search" onclick="showOrHideOptions(this)">More options</div>\
            ');*/

            $.getJSON('/js/prepopulatelocations.json', function(response) {
                window['locations'] = response;

                var ddData = [{text: 'All States', value: ''}];
                $.each(locations, function(state, data) {
                    ddData.push({
                        text: state
                    });
                    //$('<option>'+ state + '</option>').appendTo('select[name="state"]');
                });

                $('div.geo_search').each(function(i, body) {
                    resetRegions(i);
                    resetCities(i);

                    $('#state-'+ i).ddslick({
                        data: ddData,
                        onSelected: function(selectedData) {
                            if (selectedData.selectedData.text != 'All States') {
                                var regionData = [{text: 'All Regions', value: ''}];
                                $.each(locations[selectedData.selectedData.text], function (region, data) {
                                    regionData.push({text: region});
                                });

                                var state = selectedData.selectedData.text;
                                $('#state-'+ i + ' input[name="state"]').val(state);

                                $('#region-'+ i).ddslick('destroy');
                                $('#region-'+ i).ddslick({
                                    data: regionData,
                                    onSelected: function (selectedData) {
                                        if (selectedData.selectedData.text != 'All Regions') {
                                            var cityData = [{text: 'All Cities', value: ''}];
                                            $.each(locations[state][selectedData.selectedData.text].cities, function (i, city) {
                                                cityData.push({text: city});
                                            });

                                            var region = selectedData.selectedData.text;
                                            $('#region-'+ i + ' input[name="region"]').val(region);

                                            $('#city-'+ i).ddslick('destroy')
                                            $('#city-'+ i).ddslick({
                                                data: cityData,
                                                onSelected: function (selectedData) {
                                                    var city = selectedData.selectedData.text;
                                                    $('#city-'+ i + ' input[name="city"]').val(city);
                                                }
                                            });
                                        } else {
                                            resetCities(i);
                                        }
                                    }
                                });
                            } else {
                                resetRegions(i);
                                resetCities(i);
                            }
                        }
                    });
                });
            });

            function resetRegions(i) {
                $('#region-'+ i).ddslick('destroy')
                $('#region-'+ i).ddslick({
                    data: [{text: 'All Regions', value: ''}]
                });
            }

            function resetCities(i) {
                $('#city-'+ i).ddslick('destroy');
                $('#city-'+ i).ddslick({
                    data: [{text: 'All Cities', value: ''}]
                });
            }

            /*$('select[name="state"]').change(function() {
               renderRegions($(this).val());
            });
            $('select[name="region"]').change(function() {
                var state = $(this).parent().parent().prev().find('select').val();
                renderCities(state, $(this).val());
            });*/

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