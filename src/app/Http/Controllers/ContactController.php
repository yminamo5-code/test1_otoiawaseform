<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category; 
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    public function index(Request $request)
        {
            $categories = Category::all();
            $oldInput = $request->session()->get('contact_input', []);
            return view('index',compact('categories','oldInput'));
        }

    public function confirm(ContactRequest $request)
        {
            $contact=$request->only(['last-name','first-name','gender','email','tel1','tel2','tel3','address','build','category_id','content']);

            $request->session()->put('contact_input', $contact);

            $category = \App\Models\Category::find($contact['category_id']);
            $contact['category_name'] = $category ? $category->name : '';

            return view('confirm', compact('contact'));
        }

    public function store(Request $request)
        {
            $contact=$request->only(['last-name','first-name','gender','email','tel','address','build','category_id','content']);

            $contact['gender'] = match($contact['gender']) {
            '男性' => 1,
            '女性' => 2,
            'その他' => 3,
            };

            Contact::create([
                'first_name' => $contact['first-name'],
                'last_name' => $contact['last-name'],
                'gender' => $contact['gender'],
                'email' => $contact['email'],
                'tel' => $contact['tel'],
                'address' => $contact['address'],
                'building' => $contact['build'],
                'detail' => $contact['content'],
                'category_id' => $contact['category_id'],
            ]);
            return view('thanks');


        }

    public function admin(Request $request)
        {
                $query = Contact::query();

            if ($request->name_email !== null && $request->name_email !== '') {
                $query->where(function($q) use ($request) {
                    $q->where('first_name', 'like', '%'.$request->name_email.'%')
                      ->orWhere('last_name', 'like', '%'.$request->name_email.'%')
                      ->orWhere('email', 'like', '%'.$request->name_email.'%');
                });
            }

            if ($request->gender !== null && $request->gender !== '') {
                $query->where('gender', (int)$request->gender);
            }

            if ($request->category_id !== null && $request->category_id !== '') {
                $query->where('category_id', $request->category_id);
            }

            if ($request->date !== null && $request->date !== '') {
                $query->whereDate('created_at', $request->date);
            }
            $contacts = $query->paginate(7)->appends($request->all());
            return view('admin', compact('contacts'));
        }

    public function destroy($id)
        {
            $contact = \App\Models\Contact::findOrFail($id);
            $contact->delete();

            return redirect()->route('contacts.admin')->with('success', '削除しました');
        }

public function export(Request $request)
{
    $query = Contact::query();

    if ($request->filled('name_email')) {
        $v = $request->name_email;
        $query->where(function($q) use ($v) {
            $q->where('first_name', 'like', "%{$v}%")
              ->orWhere('last_name', 'like', "%{$v}%")
              ->orWhere('email', 'like', "%{$v}%");
        });
    }
    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $contacts = $query->with('category')->get();

    $headers = [
        'お名前',
        '性別',
        'メールアドレス',
        '電話番号',
        '住所',
        '建物名',
        'お問い合わせの種類',
        'お問い合わせ内容',
        '登録日時',
    ];

    $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
    $handle = fopen('php://temp', 'r+');

    fputcsv($handle, array_map(fn($h) => mb_convert_encoding($h, 'SJIS-win', 'UTF-8'), $headers));

    foreach ($contacts as $c) {
        $gender = match($c->gender) {
            1 => '男性',
            2 => '女性',
            3 => 'その他',
            default => '',
        };

        $row = [
            $c->last_name . ' ' . $c->first_name,
            $gender,
            $c->email,
            $c->tel,
            $c->address,
            $c->building,
            $c->category->name ?? '不明',
            $c->detail,
            $c->created_at->format('Y-m-d H:i:s'),
        ];

        fputcsv($handle, array_map(fn($v) => mb_convert_encoding((string)$v, 'SJIS-win', 'UTF-8'), $row));
    }

    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    return Response::make($csv, 200, [
        'Content-Type' => 'text/csv; charset=Shift_JIS',
        'Content-Disposition' => "attachment; filename={$filename}",
    ]);
}

    public function exportShiftJIS(Request $request)
    {
        $query = Contact::query();
        $contacts = $query->get();
        $columns = Schema::getColumnListing('contacts');

        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');

        $header = array_map(function($h){ return mb_convert_encoding($h, 'SJIS-win', 'UTF-8'); }, $columns);
        fputcsv($handle, $header);

        foreach ($contacts as $c) {
            $row = [];
            foreach ($columns as $col) {
                $val = $c->{$col};
                $row[] = mb_convert_encoding((string)$val, 'SJIS-win', 'UTF-8');
            }
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv; charset=Shift_JIS',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
