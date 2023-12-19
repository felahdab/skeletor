function bpFieldInitCheckbox(element) {
    var hidden_element = element.siblings('input[type=hidden]');
    var id = 'checkbox_'+Math.floor(Math.random() * 1000000);

    // make sure the value is a boolean (so it will pass validation)
    if (hidden_element.val() === '') hidden_element.val(0).trigger('change');

    // set unique IDs so that labels are correlated with inputs
    element.attr('id', id);
    element.siblings('label').attr('for', id);

    // set the default checked/unchecked state
    // if the field has been loaded with javascript
    if (hidden_element.val() != 0) {
      element.prop('checked', 'checked');
    } else {
      element.prop('checked', false);
    }

    hidden_element.on('CrudField:disable', function(e) {
      element.prop('disabled', true);
    });
    hidden_element.on('CrudField:enable', function(e) {
      element.removeAttr('disabled');
    });

    // when the checkbox is clicked
    // set the correct value on the hidden input
    element.change(function() {
      if (element.is(":checked")) {
        hidden_element.val(1).trigger('change');
      } else {
        hidden_element.val(0).trigger('change');
      }
    })
}

        