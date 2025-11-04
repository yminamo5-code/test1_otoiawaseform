@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}" />
@endsection

@section('header-button')
    <a href="/login" class="login_button">logout</a>
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
    <div class="special_button">
        <button type="submit" class="export">エクスポート</button>
        <div class="pagenation">{{ $contacts->links('vendor.pagination.numbers') }}</div>
    </div>

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
                <button class="show" data-id="{{ $contact->id }}">詳細</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- 
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><strong>お名前</strong> <span id="modal-name"></span></p>
            <p><strong>性別</strong> <span id="modal-gender"></span></p>
            <p><strong>メールアドレス</strong> <span id="modal-email"></span></p>
            <p><strong>電話番号</strong> <span id="modal-tel"></span></p>
            <p><strong>住所</strong> <span id="modal-address"></span></p>
            <p><strong>建物名</strong> <span id="modal-build"></span></p>
            <p><strong>お問い合わせの種類</strong> <span id="modal-category"></span></p>
            <p><strong>お問い合わせ内容:</strong> <span id="modal-detail"></span></p>
            <button class="delete" >削除</button>
        </div>
    </div>
--}}
@endsection