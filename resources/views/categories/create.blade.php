@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Category</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')
        <div class="card">
            {!! Form::open(['route' => 'categories.store', 'id' => 'categoriesForm']) !!}
            @csrf
            <div class="card-body">
                <div class="row">
                    @include('categories.form', ['pageType' => 'Add'])
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('categories.index') }}" class="btn btn-default">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@include('layouts.inject_script')
<script>
    $(document).ready(function() {
        $("#categoriesForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                }
            }
        });
    })
</script>
