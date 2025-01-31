

export default ( getSearchInputDiv, searchInputIndex ) => {

    let createMainCon = document.createElement("div");
        createMainCon.setAttribute("class", "search-result-con search-result-main-con");
        createMainCon.setAttribute("id", getSearchInputDiv.getAttribute("data-search_result_id") );

    let createTable = document.createElement("table");
        // header = await (await fetch("./table_partts/getProduct.html") ).text(),
        // createTextForTable = document.createTextNode(header);

    createTable.setAttribute("class", "search-result-table search-resut-main-table");
    createTable.setAttribute("id", getSearchInputDiv.getAttribute("data-search_result_id")+"_table" );
    // createTable.appendChild(createTextForTable);
    createMainCon.appendChild(createTable);




    getSearchInputDiv.appendChild(createMainCon);


}
