<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class PostsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);
        $post_type = \App\PostType::where(['slug' => $slug])->firstOrFail();
        $posts = \App\Post::where(['post_type_id' => $post_type->id])->get();
        return view('admin.posts.index', compact('posts', 'post_type'));
    }

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);
        $post_type = \App\PostType::where(['slug' => $slug])->firstOrFail();
        return view('admin.posts.edit-add', compact('post_type'));
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        $post_type = \App\PostType::where(['slug' => $slug])->firstOrFail();
        $post = \App\Post::whereId($id)->firstOrFail();
        return view('admin.posts.edit-add', compact('post', 'post_type'));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);
        $post_type = \App\PostType::where(['slug' => $slug])->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title_cn' => 'required|max:255',
            'slug' => 'required|unique:posts|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route($post_type->slug.'.create')
                ->withInput()
                ->with([
                    'message'    => $validator->errors(),
                    'alert-type' => 'error',
                ]);
        };

        $post = new \App\Post;
        $post->{'title:cn'} = $request->get('title_cn');
        $post->{'title:en'} = $request->get('title_en');
        $post->{'excerpt:cn'} = $request->get('excerpt_cn');
        $post->{'excerpt:en'} = $request->get('excerpt_en');
        $post->{'content:cn'} = $request->get('content_cn');
        $post->{'content:en'} = $request->get('content_en');
        $post->{'seo_title:cn'} = $request->get('seo_title_cn');
        $post->{'seo_title:en'} = $request->get('seo_title_en');
        $post->{'seo_description:cn'} = $request->get('seo_description_cn');
        $post->{'seo_description:en'} = $request->get('seo_description_en');
        $post->{'seo_keywords:cn'} = $request->get('seo_keywords_cn');
        $post->{'seo_keywords:en'} = $request->get('seo_keywords_en');
        $post->slug = $request->get('slug');
        $post->status = $request->get('status');
        $post->post_type_id = $request->get('post_type');
        $post->author_id = $request->get('author');

        if ($request->get('category')) {
            $post->category_id = $request->get('category');
        }

        if ($request->get('product-images')) {
            $post->image = implode(',', $request->get('product-images'));
        }

        if($request->get('meta')) {
            $post->meta_box = json_encode($request->get('meta'));
        }

        $post->save();

        return redirect()
            ->route($post_type->slug.'.index')
            ->with([
                'message'    => "Successfully Added Product",
                'alert-type' => 'success',
            ]);
    }

    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        $post_type = \App\PostType::where(['slug' => $slug])->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title_cn' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route($post_type->slug.'.index')
                ->with([
                    'message'    => $validator->errors(),
                    'alert-type' => 'error',
                ]);
        };

        $post = \App\Post::whereId($id)->firstOrFail();
        $post->{'title:cn'} = $request->get('title_cn');
        $post->{'title:en'} = $request->get('title_en');
        $post->{'excerpt:cn'} = $request->get('excerpt_cn');
        $post->{'excerpt:en'} = $request->get('excerpt_en');
        $post->{'content:cn'} = $request->get('content_cn');
        $post->{'content:en'} = $request->get('content_en');
        $post->{'seo_title:cn'} = $request->get('seo_title_cn');
        $post->{'seo_title:en'} = $request->get('seo_title_en');
        $post->{'seo_description:cn'} = $request->get('seo_description_cn');
        $post->{'seo_description:en'} = $request->get('seo_description_en');
        $post->{'seo_keywords:cn'} = $request->get('seo_keywords_cn');
        $post->{'seo_keywords:en'} = $request->get('seo_keywords_en');
        $post->slug = $request->get('slug');
        $post->status = $request->get('status');
        $post->category_id = $request->get('category');
        if ($request->get('product-images')) {
            $post->image = implode(',', $request->get('product-images'));
        }
        if($request->get('meta')) {
            $post->meta_box = json_encode($request->get('meta'));
        }

        $post->save();

        return redirect()
            ->route($post_type->slug.'.index')
            ->with([
                'message'    => "Successfully Updated Product",
                'alert-type' => 'success',
            ]);
    }

    public function destroy($id)
    {
        $category = \App\Post::whereId($id)->firstOrFail();
        $category->delete();
        return response()->json(compact('success'));
    }

    public function getSlug(Request $request)
    {
        $slug = explode('.', $request->route()->getName())[0];
        return $slug;
    }
}
