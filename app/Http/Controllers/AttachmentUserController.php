<?php

namespace App\Http\Controllers;
use App\AttachmentUser;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;
class AttachmentUserController extends Controller
{
    //

    public function view($id)
    {

    }
    public function store(Request $request,$id)
    {
        AttachmentUser::where('attachment_id',$id)->delete();
        foreach($request->share as $share)
        {
            $attachmentUser = new AttachmentUser;
            $attachmentUser->user_id = $share;
            $attachmentUser->attachment_id = $id;
            $attachmentUser->save();
        }

        Alert::success('Successfully Share')->persistent('Dismiss');
        return back();
    }
}
;