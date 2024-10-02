<link href="<?= base_url('assets/bootstrap-table/bootstrap-table.min.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/bootstrap-table/tableExport.min.js') ?>"></script>

<script src="<?= base_url('assets/bootstrap-table/jspdf.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-table/jspdf.plugin.autotable.js') ?>"></script>

<script src="<?= base_url('assets/bootstrap-table/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-table/pdfmake/vfs_fonts.js') ?>"></script>

<script src="<?= base_url('assets/bootstrap-table/bootstrap-table.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-table/bootstrap-table-locale-all.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-table/bootstrap-table-export.min.js') ?>"></script>

<script>
    const ARRAY_ICONS = {
        refresh: 'fa fa-refresh',
        export: 'fa fa-download',
        refresh: 'fa fa-refresh',
        detailOpen: 'bx bx-plus-circle',
        detailClose: 'bx bx-minus-circle'
    }
    $table = $('#table');
    var type = 'fa';

    function submitFiltrar() {
        event.preventDefault();
        $('.table_datatable').bootstrapTable('refresh');
    }


    function queryParams(params) {
        params = params;
        $('.column_filter').each(function(chave, item) {
            params[item.name] = $(item).val();
        });
        return params;
    }

    function queryParamsInput(params) {
        params = params;
        $('#formDatatableIndex input').each(function(chave, item) {
            params[item.name] = $(item).val();
        });
        $('#formDatatableIndex select').each(function(chave, item) {
            params[item.name] = $(item).val();
        });
        return params;
    }

    function loadingTemplate(message) {
        if (type === 'fa') {
            return '<a class="ph-item">Carregando, aguarde <span class="fa fa-spinner fa-spin fa-fw fa-2x"></span><a>';
        }
        if (type === 'pl') {
            return '<a class="ph-item"><span class="ph-picture"></span></a>';
        }
    }

    function ajaxRequest(params) {
        console.log(params)
        var url = URL_REQUISICAO_DATATABLE;
        $.get(url + '?', $.param(params.data)).then(function(res) {
            params.success(res);
        });
    }

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            icons: {
                refresh: 'fa fa-refresh',
                export: 'fa fa-download',
                refresh: 'fa fa-refresh',
                detailOpen: 'bx bx-plus-circle',
                detailClose: 'bx bx-minus-circle'
            },
            locale: "pt-br",
            pageList: "[10, 25, 50, 100, 200, All]"
        });
    }

    $(function() {
        initTable();
        setInterval(function(){
            initTable();
        }, 5000)
    });
</script>
