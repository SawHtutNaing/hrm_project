<div class="w-full">
    <div class="flex justify-center w-full h-[83vh] overflow-y-auto">
        <div class="w-full mx-auto px-3 py-4">
            @include('components.table', [
                'data_values' => $leave_types,
                'modal' => 'modals/leave_type_modal',
                'id' => $leave_type_id,
                'title' => 'Leave  Types',
                'search_id' => 'leave_type_search',
                'columns' => ['No', 'Leave Type','Deduction Amount', 'Action'],
                'column_vals' => ['name' ,'deduction_amount'],
            ])
        </div>
    </div>
</div>
