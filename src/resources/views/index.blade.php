@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>

    <form class="form" action="/confirm" method="post" novalidate>
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--name-text">
                    <p>
                        <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}" />
                        @error('last_name')
                        <span class="form__error">{{ $message }}</span>
                        @enderror
                    </p>
                    <p>
                        <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}" />
                        @error('first_name')
                        <span class="form__error">{{ $message }}</span>
                        @enderror
                    </p>
                </div>

                <!-- <div class="form__error">
                    @error('last_name')
                    {{ $message }}
                    @enderror
                    @error('first_name')
                    {{ $message }}
                    @enderror
                </div> -->
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--radio">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }}>
                        <span class="custom-radio"></span>
                        男性
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>
                        <span class="custom-radio"></span>
                        女性
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}>
                        <span class="custom-radio"></span>
                        その他
                    </label>
                    <span></span>
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--tel-group">
                    <input type="tel" name="tel1" pattern="\d{2,4}" placeholder="080" value="{{ old('tel1') }}" required>
                    -
                    <input type="tel" name="tel2" pattern="\d{3,4}" placeholder="1234" value="{{ old('tel2') }}" required>
                    -
                    <input type="tel" name="tel3" pattern="\d{4}" placeholder="5678" value="{{ old('tel3') }}" required>
                </div>
                <div class="form__error">
                    @error('tel')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}" />
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}" />
                </div>
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select name="category_id" required>
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>
                            {{ $category['content'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('category_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>

@endsection