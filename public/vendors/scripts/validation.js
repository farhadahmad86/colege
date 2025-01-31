

 function alertMessageShow (InputIdArray, rule_message) {
    // create a new div element
    const newDiv = document.createElement("span");
    // and give it some content
    const newContent = document.createTextNode(rule_message);
    // add the text node to the newly created div
    newDiv.appendChild(newContent);
    // add the newly created element and its content into the DOM
    const currentDiv = document.getElementById(InputIdArray);
     // document.body.insertBefore(newDiv, currentDiv);
     $("<span id='"+InputIdArray+"_alert' style='color: red; font-size: 13px'>"+rule_message+"</span>").insertBefore(currentDiv);
 }


/* ==============                           ==============
   when user add inventory this function will check which fields is require or not
   This function use for all type of cart screens
   ============== Validation Control Method ============== */
function validateInventoryInputs(InputIdArray) {
    let i = 0,
        flag = false,
        getInput = '',
        rule_required = '',
        enabled = '',
        rule_message = '';
    for (i; i<InputIdArray.length; i++){
        if( InputIdArray ) {
            getInput = document.getElementById(InputIdArray[i]);
            rule_required = getInput.getAttribute('data-rule-required');
            enabled = document.getElementById(InputIdArray[i]).disabled;
            rule_message = getInput.getAttribute("data-msg-required");
            const old_span = document.getElementById(InputIdArray[i]+"_alert");
            if(rule_required && !enabled){
                if (getInput.value === '' || getInput.value === 0 || getInput.value === '0' || getInput.value === 0.00 || getInput.value === '0.00' || !getInput.value.trim()) {
                    // getInput.focus();
                    if( typeof(old_span) !== 'undefined' && old_span !== null ){
                        old_span.remove();
                    }
                    alertMessageShow(InputIdArray[i], rule_message);
                    getInput.classList.add('alert_dangerous');
                    flag = false;
                    break;
                } else {
                    if( typeof(old_span) !== 'undefined' && old_span !== null ){
                        old_span.remove();
                    }
                    getInput.classList.remove('alert_dangerous');
                    $('#save').attr('disabled', true);
                    flag = true;
                }
            }
        }
    }
    return flag;
}
/* ============== Validation Control Method end ============== */

