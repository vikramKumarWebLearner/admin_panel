@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Category</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" id="categoriesEditForm">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        @include('categories.form', ['pageType' => 'Edit'])
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('roles.validation')
