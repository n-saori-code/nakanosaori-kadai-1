<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;


class ContactController extends Controller
{
    ##Contactの表示
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    ##Confirmの表示
    public function confirm(ContactRequest $request)
    {
        // 電話番号を結合
        $tel = $request->input('tel1') . $request->input('tel2') . $request->input('tel3');

        // 必要な入力値を取得
        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'address',
            'building',
            'category_id',
            'detail'
        ]);

        $contact['tel'] = $tel;

        $category = Category::find($contact['category_id']);
        $contact['category_name'] = $category->content ?? '';
        return view('confirm', compact('contact'));
    }

    ##Thanksの表示
    public function store(ContactRequest $request)
    {
        $tel = $request->input('tel1') . $request->input('tel2') . $request->input('tel3');

        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'address',
            'building',
            'category_id',
            'detail'
        ]);

        $contact['tel'] = $tel;
        Contact::create($contact);
        return view('thanks');
    }
}
