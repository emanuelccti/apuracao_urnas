var $table = $('.dt-bootstrap-table');

$table.attr('data-toggle', 'table');
$table.attr('data-search', 'true');
$table.attr('data-show-columns', 'true');
$table.attr('data-show-toggle', 'true');
$table.attr('data-show-fullscreen', 'true');
$table.attr('data-show-export', 'true');
$table.attr('data-pagination', 'true');
$table.attr('data-page-list', '[10, 25, 50, 100, all]');
$table.attr('data-show-refresh', 'true');

function initTable() {
	$table.bootstrapTable('destroy').bootstrapTable({
		locale: 'pt-BR',
		exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel'],
		formatToggleOn: function() {
			return 'Mostrar visualização de cartão';
		},
		exportOptions: {
			fileName: function() {
				return 'documents';
			}
		},
		
		icons: {
			paginationSwitchDown: 'fa fa-caret-square-down',
			paginationSwitchUp: 'fa fa-caret-square-up',
			refresh: 'fa fa-sync',
			toggleOff: 'fa fa-toggle-off',
			toggleOn: 'fa fa-toggle-on',
			columns: 'fa fa-th-list',
			fullscreen: 'fa fa-arrows-alt',
			detailOpen: 'fa fa-plus-circle',
			detailClose: 'fa fa-minus-circle',
			export: 'fa fa-download'
		},
	});

}

$(function () {
	initTable();
});