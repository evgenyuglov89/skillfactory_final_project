@extends('layouts.app')

@section('content')

<main class="form-signin m-auto">
    <h2>Статистика системы</h2>
    <button type="button" class="btn btn-success" id="create_links">Выданные ссылки</button>
    <button type="button" class="btn btn-success" id="click_links">Переходы по ссылкам</button>
    <table
    id="table"
    data-toggle="table"
    data-pagination="true"
    data-show-refresh="true"
    data-show-columns="true"
    data-filter-control="true"
    data-min-height=400
    data-page-list="[25, 50, 100]"
    data-page-size="25"
    data-url="/get_admin_statistics/create_links"
    data-sort-name="created_at"
    data-sort-order="desc"
    data-toolbar="#toolbar"
    data-query-params="qryParams"
    data-click-to-select="true">
    <thead>
        <tr>
            <th data-field="name">Название offer-а</th>
            <th data-field="link">Ссылка</th>
            <th data-field="advertiser_name">Имя рекламодателя</th>
            <th data-field="webmaster_name">Имя веб-мастера</th>
            <th data-field="created_at">Дата выдачи ссылки</th>
            <th data-field="status">Статус ссылки</th>
        </tr>
    </thead>
    </table>
</main>

@endsection

@section('js')
<script type="text/javascript">

$("#create_links").click("", function(e) {
    $("#table").bootstrapTable('destroy');
    $("#table thead tr").html('');
    $("#table thead tr").append('<th data-field="name">Название offer-а</th>');
    $("#table thead tr").append('<th data-field="link">Ссылка</th>');
    $("#table thead tr").append('<th data-field="advertiser_name">Имя рекламодателя</th>');
    $("#table thead tr").append('<th data-field="webmaster_name">Имя веб-мастера</th>');
    $("#table thead tr").append('<th data-field="created_at">Дата выдачи ссылки</th>');
    $("#table thead tr").append('<th data-field="status">Статус ссылки</th>');
    $("#table").bootstrapTable();
    $('#table').bootstrapTable('refresh', {url: '/get_admin_statistics/create_links'});
});
$("#click_links").click("", function(e) {
    $("#table").bootstrapTable('destroy');
    $("#table thead tr").html('');
    $("#table thead tr").append('<th data-field="name">Название offer-а</th>');
    $("#table thead tr").append('<th data-field="link">Ссылка</th>');
    $("#table thead tr").append('<th data-field="created_at">Дата перехода</th>');
    $("#table thead tr").append('<th data-field="status">Статус перехода</th>');
    $("#table").bootstrapTable();
    $('#table').bootstrapTable('refresh', {url: '/get_admin_statistics/click_links'});
});

</script>

@endsection
