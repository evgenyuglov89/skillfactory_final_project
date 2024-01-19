@extends('layouts.app')

@section('content')

<main class="form-signin m-auto">
    <h2>Список активных offer-ов</h2>

    <table
    id="table"
    data-toggle="table"
    data-pagination="true"
    data-show-refresh="true"
    data-show-columns="true"
    data-filter-control="true"
    data-min-height=400
    data-page-list="[25, 50, 100]"
    data-page-size="50"
    data-url="/get_offers_webmaster"
    data-sort-name="created_at"
    data-sort-order="desc"
    data-toolbar="#toolbar"
    data-query-params="qryParams"
    data-click-to-select="true">
    <thead>
        <tr>
            <th data-field="name">Название offer-а</th>
            <th data-field="cost">Стоимость перехода</th>
            <th data-field="theme">Тема</th>
            <th data-field="owner">Рекламодатель</th>
            <th data-field="created_at">Дата создания</th>
            <th data-field="link">Ссылка</th>
            <th data-field="actions">Действия</th>
        </tr>
    </thead>
    </table>
</main>

@endsection

@section('js')
<script type="text/javascript">

$("#table").on("change", '.switch__input', function(e) {
    if($(this).is(":checked"))
        url = "/subscribe/" + $(this).val();
    else
        url = "/unsubscribe/" + $(this).val();

    $.ajax({
        url: url,
        type: 'GET',
        success : function(msg) {
            $('#table').bootstrapTable('refresh', {silent: false});
        }, error:function () {
            console.log('error');
        }
    });
});

</script>

@endsection
