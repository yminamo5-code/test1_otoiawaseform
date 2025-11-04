@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}" />
@endsection

@section('content')
  <h2>Contact</h2>
  <form class="form" action="/confirm" method="post">
    @csrf
    <div class=label>
      <div class=label_item>
        お名前<span class=label_required>※</span>
      </div>
        <span class=form_group>
          <input type="text" name="last-name" value="{{ $oldInput['last-name'] ?? '' }}" placeholder="　例：山田">
          <input type="text" name="first-name" value="{{ $oldInput['first-name'] ?? '' }}" placeholder="　例：太郎">
        </span>
    </div>
    <div class=form_error>
        <div class=form_error_name>
            <div>
            @error('last-name')
            {{ $message }}@else &nbsp;
            @enderror
            </div>
            <div>
            @error('first-name')
            {{ $message }}
            @enderror  
            </div> 
        </div> 
    </div>

    <div class=label>
      <div class=label_item>
        性別<span class=label_required>※</span>
      </div>
        <span class=form_group>
          <input type="radio" name="gender" value="男性" {{ (isset($oldInput['gender']) && $oldInput['gender']=='男性') ? 'checked' : '' }}>
          <span>男性</span>
          <input type="radio" name="gender" value="女性" {{ (isset($oldInput['gender']) && $oldInput['gender']=='女性') ? 'checked' : '' }}>
          <span>女性</span>
          <input type="radio" name="gender" value="その他" {{ (isset($oldInput['gender']) && $oldInput['gender']=='その他') ? 'checked' : '' }}>
          <span class="gender3">その他</span>
        </span>
    </div>
        <div class="form_error">
            @error('gender')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>
        メールアドレス<span class=label_required>※</span>
      </div>
        <span class=form_group>
          <input type="" name="email" value="{{ $oldInput['email'] ?? '' }}" placeholder="　例：test@example.com">
        </span>
    </div>
        <div class="form_error">
            @error('email')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>
        電話番号<span class=label_required>※</span>
      </div>
        <span class=form_group>
          <input type="tel" name="tel1" maxlength="3" value="{{ $oldInput['tel1'] ?? '' }}" placeholder="090"> -
          <input type="tel" name="tel2" maxlength="4" value="{{ $oldInput['tel2'] ?? '' }}" placeholder="1234"> -
          <input type="tel" name="tel3" maxlength="4" value="{{ $oldInput['tel3'] ?? '' }}" placeholder="5678">
        </span>
    </div>
        <div class="form_error">
            @error('tel')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>
        住所<span class=label_required>※</span>
      </div>
        <span class=form_group>
          <input type="text" name="address" value="{{ $oldInput['address'] ?? '' }}" placeholder="　例：東京都渋谷区千駄ヶ谷1-2-3">
        </span>
    </div>
        <div class="form_error">
            @error('address')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>
        建物
      </div>
        <span class=form_group>
          <input type="text" name="build" value="{{ $oldInput['build'] ?? '' }}" placeholder="　例：千駄ヶ谷マンション101">
        </span>
    </div>

    <div class=label>
      <div class=label_item>
        お問い合わせの種類<span class=label_required>※</span>
      </div>
        <span class=form_group>
            <select name="category_id">
                <option value="" disabled selected>&nbsp;&nbsp;&nbsp;選択してください</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"{{ (isset($oldInput['category_id']) && $oldInput['category_id'] == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </span>
    </div>
        <div class="form_error">
            @error('category_id')
            {{ $message }}
            @enderror
        </div>

    <div class=label>
      <div class=label_item>
        <br />お問い合わせの内容<span class=label_required>※</span>
      </div>
        <span class=form_group>
          <textarea name="content" placeholder="　お問い合わせ内容をご記載ください">{{ $oldInput['content'] ?? '' }}</textarea>
        </span>
    </div>
        <div class="form_error">
            @error('content')
            {{ $message }}
            @enderror
        </div>
  
    <button class="button-submit" type="submit">確認画面</button>

  </form>

@endsection