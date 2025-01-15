<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $over_time_types,
                'modal' => 'modals/over_time_type_modal',
                'id' => $over_time_type_id,
                'title' => 'Over Time Types ',
                'search_id' => 'division_search',
                'columns' => ['No', 'Name', 'Nick Name' ,  'Action'],
                'column_vals' => ['name' ],
            ])
        </div>
    </div>
</div>
