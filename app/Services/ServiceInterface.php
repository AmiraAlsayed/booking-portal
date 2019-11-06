<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 * Interface ServiceInterface
 * @package App\Service
 */
interface ServiceInterface {

    public function show($id);

    public function create(Request $request);

    public function all();

}
