// class variableProperty {
//     constructor(inputValuesArray, getIdForShowAndGetData) {
//
//         /* create variable to get input values for elements */
//         this.code = inputValuesArray['code'];
//         this.title = inputValuesArray['title'];
//         this.warehouse_id = inputValuesArray['warehouse_id']; // add by mustafa
//         this.warehouse_title = inputValuesArray['warehouse_title']; // add by mustafa
//         this.expenseAccount = inputValuesArray['expenseAccount'];
//         this.remarks = inputValuesArray['remarks'];
//         this.rate = inputValuesArray['rate'];
//         this.quantity = inputValuesArray['quantity'];
//         this.pack_quantity = inputValuesArray['pack_quantity']; //add by mustafa
//         this.loose_quantity = inputValuesArray['loose_quantity']; // add by mustafa
//         this.uom = inputValuesArray['uom'];
//         this.packSize = inputValuesArray['packSize'];
//         this.amount = inputValuesArray['amount'];
//         this.cartDataArray = inputValuesArray;
//         this.idArray = getIdForShowAndGetData;
//         /* create variable to get input values for elements end */
//
//         /* create Id's variable for all elements */
//         this.codeId = getIdForShowAndGetData['codeId'];
//         this.titleId = getIdForShowAndGetData['titleId'];
//         this.warehouseIdd = getIdForShowAndGetData['warehouseIdd']; // add by mustafa
//         // this.warehouseTitle = getIdForShowAndGetData['warehouseId']; // add by mustafa
//         this.expenseAccountId = getIdForShowAndGetData['expenseAccountId'];
//         this.remarksId = getIdForShowAndGetData['remarksId'];
//         this.rateId = getIdForShowAndGetData['rateId'];
//         this.quantityId = getIdForShowAndGetData['quantityId'];
//         this.quantityPackId = getIdForShowAndGetData['quantityPackId']; // add by mustafa
//         this.quantityLooseId = getIdForShowAndGetData['quantityLooseId']; // add by mustafa
//         this.uomId = getIdForShowAndGetData['uomId'];
//         this.packSizeId = getIdForShowAndGetData['packSizeId'];
//         this.amountId = getIdForShowAndGetData['amountId'];
//         this.tblListId = getIdForShowAndGetData['tblListId'];
//         this.cartDataArrayId = getIdForShowAndGetData['cartDataArrayId'];
//         /* create Id's variable for all elements end */
//
//
//     }
//
//     /* ================================
//         Get Variables value when needed
//        ================================ */
//     get proCode() {
//         return this.code;
//     }
//
//     get proTitle() {
//         return this.title;
//     }
//
//     get warehouseTitle() {
//         return this.warehouse_title;
//     }
//
//     get warehouseIdd() {
//         return this.warehouse_id;
//     }
//
//     get proExpenseAccount() {
//         return this.expenseAccount;
//     }
//
//     get proRemarks() {
//         return this.remarks;
//     }
//
//     get proRate() {
//         return this.rate;
//     }
//
//     get proQuantity() {
//         return this.quantity;
//     }
//
//     get proPackQuantity() {
//         return this.pack_quantity;
//     }
//
//     get proLooseQuantity() {
//         return this.loose_quantity;
//     }
//
//     get proUom() {
//         return this.uom;
//     }
//
//     get proPackSize() {
//         return this.packSize;
//     }
//
//     get proAmount() {
//         return this.amount;
//     }
//
//     get _codeId() {
//         return this.codeId;
//     }
//
//     get _titleId() {
//         return this.titleId;
//     }
//
//     get _warehouseIdd() {
//         return this.warehouseIdd;
//     }
//
//     get _expenseAccountId() {
//         return this.expenseAccountId;
//     }
//
//     get _remarksId() {
//         return this.remarksId;
//     }
//
//     get _rateId() {
//         return this.rateId;
//     }
//
//     get _quantityId() {
//         return this.quantityId;
//     }
//
//     get _quantityPackId() {
//         return this.quantityPackId;
//     }
//
//     get _quantityLooseId() {
//         return this.quantityLooseId;
//     }
//
//     get _uomId() {
//         return this.uomId;
//     }
//
//     get _packSizeId() {
//         return this.packSizeId;
//     }
//
//     get _amountId() {
//         return this.amountId;
//     }
//
//     get _tblListId() {
//         return this.tblListId;
//     }
//
//     get _cartDataArrayId() {
//         return this.cartDataArrayId;
//     }
//
//     get _cartDataArray() {
//         return this.cartDataArray;
//     }
//
//     get _idArray() {
//         return this.idArray;
//     }
//
//
//     /* ================================
//         Set Variables value
//        ================================ */
//     set proCode(x) {
//         this.code = x;
//     }
//
//     set proTitle(x) {
//         this.title = x;
//     }
//
//     set warehouseTitle(x) {
//         return this.warehouse_title = x;
//     }
//
//     set warehouseIdd(x) {
//         return this.warehouse_id = x;
//     }
//
//     set proExpenseAccount(x) {
//         this.expenseAccount = x;
//     }
//
//     set proRemarks(x) {
//         this.remarks = x;
//     }
//
//     set proRate(x) {
//         this.rate = x;
//     }
//
//     set proQuantity(x) {
//         this.quantity = x;
//     }
//
//     set proPackQuantity(x) {
//         return this.pack_quantity = x;
//     }
//
//     set proLooseQuantity(x) {
//         return this.loose_quantity = x;
//     }
//
//     set proUom(x) {
//         this.uom = x;
//     }
//
//     set proPackSize(x) {
//         this.packSize = x;
//     }
//
//     set proAmount(x) {
//         this.amount = x;
//     }
//
//     set _codeId(x) {
//         this.codeId = x;
//     }
//
//     set _titleId(x) {
//         this.titleId = x;
//     }
//
//     set _warehouseIdd(x) {
//         return this.warehouseIdd = x;
//     }
//
//     set _expenseAccountId(x) {
//         this.expenseAccountId = x;
//     }
//
//     set _remarksId(x) {
//         this.remarksId = x;
//     }
//
//     set _rateId(x) {
//         this.rateId = x;
//     }
//
//     set _quantityId(x) {
//         this.quantityId = x;
//     }
//
//     set _quantityPackId(x) {
//         return this.quantityPackId = x;
//     }
//
//     set _quantityLooseId(x) {
//         return this.quantityLooseId = x;
//     }
//
//     set _uomId(x) {
//         this.uomId = x;
//     }
//
//     set _packSizeId(x) {
//         this.packSizeId = x;
//     }
//
//     set _amountId(x) {
//         this.amountId = x;
//     }
//
//     set _tblListId(x) {
//         this.tblListId = x;
//     }
//
//     set _cartDataArrayId(x) {
//         this.cartDataArrayId = x;
//     }
//
//     set _cartDataArray(x) {
//         this.cartDataArray = x;
//     }
//
//     set _idArray(x) {
//         this.idArray = x;
//     }
//
//
// }
//
// class DataCrudModel extends variableProperty {
//     constructor(inputValuesArray, idForShowAndGetData) {
//         super(inputValuesArray, idForShowAndGetData);
//     }
//
//
//     /* ============== Get Data Method ==============
//        This function use for all type cart screens
//        ============== Get Data Method ============== */
//     GET_CART_DATA(id) {
//         let cartDataArray = document.getElementById(id),
//             getData = JSON.parse(cartDataArray.value);
//         return getData;
//     }
//
//     /* ============== Get Data Method End ============== */
//
//
//     /* ============== Store Data Method ==============
//        This function use for all type cart screens
//        ============== Store Data Method ============== */
//     CREATE_CART_DATA(id, cartData) {
//         let sampleArray = [],
//             cartDataInputArray = document.getElementById(id);
//
//         if (cartDataInputArray.value !== '') {
//             sampleArray = JSON.parse(cartDataInputArray.value);
//         }
//         sampleArray.push(cartData);
//         cartDataInputArray.value = JSON.stringify(sampleArray);
//     }
//
//     /* ============== Store Data Method End ============== */
//
//
//     /* ============== Delete Data Method ==============
//        Delete single row from cart Data
//        This function use for all type cart screens
//        ============== Delete Data Method ============== */
//     DELETE_CART_DATA(id, getDelRowId) {
//         let getCartDataInputArray = document.getElementById(id),
//             cartData = JSON.parse(getCartDataInputArray.value);
//
//         if (cartData[getDelRowId] !== '') {
//             cartData.splice(getDelRowId, 1);
//         }
//         getCartDataInputArray.value = JSON.stringify(cartData);
//     }
//
//     /* ============== Delete Data Method end ============== */
//
//
//     /* ==============                    ==============
//        Update single row from cart Data
//        This function use for all type cart screens
//        ============== Update Data Method ============== */
//     UPDATE_CART_DATA(id, cartData) {
//         let sampleArray = [],
//             cartDataInputArray = document.getElementById(id),
//             editUpdateRowIndex = cartDataInputArray.getAttribute('data-editUpdateRowIndex');
//
//         if (cartDataInputArray.value !== '') {
//             sampleArray = JSON.parse(cartDataInputArray.value);
//         }
//         sampleArray.splice(editUpdateRowIndex, 0, cartData);
//         cartDataInputArray.value = JSON.stringify(sampleArray);
//     }
//
//     /* ============== Update Data Method end ============== */
//
//
//     /* ==============                    ==============
//        Update single row from cart Data
//        This function use for Work Order Screen
//        ============== Update Data Method For Work Order ============== */
//     UPDATE_CART_DATA_FOR_WORK_ORDER(id, cartData) {
//         let sampleArray = [],
//             cartDataInputArray = document.getElementById(id),
//             editUpdateRowIndex = cartDataInputArray.getAttribute('data-editUpdateRowIndex');
//
//         if (cartDataInputArray.value !== '') {
//             sampleArray = JSON.parse(cartDataInputArray.value);
//         }
//         sampleArray.splice(editUpdateRowIndex, 1, cartData);
//         cartDataInputArray.value = JSON.stringify(sampleArray);
//     }
//
//     /* ============== Update Data Method For Work Order end ============== */
//
//
//     /* ==============                    ==============
//        Cancel update inventory row from cart Data
//        This function use for all type cart screens
//        ============== Cancel Data Method ============== */
//     CANCEL_EDIT_CART_DATA(id) {
//         let sampleArray = [],
//             cartDataInputArray = document.getElementById(id),
//             getEditUpdateRow = cartDataInputArray.getAttribute('data-editUpdateValues'),
//             editUpdateRowIndex = cartDataInputArray.getAttribute('data-editUpdateRowIndex');
//
//         if (cartDataInputArray.value !== '') {
//             sampleArray = JSON.parse(cartDataInputArray.value);
//         }
//         sampleArray.splice(editUpdateRowIndex, 0, JSON.parse(getEditUpdateRow));
//         cartDataInputArray.value = JSON.stringify(sampleArray);
//         cartDataInputArray.setAttribute('data-editUpdateValues', '');
//         cartDataInputArray.setAttribute('data-editUpdateRowIndex', '');
//     }
//
//     /* ============== Cancel Data Method end ============== */
//
//
//     /* ==============                           ==============
//        Edit single row from quantity cart Data
//        This function use for only quantity cart screens
//        ============== Edit Quantity Data Method ============== */
//     EDIT_QUANTITY_CART_DATA(id, getEditRowId) {
//         let getCartDataInputArray = document.getElementById(id),
//             cartData = JSON.parse(getCartDataInputArray.value),
//             code = document.getElementById(this._codeId),
//             title = document.getElementById(this._titleId),
//             remarks = document.getElementById(this._remarksId),
//             quantity = document.getElementById(this._quantityId),
//             uom = document.getElementById(this._uomId),
//             packSize = document.getElementById(this._packSizeId);
//
//
//         if (cartData[getEditRowId] !== '') {
//             getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(cartData[getEditRowId]));
//             getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
//             code.value = cartData[getEditRowId]['code'];
//             title.value = cartData[getEditRowId]['title'];
//             // uom.value = cartData[getEditRowId]['uom']; comment by mustafa
//             // packSize.value = cartData[getEditRowId]['packSize']; comment by mustafa
//
//             /*
//                 *** for select2 options purpose
//              */
//             if (code.nextSibling.classList.contains('select2')) {
//                 $("#" + code.id).select2().trigger('change');
//             }
//             if (title.nextSibling.classList.contains('select2')) {
//                 $("#" + title.id).select2().trigger('change');
//             }
//             /*
//                 *** for select2 options purpose end
//              */
//
//
//             remarks.value = cartData[getEditRowId]['remarks'];
//             quantity.value = cartData[getEditRowId]['quantity'];
//
//             //Delete Row In Cart Data
//             cartData.splice(getEditRowId, 1);
//         }
//         getCartDataInputArray.value = JSON.stringify(cartData);
//     }
//
//     /* ============== Edit Quantity Data Method end ============== */
//
//
//     /* ==============                         ==============
//        Edit single row from amount cart Data
//        This function use for only amount cart screens
//        ============== Edit Amount Data Method ============== */
//     EDIT_AMOUNT_CART_DATA(id, getEditRowId) {
//         let getCartDataInputArray = document.getElementById(id),
//             cartData = JSON.parse(getCartDataInputArray.value),
//             code = document.getElementById(this._codeId),
//             title = document.getElementById(this._titleId),
//             remarks = document.getElementById(this._remarksId),
//             amount = document.getElementById(this._amountId);
//
//         if (cartData[getEditRowId] !== '') {
//             getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(cartData[getEditRowId]));
//             getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
//             code.value = cartData[getEditRowId]['code'];
//             title.value = cartData[getEditRowId]['title'];
//
//             /*
//                 *** for select2 options purpose
//              */
//             if (code.nextSibling.classList.contains('select2')) {
//                 $("#" + code.id).select2().trigger('change');
//             }
//             if (title.nextSibling.classList.contains('select2')) {
//                 $("#" + title.id).select2().trigger('change');
//             }
//             /*
//                 *** for select2 options purpose end
//              */
//
//
//             remarks.value = cartData[getEditRowId]['remarks'];
//             amount.value = cartData[getEditRowId]['amount'];
//
//             //Delete Row In Cart Data
//             cartData.splice(getEditRowId, 1);
//         }
//         getCartDataInputArray.value = JSON.stringify(cartData);
//     }
//
//     /* ============== Edit Amount Data Method end ============== */
//
//
//     /* ==============                                             ==============
//        Edit single row from amount cart Data
//        This function use for only amount cart screens
//        ============== Edit Amount Data Method For Uom Rate Amount ============== */
//     EDIT_UOM_RATE_AMOUNT_CART_DATA(id, getEditRowId) {
//         let getCartDataInputArray = document.getElementById(id),
//             cartData = JSON.parse(getCartDataInputArray.value),
//             code = document.getElementById(this._codeId),
//             title = document.getElementById(this._titleId),
//             expenseAccount = document.getElementById(this._expenseAccountId),
//             remarks = document.getElementById(this._remarksId),
//             rate = document.getElementById(this._rateId),
//             quantity = document.getElementById(this._quantityId),
//             uom = document.getElementById(this._uomId),
//             amount = document.getElementById(this._amountId);
//
//         if (cartData[getEditRowId] !== '') {
//             getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(cartData[getEditRowId]));
//             getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
//             code.value = cartData[getEditRowId]['code'];
//             title.value = cartData[getEditRowId]['title'];
//             expenseAccount.value = cartData[getEditRowId]['expenseAccount'];
//             uom.value = cartData[getEditRowId]['uom'];
//
//             /*
//                 *** for select2 options purpose
//              */
//             if (code.nextSibling.classList.contains('select2')) {
//                 $("#" + code.id).select2().trigger('change');
//             }
//             if (title.nextSibling.classList.contains('select2')) {
//                 $("#" + title.id).select2().trigger('change');
//             }
//             if (expenseAccount.nextSibling.classList.contains('select2')) {
//                 $("#" + expenseAccount.id).select2().trigger('change');
//             }
//             if (uom.nextSibling.classList.contains('select2')) {
//                 $("#" + uom.id).select2().trigger('change');
//             }
//             /*
//                 *** for select2 options purpose end
//              */
//
//
//             remarks.value = cartData[getEditRowId]['remarks'];
//             rate.value = cartData[getEditRowId]['rate'];
//             quantity.value = cartData[getEditRowId]['quantity'];
//             amount.value = cartData[getEditRowId]['amount'];
//
//             //Delete Row In Cart Data
//             cartData.splice(getEditRowId, 1);
//         }
//         getCartDataInputArray.value = JSON.stringify(cartData);
//     }
//
//     /* ============== Edit Amount Data Method end ============== */
//
//
//     /* ==============                                             ==============
//        Edit single row from amount cart Data
//        This function use for only amount cart screens
//        ============== Edit Amount Data Method For Uom Rate Amount ============== */
//     EDIT_UOM_RATE_AMOUNT_CART_DATA_WITH_PACK_SIZE(id, getEditRowId) {
//         let getCartDataInputArray = document.getElementById(id),
//             cartData = JSON.parse(getCartDataInputArray.value),
//             code = document.getElementById(this._codeId),
//             title = document.getElementById(this._titleId),
//             remarks = document.getElementById(this._remarksId),
//             rate = document.getElementById(this._rateId),
//             quantity = document.getElementById(this._quantityId),
//             uom = document.getElementById(this._uomId),
//             packSize = document.getElementById(this._packSizeId),
//             amount = document.getElementById(this._amountId);
//
//         if (cartData[getEditRowId] !== '') {
//             getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(cartData[getEditRowId]));
//             getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
//             code.value = cartData[getEditRowId]['code'];
//             title.value = cartData[getEditRowId]['title'];
//             uom.value = cartData[getEditRowId]['uom'];
//             packSize.value = cartData[getEditRowId]['packSize'];
//
//             /*
//                 *** for select2 options purpose
//              */
//             if (code.nextSibling.classList.contains('select2')) {
//                 $("#" + code.id).select2().trigger('change');
//             }
//             if (title.nextSibling.classList.contains('select2')) {
//                 $("#" + title.id).select2().trigger('change');
//             }
//             /*
//                 *** for select2 options purpose end
//              */
//
//
//             remarks.value = cartData[getEditRowId]['remarks'];
//             rate.value = cartData[getEditRowId]['rate'];
//             quantity.value = cartData[getEditRowId]['quantity'];
//             amount.value = cartData[getEditRowId]['amount'];
//
//             //Delete Row In Cart Data
//             cartData.splice(getEditRowId, 1);
//         }
//         getCartDataInputArray.value = JSON.stringify(cartData);
//     }
//
//     /* ============== Edit Amount Data Method end ============== */
//
//     /* ==============                                             ==============
//        Edit single row from amount cart Data
//        This function use for only warehouse loose pack amount cart screens
//        ============== Edit Amount Data Method For Uom Rate Amount ============== */
//     EDIT_WAREHOUSE_UOM_RATE_AMOUNT_CART_DATA_WITH_PACK_SIZE(id, getEditRowId) { // mustafa
//         let getCartDataInputArray = document.getElementById(id),
//             cartData = JSON.parse(getCartDataInputArray.value),
//             code = document.getElementById(this._codeId),
//             title = document.getElementById(this._titleId),
//             warehouse_id = document.getElementById(this._warehouseIdd),
//             remarks = document.getElementById(this._remarksId),
//             rate = document.getElementById(this._rateId),
//             quantity = document.getElementById(this._quantityId),
//             pack_quantity = document.getElementById(this._quantityPackId),
//             loose_quantity = document.getElementById(this._quantityLooseId),
//             uom = document.getElementById(this._uomId),
//             packSize = document.getElementById(this._packSizeId),
//             amount = document.getElementById(this._amountId);
//
//         if (cartData[getEditRowId] !== '') {
//             getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(cartData[getEditRowId]));
//             getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
//             code.value = cartData[getEditRowId]['code'];
//             title.value = cartData[getEditRowId]['title'];
//             warehouse_id.value = cartData[getEditRowId]['warehouse_id'];
//             // uom.value = cartData[getEditRowId]['uom'];
//             // alert(uom.value);
//             // alert(cartData[getEditRowId]['uom']);
//             // packSize.value = cartData[getEditRowId]['packSize'];
//             pack_quantity.value = cartData[getEditRowId]['pack_quantity'];
//             loose_quantity.value = cartData[getEditRowId]['loose_quantity'];
//
//             /*
//                 *** for select2 options purpose
//              */
//             if (code.nextSibling.classList.contains('select2')) {
//                 $("#" + code.id).select2().trigger('change');
//             }
//             if (title.nextSibling.classList.contains('select2')) {
//                 $("#" + title.id).select2().trigger('change');
//             }
//             if (warehouse_id.nextSibling.classList.contains('select2')) {
//                 $("#" + warehouse_id.id).select2().trigger('change');
//             }
//             /*
//                 *** for select2 options purpose end
//              */
//
//
//             remarks.value = cartData[getEditRowId]['remarks'];
//             // rate.value = cartData[getEditRowId]['rate'];
//             quantity.value = cartData[getEditRowId]['quantity'];
//             amount.value = cartData[getEditRowId]['amount'];
//
//             //Delete Row In Cart Data
//             cartData.splice(getEditRowId, 1);
//         }
//         getCartDataInputArray.value = JSON.stringify(cartData);
//     }
//
//     /* ============== Edit Amount Data Method end ============== */
//
// }
//
//
// class crudController {
//     constructor(inputValuesArray, idForShowAndGetData) {
//         this.inputValuesArray = inputValuesArray;
//         this.idForShowAndGetData = idForShowAndGetData;
//     }
//
//     /* ==============                       ==============
//        Store all inventory values in Cart Data Array
//        This function use for all type of cart screens
//        ============== Store Data Method ============== */
//     createCartData() {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             cartData = [],
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Inputs Value pass to CREATE_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== '') {
//             id = getCrudModel._cartDataArrayId;
//             cartData = getCrudModel._cartDataArray;
//             getCrudModel.CREATE_CART_DATA(id, cartData);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Store Data Method end ============== */
//
//
//     /* ==============                    ==============
//        Delete one inventory row in Cart Data Array
//        This function use for all type of cart screens
//        ============== Delete Data Method ============== */
//     deleteRowInCardData(getDelRowId) {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index in Input(Cart Data Array) Number pass to DELETE_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getDelRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.DELETE_CART_DATA(id, getDelRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Delete Data Method end ============== */
//
//
//     /* ==============                    ==============
//        Update single row from cart Data
//        This function use for all type of cart screens
//        ============== Update Data Method ============== */
//     updateRowInCardData() {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             cartData = [],
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Inputs Value pass to UPDATE_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== '') {
//             id = getCrudModel._cartDataArrayId;
//             cartData = getCrudModel._cartDataArray;
//             getCrudModel.UPDATE_CART_DATA(id, cartData);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Update Data Method end ============== */
//
//
//     /* ==============                    ==============
//        Update single row from cart Data
//        This function use for all type of cart screens
//        ============== Update Data Method ============== */
//     updateRowInCardDataForWorkOrder() {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             cartData = [],
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Inputs Value pass to UPDATE_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== '') {
//             id = getCrudModel._cartDataArrayId;
//             cartData = getCrudModel._cartDataArray;
//             getCrudModel.UPDATE_CART_DATA_FOR_WORK_ORDER(id, cartData);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Update Data Method end ============== */
//
//
//     /* ==============                    ==============
//        Update single row from cart Data
//        This function use for all type of cart screens
//        ============== Cancel Data Method ============== */
//     cancelEditRowInCardData() {
//
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Inputs Value pass to UPDATE_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.CANCEL_EDIT_CART_DATA(id);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Cancel Data Method end ============== */
//
//
//     /* ==============                           ==============
//        Edit single row from quantity cart Data
//        This function use for only quantity cart screens
//        ============== Edit Quantity Data Method ============== */
//     editRowInCardData(getEditRowId) {
//
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_QUANTITY_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getEditRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.EDIT_QUANTITY_CART_DATA(id, getEditRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Edit Quantity Data Method end ============== */
//
//
//     /* ==============                           ==============
//        Edit single row from quantity cart Data
//        This function use for only quantity cart screens
//        ============== Edit Quantity Data Method ============== */
//     editRowInCardDataWithPackSize(getEditRowId) {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_QUANTITY_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getEditRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.EDIT_QUANTITY_CART_DATA_WITH_PACK_SIZE(id, getEditRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Edit Quantity Data Method end ============== */
//
//
//     /* ==============                         ==============
//        Edit single row from amount cart Data
//        This function use for only amount cart screens
//        ============== Edit Amount Data Method ============== */
//     editRowInCardDataForAmount(getEditRowId) {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_AMOUNT_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getEditRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.EDIT_AMOUNT_CART_DATA(id, getEditRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Edit Amount Data Method end ============== */
//
//
//     /* ==============                                   ==============
//        Edit single row from uom-rate-amount cart Data
//        This function use for only uom-rate-amount cart screens
//        ============== Edit UOM Rate Amount Data Method  ============== */
//     editRowInCardDataForUOMRateAmount(getEditRowId) {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_UOM_RATE_AMOUNT_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getEditRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.EDIT_UOM_RATE_AMOUNT_CART_DATA(id, getEditRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Edit UOM Rate Amount Data Method  end ============== */
//
//
//     /* ==============                                   ==============
//        Edit single row from uom-rate-amount cart Data
//        This function use for only uom-rate-amount cart screens
//        ============== Edit UOM Rate Amount Data Method  ============== */
//     editRowInCardDataForUOMRateAmountWithPackSize(getEditRowId) {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_UOM_RATE_AMOUNT_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getEditRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.EDIT_UOM_RATE_AMOUNT_CART_DATA_WITH_PACK_SIZE(id, getEditRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Edit UOM Rate Amount Data Method  end ============== */
//
//     /* ==============                                   ==============
//        Edit single row from uom-rate-amount cart Data
//        This function use for only uom-rate-amount cart screens
//        ============== Edit UOM Rate Amount Data Method  ============== */
//     editRowInCardDataForWarehousePackLooseUOMRateAmountWithPackSize(getEditRowId) {
//         let id = '',
//             /*
//                In getCrudModel variable,
//                Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
//             */
//             getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
//             getCartData = '';
//
//         /*
//            In this statement,
//            Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_UOM_RATE_AMOUNT_CART_DATA Module Method
//         */
//         if (getCrudModel._cartDataArrayId !== '' && getEditRowId !== '') {
//             id = getCrudModel._cartDataArrayId;
//             getCrudModel.EDIT_WAREHOUSE_UOM_RATE_AMOUNT_CART_DATA_WITH_PACK_SIZE(id, getEditRowId);
//         }
//
//         /*
//            In getCartData Array,
//            Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
//         */
//         getCartData = {
//             data: getCrudModel.GET_CART_DATA(id),
//         };
//         return getCartData;
//     }
//
//     /* ============== Edit UOM Rate Amount Data Method  end ============== */
//
//     /* ============== Button Event Control ==============
//        when user add inventory this function will handle button events
//        This function use for all type of cart screens
//        ============== Button Event Control ============== */
//     btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName) {
//         let checkMethod = (e === "loadContent") ? e : e.getAttribute('data-method'),
//             cartData = '';
//
//
//         if (checkMethod === "loadContent") {
//             cartData = this.createCartData();
//         } else if (checkMethod === "create") {
//             if (this.validateInventoryInputs(validateInputIdArray) === true) {
//                 cartData = this.createCartData();
//                 this.clearInputValues(this.idForShowAndGetData);
//             }
//         } else if (checkMethod === "edit") {
//             let getEditRowId = e.getAttribute('data-rowId');
//             cartData = this[editRowInCardDataMethodName](getEditRowId);
//
//             let getAddBtn = document.getElementById(this.idsArray['addBtnId']);
//             getAddBtn.setAttribute('data-method', 'update');
//             getAddBtn.innerHTML = '<i class="fa fa-plus"></i> Update';
//             let getCancelBtn = document.getElementById(this.idsArray['cancelBtnId']);
//             getCancelBtn.classList.remove('hide');
//             getCancelBtn.classList.add('show');
//         } else if (checkMethod === "update") {
//             if (this.validateInventoryInputs(validateInputIdArray) === true) {
//                 let getUpdateRowId = e.getAttribute('data-rowId');
//                 cartData = this.updateRowInCardData(getUpdateRowId);
//
//                 this.clearInputValues(this.idForShowAndGetData);
//                 let getAddBtn = document.getElementById(this.idsArray['addBtnId']);
//                 getAddBtn.setAttribute('data-method', 'create');
//                 getAddBtn.innerHTML = '<i class="fa fa-plus"></i> Add';
//                 let getCancelBtn = document.getElementById(this.idsArray['cancelBtnId']);
//                 getCancelBtn.classList.remove('show');
//                 getCancelBtn.classList.add('hide');
//             }
//         } else if (checkMethod === "delete") {
//             let getDelRowId = e.getAttribute('data-rowId');
//             cartData = this.deleteRowInCardData(getDelRowId);
//         } else if (checkMethod === "cancel") {
//             cartData = this.cancelEditRowInCardData();
//
//             this.clearInputValues(this.idForShowAndGetData);
//             let getAddBtn = document.getElementById(this.idsArray['addBtnId']);
//             getAddBtn.setAttribute('data-method', 'create');
//             getAddBtn.innerHTML = '<i class="fa fa-plus"></i> Add';
//             let getCancelBtn = document.getElementById(this.idsArray['cancelBtnId']);
//             getCancelBtn.classList.remove('show');
//             getCancelBtn.classList.add('hide');
//         } else if (checkMethod === "orderQuantityChange") {
//             cartData = this.updateRowInCardDataForWorkOrder();
//         }
//
//         return cartData;
//
//     }
//
//     /* ============== Button Event Control end ============== */
//
//
//     /* ==============                           ==============
//        when user add inventory this function will check which fields is require or not
//        This function use for all type of cart screens
//        ============== Validation Control Method ============== */
//     validateInventoryInputs(InputIdArray) {
//         let i = 0,
//             flag = false,
//             getInput = '';
//
//         for (i; i < InputIdArray.length; i++) {
//             if (InputIdArray) {
//                 getInput = document.getElementById(InputIdArray[i]);
//                 if (getInput.value === '' || getInput.value === 0) {
//                     getInput.focus();
//                     getInput.classList.add('alert_dangerous');
//                     flag = false;
//                     break;
//                 } else {
//                     getInput.classList.remove('alert_dangerous');
//                     flag = true;
//                 }
//             }
//         }
//         return flag;
//     }
//
//     /* ============== Validation Control Method end ============== */
//
//
//     clearInputValues(idsArray) {
//         let titleId = document.getElementById(idsArray['codeId']),
//             codeId = document.getElementById(idsArray['titleId']),
//             expenseAccountId = (idsArray['expenseAccountId']) ? document.getElementById(idsArray['expenseAccountId']) : '',
//             uomId = (idsArray['uomId']) ? document.getElementById(idsArray['uomId']) : '';
//
//
//         /*
//          *** for select2 options refresh purpose
//          */
//         if (idsArray['codeId']) {
//             codeId.value = '';
//             if (codeId.nextSibling.classList.contains('select2')) {
//                 $("#" + codeId.id).select2().trigger('change');
//             }
//         }
//         if (idsArray['titleId']) {
//             titleId.value = '';
//             if (titleId.nextSibling.classList.contains('select2')) {
//                 $("#" + titleId.id).select2().trigger('change');
//             }
//         }
//         if (idsArray['expenseAccountId']) {
//             expenseAccountId.value = '';
//             if (expenseAccountId.nextSibling.classList.contains('select2')) {
//                 $("#" + expenseAccountId.id).select2().trigger('change');
//             }
//         }
//         if (idsArray['uomId']) {
//             uomId.value = '';
//             // if(uomId.nextSibling.classList.contains('select2')){
//             //     $("#"+uomId.id).select2().trigger('change');
//             // }
//         }
//         /*
//          *** for select2 options refresh purpose end
//          */
//
//         if (idsArray['remarksId']) {
//             document.getElementById(idsArray['remarksId']).value = '';
//         }
//         if (idsArray['rateId']) {
//             document.getElementById(idsArray['rateId']).value = '';
//         }
//         if (idsArray['quantityId']) {
//             document.getElementById(idsArray['quantityId']).value = '';
//         }
//         if (idsArray['quantityPackId']) {
//             document.getElementById(idsArray['quantityPackId']).value = '';
//         }
//         if (idsArray['quantityLooseId']) {
//             document.getElementById(idsArray['quantityLooseId']).value = '';
//         }
//         if (idsArray['amountId']) {
//             document.getElementById(idsArray['amountId']).value = '';
//         }
//     }
//
// }
//
//
// class allMethodsController {
//     constructor(cartBundleArray) {
//         this.cartBundle = cartBundleArray;
//     }
//
//     countTotalQuantity() {
//         let quantityCount = 0;
//         let getCartDataArray = this.cartBundle['data'];
//         if (getCartDataArray) {
//             getCartDataArray.forEach(function (item, index) {
//                 quantityCount = parseFloat(quantityCount) + parseFloat(getCartDataArray[index]['quantity']);
//             });
//         }
//         return quantityCount;
//     }
//
//     countTotalAmount() {
//         let quantityCount = 0;
//         let getCartDataArray = this.cartBundle['data'];
//         if (getCartDataArray) {
//             getCartDataArray.forEach(function (item, index) {
//                 quantityCount = parseFloat(quantityCount) + parseFloat(getCartDataArray[index]['amount']);
//             });
//         }
//         return quantityCount;
//     }
//
// }
//
//
// class displayValuesInTable extends crudController {
//
//     constructor(inputValuesArray, idForShowAndGetData) {
//         super(inputValuesArray, idForShowAndGetData);
//         this.idsArray = idForShowAndGetData;
//
//     }
//
//
//     /*  Only Quantity base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Remarks, Quantity.
//     This is 5 columns base, you can choose your own column but be limit in
//     ======================= Quantity Method Start ====================== */
//     onlyQuantity(e, tableColumnsClasseArray, validateInputIdArray) {
//
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardData',
//             btnCallMethodName = this.idsArray['btnCallMethodName'],
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"> <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//
//                 // var byValue = document.querySelectorAll('input[value="'+  array[index]['code']  +'"]');
//                 //
//                 // byValue.disabled = true;
//                 // alert(byValue);
//
//                 // document.getElementById("primary_limited_product_code").onchange = function () {
//                 //     alert("akdfh");
//                 //
//                 // };
//
//
//                 // document.getElementById("primary_limited_product_code").options[array[index]['code']].disabled = true;
//                 // document.getElementById("primary_limited_product_code option[value=" + array[index]['code'] + "]").hidden = true;
//                 // document.getElementById("primary_limited_product_title option[value=" + array[index]['title'] + "]").read = "disabled";
//
//                 // jQuery("#primary_limited_product_code option[value=" + array[index]['code'] + "]").attr("disabled", false);
//                 // jQuery("#primary_limited_product_title option[value=" + array[index]['title'] + "]").attr("disabled", false);
//                 // alert(array[index]['code']);
//
//                 // jQuery("#pro_title option[value=" + array[index]['code'] + "]").attr("disabled", true);
//                 // jQuery('#pro_title option[value="' + '' + '"]').prop('selected', true);
//                 //
//                 // jQuery("#pro_title option[value=" + array[index]['code'] + "]").attr("disabled", true);
//                 // jQuery('#pro_title option[value="' + '' + '"]').prop('selected', true);
//
//             });
//             // alert(1);   //row insertion (use in product recipe)
//
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//
//             let allMethods = new allMethodsController(cartData);
//             document.getElementById(this.idsArray['ttlQuantity']).value = allMethods.countTotalQuantity();
//         }
//
//
//     }
//
//     // ======================= Quantity Method End ======================
//
//     /*  Only Quantity base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Remarks, Quantity.
//     This is 5 columns base, you can choose your own column but be limit in
//     ======================= Quantity Method Start ====================== */
//     onlyQuantityWithPackSize(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataWithPackSize',
//             btnCallMethodName = this.idsArray['btnCallMethodName'],
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"> <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(2);
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//             let allMethods = new allMethodsController(cartData);
//             document.getElementById(this.idsArray['ttlQuantity']).value = allMethods.countTotalQuantity();
//         }
//
//
//     }
//
//     // ======================= Quantity Method End ======================
//
//
//     /*  Only Quantity base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Remarks, Quantity.
//     This is 5 columns base, you can choose your own column but be limit in
//     ======================= Amount Method Start ====================== */
//     onlyForAmount(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForAmount',
//             btnCallMethodName = this.idsArray['btnCallMethodName'],
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(3);
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//             let allMethods = new allMethodsController(cartData);
//             document.getElementById(this.idsArray['ttlAmount']).value = allMethods.countTotalAmount();
//         }
//
//
//     }
//
//     // ======================= Amount Method End ======================
//
//
//     /*  Only UOM Rate Quantity Amount base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
//     This is 9 columns base, you can choose your own column but be limit in
//     ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
//     onlyForUOMRateAmount(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
//             btnCallMethodName = this.idsArray['btnCallMethodName'],
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['expenseAccountClass'] + '">' + array[index]['expenseAccountText'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uomText'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"> <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(4);
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//             let allMethods = new allMethodsController(cartData),
//                 countTotalAmount = allMethods.countTotalAmount();
//             document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(3);
//             document.getElementById("overHeadGrandView").innerText = countTotalAmount.toFixed(3);
//         }
//
//
//     }
//
//     // ======================= UOM-Rate-Quantity-Amount Method End ======================
//
//
//     /*  Only UOM Rate Quantity Amount base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
//     This is 9 columns base, you can choose your own column but be limit in
//     ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
//     onlyForUOMRateAmountWithPackSize(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmountWithPackSize',
//             btnCallMethodName = this.idsArray['btnCallMethodName'],
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"> <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(5);
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//             let allMethods = new allMethodsController(cartData),
//                 countTotalAmount = allMethods.countTotalAmount();
//             document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(2);
//             document.getElementById(this.idsArray['ttlAmountViewId']).innerText = countTotalAmount.toFixed(2);
//         }
//
//
//     }
//
//     // ======================= Warehouse-Pack-Loose-Quantity-UOM-Rate-Quantity-Amount Method End ======================
//
//
//     /*  Only UOM Rate Quantity Amount base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
    // This is 9 columns base, you can choose your own column but be limit in
    // ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
    // onlyForWarehousePackLooseUOMRateAmountWithPackSize(e, tableColumnsClasseArray, validateInputIdArray) {
    //     let array = [],
    //         row = '',
    //         i = 0,
    //         sr = 1,
    //         editRowInCardDataMethodName = 'editRowInCardDataForWarehousePackLooseUOMRateAmountWithPackSize',
    //         btnCallMethodName = this.idsArray['btnCallMethodName'],
    //         cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
    //
    //     if (cartData) {
    //         array = cartData['data'];
    //         array.forEach(function (item, index) {
    //             row += '<tr class="edit_update">';
    //             row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
    //             row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
    //             row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
    //             row += '<td class="' + tableColumnsClasseArray['warehouseTitleClass'] + '">' + array[index]['warehouse_title'] + '</td>';
    //             row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
    //             row += '<td align="center" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + '</td>';
    //             row += '<td align="center" class="' + tableColumnsClasseArray['packQuantityClass'] + '">' + array[index]['pack_quantity'] + '</td>';
    //             row += '<td align="center" class="' + tableColumnsClasseArray['looseQuantityClass'] + '">' + array[index]['loose_quantity'] + '</td>';
    //             row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
    //             row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' </td>';
    //             // row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + '</td>';
    //             // row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + '</td>';
    //             row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"> <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
    //             row += '</tr>';
    //             i++;
    //             sr++;
    //         });
    //         // alert(5);
    //         array = [];
    //         document.getElementById(this.idsArray['tblListId']).innerHTML = row;
    //
    //         let allMethods = new allMethodsController(cartData);
    //         document.getElementById(this.idsArray['ttlQuantity']).value = allMethods.countTotalQuantity();
    //
    //         let allMethodss = new allMethodsController(cartData),
    //             countTotalAmount = allMethodss.countTotalAmount();
    //         document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(2);
    //         // document.getElementById(this.idsArray['ttlAmountViewId']).innerText = countTotalAmount.toFixed(2);
    //     }
    // }
//
//     // ======================= UOM-Rate-Quantity-Amount Method End ======================
//
//
//     /*  Only UOM Rate Quantity Amount base column data display,
//     Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
//     This is 9 columns base, you can choose your own column but be limit in
//     ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
//     onlyForUOMRateAmountWithPackSizeForInputs(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmountWithPackSize',
//             btnCallMethodName = this.idsArray['btnCallMethodName'],
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['quantityClass'] + '">' +
//                     '<input type="text" class="inputs_up_tbl" onkeypress="return allow_only_number_and_decimals(this,event);" value="' + array[index]['quantity'] + '">' +
//                     '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' +
//                     '<input type="text" class="inputs_up_tbl" onkeypress="return allow_only_number_and_decimals(this,event);" value="' + array[index]['rate'] + '">' +
//                     '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"></td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(6);
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//             let allMethods = new allMethodsController(cartData),
//                 countTotalAmount = allMethods.countTotalAmount();
//             document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(2);
//             document.getElementById(this.idsArray['ttlAmountViewId']).innerText = countTotalAmount.toFixed(2);
//         }
//
//
//     }
//
//     // ======================= UOM-Rate-Quantity-Amount Method End ======================
//
//
//     /*  Only For Work Order When Primary Goods Call & Print,
//     Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
//     This is 8 columns base, you can choose your own column but be limit in
//     ======================= Work-Order Primary Goods Method Start ====================== */
//     onlyForPrimaryGoods(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 // let orderQuantity = ( array[index]['orderQuantity'] === 0 || array[index]['orderQuantity'] <= array[index]['quantity'] ) ? array[index]['quantity'] : array[index]['orderQuantity'];
//                 // let ttl_quantity = parseFloat( orderQuantity ) + parseFloat( array[index]['availableQuantity'] );
//
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['productionQtyClass'] + '">' + array[index]['quantity'] + '</td>';
//                 // row += '<td align="right" class="' + tableColumnsClasseArray['stockBeforeProductionClass'] + '">' + array[index]['stockBeforeProduction'] + '</td>';
//                 // row += '<td align="right" class="' + tableColumnsClasseArray['stockAfterProductionClass'] + '">' + array[index]['stockAfterProduction'] + ' </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(7);   //work order
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//         }
//
//
//     }
//
//     // ======================= Work-Order Primary Goods Method End ======================
//
//
//     /*  Only For Work Order When Secondary Goods Call & Print,
//     Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
//     This is 8 columns base, you can choose your own column but be limit in
//     ======================= Work-Order Secondary Goods Method Start ====================== */
//     onlyForSecondaryGoods(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 // let qty = parseFloat( array[index]['quantity'] ),
//                 //     qty_percentage = qty / parseFloat( array[index]['primaryFinishedGoodsQty'] ) * 100,
//                 //     ttl_quantity = ( parseFloat( array[index]['orderQuantity'] ) * qty_percentage ) / 100,
//                 //     stockWillBe = parseFloat( array[index]['availableQuantity'] ) + ttl_quantity;
//
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['productionQtyClass'] + '">' + array[index]['quantity'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['percentageClass'] + '">' + array[index]['qtyPercentage'] + '% </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['ttlQtyClass'] + '">' + array[index]['ttlQuantity'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['stockBeforeProductionClass'] + '">' + array[index]['availableQuantity'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['stockAfterProductionClass'] + '">' + array[index]['stockAfterProduction'] + ' </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(8);  //work order
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//         }
//
//
//     }
//
//     // ======================= Work-Order Secondary Goods Method End ======================
//
//
//     /*  Only For Work Order When Budgeted Raw Call & Print,
//     Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
//     This is 8 columns base, you can choose your own column but be limit in
//     ======================= Work-Order Secondary Goods Method Start ====================== */
//     onlyForBudgetedRaw(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 // let qty = parseFloat( array[index]['quantity'] ),
//                 //     qty_percentage = qty / parseFloat( array[index]['primaryFinishedGoodsQty'] ) * 100,
//                 //     ttl_quantity = ( parseFloat( array[index]['orderQuantity'] ) * qty_percentage ) / 100;
//
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['productionQtyClass'] + '">' + array[index]['quantity'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['percentageClass'] + '">' + array[index]['qtyPercentage'] + '% </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['ttlQtyClass'] + '">' + array[index]['ttlQuantity'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['inHandClass'] + '">' + array[index]['availableQuantity'] + '</td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(9);  work order
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//         }
//
//
//     }
//
//     // ======================= Work-Order Secondary Goods Method End ======================
//
//
//     /*  Only For Work Order When Budgeted Raw Call & Print,
//     Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
//     This is 8 columns base, you can choose your own column but be limit in
//     ======================= Work-Order Secondary Goods Method Start ====================== */
//     onlyForRawStockCosting(e, tableColumnsClasseArray, validateInputIdArray) {
//         let array = [],
//             row = '',
//             i = 0,
//             sr = 1,
//             editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
//             cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);
//
//         if (cartData) {
//             array = cartData['data'];
//             array.forEach(function (item, index) {
//                 // let qty = parseFloat( array[index]['quantity'] ),
//                 //     qty_percentage = qty / parseFloat( array[index]['primaryFinishedGoodsQty'] ) * 100,
//                 //     ttl_quantity = ( parseFloat( array[index]['orderQuantity'] ) * qty_percentage ) / 100,
//                 //     rateType = (array[index]['rateType'] === 0) ? parseFloat( array[index]['lastPurchaseRate'] ) : parseFloat( array[index]['averageRate'] ),
//                 //     ttl_amount = ttl_quantity * rateType;
//                 // grandTtl = ttl_amount + parseFloat(grandTtl);
//
//                 row += '<tr class="edit_update">';
//                 row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
//                 row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['qtyClass'] + '">' + array[index]['ttlQuantity'] + '</td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + ' </td>';
//                 row += '<td align="right" class="' + tableColumnsClasseArray['totalClass'] + '">' + array[index]['amount'] + ' </td>';
//                 row += '</tr>';
//                 i++;
//                 sr++;
//             });
//             // alert(10);   //work order
//             array = [];
//             document.getElementById(this.idsArray['tblListId']).innerHTML = row;
//
//             let allMethods = new allMethodsController(cartData),
//                 countTotalAmount = allMethods.countTotalAmount();
//             document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(3);
//             document.getElementById("stockCostingGrandView").innerText = countTotalAmount.toFixed(3);
//         }
//
//
//     }
//
//     // ======================= Work-Order Secondary Goods Method End ======================
//
// }
//
//
// function quantityRateMultiply(rate, qty, amount) {
//     let getRateId = document.getElementById(rate),
//         getQuantityId = document.getElementById(qty),
//         getAmountId = document.getElementById(amount),
//         quantityAmount = (getQuantityId.value) ? getQuantityId.value : 1,
//         rateAmount = (getRateId.value) ? getRateId.value : 0;
//     getAmountId.value = rateAmount * quantityAmount;
// }
//



class variableProperty {
    constructor( inputValuesArray, getIdForShowAndGetData ){

        /* create variable to get input values for elements */
        this.code = inputValuesArray['code'];
        this.title = inputValuesArray['title'];
        this.expenseAccount = inputValuesArray['expenseAccount'];
        this.remarks = inputValuesArray['remarks'];
        this.rate = inputValuesArray['rate'];
        this.quantity = inputValuesArray['quantity'];
        this.uom = inputValuesArray['uom'];
        this.packSize = inputValuesArray['packSize'];
        this.amount = inputValuesArray['amount'];
        this.cartDataArray = inputValuesArray;
        this.idArray = getIdForShowAndGetData;
        /* create variable to get input values for elements end */

        /* create Id's variable for all elements */
        this.codeId = getIdForShowAndGetData['codeId'];
        this.titleId = getIdForShowAndGetData['titleId'];
        this.expenseAccountId = getIdForShowAndGetData['expenseAccountId'];
        this.remarksId = getIdForShowAndGetData['remarksId'];
        this.rateId = getIdForShowAndGetData['rateId'];
        this.quantityId = getIdForShowAndGetData['quantityId'];
        this.uomId = getIdForShowAndGetData['uomId'];
        this.packSizeId = getIdForShowAndGetData['packSizeId'];
        this.amountId = getIdForShowAndGetData['amountId'];
        this.tblListId = getIdForShowAndGetData['tblListId'];
        this.cartDataArrayId = getIdForShowAndGetData['cartDataArrayId'];
        /* create Id's variable for all elements end */


    }

    /* ================================
        Get Variables value when needed
       ================================ */
    get proCode(){
        return this.code;
    }

    get proTitle(){
        return this.title;
    }

    get proExpenseAccount(){
        return this.expenseAccount;
    }

    get proRemarks(){
        return this.remarks;
    }

    get proRate(){
        return this.rate;
    }

    get proQuantity(){
        return this.quantity;
    }

    get proUom(){
        return this.uom;
    }

    get proPackSize(){
        return this.packSize;
    }

    get proAmount(){
        return this.amount;
    }

    get _codeId(){
        return this.codeId;
    }

    get _titleId(){
        return this.titleId;
    }

    get _expenseAccountId(){
        return this.expenseAccountId;
    }

    get _remarksId(){
        return this.remarksId;
    }

    get _rateId(){
        return this.rateId;
    }

    get _quantityId(){
        return this.quantityId;
    }

    get _uomId(){
        return this.uomId;
    }

    get _packSizeId(){
        return this.packSizeId;
    }

    get _amountId(){
        return this.amountId;
    }

    get _tblListId(){
        return this.tblListId;
    }

    get _cartDataArrayId(){
        return this.cartDataArrayId;
    }

    get _cartDataArray(){
        return this.cartDataArray;
    }

    get _idArray(){
        return this.idArray;
    }


    /* ================================
        Set Variables value
       ================================ */
    set proCode(x){
        this.code = x;
    }

    set proTitle(x){
        this.title = x;
    }

    set proExpenseAccount(x){
        this.expenseAccount = x;
    }

    set proRemarks(x){
        this.remarks = x;
    }

    set proRate(x){
        this.rate = x;
    }

    set proQuantity(x){
        this.quantity = x;
    }

    set proUom(x){
        this.uom = x;
    }

    set proPackSize(x){
        this.packSize = x;
    }

    set proAmount(x){
        this.amount = x;
    }

    set _codeId(x){
        this.codeId = x;
    }

    set _titleId(x){
        this.titleId = x;
    }

    set _expenseAccountId(x){
        this.expenseAccountId = x;
    }

    set _remarksId(x){
        this.remarksId = x;
    }

    set _rateId(x){
        this.rateId = x;
    }

    set _quantityId(x){
        this.quantityId = x;
    }

    set _uomId(x){
        this.uomId = x;
    }

    set _packSizeId(x){
        this.packSizeId = x;
    }

    set _amountId(x){
        this.amountId = x;
    }

    set _tblListId(x){
        this.tblListId = x;
    }

    set _cartDataArrayId(x){
        this.cartDataArrayId = x;
    }

    set _cartDataArray(x){
        this.cartDataArray = x;
    }

    set _idArray(x){
        this.idArray = x;
    }


}

class DataCrudModel extends variableProperty{
    constructor( inputValuesArray, idForShowAndGetData ){
        super( inputValuesArray, idForShowAndGetData );
    }


    /* ============== Get Data Method ==============
       This function use for all type cart screens
       ============== Get Data Method ============== */
    GET_CART_DATA( id ) {
        let cartDataArray = document.getElementById(id),
            getData = JSON.parse(cartDataArray.value);
        return getData;
    }
    /* ============== Get Data Method End ============== */


    /* ============== Store Data Method ==============
       This function use for all type cart screens
       ============== Store Data Method ============== */
    CREATE_CART_DATA( id, cartData ) {
        let sampleArray = [],
            cartDataInputArray = document.getElementById(id);

        if( cartDataInputArray.value !== '') {
            sampleArray = JSON.parse(cartDataInputArray.value);
        }
        sampleArray.push(cartData);
        cartDataInputArray.value = JSON.stringify(sampleArray);
    }
    /* ============== Store Data Method End ============== */


    /* ============== Delete Data Method ==============
       Delete single row from cart Data
       This function use for all type cart screens
       ============== Delete Data Method ============== */
    DELETE_CART_DATA( id, getDelRowId ) {
        let getCartDataInputArray = document.getElementById(id),
            cartData = JSON.parse( getCartDataInputArray.value );

        if( cartData[getDelRowId] !== '') {
            cartData.splice( getDelRowId, 1 );
        }
        getCartDataInputArray.value = JSON.stringify(cartData);
    }
    /* ============== Delete Data Method end ============== */


    /* ==============                    ==============
       Update single row from cart Data
       This function use for all type cart screens
       ============== Update Data Method ============== */
    UPDATE_CART_DATA( id, cartData ) {
        let sampleArray = [],
            cartDataInputArray = document.getElementById(id),
            editUpdateRowIndex = cartDataInputArray.getAttribute('data-editUpdateRowIndex');

        if( cartDataInputArray.value !== '') {
            sampleArray = JSON.parse(cartDataInputArray.value);
        }
        sampleArray.splice( editUpdateRowIndex, 0, cartData );
        cartDataInputArray.value = JSON.stringify(sampleArray);
    }
    /* ============== Update Data Method end ============== */


    /* ==============                    ==============
       Update single row from cart Data
       This function use for Work Order Screen
       ============== Update Data Method For Work Order ============== */
    UPDATE_CART_DATA_FOR_WORK_ORDER( id, cartData ) {
        let sampleArray = [],
            cartDataInputArray = document.getElementById(id),
            editUpdateRowIndex = cartDataInputArray.getAttribute('data-editUpdateRowIndex');

        if( cartDataInputArray.value !== '') {
            sampleArray = JSON.parse(cartDataInputArray.value);
        }
        sampleArray.splice( editUpdateRowIndex, 1, cartData );
        cartDataInputArray.value = JSON.stringify(sampleArray);
    }
    /* ============== Update Data Method For Work Order end ============== */


    /* ==============                    ==============
       Cancel update inventory row from cart Data
       This function use for all type cart screens
       ============== Cancel Data Method ============== */
    CANCEL_EDIT_CART_DATA( id ) {
        let sampleArray = [],
            cartDataInputArray = document.getElementById(id),
            getEditUpdateRow = cartDataInputArray.getAttribute('data-editUpdateValues'),
            editUpdateRowIndex = cartDataInputArray.getAttribute('data-editUpdateRowIndex');

        if( cartDataInputArray.value !== '') {
            sampleArray = JSON.parse(cartDataInputArray.value);
        }
        sampleArray.splice( editUpdateRowIndex, 0, JSON.parse( getEditUpdateRow ) );
        cartDataInputArray.value = JSON.stringify(sampleArray);
        cartDataInputArray.setAttribute('data-editUpdateValues', '');
        cartDataInputArray.setAttribute('data-editUpdateRowIndex', '');
    }
    /* ============== Cancel Data Method end ============== */


    /* ==============                           ==============
       Edit single row from quantity cart Data
       This function use for only quantity cart screens
       ============== Edit Quantity Data Method ============== */
    EDIT_QUANTITY_CART_DATA_WITH_PACK_SIZE( id, getEditRowId ) {
        let getCartDataInputArray = document.getElementById(id),
            cartData = JSON.parse( getCartDataInputArray.value ),
            code = document.getElementById(this._codeId),
            title = document.getElementById(this._titleId),
            remarks = document.getElementById(this._remarksId),
            quantity = document.getElementById(this._quantityId),
            uom = document.getElementById(this._uomId),
            packSize = document.getElementById(this._packSizeId);

        if( cartData[getEditRowId] !== '') {
            getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(  cartData[getEditRowId] ) );
            getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
            code.value = cartData[getEditRowId]['code'];
            title.value = cartData[getEditRowId]['title'];
            uom.value = cartData[getEditRowId]['uom'];
            packSize.value = cartData[getEditRowId]['packSize'];

            /*
                *** for select2 options purpose
             */
            if(code.nextSibling.classList.contains('select2')){
                $("#"+code.id).select2().trigger('change');
            }
            if(title.nextSibling.classList.contains('select2')){
                $("#"+title.id).select2().trigger('change');
            }
            /*
                *** for select2 options purpose end
             */


            remarks.value = cartData[getEditRowId]['remarks'];
            quantity.value = cartData[getEditRowId]['quantity'];

            //Delete Row In Cart Data
            cartData.splice( getEditRowId, 1 );
        }
        getCartDataInputArray.value = JSON.stringify(cartData);
    }
    /* ============== Edit Quantity Data Method end ============== */



    /* ==============                         ==============
       Edit single row from amount cart Data
       This function use for only amount cart screens
       ============== Edit Amount Data Method ============== */
    EDIT_AMOUNT_CART_DATA( id, getEditRowId ) {
        let getCartDataInputArray = document.getElementById(id),
            cartData = JSON.parse( getCartDataInputArray.value ),
            code = document.getElementById(this._codeId),
            title = document.getElementById(this._titleId),
            remarks = document.getElementById(this._remarksId),
            amount = document.getElementById(this._amountId);

        if( cartData[getEditRowId] !== '') {
            getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(  cartData[getEditRowId] ) );
            getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
            code.value = cartData[getEditRowId]['code'];
            title.value = cartData[getEditRowId]['title'];

            /*
                *** for select2 options purpose
             */
            if(code.nextSibling.classList.contains('select2')){
                $("#"+code.id).select2().trigger('change');
            }
            if(title.nextSibling.classList.contains('select2')){
                $("#"+title.id).select2().trigger('change');
            }
            /*
                *** for select2 options purpose end
             */


            remarks.value = cartData[getEditRowId]['remarks'];
            amount.value = cartData[getEditRowId]['amount'];

            //Delete Row In Cart Data
            cartData.splice( getEditRowId, 1 );
        }
        getCartDataInputArray.value = JSON.stringify(cartData);
    }
    /* ============== Edit Amount Data Method end ============== */



    /* ==============                                             ==============
       Edit single row from amount cart Data
       This function use for only amount cart screens
       ============== Edit Amount Data Method For Uom Rate Amount ============== */
    EDIT_UOM_RATE_AMOUNT_CART_DATA( id, getEditRowId ) {
        let getCartDataInputArray = document.getElementById(id),
            cartData = JSON.parse( getCartDataInputArray.value ),
            code = document.getElementById(this._codeId),
            title = document.getElementById(this._titleId),
            expenseAccount = document.getElementById(this._expenseAccountId),
            remarks = document.getElementById(this._remarksId),
            rate = document.getElementById(this._rateId),
            quantity = document.getElementById(this._quantityId),
            uom = document.getElementById(this._uomId),
            amount = document.getElementById(this._amountId);

        if( cartData[getEditRowId] !== '') {
            getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(  cartData[getEditRowId] ) );
            getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
            code.value = cartData[getEditRowId]['code'];
            title.value = cartData[getEditRowId]['title'];
            expenseAccount.value = cartData[getEditRowId]['expenseAccount'];
            uom.value = cartData[getEditRowId]['uom'];

            /*
                *** for select2 options purpose
             */
            if(code.nextSibling.classList.contains('select2')){
                $("#"+code.id).select2().trigger('change');
            }
            if(title.nextSibling.classList.contains('select2')){
                $("#"+title.id).select2().trigger('change');
            }
            if(expenseAccount.nextSibling.classList.contains('select2')){
                $("#"+expenseAccount.id).select2().trigger('change');
            }
            if(uom.nextSibling.classList.contains('select2')){
                $("#"+uom.id).select2().trigger('change');
            }
            /*
                *** for select2 options purpose end
             */


            remarks.value = cartData[getEditRowId]['remarks'];
            rate.value = cartData[getEditRowId]['rate'];
            quantity.value = cartData[getEditRowId]['quantity'];
            amount.value = cartData[getEditRowId]['amount'];

            //Delete Row In Cart Data
            cartData.splice( getEditRowId, 1 );
        }
        getCartDataInputArray.value = JSON.stringify(cartData);
    }
    /* ============== Edit Amount Data Method end ============== */


    /* ==============                                             ==============
       Edit single row from amount cart Data
       This function use for only amount cart screens
       ============== Edit Amount Data Method For Uom Rate Amount ============== */
    EDIT_UOM_RATE_AMOUNT_CART_DATA_WITH_PACK_SIZE( id, getEditRowId ) {
        let getCartDataInputArray = document.getElementById(id),
            cartData = JSON.parse( getCartDataInputArray.value ),
            code = document.getElementById(this._codeId),
            title = document.getElementById(this._titleId),
            remarks = document.getElementById(this._remarksId),
            rate = document.getElementById(this._rateId),
            quantity = document.getElementById(this._quantityId),
            uom = document.getElementById(this._uomId),
            packSize = document.getElementById(this._packSizeId),
            amount = document.getElementById(this._amountId);

        if( cartData[getEditRowId] !== '') {
            getCartDataInputArray.setAttribute('data-editUpdateValues', JSON.stringify(  cartData[getEditRowId] ) );
            getCartDataInputArray.setAttribute('data-editUpdateRowIndex', getEditRowId);
            code.value = cartData[getEditRowId]['code'];
            title.value = cartData[getEditRowId]['title'];
            uom.value = cartData[getEditRowId]['uom'];
            packSize.value = cartData[getEditRowId]['packSize'];

            /*
                *** for select2 options purpose
             */
            if(code.nextSibling.classList.contains('select2')){
                $("#"+code.id).select2().trigger('change');
            }
            if(title.nextSibling.classList.contains('select2')){
                $("#"+title.id).select2().trigger('change');
            }
            /*
                *** for select2 options purpose end
             */


            remarks.value = cartData[getEditRowId]['remarks'];
            rate.value = cartData[getEditRowId]['rate'];
            quantity.value = cartData[getEditRowId]['quantity'];
            amount.value = cartData[getEditRowId]['amount'];

            //Delete Row In Cart Data
            cartData.splice( getEditRowId, 1 );
        }
        getCartDataInputArray.value = JSON.stringify(cartData);
    }
    /* ============== Edit Amount Data Method end ============== */


}


class crudController {
    constructor( inputValuesArray, idForShowAndGetData ){
        this.inputValuesArray = inputValuesArray;
        this.idForShowAndGetData = idForShowAndGetData;
    }

    /* ==============                       ==============
       Store all inventory values in Cart Data Array
       This function use for all type of cart screens
       ============== Store Data Method ============== */
    createCartData(){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            cartData = [],
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Inputs Value pass to CREATE_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== ''){
            id = getCrudModel._cartDataArrayId;
            cartData = getCrudModel._cartDataArray;
            getCrudModel.CREATE_CART_DATA(id, cartData);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Store Data Method end ============== */


    /* ==============                    ==============
       Delete one inventory row in Cart Data Array
       This function use for all type of cart screens
       ============== Delete Data Method ============== */
    deleteRowInCardData(getDelRowId){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Row Index in Input(Cart Data Array) Number pass to DELETE_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getDelRowId !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.DELETE_CART_DATA(id, getDelRowId);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Delete Data Method end ============== */


    /* ==============                    ==============
       Update single row from cart Data
       This function use for all type of cart screens
       ============== Update Data Method ============== */
    updateRowInCardData(){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            cartData = [],
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Inputs Value pass to UPDATE_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== ''){
            id = getCrudModel._cartDataArrayId;
            cartData = getCrudModel._cartDataArray;
            getCrudModel.UPDATE_CART_DATA(id, cartData);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Update Data Method end ============== */


    /* ==============                    ==============
       Update single row from cart Data
       This function use for all type of cart screens
       ============== Update Data Method ============== */
    updateRowInCardDataForWorkOrder(){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            cartData = [],
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Inputs Value pass to UPDATE_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== ''){
            id = getCrudModel._cartDataArrayId;
            cartData = getCrudModel._cartDataArray;
            getCrudModel.UPDATE_CART_DATA_FOR_WORK_ORDER(id, cartData);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Update Data Method end ============== */


    /* ==============                    ==============
       Update single row from cart Data
       This function use for all type of cart screens
       ============== Cancel Data Method ============== */
    cancelEditRowInCardData(){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Inputs Value pass to UPDATE_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getCrudModel._cartDataArray !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.CANCEL_EDIT_CART_DATA(id);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Cancel Data Method end ============== */


    /* ==============                           ==============
       Edit single row from quantity cart Data
       This function use for only quantity cart screens
       ============== Edit Quantity Data Method ============== */
    editRowInCardData(getEditRowId){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_QUANTITY_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getEditRowId !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.EDIT_QUANTITY_CART_DATA(id, getEditRowId);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Edit Quantity Data Method end ============== */



    /* ==============                           ==============
       Edit single row from quantity cart Data
       This function use for only quantity cart screens
       ============== Edit Quantity Data Method ============== */
    editRowInCardDataWithPackSize(getEditRowId){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_QUANTITY_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getEditRowId !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.EDIT_QUANTITY_CART_DATA_WITH_PACK_SIZE(id, getEditRowId);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Edit Quantity Data Method end ============== */


    /* ==============                         ==============
       Edit single row from amount cart Data
       This function use for only amount cart screens
       ============== Edit Amount Data Method ============== */
    editRowInCardDataForAmount(getEditRowId){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_AMOUNT_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getEditRowId !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.EDIT_AMOUNT_CART_DATA(id, getEditRowId);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Edit Amount Data Method end ============== */


    /* ==============                                   ==============
       Edit single row from uom-rate-amount cart Data
       This function use for only uom-rate-amount cart screens
       ============== Edit UOM Rate Amount Data Method  ============== */
    editRowInCardDataForUOMRateAmount(getEditRowId){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_UOM_RATE_AMOUNT_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getEditRowId !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.EDIT_UOM_RATE_AMOUNT_CART_DATA(id, getEditRowId);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Edit UOM Rate Amount Data Method  end ============== */


    /* ==============                                   ==============
       Edit single row from uom-rate-amount cart Data
       This function use for only uom-rate-amount cart screens
       ============== Edit UOM Rate Amount Data Method  ============== */
    editRowInCardDataForUOMRateAmountWithPackSize(getEditRowId){
        let id = '',
            /*
               In getCrudModel variable,
               Model Class Fetch & give both of arrays(Inputs Value Array, Id's Array)
            */
            getCrudModel = new DataCrudModel(this.inputValuesArray, this.idForShowAndGetData),
            getCartData = '';

        /*
           In this statement,
           Get Input(Cart Data Array) Id & Row Index of Input(Cart Data Array) Number pass to EDIT_UOM_RATE_AMOUNT_CART_DATA Module Method
        */
        if(getCrudModel._cartDataArrayId !== '' && getEditRowId !== ''){
            id = getCrudModel._cartDataArrayId;
            getCrudModel.EDIT_UOM_RATE_AMOUNT_CART_DATA_WITH_PACK_SIZE(id, getEditRowId);
        }

        /*
           In getCartData Array,
           Fetch All Records from Input(Cart Data Array) from GET_CART_DATA Module Method & store into it.
        */
        getCartData = {
            data: getCrudModel.GET_CART_DATA(id),
        };
        return getCartData;
    }
    /* ============== Edit UOM Rate Amount Data Method  end ============== */


    /* ============== Button Event Control ==============
       when user add inventory this function will handle button events
       This function use for all type of cart screens
       ============== Button Event Control ============== */
    btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName){
        let checkMethod = (e === "loadContent") ? e : e.getAttribute('data-method'),
            cartData = '';


        if( checkMethod === "loadContent"){
            cartData = this.createCartData();
        }
        else if( checkMethod === "create"){
            if( this.validateInventoryInputs(validateInputIdArray) === true ) {
                cartData = this.createCartData();
                this.clearInputValues(this.idForShowAndGetData);
            }
        }
        else if( checkMethod === "edit"){
            let getEditRowId = e.getAttribute('data-rowId');
            cartData = this[editRowInCardDataMethodName]( getEditRowId );

            let getAddBtn = document.getElementById(this.idsArray['addBtnId']);
            getAddBtn.setAttribute('data-method', 'update');
            getAddBtn.innerHTML = '<i class="fa fa-plus"></i> Update';
            let getCancelBtn = document.getElementById(this.idsArray['cancelBtnId']);
            getCancelBtn.classList.remove('hide');
            getCancelBtn.classList.add('show');
        }
        else if( checkMethod === "update"){
            if( this.validateInventoryInputs(validateInputIdArray) === true ) {
                let getUpdateRowId = e.getAttribute('data-rowId');
                cartData = this.updateRowInCardData(getUpdateRowId);

                this.clearInputValues(this.idForShowAndGetData);
                let getAddBtn = document.getElementById(this.idsArray['addBtnId']);
                getAddBtn.setAttribute('data-method', 'create');
                getAddBtn.innerHTML = '<i class="fa fa-plus"></i> Add';
                let getCancelBtn = document.getElementById(this.idsArray['cancelBtnId']);
                getCancelBtn.classList.remove('show');
                getCancelBtn.classList.add('hide');
            }
        }
        else if( checkMethod === "delete"){
            let getDelRowId = e.getAttribute('data-rowId');
            cartData = this.deleteRowInCardData( getDelRowId );
        }
        else if( checkMethod === "cancel"){
            cartData = this.cancelEditRowInCardData();

            this.clearInputValues(this.idForShowAndGetData);
            let getAddBtn = document.getElementById(this.idsArray['addBtnId']);
            getAddBtn.setAttribute('data-method', 'create');
            getAddBtn.innerHTML = '<i class="fa fa-plus"></i> Add';
            let getCancelBtn = document.getElementById(this.idsArray['cancelBtnId']);
            getCancelBtn.classList.remove('show');
            getCancelBtn.classList.add('hide');
        }
        else if( checkMethod === "orderQuantityChange"){
            cartData = this.updateRowInCardDataForWorkOrder();
        }

        return cartData;

    }
    /* ============== Button Event Control end ============== */


    /* ==============                           ==============
       when user add inventory this function will check which fields is require or not
       This function use for all type of cart screens
       ============== Validation Control Method ============== */
    validateInventoryInputs(InputIdArray) {
        let i = 0,
            flag = false,
            getInput = '';

        for (i; i<InputIdArray.length; i++){
            if( InputIdArray ) {
                getInput = document.getElementById(InputIdArray[i]);
                if (getInput.value === '' || getInput.value === 0) {
                    getInput.focus();
                    getInput.classList.add('alert_dangerous');
                    flag = false;
                    break;
                } else {
                    getInput.classList.remove('alert_dangerous');
                    flag = true;
                }
            }
        }
        return flag;
    }
    /* ============== Validation Control Method end ============== */



    clearInputValues(idsArray) {
        let titleId = document.getElementById(idsArray['codeId']),
            codeId = document.getElementById(idsArray['titleId']),
            expenseAccountId = ( idsArray['expenseAccountId'] ) ? document.getElementById(idsArray['expenseAccountId']) : '',
            uomId = ( idsArray['uomId'] ) ? document.getElementById(idsArray['uomId']) : '';


        /*
         *** for select2 options refresh purpose
         */
        if(idsArray['codeId']){
            codeId.value = '';
            if(codeId.nextSibling.classList.contains('select2')){
                $("#"+codeId.id).select2().trigger('change');
            }
        }
        if(idsArray['titleId']){
            titleId.value = '';
            if(titleId.nextSibling.classList.contains('select2')){
                $("#"+titleId.id).select2().trigger('change');
            }
        }
        if(idsArray['expenseAccountId']){
            expenseAccountId.value = '';
            if(expenseAccountId.nextSibling.classList.contains('select2')){
                $("#"+expenseAccountId.id).select2().trigger('change');
            }
        }
        if(idsArray['uomId']){
            uomId.value = '';
            // if(uomId.nextSibling.classList.contains('select2')){
            //     $("#"+uomId.id).select2().trigger('change');
            // }
        }
        /*
         *** for select2 options refresh purpose end
         */

        if(idsArray['remarksId']){
            document.getElementById(idsArray['remarksId']).value = '';
        }
        if(idsArray['rateId']){
            document.getElementById(idsArray['rateId']).value = '';
        }
        if(idsArray['quantityId']){
            document.getElementById(idsArray['quantityId']).value = '';
        }
        if(idsArray['amountId']){
            document.getElementById(idsArray['amountId']).value = '';
        }
    }

}


class allMethodsController {
    constructor( cartBundleArray ){
        this.cartBundle = cartBundleArray;
    }

    countTotalQuantity(){
        let quantityCount = 0;
        let getCartDataArray = this.cartBundle['data'];
        if(getCartDataArray){
            getCartDataArray.forEach(function (item, index) {
                quantityCount = parseFloat(quantityCount) + parseFloat( getCartDataArray[index]['quantity'] );
            });
        }
        return quantityCount;
    }

    countTotalAmount(){
        let quantityCount = 0;
        let getCartDataArray = this.cartBundle['data'];
        if(getCartDataArray){
            getCartDataArray.forEach(function (item, index) {
                quantityCount = parseFloat(quantityCount) + parseFloat( getCartDataArray[index]['amount'] );
            });
        }
        return quantityCount;
    }

}




class displayValuesInTable extends crudController{
    constructor( inputValuesArray, idForShowAndGetData ){
        super( inputValuesArray, idForShowAndGetData );
        this.idsArray = idForShowAndGetData;
    }


    /*  Only Quantity base column data display,
    Columns are Sr, Product/Account Code, Product/Account Name, Remarks, Quantity.
    This is 5 columns base, you can choose your own column but be limit in
    ======================= Quantity Method Start ====================== */
    onlyQuantity(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardData',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData);
            document.getElementById(this.idsArray['ttlQuantity']).value = allMethods.countTotalQuantity();
        }


    }
    // ======================= Quantity Method End ======================

    /*  Only Quantity base column data display,
    Columns are Sr, Product/Account Code, Product/Account Name, Remarks, Quantity.
    This is 5 columns base, you can choose your own column but be limit in
    ======================= Quantity Method Start ====================== */
    onlyQuantityWithPackSize(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataWithPackSize',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData);
            document.getElementById(this.idsArray['ttlQuantity']).value = allMethods.countTotalQuantity();
        }


    }
    // ======================= Quantity Method End ======================


    /*  Only Quantity base column data display,
    Columns are Sr, Product/Account Code, Product/Account Name, Remarks, Quantity.
    This is 5 columns base, you can choose your own column but be limit in
    ======================= Amount Method Start ====================== */
    onlyForAmount(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForAmount',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData);
            document.getElementById(this.idsArray['ttlAmount']).value = allMethods.countTotalAmount();
        }


    }
    // ======================= Amount Method End ======================


    /*  Only UOM Rate Quantity Amount base column data display,
    Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
    This is 9 columns base, you can choose your own column but be limit in
    ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
    onlyForUOMRateAmount(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['expenseAccountClass'] + '">' + array[index]['expenseAccountText'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uomText'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData),
                countTotalAmount = allMethods.countTotalAmount();
            document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(3);
            document.getElementById("overHeadGrandView").innerText = countTotalAmount.toFixed(3);
        }


    }
    // ======================= UOM-Rate-Quantity-Amount Method End ======================


    /*  Only UOM Rate Quantity Amount base column data display,
    Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
    This is 9 columns base, you can choose your own column but be limit in
    ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
    onlyForUOMRateAmountWithPackSize(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmountWithPackSize',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="center" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData),
                countTotalAmount = allMethods.countTotalAmount();
            document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(2);
            document.getElementById(this.idsArray['ttlAmountViewId']).innerText = countTotalAmount.toFixed(2);
        }


    }
    // ======================= UOM-Rate-Quantity-Amount Method End ======================


    /*  Only UOM Rate Quantity Amount base column data display,
    Columns are Sr, Product/Account Code, Product/Account Name, Expense Account, Remarks, Rate, Quantity, UOM, Amount.
    This is 9 columns base, you can choose your own column but be limit in
    ======================= UOM-Rate-Quantity-Amount Method Start ====================== */
    onlyForUOMRateAmountWithPackSizeForInputs(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmountWithPackSize',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="center" class="' + tableColumnsClasseArray['quantityClass'] + '">' +
                    '<input type="text" class="inputs_up_tbl" onkeypress="return allow_only_number_and_decimals(this,event);" value="'+ array[index]['quantity'] +'">' +
                    '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' +
                    '<input type="text" class="inputs_up_tbl" onkeypress="return allow_only_number_and_decimals(this,event);" value="'+ array[index]['rate'] +'">' +
                    '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + ' <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="'+ btnCallMethodName +'(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData),
                countTotalAmount = allMethods.countTotalAmount();
            document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(2);
            document.getElementById(this.idsArray['ttlAmountViewId']).innerText = countTotalAmount.toFixed(2);
        }


    }
    // ======================= UOM-Rate-Quantity-Amount Method End ======================


    /*  Only For Work Order When Primary Goods Call & Print,
    Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
    This is 8 columns base, you can choose your own column but be limit in
    ======================= Work-Order Primary Goods Method Start ====================== */
    onlyForPrimaryGoods(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                // let orderQuantity = ( array[index]['orderQuantity'] === 0 || array[index]['orderQuantity'] <= array[index]['quantity'] ) ? array[index]['quantity'] : array[index]['orderQuantity'];
                // let ttl_quantity = parseFloat( orderQuantity ) + parseFloat( array[index]['availableQuantity'] );

                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['productionQtyClass'] + '">' + array[index]['quantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['stockBeforeProductionClass'] + '">' + array[index]['stockBeforeProduction'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['stockAfterProductionClass'] + '">' + array[index]['stockAfterProduction'] + ' </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;
        }


    }
    // ======================= Work-Order Primary Goods Method End ======================



    /*  Only For Work Order When Secondary Goods Call & Print,
    Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
    This is 8 columns base, you can choose your own column but be limit in
    ======================= Work-Order Secondary Goods Method Start ====================== */
    onlyForSecondaryGoods(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                // let qty = parseFloat( array[index]['quantity'] ),
                //     qty_percentage = qty / parseFloat( array[index]['primaryFinishedGoodsQty'] ) * 100,
                //     ttl_quantity = ( parseFloat( array[index]['orderQuantity'] ) * qty_percentage ) / 100,
                //     stockWillBe = parseFloat( array[index]['availableQuantity'] ) + ttl_quantity;

                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['productionQtyClass'] + '">' + array[index]['quantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['percentageClass'] + '">' + array[index]['qtyPercentage'] + '% </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['ttlQtyClass'] + '">' + array[index]['ttlQuantity'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['stockBeforeProductionClass'] + '">' + array[index]['availableQuantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['stockAfterProductionClass'] + '">' + array[index]['stockAfterProduction'] + ' </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;
        }


    }
    // ======================= Work-Order Secondary Goods Method End ======================




    /*  Only For Work Order When Budgeted Raw Call & Print,
    Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
    This is 8 columns base, you can choose your own column but be limit in
    ======================= Work-Order Secondary Goods Method Start ====================== */
    onlyForBudgetedRaw(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                // let qty = parseFloat( array[index]['quantity'] ),
                //     qty_percentage = qty / parseFloat( array[index]['primaryFinishedGoodsQty'] ) * 100,
                //     ttl_quantity = ( parseFloat( array[index]['orderQuantity'] ) * qty_percentage ) / 100;

                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['productionQtyClass'] + '">' + array[index]['quantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['percentageClass'] + '">' + array[index]['qtyPercentage'] + '% </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['ttlQtyClass'] + '">' + array[index]['ttlQuantity'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['inHandClass'] + '">' + array[index]['availableQuantity'] + '</td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;
        }


    }
    // ======================= Work-Order Secondary Goods Method End ======================




    /*  Only For Work Order When Budgeted Raw Call & Print,
    Columns are Sr, Code, Title, Remarks, UOM, Recipe Production Qty, Stock Before Production, Stock After Production.
    This is 8 columns base, you can choose your own column but be limit in
    ======================= Work-Order Secondary Goods Method Start ====================== */
    onlyForRawStockCosting(e, tableColumnsClasseArray, validateInputIdArray){
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForUOMRateAmount',
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if(cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                // let qty = parseFloat( array[index]['quantity'] ),
                //     qty_percentage = qty / parseFloat( array[index]['primaryFinishedGoodsQty'] ) * 100,
                //     ttl_quantity = ( parseFloat( array[index]['orderQuantity'] ) * qty_percentage ) / 100,
                //     rateType = (array[index]['rateType'] === 0) ? parseFloat( array[index]['lastPurchaseRate'] ) : parseFloat( array[index]['averageRate'] ),
                //     ttl_amount = ttl_quantity * rateType;
                // grandTtl = ttl_amount + parseFloat(grandTtl);

                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['qtyClass'] + '">' + array[index]['ttlQuantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + ' </td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['totalClass'] + '">' + array[index]['amount'] + ' </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData),
                countTotalAmount = allMethods.countTotalAmount();
            document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(3);
            document.getElementById("stockCostingGrandView").innerText = countTotalAmount.toFixed(3);
        }


    }
    // ======================= Work-Order Secondary Goods Method End ======================
    onlyForWarehousePackLooseUOMRateAmountWithPackSize(e, tableColumnsClasseArray, validateInputIdArray) {
        let array = [],
            row = '',
            i = 0,
            sr = 1,
            editRowInCardDataMethodName = 'editRowInCardDataForWarehousePackLooseUOMRateAmountWithPackSize',
            btnCallMethodName = this.idsArray['btnCallMethodName'],
            cartData = this.btnEventControl(e, validateInputIdArray, editRowInCardDataMethodName);

        if (cartData) {
            array = cartData['data'];
            array.forEach(function (item, index) {
                row += '<tr class="edit_update">';
                row += '<td align="center" class="' + tableColumnsClasseArray['srClass'] + '">' + sr + '</td>';
                row += '<td class="' + tableColumnsClasseArray['codeClass'] + '">' + array[index]['code'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['titleClass'] + '">' + array[index]['title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['warehouseTitleClass'] + '">' + array[index]['warehouse_title'] + '</td>';
                row += '<td class="' + tableColumnsClasseArray['remarksClass'] + '">' + array[index]['remarks'] + '</td>';
                row += '<td align="center" class="' + tableColumnsClasseArray['quantityClass'] + '">' + array[index]['quantity'] + '</td>';
                row += '<td align="center" class="' + tableColumnsClasseArray['packQuantityClass'] + '">' + array[index]['pack_quantity'] + '</td>';
                row += '<td align="center" class="' + tableColumnsClasseArray['looseQuantityClass'] + '">' + array[index]['loose_quantity'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['uomClass'] + '">' + array[index]['uom'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['packSizeClass'] + '">' + array[index]['packSize'] + ' </td>';
                // row += '<td align="right" class="' + tableColumnsClasseArray['rateClass'] + '">' + array[index]['rate'] + '</td>';
                // row += '<td align="right" class="' + tableColumnsClasseArray['amountClass'] + '">' + array[index]['amount'] + '</td>';
                row += '<td align="right" class="' + tableColumnsClasseArray['actionClass'] + '"> <div class="edit_update_bx"> <a class="edit_link btn btn-sm btn-success" data-rowId="' + i + '" data-method="edit" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-edit"></i> </a> <a class="delete_link btn btn-sm btn-danger" data-rowId="' + i + '" data-method="delete" onclick="' + btnCallMethodName + '(this)"> <i class="fa fa-trash"></i> </a> </div> </td>';
                row += '</tr>';
                i++;
                sr++;
            });
            // alert(5);
            array = [];
            document.getElementById(this.idsArray['tblListId']).innerHTML = row;

            let allMethods = new allMethodsController(cartData);
            document.getElementById(this.idsArray['ttlQuantity']).value = allMethods.countTotalQuantity();

            let allMethodss = new allMethodsController(cartData),
                countTotalAmount = allMethodss.countTotalAmount();
            document.getElementById(this.idsArray['ttlAmountId']).value = countTotalAmount.toFixed(2);
            // document.getElementById(this.idsArray['ttlAmountViewId']).innerText = countTotalAmount.toFixed(2);
        }
    }
}

function quantityRateMultiply(rate, qty, amount){
    let getRateId = document.getElementById(rate),
        getQuantityId = document.getElementById(qty),
        getAmountId = document.getElementById(amount),
        quantityAmount = ( getQuantityId.value ) ? getQuantityId.value : 1,
        rateAmount = ( getRateId.value ) ? getRateId.value : 0;
    getAmountId.value = rateAmount * quantityAmount;
}

