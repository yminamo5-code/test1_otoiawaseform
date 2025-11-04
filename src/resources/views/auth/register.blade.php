@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}" />
@endsection

@section('header-button')
    <a href="/login">login</a>
@endsection

@section('content')
<div class="page-wrapper">
            <h2>Resister</h2>

    <form class="form" action="{{ route('register') }}" method="POST">
    @csrf
    <div class="register-box">
    <div class=label>
      <div class=label_item>お名前</div>
        <span class=form_group>
          <input type="text" name="name" value="{{ old('name')}}" placeholder="　例：山田　太郎"/>
        </span>
    </div>
        <div class="form_error">
            @error('name')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>メールアドレス</div>
        <span class=form_group>
          <input type="email" name="email" value="{{ old('email')}}" placeholder="　例：test@example.com"/>  
        </span>
    </div>
        <div class="form_error">
            @error('email')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>パスワード</div>
        <span class=form_group>
          <input type="password" name="password" value="{{ old('password')}}" placeholder="　例：coachtech1106"/>
        </span>
    </div>
        <div class="form_error">
            @error('password')
            {{ $message }}
            @enderror
        </div>

    <button class="button-submit" type="submit">登録</button>
        </form>
    </div>
</div>
  </form>
@endsection