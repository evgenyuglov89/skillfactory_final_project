@extends('layouts.app')

@section('content')

<main class="form-signin m-auto">
    <h2>Список offer-ов</h2>
    <a type="button" class="btn btn-outline-primary my-8" href="{{ route('new_offer') }}">Новый offer</a>

    <table
    id="table"
    data-toggle="table"
    data-side-pagination="server"
    data-pagination="true"
    data-show-refresh="true"
    data-show-columns="true"
    data-filter-control="true"
    data-min-height=400
    data-page-list="[25, 50, 100]"
    data-page-size="25"
    data-url="/get_offers_advertiser"
    data-sort-name="created_at"
    data-toolbar="#toolbar"
    data-query-params="qryParams"
    data-click-to-select="true"
    data-sort-order="desc">
    <thead>
        <tr>
            <th data-field="name">Название offer-a</th>
            <th data-field="url">URL</th>
            <th data-field="cost">Стоимость перехода</th>
            <th data-field="theme">Тема</th>
            <th data-field="subscribers_number">Кол-во подписчиков</th>
            <th data-field="status">Статус</th>
            <th data-field="created_at">Дата создания</th>
            <th data-field="changed_user">Редактирование</th>
            <th data-field="changed_status">Смена статуса</th>
        </tr>
    </thead>
    </table>
</main>

@endsection

@section('js')
<script type="text/javascript">

$("#table").on("change", '.switch__input', function(e) {
    if($(this).is(":checked"))
        url = "/change_offer_status/activate/" + $(this).val();
    else
        url = "/change_offer_status/deactivate/" + $(this).val();

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
