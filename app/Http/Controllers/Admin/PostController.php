<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user')->get();
        // dd($posts);
        if ($request->ajax()) {
            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('created_by', function ($row) {
                    return $row->user->full_name;
                })
                ->addColumn('status', function ($row) {
                    $is_approve = $row['is_approve'] ? '<span class="badge bg-success">Approve</span>' : '<span class="badge bg-danger">Deny</span>';
                    return $is_approve;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('view-post',['id' => $row['id']]).'" class="edit btn btn-primary btn-sm">View Post</a>';
                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('admin.post.index', ['posts' => $posts]);
    }

    public function viewPost($id){
        $post = Post::where('id','=',$id)->first();
        return view('admin.post.post',['post' => $post]);
    }

    public function postApproveDeny($id){
        $user = Post::where('id','=',$id)->first();
        $is_approve = !$user->is_approve ? true : false;

        Post::where('id','=',$id)->update(['is_approve' => $is_approve]);

        return redirect()->route('view-post',['id' => $id]);
    }
}
