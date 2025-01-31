var PS_SEARCHABLE_TABLE_TITLE_NAME = (typeof PRODUCTS_TABLE_TITLE_NAMES === "undefined") ? ['BarCode', 'Title', 'Product Code', 'Alternative Code'] : PRODUCTS_TABLE_TITLE_NAMES;
var PS_SEARCHABLE_KEYS_NAME = (typeof PRODUCTS_COLUMNS_NAMES === "undefined") ? ['pro_p_code', 'pro_title', 'pro_code', 'pro_alternative_code'] : PRODUCTS_COLUMNS_NAMES;
var PS_FETCH_PRODUCTS_LIST_ROUTE = GET_PRODUCTS_ROUTE;


const options = {
    // isCaseSensitive: false,
    // includeScore: false,
    shouldSort: false,
    // includeMatches: false,
    // findAllMatches: false,
    // minMatchCharLength: 1,
    location: 0,
    threshold: 0.0,
    distance: 500,
    // useExtendedSearch: false,
    ignoreLocation: true,
    // ignoreFieldNorm: false,
    keys: PS_SEARCHABLE_KEYS_NAME,
};


var list;
var myIndex;
var fuse;
var search_results;
const table_Keyevent = 'keypress';

var search_input_selector = '.ps__search__input';
var search_input_elem = $(search_input_selector);
var current_search_input_elem = null;
var search_result_table = '.ps__search__table';

$(document).ready(function () {
    if ($('.ps__search ' + search_input_selector).length > 0) {
        addSearchTable();
        getJsonProducts();
    }
});

// changed by nabeel
function sirf_reload(getroute) {
    PS_FETCH_PRODUCTS_LIST_ROUTE = getroute;
    getJsonProducts();
}

function addSearchTable() {
    var search_table = '' +
        '<div class="ps__search__results">\n' +
        '    <table class="table table-bordered ps__search__table mb-0">\n' +
        '        <thead>\n' +
        '        <tr>\n';
    $.each(PS_SEARCHABLE_TABLE_TITLE_NAME, function (table_name_key, table_name_value) {
        search_table += '            <th class="tbl_txt_20 ps__search__result__header">' + table_name_value + '</th>\n';
    });
    search_table += '' +
        '        </tr>\n' +
        '        </thead>\n' +
        '        <tbody class="ps__search__table__body">\n' +
        '        </tbody>\n' +
        '    </table>\n' +
        '</div>';

    $('.ps__search').append($(search_table));
}

function getJsonProducts() {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: PS_FETCH_PRODUCTS_LIST_ROUTE,
        type: "get",
        cache: false,
        dataType: 'json',
        success: function (data) {
            console.log(data, $.parseJSON(data));

            list = $.parseJSON(data);
            var search_mustafa = [];
            for (var ms in list) {
                var one_node = list[ms];
                search_mustafa.push({'item': one_node});
            }

            search_results = search_mustafa;
            myIndex = Fuse.createIndex(options.keys, list);
            fuse = new Fuse(list, options, myIndex);

            var tds = '';
            var tbody = $('.ps__search__table__body');
            tbody.html('');

            $.each(search_results, function (key, value) {

                tds += '<tr id="' + value.refIndex + '" data-index="' + key + '">\n';
                $.each(PS_SEARCHABLE_KEYS_NAME, function (search_key, search_value) {
                    tds += '    <td class="tbl_txt_20 ps__search__result__select">' + value.item[search_value] + '</td>\n';
                });
            });
            tbody.append($(tds));

        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

var old_value = '';
search_input_elem.on('keyup', $.debounce(500, function (e) {
    current_search_input_elem = $(this);
    var value = current_search_input_elem.val();
    value = value.replace(/\=|\'|\!|\^|\.|\$/g, ""); // .toString().replaceAll('=', '').replaceAll("'", '').replaceAll('!', '').replaceAll('^', '').replaceAll('.', '').replaceAll('$', '');
    if (value === old_value) return 0;
    old_value = value;
    console.log(value);

    if (value.length >= 1) {
        search_results = fuse.search(value);

        var tds = '';
        var tbody = $('#' + current_search_input_elem.attr('id') + ' + .ps__search__results .ps__search__table__body');
        tbody.html('');

        $.each(search_results, function (key, value) {
            tds += '<tr id="' + value.refIndex + '" data-index="' + key + '">\n';
            $.each(PS_SEARCHABLE_KEYS_NAME, function (search_key, search_value) {
                tds += '    <td class="tbl_txt_20 ps__search__result__select">' + value.item[search_value] + '</td>\n';
            });
        });
        tbody.append($(tds));

        if (search_results.length > 0) {
            setTable();
        }
        console.log(search_results);
    }else{
        getJsonProducts();
    }
}));

$(search_input_selector).on('keyup', function (e) {

    var event = jQuery.Event(table_Keyevent);
    if (e.keyCode === 40) {
        event.which = 40;
        event.keyCode = 40;
        $(search_result_table).trigger(event);
    }
    if (e.keyCode === 38) {
        event.which = 38;
        event.keyCode = 38;
        $(search_result_table).trigger(event);
    }
    if (e.keyCode === 13) {
        event.which = 13;
        event.keyCode = 13;
        setTimeout(function () {

            $(search_result_table).trigger(event);

        }, 500);
    }
});
$(document).on('click', '.ps__search__result__select', function (e) {

    var index = $(this).parent().attr('data-index');
    getProduct(index);
    $(this).parent().parent().parent().parent().css('display', 'none');
});


var rows = [];
var selectedRow = 0;

function setTable() {
    rows = $('#' + current_search_input_elem.attr('id') + ' + .ps__search__results .ps__search__table__body > tr');
    selectedRow = 0;
    rows[0].classList.add("ps__search__table__tr__active");
}

$(document).on(table_Keyevent, search_result_table, function (e) {
    e.preventDefault();

    if (!(e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13)) return 0;
    if (e.keyCode === 13) {
        getProduct($(rows[selectedRow]).attr('data-index'));
        $(this).parent().css('display', 'none');
    }

    //Clear out old row's color
    rows[selectedRow].classList.remove("ps__search__table__tr__active");

    if (e.keyCode === 38) {
        selectedRow--;
    } else if (e.keyCode === 40) {
        selectedRow++;
    }
    if (selectedRow >= rows.length) {
        selectedRow = 0;
    } else if (selectedRow < 0) {
        selectedRow = rows.length - 1;
    }

    rows[selectedRow].classList.add("ps__search__table__tr__active");
    var $container = $('.ps__search__results');
    var $scrollTo = $('#' + $(rows[selectedRow]).attr('id'));
    $container.scrollTop(
        $scrollTo.offset().top - $container.offset().top + $container.scrollTop() - 65
    );
});

function getProduct(id) {
    var product = search_results[id].item;
    console.log(product);

    if ($.isFunction(window.productChanged)) {
        productChanged(product);
    } else {
        // console.log('productChanged does not exist');
    }
}


$('.ps__search__input').on('focus keyup', function (e) {
    if (e.keyCode === 13) return 0;
    $(this).next().css('display', 'block');
});
$(document).on('click', function (event) {
    if (!($(event.target).hasClass('ps__search__result__select') && $(event.target).hasClass('ps__search__result__header'))) {
        if ($('.ps__search__results').css('display') === 'block' && !$('.ps__search__input').is(':focus')) {
            $('.ps__search__results').css('display', 'none');
        }
    }
});
