<!-- sideBar -->
@auth('web')
<div id="hoge" class="test">
    履歴書一覧
    <ol>
        @foreach ($users as $user)
        <li><a href="{{ route('profile',$user->name) }}">{{ $user->name }}の履歴書</a></li>
        @endforeach
    </ol>
</div>
@endauth
@auth('customers')
<div id="hoge" class="test">
    履歴書一覧
    <ol>
        @foreach ($users as $user)
        <li><a href="{{ route('customers.u_profile',$user->name) }}">{{ $user->name }}の履歴書</a></li>
        @endforeach
    </ol>
</div>
@endauth
@auth('web')
<div id="hoge2" class="test2">
    会社一覧
    <ol>
        @foreach ($customers as $customer)
        <li><a href="{{ route('c_profile',$customer->name) }}">{{ $customer->name }}の会社のページ</a></li>
        @endforeach

    </ol>
</div>
@endauth
@auth('customers')
<div id="hoge2" class="test2">
    会社一覧
    <ol>
        @foreach ($customers as $customer)
        <li><a href="{{ route('customers.profile',$customer->name) }}">{{ $customer->name }}の会社のページ</a></li>
        @endforeach

    </ol>
</div>
@endauth