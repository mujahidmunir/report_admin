<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('created_at', 'DESC')->whereNotIn('category_id', [349])->get();
        return view('admin.history', compact('reports'));
    }

    public function article(){
        $reports = Report::orderBy('created_at', 'DESC')->whereIn('category_id', [349])->get();
        return view('admin.history', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\request()->ajax()){
            $category = Category::whereParent(null)->get();
            return response()->json($category);
        }
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created_at =  Carbon::parse($request->input('created'))->format('Y-m-d H:i:s');

        $img = $request->file('img');
        $file_name = now()->timestamp.'.png';

        $img = ImageManagerStatic::make($img);
        $upload_img = $img->resize(null, 700, function ($constraint) {
            $constraint->aspectRatio();
        });
        $upload_img->save(public_path("images/reports/{$file_name}"), 80, 'png');

        $create = Report::create([
            'user_id' => Auth::user()->id ,
            'title' => $request->input('title'),
            'category_id' => $request->input('cat'),
            'sub_category_id' => $request->input('sub'),
            'link' => $request->input('link'),
            'image' => $file_name
        ]);

        if ($request->input('created') == !null){
            Report::whereId($create->id)->update([
                'created_at' => $created_at,
                'updated_at' => $created_at
            ]);
        }

        return redirect('/');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addCategory(Request $request){
        if (\request()->ajax()){
            $parent = $request->input('parent');
            $create_cat = Category::create([
                'name' => $request->input('name'),
                'parent' => $request->input('parent'),
                'slug' => \Illuminate\Support\Str::slug($request->input('name'))
            ]);
            $cat = Category::whereId($create_cat->id)->first();
            return response()->json($cat);
        }
    }

    public function subCat($id){
        if (\request()->ajax()){
            $cat = Category::whereParent($id)->get();
            return response()->json($cat);
        }
    }
}
