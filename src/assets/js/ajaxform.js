function AjaxForm(formSelector) {

    var selectors = [];

    function init(formSelector) {
        addFormListeners(formSelector);
        selectors.push(formSelector);
    }

    function hasSelector(allSelectors, selector) {
        var filteredSelectors = allSelectors.filter(function (checkedSelector) {
            return checkedSelector === selector;
        });
        return filteredSelectors.length > 0;
    }

    function addFormListeners(form, skipCheck) {
        if (skipCheck || !hasSelector(selectors, form)) {
            $("body").on('change', form + " :input", function() {
                $(this).closest('form').submit();
            });
        }
    }

    this.addForm = function (formSelector) {
        addFormListeners(formSelector);
        selectors = selectors.concat(formSelector);
    };
    init(formSelector);
}