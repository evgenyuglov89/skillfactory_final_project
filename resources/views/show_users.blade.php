@extends('layouts.app')

@section('content')

<main class="form-signin m-auto">
    <h2>Список пользователей</h2>
    <a type="button" class="btn btn-outline-primary my-8" href="{{ route('new_user') }}">Новый пользователь</a>

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
    data-url="/get_users"
    data-sort-name="created_at"
    data-sort-order="desc"
    data-toolbar="#toolbar"
    data-query-params="qryParams"
    data-click-to-select="true">
    <thead>
        <tr>
            <th data-field="id">ID</th>
            <th data-field="name">Имя</th>
            <th data-field="email">Почта</th>
            <th data-field="role">Роль</th>
            <th data-field="created_at">Дата создания</th>
            <th data-field="status">Статус</th>
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
        url = "/change_user_status/activate/" + $(this).val();
    else
        url = "/change_user_status/deactivate/" + $(this).val();

    $.ajax({
        url: url,
        type: 'GET',
        success : function(msg) {
            if(msg === "ok"){
                $('#table').bootstrapTable('refresh', {silent: false});
                return;
            }
        }, error:function () {
            console.log('error');
        }
    });
});

</script>

@endsection
