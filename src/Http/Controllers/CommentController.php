<?php namespace Laravelista\Comments\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Laravelista\Comments\Comments\Comment;
use League\Fractal\Manager;
use Laravelista\Syndra\Syndra;
use Laravelista\Comments\Comments\CommentTransformer;
use League\Fractal\Resource\Collection;
use Illuminate\Routing\Controller as BaseController;

class CommentController extends BaseController
{
    protected $fractal;
    protected $syndra;

    public function __construct(Manager $fractal, Syndra $syndra)
    {
        $this->fractal = $fractal;
        $this->syndra = $syndra;
    }

    /**
     * Prepares valid content from
     * config for validation.
     *
     * @return string
     */
    public function getValidContentString()
    {
        return implode(',', config('comments.content'));
    }

    /**
     * Basic rules for validation on every request.
     *
     * @return array
     */
    public function getBasicRules()
    {
        return [
            'content' => 'required|string|in:' . $this->getValidContentString(),
            'id' => 'required|int|min:1'
        ];
    }

    /**
     * Returns a validator instance with basic and additional rules.
     *
     * @param  array  $data             Most likely $request->all().
     * @param  array $additional_rules Request specific rules.
     * @return Validator
     */
    public function baseValidate(array $data, array $additional_rules = [])
    {
        return Validator::make($data,
            array_merge($this->getBasicRules(), $additional_rules)
        );
    }

    /**
     * Based on content and id, it returns an eloquent model.
     *
     * @param  string $content Eg. App\user
     * @param  int    $id      Model id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getModel(string $content, int $id)
    {
        return $content::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = $this->baseValidate($request->all());

        if($validator->fails()) {
            return $this->syndra->respondValidationError(
                $validator->errors()->getMessages()
            );
        }

        $model = $this->getModel(
            $request->get('content'),
            $request->get('id')
        );

        $resource = new Collection($model->comments, new CommentTransformer);
        $data = $this->fractal->createData($resource)->toArray();

        return $this->syndra->respond($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->baseValidate($request->all(), [
            'comment' => 'required|string'
        ]);

        if($validator->fails()) {
            return $this->syndra->respondValidationError(
                $validator->errors()->getMessages()
            );
        }

        $model = $this->getModel(
            $request->get('content'),
            $request->get('id')
        );

        $comment = new Comment;
        $comment->user()->associate(auth()->user());
        $comment->content()->associate($model);
        $comment->comment = $request->get('comment');
        $comment->save();

        return $this->syndra->respondCreated();
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
}
