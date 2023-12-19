function bpFieldInitChecklist(element) {
    var hidden_input = element.find('input[type=hidden]');
    var selected_options = JSON.parse(hidden_input.val() || '[]');
    var checkboxes = element.find('input[type=checkbox]');
    var container = element.find('.row');

    // set the default checked/unchecked states on checklist options
    checkboxes.each(function(key, option) {
      var id = $(this).val();

      if (selected_options.map(String).includes(id)) {
        $(this).prop('checked', 'checked');
      } else {
        $(this).prop('checked', false);
      }
    });

    // when a checkbox is clicked
    // set the correct value on the hidden input
    checkboxes.click(function() {
      var newValue = [];

      checkboxes.each(function() {
        if ($(this).is(':checked')) {
          var id = $(this).val();
          newValue.push(id);
        }
      });

      hidden_input.val(JSON.stringify(newValue)).trigger('change');

    });

    hidden_input.on('CrudField:disable', function(e) {
          checkboxes.attr('disabled', 'disabled');
      });

    hidden_input.on('CrudField:enable', function(e) {
        checkboxes.removeAttr('disabled');
    });

}

        