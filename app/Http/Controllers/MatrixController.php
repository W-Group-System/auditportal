<?php

namespace App\Http\Controllers;
use App\Consequence;
use App\Likelihood;
use App\Matrix;
use Illuminate\Http\Request;

class MatrixController extends Controller
{
//
    public function index()
    {
        $consequences = Consequence::orderBy('number')->get();
        $likelihoods = Likelihood::orderBy('number')->get();
        $matrices = Matrix::orderBy('from')->get();
        return view('matrices',array(
            'consequences' => $consequences,
            'likelihoods' => $likelihoods,
            'matrices' => $matrices,
        ));
    }
}
