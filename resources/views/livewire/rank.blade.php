<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $ranks,
                'modal' => 'modals/rank_modal',
                'id' => $rank_id,
                'title' => 'rank',
                'search_id' => 'rank_search',
                'columns' => ['No', 'Name',  'PayScale ' ,  'Sort No' ,  'Action'],
                'column_vals' => ['name' , 'payscale' , 'sort_no' ],
            ])
        </div>
    </div>
</div>
