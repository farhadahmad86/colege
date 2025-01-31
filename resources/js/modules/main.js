
window.fetchCompanies = (input) => {
    var action = $(input).data('fetch-url');

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: action,
        type: 'post',
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            console.log(`ajax fetch ${$(input).attr('id')} before`);
        },
        success: function (data) {
            console.log(`response fetch ${$(input).attr('id')}:`, data);
            if (data['result'] === true) {
                console.log('result true');
                destroySelect2(`select#${$(input).attr('id')}`);
                input.html('');
                input.html(data['options']);
                initSelect2(`select#${$(input).attr('id')}`);
                console.log('result end');
            }
        },
        error: function (xhr, textStatus, errorThrown, jqXHR) {
            console.log(xhr, textStatus, errorThrown, jqXHR);
            console.log(`ajax ${$(input).attr('id')} error`);
        },
        complete: function () {
            console.log(`ajax ${$(input).attr('id')} Complete`);
        }
    });
});




$(function () {

    $(document).ready(function () {
        $('select#company').trigger('change');

    });

    $('select#company').on('change', function (event) {
        event.preventDefault();


        var companyId = $(this).find(':selected').data('company-id');
        var regionId = $('#data').data('region-id');
        var action = $('#data').data('region-action');

        if (companyId === '' || companyId === 'undefined') return 0;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: action,
            type: 'post',
            cache: false,
            data: {
                company: companyId,
                region: regionId,
            },
            dataType: 'json',
            beforeSend: function () {
                console.log('ajax Company before');
            },
            success: function (data) {
                console.log('response Company:', data);

                if (data['result'] === true) {
                    console.log('result true');
                    var region = $('select#region');

                    destroySelect2('select#region');
                    region.html('');
                    region.html(data['options']);
                    initSelect2('select#region');
                    console.log('result end');

                    if ($('select#zone').length) {
                        region.trigger('change');
                    }
                }

            },
            error: function (xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax company error');
            },
            complete: function () {
                console.log('ajax company Complete');
            }
        });

    });


    $('select#region').on('change', function (event) {
        event.preventDefault();

        var regionId = $(this).find(':selected').data('region-id');
        var zoneId = $('#data').data('zone-id');
        var action = $('#data').data('zone-action');

        if (regionId === '' || regionId === 'undefined') return 0;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: action,
            type: 'post',
            cache: false,
            data: {
                region: regionId,
                zone: zoneId,
            },
            dataType: 'json',
            beforeSend: function () {
                console.log('ajax region before');
            },
            success: function (data) {
                console.log('response region:', data);

                if (data['result'] === true) {
                    var zone = $('select#zone');
                    zone.html('');
                    zone.html(data['options']);

                    if ($('select#city').length) {
                        zone.trigger('change');
                    }
                }

            },
            error: function (xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax region error');
            },
            complete: function () {
                console.log('ajax region Complete');
            }
        });

    });


    $('select#zone').on('change', function (event) {
        event.preventDefault();

        var zoneId = $(this).find(':selected').data('zone-id');
        var cityId = $('#data').data('city-id');
        var action = $('#data').data('city-action');


        if (zoneId === '' || zoneId === 'undefined') return 0;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: action,
            type: 'post',
            cache: false,
            data: {
                zone: zoneId,
                city: cityId,
            },
            dataType: 'json',
            beforeSend: function () {
                console.log('ajax zone before');
            },
            success: function (data) {
                console.log('response zone:', data);

                if (data['result'] === true) {
                    var city = $('select#city');
                    city.html('');
                    city.html(data['options']);

                    if ($('select#grid').length) {
                        city.trigger('change');
                    }
                }

            },
            error: function (xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax zone error');
            },
            complete: function () {
                console.log('ajax zone Complete');
            }
        });

    });


    $('select#city').on('change', function (event) {
        event.preventDefault();

        var cityId = $(this).find(':selected').data('city-id');
        var gridId = $('#data').data('grid-id');
        var action = $('#data').data('grid-action');

        console.log(cityId, gridId, action);

        if (cityId === '' || cityId === 'undefined') return 0;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: action,
            type: 'post',
            cache: false,
            data: {
                city: cityId,
                grid: gridId,
            },
            dataType: 'json',
            beforeSend: function () {
                console.log('ajax city before');
            },
            success: function (data) {
                console.log('response city:', data);

                if (data['result'] === true) {
                    var grid = $('select#grid');
                    grid.html('');
                    grid.html(data['options']);

                    if ($('select#franchiseArea').length) {
                        grid.trigger('change');
                    }
                }

            },
            error: function (xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax zone error');
            },
            complete: function () {
                console.log('ajax zone Complete');
            }
        });

    });


    $('select#grid').on('change', function (event) {
        event.preventDefault();

        var gridId = $(this).find(':selected').data('grid-id');
        var franchiseAreaId = $('#data').data('franchise-area-id');
        var action = $('#data').data('franchise-area-action');

        if (gridId === '' || gridId === 'undefined') return 0;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: action,
            type: 'post',
            cache: false,
            data: {
                grid: gridId,
                franchiseArea: franchiseAreaId,
            },
            dataType: 'json',
            beforeSend: function () {
                console.log('ajax grid before');
            },
            success: function (data) {
                console.log('response grid:', data);

                if (data['result'] === true) {
                    var franchiseArea = $('select#franchiseArea');
                    franchiseArea.html('');
                    franchiseArea.html(data['options']);

                    if ($('select#circle').length) {
                        franchiseArea.trigger('change');
                    }
                }

            },
            error: function (xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax grid error');
            },
            complete: function () {
                console.log('ajax grid Complete');
            }
        });

    });


    $('select#franchiseArea').on('change', function (event) {
        event.preventDefault();

        var franchiseAreaId = $(this).find(':selected').data('franchise-area-id');
        var circleId = $('#data').data('circle-id');
        var action = $('#data').data('circle-action');

        if (franchiseAreaId === '' || franchiseAreaId === 'undefined') return 0;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: action,
            type: 'post',
            cache: false,
            data: {
                franchiseArea: franchiseAreaId,
                circle: circleId,
            },
            dataType: 'json',
            beforeSend: function () {
                console.log('ajax Franchise Area before');
            },
            success: function (data) {
                console.log('response Franchise Area:', data);

                if (data['result'] === true) {
                    var circle = $('select#circle');
                    circle.html('');
                    circle.html(data['options']);
                }

            },
            error: function (xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax Franchise Area error');
            },
            complete: function () {
                console.log('ajax Franchise Area Complete');
            }
        });

    });


});





