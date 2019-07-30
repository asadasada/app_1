@extends('layouts.app')

@section('content')
<div class="container prf">
    <div class="row justify-content-center center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ Auth::user()->name }}のプロファイル</div>
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
                                <div><h5 class="gray">学歴</h5></div>
                                <textarea name="utxt1" cols="50" rows="2">{{ $txt1 }}</textarea>
                                <div><h5 class="gray">職務経験</h5></div>
                                <textarea name="utxt2" cols="50" rows="2">{{ $txt2 }}</textarea>
                                <div><h5 class="gray">スキルタグ(#tag_name#で登録)</h5></div>
                                <textarea name="utxt3" cols="50" rows="3">{{ $txt3 }}</textarea>
                                <div><h5 class="gray">自己アピール</h5></div>
                                <textarea name="utxt4" cols="50" rows="5" placeholder="必須" required>{{ $txt4 }}</textarea>
                                <div>
                                <!-- githubのリンク(nashi) -->
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">送信</button>
                                </div>
                            </div>
                            <div id="child">
                                @if(Auth::user()->id)
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
               <a href="{{ route('profile',Auth::user()->name) }}">戻る</a>
               @endauth
           </div>
       </div>
   </div>
</div>
@endsection
