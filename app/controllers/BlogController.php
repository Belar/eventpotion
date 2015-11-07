<?php

class BlogController extends \BaseController {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        $posts = Post::where('public_state','=',true)->orderBy('created_at', 'desc')->paginate(10);

        return View::make('blog.index_post', array('pageTitle' => 'Blog', 'posts'=>$posts));
    }

    
    public function blogTag($tag)
	{
			
		$posts = Post::where('public_state', '=', true)->where('tags', 'LIKE', '%'.$tag.'%')->orderBy('created_at', 'desc')->paginate(10);
				
		return View::make('blog.index_post', array('posts' => $posts, 'pageTitle' => 'Blog Posts'));
	
	}

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function create()
    {
        return View::make('blog.add_post', array('pageTitle' => 'Add Post'));
    }


    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store()
    {
        // Fetch all request data.
        $data = Input::only('title', 'content', 'tags', 'public_state', 'image');
        // Build the validation constraint set.
        $rules = array(
            'title' => array('required', 'min:3'),
            'content' => array('max:21800'),
            'public_state' => array('integer'),	
        );
        // Create a new validator instance.
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {

            $current_user = Sentry::getUser();

            $post = new Post();
            $post->author_id = $current_user->id;

            $title = Input::get('title');				
            $uniqid = str_shuffle(uniqid());
            $post->slug = Str::slug($title, '-').'-'.$uniqid;

            $post->title = $title;

            $post->content = Input::get('content');
            $post->tags = Input::get('tags');

            $post->public_state = ( Input::get('public_state') ? 1 : 0);

            $file = Input::file('image');

            if($file){
                $destinationPath = 'uploads/posts/';
                $filename = $file->getClientOriginalName();
                Input::file('image')->move($destinationPath, $filename);

                $img = Image::make($destinationPath.$filename);
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destinationPath.'800/'.$filename);

                $img = Image::make($destinationPath.$filename);
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destinationPath.'400/'.$filename);

                $post->header_image = $filename;
            }

            $post->save();

            return Redirect::to('/')->with('global_success', 'Post submitted successfuly!');
        }

        return Redirect::to('/blog/add')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
    }


    /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($id)
    {
        $post = Post::where('id','=',$id)->orWhere('slug','=',$id)->first();
        return View::make('blog.show_post', array('pageTitle'=>$post->title, 'post'=>$post));
    }


    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id)
    {
        $post = Post::find($id);
        return View::make('blog.edit_post', array('post'=>$post));
    }


    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id)
    {

        $post = Post::find($id);

        // Fetch all request data.
        $data = Input::only('title', 'content', 'tags', 'public_state', 'image');
        // Build the validation constraint set.
        $rules = array(
            'title' => array('required', 'min:3'),
            'content' => array('max:21800'),
            'public_state' => array('integer'),	
        );
        // Create a new validator instance.
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {

            $title = Input::get('title');	

            if ($post->title !== $title)
            {
                $uniqid = str_shuffle(uniqid());
                $post->slug = Str::slug($title, '-').'-'.$uniqid;
                $post->title = $title;
            }

            $uniqid = str_shuffle(uniqid());
            $post->slug = Str::slug($title, '-').'-'.$uniqid;

            $post->title = $title;

            $post->content = Input::get('content');
            $post->tags = Input::get('tags');

            $post->public_state = ( Input::get('public_state') ? 1 : 0);

            $file = Input::file('image');
            if($file){
                $destinationPath = 'uploads/posts/';
                $filename = $file->getClientOriginalName();

                if(! $filename == $post->header_image)
                {
                    Input::file('image')->move($destinationPath, $filename);

                    $img = Image::make($destinationPath.$filename);
                    $img->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($destinationPath.'800/'.$filename);

                    $img = Image::make($destinationPath.$filename);
                    $img->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($destinationPath.'400/'.$filename);

                    $post->header_image = $filename;
                }
            }

            $post->save();

            return Redirect::to('/')->with('global_success', 'Post submitted successfuly!');
        }

        return Redirect::to('/blog/add')->withInput()->withErrors($validator)->with('message', 'Validation Errors!');
    }


    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id)
    {
        //
    }


}
