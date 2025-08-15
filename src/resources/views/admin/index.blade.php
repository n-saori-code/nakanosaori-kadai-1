<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/admin">
                FashionablyLate
            </a>

            <div class="header__button">
                <form class="form" action="/logout" method="post">
                    @csrf
                    <button>logout</button>
                </form>
            </div>
        </div>
    </header>

    <main>
        <div class="admin__content">
            <div class="admin__heading">
                <h2>Admin</h2>
            </div>

            <form class="search-form" action="/admin/search" method="get">
                @csrf
                <div class="search-form__item">
                    <input class="search-form__item-input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください">
                    <select class="search-form__item-select search-form__gender" name="gender">
                        <option value="" selected disabled>性別</option>
                        <option value="">全て</option>
                        <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                    </select>
                    <select class="search-form__item-select search-form__category" name="category_id">
                        <option value="">全て</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                        @endforeach
                    </select>
                    <input class="search-form__item-date" type="date" name="date" value="{{ request('date') }}">

                    <button class="search-form__button-submit" type="submit">検索</button>
                    <a href="/admin" class="search-form__reset-submit">リセット</a>
                </div>
            </form>

            <div class="contact-list">
                <div class="contact-list__controls">
                    <a href="{{ route('admin.export', request()->query()) }}" class="contact-list__export-button">エクスポート</a>
                    <div class="contact-list__pagination">
                        {{ $contacts->links('vendor.pagination.default') }}
                    </div>
                </div>

                <table class="contact-list__table">
                    <thead>
                        <tr class="contact-list__row contact-list__row--header">
                            <th class="contact-list__header">お名前</th>
                            <th class="contact-list__header">性別</th>
                            <th class="contact-list__header">メールアドレス</th>
                            <th class="contact-list__header">お問い合わせの種類</th>
                            <th class="contact-list__header"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                        <tr class="contact-list__row">
                            <td class="contact-list__cell">{{ $contact['last_name'] . '　' . $contact['first_name'] }}</td>
                            @php
                            $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
                            @endphp
                            <td class="contact-list__cell">{{ $genderMap[$contact['gender']] ?? '' }} </td>
                            <td class="contact-list__cell">{{ $contact['email'] }}</td>
                            <td class="contact-list__cell">{{ $contact->category->content ?? '' }}</td>
                            <td class="contact-list__cell">
                                <button class="contact-list__button"
                                    data-id="{{ $contact['id'] }}"
                                    data-name="{{ $contact['last_name'] . '　' . $contact['first_name'] }}"
                                    data-gender="{{ $genderMap[$contact['gender']] ?? '' }}"
                                    data-email="{{ $contact['email'] }}"
                                    data-tel="{{ $contact['tel'] ?? '' }}"
                                    data-address="{{ $contact['address'] ?? '' }}"
                                    data-building="{{ $contact['building'] ?? '' }}"
                                    data-category="{{ $contact->category->content ?? '' }}"
                                    data-message="{{ $contact['detail'] ?? '' }}">詳細</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- モーダル -->
        <div id="detailModal" class="modal">
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <div class="modal-body">
                    <p><strong>お名前</strong> <span id="modal-name"></span></p>
                    <p><strong>性別</strong> <span id="modal-gender"></span></p>
                    <p><strong>メールアドレス</strong> <span id="modal-email"></span></p>
                    <p><strong>電話番号</strong> <span id="modal-tel"></span></p>
                    <p><strong>住所</strong> <span id="modal-address"></span></p>
                    <p><strong>建物名</strong> <span id="modal-building"></span></p>
                    <p><strong>お問い合わせの種類</strong> <span id="modal-category"></span></p>
                    <p><strong>お問い合わせ内容</strong> <span id="modal-message"></span></p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="/admin/delete">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="delete-id">
                        <button class="modal-delete">削除</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("detailModal");
            const closeBtn = modal.querySelector(".modal-close");
            const deleteIdInput = document.getElementById("delete-id");

            // 全ての詳細ボタンにイベントを追加
            document.querySelectorAll(".contact-list__button").forEach(button => {
                button.addEventListener("click", () => {
                    document.getElementById("modal-name").textContent = button.dataset.name;
                    document.getElementById("modal-gender").textContent = button.dataset.gender;
                    document.getElementById("modal-email").textContent = button.dataset.email;
                    document.getElementById("modal-tel").textContent = button.dataset.tel;
                    document.getElementById("modal-address").textContent = button.dataset.address;
                    document.getElementById("modal-building").textContent = button.dataset.building;
                    document.getElementById("modal-category").textContent = button.dataset.category;
                    document.getElementById("modal-message").textContent = button.dataset.message;

                    // hiddenフィールドにIDをセット
                    deleteIdInput.value = button.dataset.id;

                    modal.style.display = "block";
                });
            });

            // 閉じる
            closeBtn.addEventListener("click", () => {
                modal.style.display = "none";
            });

            // 背景クリックで閉じる
            window.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>

</body>

</html>