<?php

namespace App\Http\Controllers;

interface IController {
    public function getData($id = null);
}