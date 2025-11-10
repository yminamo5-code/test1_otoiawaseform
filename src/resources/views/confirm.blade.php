@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/confirm.css')}}" />
@endsection

@section('content')
  <h2>Confirm</h2>

    <form class="form" action="/contacts" method="post">
        @csrf
        <div class="form-row">
            <div class=item> お名前</div>
            <input type="text" value="{{ $contact['last-name'].'　'.$contact['first-name'] }}" readonly/>
            <input type="hidden" name="first-name" value="{{ $contact['first-name'] }}">
            <input type="hidden" name="last-name" value="{{ $contact['last-name'] }}">
        </div>

        <div class="form-row">
            <div class=item>性別</div>
            <input type="text" name="gender" value="{{ $contact['gender']}}" readonly/>
        </div>

        <div class="form-row">
            <div class=item>メールアドレス</div>
            <input type="text" name="email" value="{{ $contact['email']}}" readonly/>
        </div>

        <div class="form-row">
            <div class=item>電話番号</div>
            <input type="text" name="tel" value="{{ $contact['tel1'].$contact['tel2'].$contact['tel3']}}" readonly/>
        </div>

        <div class="form-row">
            <div class=item>住所</div>
            <input type="text" name="address" value="{{ $contact['address']}}" readonly/>
        </div>

        <div class="form-row">
            <div class=item>建物</div>
            <input type="text" name="build" value="{{ $contact['build']}}" readonly/>
        </div>

        <div class="form-row">
            <div class=item>お問い合わせの種類</div>
                <input type="text" value="{{ $contact['category_name'] }}" readonly>
                <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
        </div>

        <div class="form-row">
            <div class=item>お問い合わせ内容</div>
            <textarea name="content" readonly>

{{ $contact['content']}}</textarea>
        </div>

        <div class="button-row">
            <button class="button1" type="submit" formaction="{{ route('contacts.store') }}">送信</button>
            <button class="button2" type="button" onclick="window.location.href='{{ route('contacts.index') }}'">修正</button>
        </div>
    </form>

@endsection
