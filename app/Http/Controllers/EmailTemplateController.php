<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\EmailTemplateRequest;
use App\Services\EmailTemplateService;
use App\Traits\BreadCrumbTrait;

class EmailTemplateController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new EmailTemplateService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $emailTemplates = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('Email Template Management', 'emailTemplates.index', null);
            return view('emailTemplates.list',compact('emailTemplates', 'breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(string $name)
    {
        if(request()->ajax()) {
            try {
                $pricinpalLetter = EmailTemplate::name($name)->first()->toArray();
                return $this->returnJsonResponse(true, null, $pricinpalLetter);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Email Template Management', 'emailTemplates.index', $emailTemplate->name);
            return view('emailTemplates.create',compact('emailTemplate', 'breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmailTemplateRequest  $request
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        try {
            $this->service->update($request->all(), $emailTemplate);
            return redirect("emailTemplates")->withSuccess('Email Template details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        //
    }
}
