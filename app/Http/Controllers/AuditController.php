<?php

namespace App\Http\Controllers;
use App\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //

    public function index()
    {
        //
        $audits = Audit::get();
        return view(
            'audit',
            array(
                'audits' => $audits,
            )
        );
    }
}
