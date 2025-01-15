<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $divisions,
                'modal' => 'modals/division_modal',
                'id' => $division_id,
                'title' => 'Division',
                'search_id' => 'division_search',
                'columns' => ['No', 'Name', 'Nick Name' ,  'Action'],
                'column_vals' => ['name'  ,'nick_name'],
            ])
        </div>
    </div>
</div>
