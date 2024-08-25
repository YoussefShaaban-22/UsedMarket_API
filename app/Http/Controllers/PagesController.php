<?php

namespace App\Http\Controllers;

use App\Models\ReturnPolicy;
use App\Models\Shippingpolicy;
use App\Models\PrivacyPolicy;
use App\Models\TermsService;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function ReturnPolicyindex()
    {
        $ReturnPolicy = ReturnPolicy::all();
        return $ReturnPolicy;
    }
    public function ReturnPolicyshow($id)
    {
        $ReturnPolicy = ReturnPolicy::find($id);
        return $ReturnPolicy;
    }

    public function ReturnPolicyupdate(Request $request, $id)
    {
        $request->validate([
            "content" => 'required',
        ]);
        $ReturnPolicy = ReturnPolicy::find($id);
        $ReturnPolicy->update([
            "content" => $request->content,
        ]);

        $response = [
            "ReturnPolicy" => $ReturnPolicy,
            "message" => "ReturnPolicy updated successfully.",
        ];
        return response($response, 201);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function Shippingpolicyindex()
    {
        $Shippingpolicy = Shippingpolicy::all();
        return $Shippingpolicy;
    }
    public function Shippingpolicyshow($id)
    {
        $Shippingpolicy = Shippingpolicy::find($id);
        return $Shippingpolicy;
    }

    public function Shippingpolicyupdate(Request $request, $id)
    {
        $request->validate([
            "content" => 'required',
        ]);
        $Shippingpolicy = Shippingpolicy::find($id);
        $Shippingpolicy->update([
            "content" => $request->content,
        ]);

        $response = [
            "Shippingpolicy" => $Shippingpolicy,
            "message" => "Shippingpolicy updated successfully.",
        ];
        return response($response, 201);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function PrivacyPolicyindex()
    {
        $PrivacyPolicy = PrivacyPolicy::all();
        return $PrivacyPolicy;
    }
    public function PrivacyPolicyshow($id)
    {
        $PrivacyPolicy = PrivacyPolicy::find($id);
        return $PrivacyPolicy;
    }

    public function PrivacyPolicyupdate(Request $request, $id)
    {
        $request->validate([
            "content" => 'required',
        ]);
        $PrivacyPolicy = PrivacyPolicy::find($id);
        $PrivacyPolicy->update([
            "content" => $request->content,
        ]);

        $response = [
            "PrivacyPolicy" => $PrivacyPolicy,
            "message" => "PrivacyPolicy updated successfully.",
        ];
        return response($response, 201);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function TermsServiceindex()
    {
        $TermsService = TermsService::all();
        return $TermsService;
    }
    public function TermsServiceshow($id)
    {
        $TermsService = TermsService::find($id);
        return $TermsService;
    }

    public function TermsServiceupdate(Request $request, $id)
    {
        $request->validate([
            "content" => 'required',
        ]);
        $TermsService = TermsService::find($id);
        $TermsService->update([
            "content" => $request->content,
        ]);

        $response = [
            "TermsService" => $TermsService,
            "message" => "TermsService updated successfully.",
        ];
        return response($response, 201);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
