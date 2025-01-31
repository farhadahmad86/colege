/* Select2 Helper Functions */

window.disableSelect2Value = (filedName, value) => {
    destroySelect2(filedName);
    $(filedName + ' option[value="' + value + '"]').prop('disabled', true);
    initSelect2(filedName);
};

window.enableSelect2Value = (filedName, value) => {
    destroySelect2(filedName);
    $(filedName + ' option[value="' + value + '"]').prop('disabled', false);
    initSelect2(filedName);
};

window.clearSelect2Single = (filedNames) => {
    $.each(filedNames, function (index, fieldName) {
        $(fieldName).val('').change();
    });
};

window.addDataToSelect2 = (filedName, dataName, dataValue) => {
    destroySelect2(filedName);
    $(filedName).data(dataName, dataValue);
    initSelect2(filedName);
};

window.getDataFromSelect2 = (filedName, dataName) => {
    destroySelect2(filedName);
    $(filedName).data(dataName);
    initSelect2(filedName);
};

window.changeSelect2Value = (filedName, value) => {
    destroySelect2(filedName);
    $(filedName).val(value);
    initSelect2(filedName);
};


window.destroySelect2 = (filedName) => {
    console.log('adsasdasdasdsad end');
    $(filedName).select2('destroy');
};

window.initSelect2 = (filedName) => {
    $(filedName).select2({
        // theme: "bootstrap",
    });
};

window.initSelect2WithTemplate = (filedName, template_data, placeholder = '') => {
    $(filedName).select2({
        theme: "bootstrap",
        placeholder: placeholder,
        data: template_data,
        escapeMarkup: function(markup) {
            return markup;
        },
        templateResult: function(data) {
            return data.html;
        },
        templateSelection: function(data) {
            return data.text;
        }
    });
};

window.getDataAttributeFromSelect2Option = (filedName, dataName) => {
    return $(filedName).find(":selected").data(dataName);
    // return $(filedName).select2().find(":selected").data(dataName);
};

window.selectMultipleSelect2Options = (filedName, values) => {
    destroySelect2(filedName);
    $(filedName).val(values);
    initSelect2(filedName);
};window.selectMultipleSelect2OptionsTemplate = (filedName, values, template_data, placeholder = '') => {
    destroySelect2(filedName);
    $(filedName).val(values);
    initSelect2WithTemplate(filedName, template_data, placeholder);
};

window.updateSelect2WithNewOptions = (filedName, options) => {
    destroySelect2(filedName);
    $(filedName).html('');
    $(filedName).html(options);
    initSelect2(filedName);
};


