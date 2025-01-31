// var dmp = new diff_match_patch();
// var diff = dmp.diff_main('Hello World.', 'Goodbye World.');
// // Result: [(-1, "Hell"), (1, "G"), (0, "o"), (1, "odbye"), (0, " World.")]
// dmp.diff_cleanupSemantic(diff);
// // Result: [(-1, "Hello"), (1, "Goodbye"), (0, " World.")]
// alert(diff);


/* ######################################### Sidebar Remain Open ######################################### */

// // for sidebar menu entirely but not cover treeview
// console.log(
//     $('ul.accordion-menu a').filter(function () {
//         return this.href == url;
//     }).addClass('active')  //     }).parent().addClass('active')
// );
//
// // for treeview
// console.log(
//     $('ul.submenu a').filter(function () {
//         return this.href == url;
//     }).addClass('active').parentsUntil(".accordion-menu > .treeview .submenu").addClass('active')
// );

// $(document).ready(function() {
// setTimeout(function () {
    /** add active class and stay opened when selected */
    var url = window.location;

    /* ********************** First Level ******************** */
    var firstLvl, first = false, lvl1 = 'first';
    firstLvl = $('ul.accordion-menu > li > a').filter(function () {
        return this.href == url;
    });
    if (firstLvl.length) {
        first = true;
        window.localStorage.setItem('lastActiveUrl', firstLvl.attr('href'));
        window.localStorage.setItem('lastActiveLvl', lvl1);
    }
    firstLvl.addClass('active');
// firstLvl.focus();

    /* ********************** Second Level ******************** */
    var secondLvl, second = false, lvl2 = 'second';
    secondLvl = $('ul.submenu > li > a').filter(function () {
        return this.href == url;
    });
    if (secondLvl.length) {
        second = true;
        window.localStorage.setItem('lastActiveUrl', secondLvl.attr('href'));
        window.localStorage.setItem('lastActiveLvl', lvl2);
    }
    secondLvl.addClass('active');
    secondLvl.parent().parent().prev().addClass('active').click();
// secondLvl.focus();

    /* ********************** Third Level ******************** */
    var thirdLvl, thirdLvl_parent, third = false, lvl3 = 'third';
    thirdLvl = $('ul.submenu.child > li > a').filter(function () {
        return this.href == url;
    });
    if (thirdLvl.length) {
        third = true;
        window.localStorage.setItem('lastActiveUrl', thirdLvl.attr('href'));
        window.localStorage.setItem('lastActiveLvl', lvl3);
    }
    thirdLvl.addClass('active');
    thirdLvl_parent = thirdLvl.parent().parent().prev();
    thirdLvl_parent.addClass('active').click();
    thirdLvl_parent = thirdLvl_parent.parent().parent().prev().addClass('active').click();
// thirdLvl.focus();

    /* ********************** Keep Last SideBar Open If Url Not Found ******************** */
    $(function () {
        // window.localStorage.setItem('lastActiveSideBar', url);
        // var lastActiveSideBar = window.localStorage.getItem('lastActiveSideBar');
        var lastActiveUrl = window.localStorage.getItem('lastActiveUrl');
        var lastActiveLvl = window.localStorage.getItem('lastActiveLvl');

        // alert('first: ' + first + ', second: ' + second + ', third: ' + third + ', lastActiveLvl: ' + lastActiveLvl);

        if (!first && !second && !third) {
            if (lastActiveLvl === 'first') {
                firstLvl = $('ul.accordion-menu > li > a').filter(function () {
                    return this.href === lastActiveUrl;
                });
                firstLvl.addClass('active');
                // firstLvl.focus();
            } else if (lastActiveLvl === 'second') {
                secondLvl = $('ul.submenu > li > a').filter(function () {
                    return this.href === lastActiveUrl;
                });
                secondLvl.addClass('active');
                secondLvl.parent().parent().prev().addClass('active').click();
                // secondLvl.focus();
            } else if (lastActiveLvl === 'third') {
                thirdLvl = $('ul.submenu.child > li > a').filter(function () {
                    return this.href === lastActiveUrl;
                });
                thirdLvl.addClass('active');
                thirdLvl_parent = thirdLvl.parent().parent().prev();
                thirdLvl_parent.addClass('active').click();
                thirdLvl_parent = thirdLvl_parent.parent().parent().prev().addClass('active').click();
                // thirdLvl.focus();
            } else {
                // alert('wrong');
            }
        }

        // window.localStorage.removeItem("lastActiveSideBar");
        // window.localStorage.removeItem("lastActiveUrl");
        // window.localStorage.removeItem("lastActiveLvl");

    });

    /* ######################################### Sidebar Remain Open End ######################################### */
// }, 200);
// });



