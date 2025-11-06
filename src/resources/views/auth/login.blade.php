@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}" />
@endsection

@section('header-button')
    <a href="/register">register</a>
@endsection

@section('content')
<div class="page-wrapper">
            <h2>Login</h2>

    <form class="form" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="register-box">
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

    <button class="button-submit" type="submit">ログイン</button>
        </form>
    </div>
</div>
  </form>
@endsection