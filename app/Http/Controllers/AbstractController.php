<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * AbstractController Class abstract controller shared across all controllers
 * @package App\Http\Controllers
 * @author Amira Sherif
 */
abstract class AbstractController extends Controller
{
    /**
     * @var Request $request instance from Request object
     */
    protected $request;

    /**
     * AbstractController constructor.
     * @param Request $request instance from Request object
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}