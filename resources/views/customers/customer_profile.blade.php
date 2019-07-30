@extends('layouts.customers')
@section('content')
<div class="container prf">
    <div class="row justify-content-center center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ $name }}のプロファイル</div>
                <div class="card-body box">
                    @if (session('status'))
                    <div class="alert alert-success">
                        asadadadadada
                        {{ session('status') }}
                    </div>
                    @endif
                    <div id="befo_child">
                        募集要項
                        <div><h5 class="gray">説明</h5></div>
                        @isset($txt2)<p>{{ $txt2 }}</p>@endisset
                        <div><h5 class="gray">求めるスキル(#tag#で登録)</h5></div>
                        @isset($txt3)<p>{{ $txt3 }}</p>@endisset
                        <div><h5 class="gray">概要</h5></div>
                        @isset($txt4)<p>{{ $txt4 }}</p>@endisset
                    </div>
                    <div id="child">
                        写真: {{ $name }}
                        <div>
                           <a class = "parent_pic" href="{{$image_url}}" target="_blank">
                            <img class="pic" src="{{ $image_url }}" class="img-responsive" alt=""> </a>
                        </div>
                    </div>
                </div>
            </div>
            @auth('customers')
            @if( Auth::user()->name == $name)
            <form action="./profile/update" method="post" name="upd" accept-charset="utf-8">
                {{ csrf_field() }}
                <input type="hidden" name="txt2" value="{{ $txt2 }}">
                <input type="hidden" name="txt3" value="{{ $txt3 }}">
                <input type="hidden" name="txt4" value="{{ $txt4 }}">
                <a href="javascript:upd.submit()">編集</a>
            </form>
            @endif
            @endauth
        </div>
        <div class="tags">
        @auth('web')
        <div>所有タグ(クリックでリンクを表示)</div>
        <br>
        @isset($tags)
        <ol>
            @foreach ($tags as $id => $tag_name)
            <li><a href="{{ route('c_profile',[$name,'&tags='.hash('md5',$id)]) }}">{{ $tag_name }}</a></li>
            @endforeach
            @endisset
        </ol>
        <div>プロファイルへのリンク</div>
        <ol>
            @foreach ($customers as $customer)
            <li><a href="{{ route('c_profile',$customer->name) }}">{{ $customer->name }}のプロファイル</a></li>
            @endforeach
        </ol>
        @endauth
        @auth('customers')
        <div>所有タグ(クリックでリンクを表示)</div>
        <br>
        @if($tags != null)
        <ol>
            @foreach ($tags as $id => $tag_name)
            <li><a href="{{ route('customers.profile',[$name,'&tags='.hash('md5',$id)]) }}">{{ $tag_name }}</a></li>
            @endforeach
            @endif
        </ol>
        <div>プロファイルへのリンク</div>
        <ol>
            @foreach ($customers as $customer)
            <li><a href="{{ route('customers.profile',$customer->name) }}">{{ $customer->name }}のプロファイル</a></li>
            @endforeach
        </ol>
        @endauth

        @if(Session::has('teast'))
        <div>{{ session('test') }}</div>
        @endif
    </div>
    </div>
@auth('web')
<div id="tete">
    <div>全てのcustomerタグ一覧</div>
    <ol>
        @foreach ($all_tags as $tag)
        @if(!$tag->customers()->get()->isEmpty())
        <li id="tete_list"><a href="{{ route('profile',[$name,'&tags='.hash('md5',$tag->id)]) }}">[{{ $tag->tag_name }}]</a></li>
        @endif
        @endforeach
    </ol>
</div>
@endauth
@auth('customers')
<div id="tete">
    <div>全てのcustomerタグ一覧</div>
    <ol>
        @foreach ($all_tags as $tag)
        @if(!$tag->customers()->get()->isEmpty())
        <li id="tete_list"><a href="{{ route('customers.profile',[$name,'&tags='.hash('md5',$tag->id)]) }}">[{{ $tag->tag_name }}]</a></li>
        @endif
        @endforeach
    </ol>
</div>
@endauth
</div>
@endsection
