(function ($) {
  ("use strict");

  // Migrate walkers button call id = migrate-walkers
  $(document).ready(function () {
    $("#migrate-walkers").on("click", function (e) {
      e.preventDefault();
      // Confirmar antes de realizar la acción
      if (!confirm("¿Estás seguro de que deseas migrar los datos?")) {
        return;
      }

      const ajaxurl = wp_easy_tables_ajax.ajax_url;

      // Realizar la solicitud AJAX
      $.ajax({
        url: ajaxurl, // ajaxurl es proporcionado por WordPress
        type: "POST",
        data: {
          action: "migrate_walkers",
        },
        success: function (response) {
          if (response.success) {
            alert("Migración completada. " + response.data.message);
          } else {
            alert("Migración fallida. " + response.data.message);
          }
        },
        error: function (xhr, status, error) {
          alert("Ocurrió un error durante la migración.");
        },
      });
    });
  });
})(jQuery);
