(function ($) {
	("use strict");

	// Migrate walkers button call id = migrate-walkers
	$( document ).ready(
		function () {
			$( "#migrate-servers" ).on(
				"click",
				function (e) {
					e.preventDefault();
					// Confirmar antes de realizar la acción
					if ( ! confirm( "¿Estás seguro de que deseas migrar los datos?" )) {
						return;
					}

					const ajaxurl = wp_easy_tables_servers_ajax.ajax_url;

					console.log( { ajaxurl } );

					// Realizar la solicitud AJAX
					$.ajax(
						{
							url: ajaxurl, // ajaxurl es proporcionado por WordPress
							type: "POST",
							data: {
								action: "migrate_servers",
							},
							success: function (response) {
								if (response.success) {
									alert( "Migración completada. " + response.data.message );
								} else {
									alert( "Migración fallida. " + response.data.message );
								}
							},
							error: function (xhr, status, error) {
								alert( "Ocurrió un error durante la migración." );
							},
						}
					);
				}
			);
		}
	);

	// export walkers button call id = export-walkers
	$( document ).ready(
		function () {
			$( "#export-servers" ).on(
				"click",
				function (e) {
					e.preventDefault();
					// Confirmar antes de realizar la acción
					if ( ! confirm( "¿Estás seguro de que deseas exportar los datos?" )) {
						return;
					}

					// Redirigir a la URL de exportación
					window.location.href = "/wp-json/wp-easy-tables/v1/export-servers";
				}
			);
		}
	);
})( jQuery );
