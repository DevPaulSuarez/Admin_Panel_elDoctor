@extends('layouts.main')

@section('title', 'Blogs')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Blogs</h4>
            </div>
            <div class="card-content table-responsive">
                <a href="/citas/create" class="btn btn-primary"><i class='fa fa-support'></i> Nuevo Blog</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>

</script>
@endsection