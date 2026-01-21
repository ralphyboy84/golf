(function ($) {
  "use strict";

  $(document).ready(function () {
    // loadSelectBoxes();
  });
})(jQuery);

function loadSelectBoxes() {
  $("#multiple-checkboxes, #regionSelect, #clubsSelect").multiselect({
    includeSelectAllOption: false,
  });
}
