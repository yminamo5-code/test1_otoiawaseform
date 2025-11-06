@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}" />
@endsection

@section('header-button')
    <form method="POST" action="{{route('logout')}}">
        @csrf
        <button type="submit" class="logout_button">logout</button>
    </form>
@endsection

@section('content')
    <h2>Admin</h2>

    <form class="wrap" method="GET" action="{{ route('contacts.admin') }}">
        <input type="text" name="name_email" placeholder="　名前やメールアドレスを入力してください"value="{{ request('name_email') }}"/>
        <select name="gender">
            <option value="" disabled selected>性別</option>
            <option value="">全部</option>
            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
        </select>
        <select name="category_id">
            <option value="" disabled selected>お問い合わせの種類</option>
            @foreach(\App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit" class="search">検索</button>
        <a href="{{ route('contacts.admin') }}" class="reset">リセット</a>
    </form>
    <form method="GET" action="{{ route('contacts.export') }}" class="special_button">
        <input type="hidden" name="name_email" value="{{ request('name_email') }}">
        <input type="hidden" name="gender" value="{{ request('gender') }}">
        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
            <button type="submit" class="export">エクスポート</button>
            <div class="pagenation">{{ $contacts->links('vendor.pagination.numbers') }}</div>
    </form>

    <table>
        <tr class="title">
            <th>お名前</th>
            <th>性別</th>
            <th>メールアドレス</th>
            <th>お問い合わせの種類</th>
            <th></th>
        </tr>
    <tbody>
        @foreach($contacts as $contact)
        <tr id="row-{{ $contact->id }}" class="row">
            <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
            <td>{{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->category->name ?? '不明' }}</td>
            <td>
                <label for="modal-toggle-{{ $contact->id }}" class="show">詳細</label>
            </td>
        </tr>
        @endforeach
    </tbody>

        @foreach($contacts as $contact)
<input type="checkbox" id="modal-toggle-{{ $contact->id }}" class="modal-toggle" hidden>

<div class="modal">
    <label for="modal-toggle-{{ $contact->id }}" class="modal-overlay"></label>
    <div class="modal-content">
        <label for="modal-toggle-{{ $contact->id }}" class="close">&times;</label>

        <p><strong>お名前</strong> {{ $contact->last_name }} {{ $contact->first_name }}</p>
        <p><strong>性別</strong> {{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}</p>
        <p><strong>メール</strong> {{ $contact->email }}</p>
        <p><strong>電話</strong> {{ $contact->tel }}</p>
        <p><strong>住所</strong> {{ $contact->address }}</p>
        <p><strong>建物名</strong> {{ $contact->building_name }}</p>
        <p><strong>お問い合わせの種類</strong> {{ $contact->category->name ?? '不明' }}</p>
        <p><strong>お問い合わせ内容</strong> {{ $contact->detail }}</p>

        <form method="POST" action="{{ route('contacts.destroy', $contact->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete">削除</button>
        </form>
    </div>
</div>
@endforeach

@endsection