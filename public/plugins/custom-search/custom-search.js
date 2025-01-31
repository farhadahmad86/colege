
var SEARCHABLE_KEYS_NAME = PRODUCTS_COLUMNS_NAMES;
var FETCH_PRODUCTS_LIST_ROUTE = GET_PRODUCTS_ROUTE;


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
    keys: SEARCHABLE_KEYS_NAME,
};


var list;
var myIndex;
var fuse;
var search_results;
const table_Keyevent = 'keypress';


$(document).ready(function () {
    getJsonProducts();
});

function getJsonProducts() {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: FETCH_PRODUCTS_LIST_ROUTE,
        type: "get",
        cache: false,
        dataType: 'json',
        success: function (data) {
            console.log(data, $.parseJSON( data ));

            list = $.parseJSON( data );
            myIndex = Fuse.createIndex(options.keys, list);
            fuse = new Fuse(list, options, myIndex);
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

var old_value = '';
$('.search__input').on('keyup', $.debounce(500, function (e) {

    var value = $(this).val();
    value = value.replaceAll('=', '').replaceAll("'", '').replaceAll('!', '').replaceAll('^', '').replaceAll('.', '').replaceAll('$', '');
    if (value === old_value) return 0;
    old_value = value;
    console.log(value);

    if (value.length > 1) {

        search_results = fuse.search(value);

        var tds = '';
        var tbody = $('.search__table__body');
        tbody.html('');

        $.each(search_results, function (key, value) {
            tds += '' +
                '<tr id="' + value.refIndex + '" data-index="'+ key +'">\n' +
                '    <td class="tbl_txt_20 search__result__select">' + value.item.pro_p_code + '</td>\n' +
                '    <td class="tbl_txt_30 search__result__select">' + value.item.pro_title + '</td>\n' +
                '    <td class="tbl_txt_20 search__result__select">' + value.item.pro_code + '</td>\n' +
                '    <td class="tbl_txt_30 search__result__select">' + value.item.pro_clubbing_codes + '</td>\n' +
                '</tr>' +
                '';
            // tbody.append( $(tds) );
        });
        tbody.append($(tds));

        if (search_results.length > 0) { setTable(); }
        console.log(search_results);
    }
}));

$('#region_name').on('keyup', function (e) {
    var event = jQuery.Event(table_Keyevent);
    if(e.keyCode === 40) {
        event.which = 40; event.keyCode = 40;
        $('table').trigger(event);
    }
    if(e.keyCode === 38) {
        event.which = 38; event.keyCode = 38;
        $('table').trigger(event);
    }
    if(e.keyCode === 13) {
        event.which = 13; event.keyCode = 13;
        $('table').trigger(event);
    }
});
$(document).on('click', '.search__result__select', function (e) {

    var index = $(this).parent().attr('data-index');
    console.log( index );
    getProduct(index);
    $(this).parent().parent().parent().parent().css('display', 'none');
});


var rows = [];
var selectedRow = 0;
function setTable()
{
    rows = $('.search__table__body > tr');
    selectedRow = 0;
    rows[0].classList.add("active");
}
$('table').on(table_Keyevent, function (e) {
    e.preventDefault();

    if(!(e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13)) return 0;
    if(e.keyCode === 13) { console.log('search result selected row index: ', $(rows[selectedRow]).attr('data-index'), getProduct($(rows[selectedRow]).attr('data-index')) ); }

    //Clear out old row's color
    rows[selectedRow].classList.remove("active");

    if(e.keyCode === 38) {
        selectedRow--;
    } else if(e.keyCode === 40) {
        selectedRow++;
    }
    if(selectedRow >= rows.length) {
        selectedRow = 0;
    } else if(selectedRow < 0) {
        selectedRow = rows.length-1;
    }

    rows[selectedRow].classList.add("active");
    var $container = $('.search__results');
    var $scrollTo = $('#'+$(rows[selectedRow]).attr('id'));
    $container.scrollTop(
        $scrollTo.offset().top - $container.offset().top + $container.scrollTop() - 65
    );
});

function getProduct(id) {
    console.log('search result single object: ', search_results[id] );
}


$('.search__input').on('focus', function (e) {
    $(this).next().css('display', 'block');
});
$(document).on('click', function (event) {
    if ( !($(event.target).hasClass('search__result__select') && $(event.target).hasClass('search__result__header')) ) {
        if( $('.search__results').css('display') === 'block' && !$('.search__input').is(':focus') ) {
            $('.search__results').css('display', 'none');
        }
    }
});
