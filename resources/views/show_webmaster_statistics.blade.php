@extends('layouts.app')

@section('content')

<main class="form-signin m-auto">
    <h2>Статистика </h2>
    <button type="button" class="btn btn-success" id="day">За день</button>
    <button type="button" class="btn btn-success" id="month">За месяц</button>
    <button type="button" class="btn btn-success" id="year">За год</button>
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
    data-url="/get_webmaster_statistics/day"
    data-sort-name="name"
    data-sort-order="desc"
    data-toolbar="#toolbar"
    data-query-params="qryParams"
    data-click-to-select="true">
    <thead>
        <tr>
            <th data-field="name">Название offer-а</th>
            <th data-field="redirect_count">Кол-во переходов</th>
            <th data-field="redirect_success_count">Кол-во успешных переходов</th>
            <th data-field="costs">Доход</th>
        </tr>
    </thead>
    </table>
</main>

@endsection

@section('js')
<script type="text/javascript">

$("#day").click("", function(e) {
    $('#table').bootstrapTable('refresh', {url: '/get_webmaster_statistics/day'});
});
$("#month").click("", function(e) {
    $('#table').bootstrapTable('refresh', {url: '/get_webmaster_statistics/month'});
});
$("#year").click("", function(e) {
    $('#table').bootstrapTable('refresh', {url: '/get_webmaster_statistics/year'});
});

</script>

@endsection
