
/* Select2 Helper Functions */
window.disableSelect2Value = function (filedName, value) {
    destroySelect2(filedName);
    $(filedName + ' option[value="' + value + '"]').prop('disabled', true);
    initSelect2(filedName);
};

window.enableSelect2Value = function (filedName, value) {
    destroySelect2(filedName);
    $(filedName + ' option[value="' + value + '"]').prop('disabled', false);
    initSelect2(filedName);
};

window.clearSelect2Single = function (filedNames) {
    $.each(filedNames, function (index, fieldName) {
        $(fieldName).val('').change();
    });
};

window.addDataToSelect2 = function (filedName, dataName, dataValue) {
    destroySelect2(filedName);
    $(filedName).data(dataName, dataValue);
    initSelect2(filedName);
};

window.getDataFromSelect2 = function (filedName, dataName) {
    destroySelect2(filedName);
    $(filedName).data(dataName);
    initSelect2(filedName);
};

window.changeSelect2Value = function (filedName, value) {
    destroySelect2(filedName);
    $(filedName).val(value);
    initSelect2(filedName);
};

window.destroySelect2 = function (filedName) {
    console.log('adsasdasdasdsad end');
    $(filedName).select2('destroy');
};

window.initSelect2 = function (filedName) {
    $(filedName).select2({// theme: "bootstrap",
    });
};

window.initSelect2WithTemplate = function (filedName, template_data) {
    var placeholder = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';
    $(filedName).select2({
        theme: "bootstrap",
        placeholder: placeholder,
        data: template_data,
        escapeMarkup: function escapeMarkup(markup) {
            return markup;
        },
        templateResult: function templateResult(data) {
            return data.html;
        },
        templateSelection: function templateSelection(data) {
            return data.text;
        }
    });
};

window.getDataAttributeFromSelect2Option = function (filedName, dataName) {
    return $(filedName).find(":selected").data(dataName); // return $(filedName).select2().find(":selected").data(dataName);
};

window.selectMultipleSelect2Options = function (filedName, values) {
    destroySelect2(filedName);
    $(filedName).val(values);
    initSelect2(filedName);
};

window.selectMultipleSelect2OptionsTemplate = function (filedName, values, template_data) {
    var placeholder = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : '';
    destroySelect2(filedName);
    $(filedName).val(values);
    initSelect2WithTemplate(filedName, template_data, placeholder);
};

window.updateSelect2WithNewOptions = function (filedName, options) {
    destroySelect2(filedName);
    $(filedName).html('');
    $(filedName).html(options);
    initSelect2(filedName);
};




"use strict";

window.fetchCompanies = function (input) {
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
        beforeSend: function beforeSend() {
            console.log("ajax fetch ".concat($(input).attr('id'), " before"));
        },
        success: function success(data) {
            console.log("response fetch ".concat($(input).attr('id'), ":"), data);

            if (data['result'] === true) {
                console.log('result true');
                destroySelect2("select#".concat($(input).attr('id')));
                input.html('');
                input.html(data['options']);
                initSelect2("select#".concat($(input).attr('id')));
                console.log('result end');
            }
        },
        error: function error(xhr, textStatus, errorThrown, jqXHR) {
            console.log(xhr, textStatus, errorThrown, jqXHR);
            console.log("ajax ".concat($(input).attr('id'), " error"));
        },
        complete: function complete() {
            console.log("ajax ".concat($(input).attr('id'), " Complete"));
        }
    });
};

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
        console.log(companyId,regionId,action);

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
                region: regionId
            },
            dataType: 'json',
            beforeSend: function beforeSend() {
                console.log('ajax Company before');
            },
            success: function success(data) {
                console.log('response Company:', data);

                if (data['result'] === true) {
                    console.log('result true');
                    var region = $('select#region');
                    destroySelect2('select#region');
                    region.html('');
                    region.append(data['options']);
                    initSelect2('select#region');
                    console.log('result end');

                    if ($('select#zone').length) {
                        region.trigger('change');
                    }
                }
            },
            error: function error(xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr.responseText, textStatus, errorThrown, jqXHR);
                console.log('ajax company error');
            },
            complete: function complete() {
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
                zone: zoneId
            },
            dataType: 'json',
            beforeSend: function beforeSend() {
                console.log('ajax region before');
            },
            success: function success(data) {
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
            error: function error(xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax region error');
            },
            complete: function complete() {
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
                city: cityId
            },
            dataType: 'json',
            beforeSend: function beforeSend() {
                console.log('ajax zone before');
            },
            success: function success(data) {
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
            error: function error(xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax zone error');
            },
            complete: function complete() {
                console.log('ajax zone Complete');
            }
        });
    });
    $('select#city').on('change', function (event) {
        event.preventDefault();

        var zoneId = $('#zone').find(':selected').data('zone-id');
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
                // zone: zoneId,
                zone: zoneId,
                city: cityId,
                grid: gridId
            },
            dataType: 'json',
            beforeSend: function beforeSend() {
                console.log('ajax city before');
            },
            success: function success(data) {
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
            error: function error(xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax zone error');
            },
            complete: function complete() {
                console.log('ajax zone Complete');
            }
        });
    });
    $('select#grid').on('change', function (event) {
        event.preventDefault();
        var cityId = $('#city').find(':selected').data('city-id');
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
                city: cityId,
                grid: gridId,
                franchiseArea: franchiseAreaId
            },
            dataType: 'json',
            beforeSend: function beforeSend() {
                console.log('ajax grid before');
            },
            success: function success(data) {
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
            error: function error(xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax grid error');
            },
            complete: function complete() {
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
                circle: circleId
            },
            dataType: 'json',
            beforeSend: function beforeSend() {
                console.log('ajax Franchise Area before');
            },
            success: function success(data) {
                console.log('response Franchise Area:', data);

                if (data['result'] === true) {
                    var circle = $('select#circle');
                    circle.html('');
                    circle.html(data['options']);
                }
            },
            error: function error(xhr, textStatus, errorThrown, jqXHR) {
                console.log(xhr, textStatus, errorThrown, jqXHR);
                console.log('ajax Franchise Area error');
            },
            complete: function complete() {
                console.log('ajax Franchise Area Complete');
            }
        });
    });
});
