<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $payscales,
                'modal' => 'modals/payscale_modal',
                'id' => $payscale_id,
                'title' => 'Payscales',
                'search_id' => 'payscale_search',
                'columns' => ['No', 'Name','Min Salary',  'Action'],
                'column_vals' => ['name'  , 'min_salary'],
            ])
        </div>
    </div>
</div>
