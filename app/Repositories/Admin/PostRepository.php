<?php

namespace App\Repositories\Admin;

use App\Models\Post;
use App\Repositories\Admin\PostInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class PostRepository implements  PostInterface
{
    public function  getPostOfIndex()
    {
        return $posts=Post::with('postCategory')->get();
    }
    public function  storePost(Request $request)
    {
        //dd($request->all());
        
        $data = new Post();
        $data->post_category_id = $request->post_category_id;
        $data->post_title = $request->post_title;
        $data->post_sub_title = $request->post_sub_title;
        $data->user_id=Auth::id();
        //single thumbnail
        if ($request->post_thumbnail) {
            $post_thumbnail = $request->post_thumbnail;
            $photoname = time() . '.' .  $request->post_title . '.' .  $post_thumbnail->getClientOriginalExtension();
            Image::make($post_thumbnail)->resize(600, 600)->save('public/files/post/' . $photoname);

            $data->post_thumbnail = $photoname; // public/files/product/plus-point.jpg
        }

        $images = [];
        $images = array();
        if($request->hasFile('post_images')){
            foreach ($request->file('post_images') as $key => $image) {
                $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(600,600)->save('public/files/product/'.$imageName);
                array_push($images, $imageName);
            }
            $data['post_images'] = json_encode($images);
        }
        $data->post_description = $request->post_description;
        $data->post_sub_remarks = $request->post_sub_remarks;
        $data->save();
        return  $data;
    }

    public function getPostId($id)
    {
        return $post = Post::find($id);
    }

    public function updatePost(Request $request, $id)
    {
        $data = Post::findOrFail($id);
        $data->post_category_id = $request->post_category_id;
        $data->post_title = $request->post_title;
        $data->post_sub_title = $request->post_sub_title;
        if ($request->post_thumbnail) {
            if (!$data->post_thumbnail == null) {
                unlink(public_path('public/files/post/' . $data->post_thumbnail));
            }

            $post_thumbnail= $request->post_thumbnail;
            $photoname = time() . '.' .  $request->post_title  .  '.' . $post_thumbnail->getClientOriginalExtension();
            Image::make($post_thumbnail)->resize(600, 600)->save('public/files/post/' . $photoname);
            $data->post_thumbnail = $photoname; // public/files/product/plus-point.jpg
        }
        //multiple images
        $post_images = [];
        if ($request->hasFile('post_images')) {
            $multiimage = json_decode($data->post_images);
            if (!$data->post_images == null) {
                foreach ($multiimage as $imagee) {
                    unlink(public_path('files/post/' . $imagee));
                }
            }
            foreach ($request->file('post_images') as $key => $image) {
                $imageName = hexdec(uniqid()) . '.' .$image->getClientOriginalExtension();
                Image::make($post_images) ->resize(600, 600)->save('public/files/post/' . $imageName);
                array_push($post_images, $imageName);
            }
            $data->post_images = json_encode($post_images);
        }
        $data->post_description = $request->post_description;
        $data->post_sub_remarks = $request->post_sub_remarks;
        $data->save();
        return  $data;
    }
    public function deletePost($id)
    {


        $post = Post::findOrFail($id);

        if (! $post->post_thumbnail == null) {
            unlink(public_path('files/post/' . $post->post_thumbnail));
        }
        $multiimage = json_decode($post->post_images);
        if (!$post->post_images == null) {
            foreach ($multiimage as $imagee) {
                unlink(public_path('files/product/' . $imagee));
            }
        }
      return  Post::destroy($id);
    }
}
