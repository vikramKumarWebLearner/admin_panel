<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable {
	public function dataTable($query, Request $request) {
		$dataTable = new EloquentDataTable($query);
		$dataTable->addIndexColumn();
		if ($request->toArray()['order'][0]['column'] == 2) {
			$sortDirection = $request->toArray()['order'][0]['dir'];
			$sortColumn = $request->input('order[0][column]');
			$query
			->select('users.*', 'roles.name AS role_text')
			->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
			->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
			->orderBy('roles.name', $sortDirection);

			// $query
			// ->select('users.*', 'roles_new.name AS role_text')
			// ->with('roles_new')
			// ->orderBy('roles_new.name', $sortDirection);
		}

		$dataTable->addColumn('status', function ($row) {
			if ($row->status == 'ACTIVE') {
				return '<span class="badge badge-primary">Active</span>';
			} else {
				return '<span class="badge badge-danger">Inactive</span>';
			}
		});
		$dataTable->filter(function ($instance) use ($request) {
			if ($request->get('status') != '') {
				$instance->where('status', $request->get('status'));
			}
			if ($request->get('role_id') != '') {
				$instance->whereHas('roles', function ($query) use ($request) {
					$query->where('name', $request->get('role_id'));
				});
			}
			if (!empty($request->get('search'))) {
				$instance->where(function ($w) use ($request) {
					$search = $request->get('search');
					$w->orWhere('name', 'LIKE', "%$search%")
						->orWhere('email', 'LIKE', "%$search%");
				});
			}
		});

		$dataTable->addColumn('action', 'users.datatables_actions');
		$dataTable->rawColumns(['name', 'action', 'password_link', 'status']);
		$dataTable->make(true);
		return $dataTable;
	}

	public function query(User $model) {
		return $model->newQuery();
	}

	protected function filename(): string {
		return 'users_datatable_' . time();
	}
}
