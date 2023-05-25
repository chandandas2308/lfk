<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogVideo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;
use Video;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class BlogController extends Controller
{
    //
    // public function index()
    // {
    //     return view('superadmin.blogs');
    // }

    public function website()
    {
        return view('superadmin.website');
    }


      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('superadmin.blogs', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->title, '-');
        if (!file_exists('Blogs')) {
            mkdir('Blogs', 666, true);
        }
        $image_resize = Image::make($request->image->getRealPath());
        // $image_resize->resize(400, 400);
        $image_resize->save(public_path('Blogs/' . $slug . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));
        $path = 'Blogs/' . $slug . date('d_m_y_h') . time() . "." .  $request->image->extension();
        Blog::create([
            'slug'  => $slug,
            "title" => $request->title,
            "image" => $path,
            "description" => $request->description
        ]);
        return response()->json(['success'=>'Blog Created Successfully!']);
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
    public function update(Request $request)
    {
        $slug = Str::slug($request->title, '-');
        $old_data =  Blog::find($request->id);

        if ($request->image != null) {
            $image_resize = Image::make($request->image->getRealPath());
            // $image_resize->resize(400, 400);
            $image_resize->save(public_path('Blogs/' . $slug . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));
            $path = 'Blogs/' . $slug . date('d_m_y_h') . time() . "." .  $request->image->extension();
            $imagepath = $path;
            File::delete($old_data->image);
        } else {
            $imagepath = $old_data->image;
        }
        Blog::where('id', $request->id)->update([
            'slug' => $slug,
            "title" => $request->title,
            "image" => $imagepath,
            "description" => $request->description
        ]);
        return response()->json(['success'=> 'Blog Updated Successfully!']);
    }
    public function changestatus(Request $request)
    {
        $blog = Blog::find($request->id);
        Blog::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        return response()->json(['success' => 'Blog Status Changed Successfully.']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $data = Blog::where('id', '=', $_GET['id'])->first();
        File::delete($data->image);
        Blog::where("id", $data->id)->delete();
        return response()->json(["success"=>"Blog Deleted Successfully !"]);
    }

    public function view()
    {
        $data = Blog::find(request()->id);
        if(request()->status == 0){
            return view('superadmin.blog.image-blog.editBlog',["data"=>$data]);
        }else{
            return view('superadmin.blog.image-blog.viewBlog',["data"=>$data]);
        }
    }

    
    
    public function allView()
    {
        $data = FacadesDB::table('blogs')->orderBy('id','desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewOrders" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editOrders" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteOrders" data-toggle="modal" data-target="#removeModalSalesOrders" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->title,
                '<img src="/'.$item->image.'" height="100" width="100" />',
                $action
            );
            $action = '';
        }

        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($data),
            "recordsFiltered" 	=> sizeOf($data),
            "data" 				=> $new_data
        );
        echo json_encode($output);

    }

    // add video
    public function videostore(Request $request)
    {
 
        $this->validate($request, [
            'titleVideo' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
        
        $slug = Str::slug($request->titleVideo, '-');
        if (!file_exists('videos')) {
            mkdir('videos', 666, true);
        }
    
        $filePath = 'videos';

        $file_name = $slug.time().'.'.$request->video->extension();
        $request->video->move(public_path($filePath),$file_name);
        
         BlogVideo::create([
            'slug'  => $slug,
            "title" => $request->titleVideo,
            "video_name" => $file_name,
            "video" => $filePath.'/'.$file_name,
            "description" => $request->descriptionVideo
        ]);
       
    
        return redirect()->back()->with('status','Blog Video Created Successfully!');
        // return response()->json(['success'=>'Blog Video Created Successfully!']);
    }

    public function Videoview()
    {
        $data = BlogVideo::find(request()->id);
        if(request()->status == 0){
            return view('superadmin.blog.video-blog.editblog-video',["data"=>$data]);
        }else{
            return view('superadmin.blog.video-blog.viewblog-video',["data"=>$data]);
        }
    }

    public function videoallView()
    {
        $data = FacadesDB::table('blog_videos')->orderBy('id','desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewBlogVideo" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editBlogVideo" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteBlogVideo" data-toggle="modal" data-target="#removeModalVideo" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->title,
                $item->video_name,
                $action
            );
            $action = '';
        }

        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($data),
            "recordsFiltered" 	=> sizeOf($data),
            "data" 				=> $new_data
        );
        echo json_encode($output);   
    }

    public function videodestroy()
    {
        $data = BlogVideo::where('id', '=', $_GET['id'])->first();
        File::delete($data->image);
        BlogVideo::where("id", $data->id)->delete();
        return response()->json(["success"=>"Blog Video Deleted Successfully !"]);
    }

    public function videoupdate(Request $request)
    {
        $slug = Str::slug($request->editTitle, '-');
        $old_data =  BlogVideo::find($request->id);
        if ($request->editVideo != null) {
            // $fileName = $request->editVideo->getClientOriginalName();
            
            $filePath = 'videos';

            $file_name = $slug.time().'.'.$request->video->extension();
            // $request->video->move(public_path($filePath),$file_name);

            $request->editVideo->move(public_path($filePath),$file_name);
            
            File::delete($old_data->video);
        } else {
            $fileName = $old_data->editVideo;
            
        }
        BlogVideo::where('id', $request->id)->update([
            'slug' => $slug,
            "title" => $request->editTitle,
            "video_name" => $file_name,
            "video" => $filePath.'/'.$file_name,
            "description" => $request->description
        ]);
        // return response()->json(['success'=> 'Blog Updated Successfully!']);
        return redirect()->back()->with('status','Blog Video Updated Successfully!');
    }

}
