@extends('layouts.app')
<!-- backup済み -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- midium幅(720ox)以上で反映(残4) -->
        <div class="col-md-8">
                       @if (session('status'))
                        <div class="alert alert-success">
                            asadadadadada
                            {{ session('status') }}
                        </div>
                    @endif
            <!-- card start////////////////////////////////// -->
            <!-- card end////////////////////////////////// -->
    </div>
</div>
@endsection
