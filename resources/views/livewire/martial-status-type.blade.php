<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $martial_status_types,
                'modal' => 'modals/martial_status_type_modal',
                'id' => $martial_status_type_id,
                'title' => 'Blood Types',
                'search_id' => 'martial_status_search',
                'columns' => ['စဉ်','Name','Action'],
                'column_vals' => ['name'],
            ])
        </div>
    </div>
</div>

