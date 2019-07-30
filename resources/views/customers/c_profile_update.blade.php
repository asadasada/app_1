@extends('layouts.customers')

@section('content')
<div class="container prf">
    <div class="row justify-content-center center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ Auth::guard('customers')->user()->name }}のページ</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        asadadadadada
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="upload" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div  class="box">
                            <div id="befo_child">
                                <div><h5 class="gray">職務経験</h5></div>
                                <textarea name="utxt2" cols="50" rows="3" value="">{{ $txt2 }}</textarea>
                                <div><h5 class="gray">求めるスキル</h5></div>
                                <textarea name="utxt3" cols="50" rows="3" value="">{{ $txt3 }}</textarea>
                                <div><h5 class="gray">概要</h5></div>
                                <textarea name="utxt4" cols="50" rows="5" placeholder="必須" value="" required>{{ $txt4 }}</textarea>
                                <div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">送信</button>
                                </div>
                            </div>
                            <div id="child">
                                @if(Auth::guard('customers')->user()->id)
                                <div class="fstch">
                                    写真:
                                </div>
                                <div class="secch">
                                    <input type="file" name="pic" placeholder="写真">
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    @auth
                    <a href="{{ route('customers.profile',Auth::guard('customers')->user()->name) }}">戻る</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endsection
