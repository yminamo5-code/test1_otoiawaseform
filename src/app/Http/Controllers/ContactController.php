<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category; 

class ContactController extends Controller
{
    public function index(Request $request)
        {
            $categories = Category::all();
            // セッションに保存されている入力値を取得
            $oldInput = $request->session()->get('contact_input', []);
            return view('index',compact('categories','oldInput'));
        }

    public function confirm(Request $request)
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
}
