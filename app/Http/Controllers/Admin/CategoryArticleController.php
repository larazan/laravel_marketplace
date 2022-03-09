<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CategoryArticle;
use App\Http\Requests\CategoryArticleRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CategoryArticleController extends Controller
{
    public function __construct()
    {
        $this->data['currentAdminMenu'] = 'article';
		$this->data['currentAdminSubMenu'] = 'category_article';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['categories'] = CategoryArticle::orderBy('name', 'desc')->paginate(10);

        return view('admin.category_articles.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryArticle::orderBy('name', 'DESC')->get();

        $this->data['categories'] = $categories->toArray();
        $this->data['category'] = null;

        return view('admin.category_articles.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryArticleRequest $request)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);
        $params['parent_id'] = (int)$params['parent_id'];

        if (CategoryArticle::create($params)) {
            Session::flash('success', 'Category has been saved');
        }
        return redirect('admin/category_articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CategoryArticle::findOrFail($id);
        $categories = CategoryArticle::where('id', '!=', $id)->orderBy('name', 'DESC')->get();

        $this->data['categories'] = $categories->toArray();
        $this->data['category'] = $category;
        return view('admin.category_articles.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryArticleRequest $request, $id)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);
        $params['parent_id'] = (int)$params['parent_id'];

        $category = CategoryArticle::findOrFail($id);
        if ($category->update($params)) {
            Session::flash('success', 'Category has been updated.');
        }

        return redirect('admin/category_articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category  = CategoryArticle::findOrFail($id);

        if ($category->delete()) {
            Session::flash('success', 'Category has been deleted');
        }

        return redirect('admin/category_articles');
    }
}
