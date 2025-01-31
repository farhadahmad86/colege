
import CreateSearchDiv from './createSearchDiv.js';


    let getSearchInputDiv = document.getElementsByClassName("search_input");
    Array.prototype.forEach.call(getSearchInputDiv, getAndPassSearchInputDiv);

    function getAndPassSearchInputDiv( item, index, arr ) {
        CreateSearchDiv( arr[index], index );
    }

