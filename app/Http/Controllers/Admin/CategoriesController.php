<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CategoriesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = \App\Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.edit-add');
    }

    public function edit($id)
    {
        $category = \App\Category::whereId($id)->firstOrFail();
        return view('admin.categories.edit-add', compact('category'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_cn' => 'required|max:255',
            'slug' => 'required|unique:posts|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('categories.create')
                ->withInput($request->input())
                ->with([
                    'message'    => $validator->errors(),
                    'alert-type' => 'error',
                ]);
        };

        $category = new \App\Category;
        $category->{'name:cn'} = $request->get('name_cn');
        $category->{'name:en'} = $request->get('name_en');
        $category->slug = $request->get('slug');
        $category->order = $request->get('order');
        $category->parent_id = $request->get('parent_category');

        $category->save();
        return redirect()
            ->route('categories.index')
            ->with([
                'message'    => "Successfully Added Category",
                'alert-type' => 'success',
            ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_cn' => 'required|max:255',
            'slug' => 'required|unique:posts|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('categories.edit',$id)
                ->with([
                    'message'    => $validator->errors(),
                    'alert-type' => 'error',
                ]);
        };

        $category = \App\Category::whereId($id)->firstOrFail();
        $category->{'name:cn'} = $request->get('name_cn');
        $category->{'name:en'} = $request->get('name_en');
        $category->slug = $request->get('slug');
        $category->order = $request->get('order');
        $category->parent_id = $request->get('parent_category');

        $category->save();

        return redirect()
            ->route('categories.index')
            ->with([
                'message'    => "Successfully Updated Category",
                'alert-type' => 'success',
            ]);
    }

    public function destroy($id)
    {
        $category = \App\Category::whereId($id)->firstOrFail();
        if (count($category->child)) {
            $message = 'The category has child!';
            return response()->json(compact('error', 'message'), 500);
        }
        else {
            $category->delete();
            return response()->json(compact('success'));
        }

    }

}
