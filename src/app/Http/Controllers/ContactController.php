<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category; 
use App\Http\Requests\ContactRequest;


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
}
