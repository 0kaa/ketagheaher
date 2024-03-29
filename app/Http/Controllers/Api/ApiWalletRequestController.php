<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\WalletRequest;
use Illuminate\Http\Request;

class ApiWalletRequestController extends Controller
{
    use ApiResponseTrait;

    // create wallet request
    public function createWalletRequest()
    {
        $user = auth()->user();

        if ($user->wallet->balance < 100) {
            return $this->ApiResponse(null, trans('local.at_least_100_sar'), 404);
        }

        if (WalletRequest::where('user_id', $user->id)->where('is_approved', 0)->exists()) {
            return $this->ApiResponse(null, trans('local.already_requested_money'), 404);
        }

        WalletRequest::create([
            'amount' => $user->wallet->balance,
            'user_id' => $user->id,
            'is_approved' => 0
        ]);

        return $this->ApiResponse(null, trans('local.wallet_request_successfuly'), 200);
    }
}
