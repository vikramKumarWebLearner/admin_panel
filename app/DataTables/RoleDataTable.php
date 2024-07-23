<?php

namespace App\DataTables;

use App\Models\Role;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RoleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->addColumn('name', function ($role) {
             return '<a href="' . route('roles.show', $role->id) .'">'.$role->name.'</a>';
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("name LIKE ?", ["%{$keyword}%"]);
        })
        ->orderColumn('name', function ($query, $orderBy) {
            $query->orderByRaw("CASE WHEN name LIKE '[0-9]%' THEN 1 ELSE 2 END, name $orderBy");
        }, ' ');
        $dataTable->addColumn('action', 'roles.datatables_actions');
        $dataTable->rawColumns(['name','action']);
        $dataTable->make(true);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('datatables.bAction')])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => false,
                'order'     => [[0, 'desc']],
                'buttons'   => [

                    // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner','title' => __('datatables.bcreate')],
                    // ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner','title' => __('datatables.bexport')],
                    // ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner','title' => __('datatables.bprint')],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner','title' => __('datatables.breset')],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner','title' => __('datatables.breload')],
                ],
                'language' => __('datatables')
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // 'id' => ['title'=>'No','searchable' => false, 'orderable' => false],
            'name',
            // 'title',
            // 'guard_name',
            // 'description'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'roles_datatable_' . time();
    }
}
