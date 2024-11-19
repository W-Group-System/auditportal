<?php

namespace App\Http\Controllers;
use App\Whistleblower;
use App\Mail\WhistleBlow;
use Illuminate\Support\Facades\Mail;
use App\WhistleblowerAttachment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WhistleBlowerController extends Controller
{
    //
    public function new(Request $request)
    {
        return view('newWhistle');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $new = new Whistleblower;
        $new->issue = $request->issue;
        $new->name_of_respondent = $request->name_of_respondent;
        $new->department_of_respondent = $request->department;
        $new->risk = $request->risk;
        $new->date_of_incident = $request->date_of_incident;
        $new->name_of_whistleblower = $request->name_of_whistleblower;
        $new->save();

        if ($request->hasFile('proof')) {
            $files = $request->file('proof');
            $file_names = [];
            foreach ($files as $attachment) {
                $name = time() . '_' . $attachment->getClientOriginalName();
                $attachment->move(public_path() . '/proof/', $name);
                $file_name = '/proof/' . $name;
                $file_names[] = $file_name;
                $newProof = new WhistleblowerAttachment;
                $newProof->whistleblower_id = $new->id;
                $newProof->file_name = $file_name;
                $newProof->save();
            }
          
        
        }
        $data = [];
        $data['data'] = $new;
        $data['file_name'] = $file_name;
        $send_update = Mail::to(['richsel.villaruel@wgroup.com.ph','bea.bernardino@rico.com.ph'])->send(new WhistleBlow($data));
        Alert::success('Your report has been successfully submitted and recorded. Thank you for your input. We will review it and take appropriate action shortly.')->persistent('Dismiss');
        return redirect('/whistle-blower');

    }
    public function reports()
    {
        $lists = Whistleblower::with('attachments')->orderBy('id','desc')->get();
        return view('whitlereport',
        array('lists' =>$lists)
    );

    }
}
