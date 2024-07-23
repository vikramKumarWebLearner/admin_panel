@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                @can('categories.create')
                    <div class="col-sm-6">
                        <a class="btn btn-primary float-right" href="{{ route('categories.create') }}">Add Category</a>
                    </div>
                @endcan
            </div>
        </div>
    </section>
    <div class="content px-3">
        <div class="alert-container">
            @include('custom_flash_message')
        </div>
        <div id="error-msg"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table" id="categories">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <div class="card-footer clearfix">
                    <div class="float-right"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inject_script')
<script>
    $(document).redy(function() {
        var datatables = $('#categories').DataTables({

        })
    });
</script>
