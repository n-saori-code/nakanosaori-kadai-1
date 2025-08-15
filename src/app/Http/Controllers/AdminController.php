<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    ##adminの表示
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect('/login');
        }

        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    ##検索機能
    public function search(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect('/login');
        }

        $contacts = Contact::with('category')
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->CategorySearch($request->category_id)
            ->DateSearch($request->date)
            ->paginate(7);

        $contacts->appends([
            'keyword' => $request->keyword,
            'gender' => $request->gender,
            'category_id' => $request->category_id,
            'date' => $request->date,
        ]);
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    ##削除処理
    public function destroy(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect('/login');
        }

        Contact::find($request->id)->delete();

        return redirect('/admin');
    }

    ##データをエクスポート
    public function export(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect('/login');
        }

        // 絞り込み検索と同じ処理
        $contacts = Contact::with('category')
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->CategorySearch($request->category_id)
            ->DateSearch($request->date)
            ->get(); // エクスポートではpaginateではなく全部取得

        // CSV ヘッダー
        $csvHeader = ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容'];

        $callback = function () use ($contacts, $csvHeader) {
            $file = fopen('php://output', 'w');
            // ヘッダー出力
            fputcsv($file, $csvHeader);

            $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $genderMap[$contact->gender] ?? '',
                    $contact->email,
                    $contact->tel ?? '',
                    $contact->address ?? '',
                    $contact->building ?? '',
                    $contact->category->content ?? '',
                    $contact->detail ?? ''
                ]);
            }

            fclose($file);
        };

        $fileName = 'contacts_' . date('Ymd_His') . '.csv';

        return Response::stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Cache-Control" => "no-cache, no-store, must-revalidate",
            "Pragma" => "no-cache",
            "Expires" => "0"
        ]);
    }
}
