<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\WalletRequest;
use App\Services\Notify;
use Illuminate\Http\Request;

class WalletRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet_requests = WalletRequest::all();

        return view('admin.wallet-requests.index', compact('wallet_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet_request = WalletRequest::find($id);

        return view('admin.wallet-requests.show', compact('wallet_request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approve($id)
    {
        $wallet_request = WalletRequest::find($id);

        if ($wallet_request && $wallet_request->is_approved != 1) {

            $wallet_request->update(['is_approved' => 1]);

            $wallet_request->user->wallet->balance = 0;
            $wallet_request->user->wallet->save();

            // // Notification to user with wallet
            $notification = Notification::create([
                'user_id'       => $wallet_request->user_id,
                'type'          => 'wallet_request',
                'model_id'      => $wallet_request->id,
                'message_en'    => 'Your wallet has been approved by admin',
                'message_ar'    => 'تمت الموافقة على طلب رصيدك بواسطة المشرف',
            ]);

            Notify::NotifyMob($notification->message_ar, $notification->message_en, $wallet_request->user_id, null, $data = null);

            return redirect()->back()->with('success', __('local.wallet_request_approved'));
        }
    }
}
