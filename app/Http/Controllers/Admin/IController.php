<?php

namespace App\Http\Controllers\Admin;

interface IController {
    public function getData($id = null);
}