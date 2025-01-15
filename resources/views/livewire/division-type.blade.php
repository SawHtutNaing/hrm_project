<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $division_types,
                'modal' => 'modals/division_type_modal',
                'id' => $division_type_id,
                'title' => 'Division  Types',
                'search_id' => 'division_type_search',
                'columns' => ['No', 'Name', 'Action'],
                'column_vals' => ['name' ],
            ])
        </div>
    </div>
</div>
