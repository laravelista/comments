<?php namespace Laravelista\Comments\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Manager;
use Laravelista\Syndra\Syndra;
use Laravelista\Comments\Comments\UserTransformer;
use League\Fractal\Resource\Item;

class UserController extends BaseController
{
    protected $fractal;
    protected $syndra;

    public function __construct(Syndra $syndra, Manager $fractal)
    {
        $this->fractal = $fractal;
        $this->syndra = $syndra;
    }

    public function getAuthenticatedUser()
    {
        if(auth()->guest()) {
            return "false";
        }

        $resource = new Item(auth()->user(), new UserTransformer);
        $data = $this->fractal->createData($resource)->toArray();

        return $this->syndra->respond($data);
    }
}
