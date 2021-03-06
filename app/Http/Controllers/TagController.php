<?php namespace Learn\Http\Controllers;

use Learn\Http\Requests;
use Learn\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Learn\Http\Requests\TagCreateRequest;
use Learn\Http\Requests\TagUpdateRequest;
use Learn\Models\Tag;
use Learn\Repos\TagRepo;
use Learn\Services\MessageService;

class TagController extends Controller {

    protected $tag;
    protected $repo;
    protected $message;

    function __construct(Tag $tag, TagRepo $repo, MessageService $message)
    {
        $this->tag = $tag;
        $this->repo = $repo;
        $this->message = $message;
    }

    /**
	 * Display a listing of the resource in the admin area.
	 *
	 * @return Response
	 */
	public function adminIndex()
	{
		$tags = $this->tag->paginate(50);
        return view('admin/tags/index')->with('tags', $tags);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function adminCreate()
	{
		return view('admin/tags/create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param TagCreateRequest $request
     * @return Response
     */
	public function adminStore(TagCreateRequest $request)
	{
		$this->tag = $this->tag->fill($request->all());
        $this->tag->save();
        $this->message->success('New tag "' . $this->tag->name . '" has been saved.');

        if ($request->has('tags')) {
            $this->tag->syncTagArray($request->get('tags'));
        }
        $this->repo->cleanCache($this->tag);
        return redirect('admin/tags');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function adminEdit($id)
	{
		$this->tag = $this->tag->find($id);
        return view('admin/tags/edit')->with('tag', $this->tag);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function adminUpdate(TagUpdateRequest $request, $id)
	{
		$this->tag = $this->tag->find($id);
        $this->tag->fill($request->all());
        $this->tag->save();
        $this->message->success('Tag "' . $this->tag->name . '" has been updated.');

        $this->tag->syncTagArray($request->get('tags'));
        $this->repo->cleanCache($this->tag);
        return redirect('/admin/tags/' . $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function adminDestroy($id)
	{
        $name = $this->repo->destroy($id);
        $this->message->success('Tag "' . $name . '" has been deleted.');
        return redirect('/admin/tags');
	}

}
