<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    // ----------CREAR
    public function createBlog(Request $request){
        $request -> validate([
            "title"=>"required",
            "content"=>"required"
        ]);

        $user_id= auth()->user()->id;

        $blog=new Blog();
        $blog->user_id=$user_id;
        $blog->title=$request->title;
        $blog->content=$request->content;

        $blog->save();
        return response([
            "status"=>1,
            "mgs"=>"¡Se guardo correctamente"
        ]);
    }


    

    public function listBlog(){
        $user_id = auth()->user()->id;
        $blogs = Blog::where("user_id", $user_id)->get();

        return response([
            "status"=>1,
            "mgs"=>"¡listado de Blog",
            "data"=>$blogs
        ]);
    }





    public function showBlog($id){
        
    }







    public function updateBlog(Request $request, $id){
        $user_id = auth()->user()->id;
        if(Blog::where(["user_id"=>$user_id,"id"=>$id])->exists()){
            $blog=Blog::find($id);

            $blog->title=$request->title;
            $blog->content=$request->content;
            $blog->save();

            return response([
                "status"=>1,
                "mgs"=>"¡Blog actualizado correctamente",
            ]);

        }else{
            return response([
                "status"=>0,
                "mgs"=>"¡No se encontro Blog",
            ],404);

        }
    }





    public function deleteBlog($id){
        $user_id = auth()->user()->id;
        if(Blog::where(["id"=>$id,"user_id"=>$user_id])->exists()){
            $blog=Blog::where(["id"=>$id,"user_id"=>$user_id])->first();
            $blog->delete();
            
            return response([
                "status"=>1,
                "mgs"=>"¡Se elimino correctamente",
            ]);
        }else{
            return response([
                "status"=>0,
                "mgs"=>"¡No se encontro Blog",
            ],404);

        }
    }
}
