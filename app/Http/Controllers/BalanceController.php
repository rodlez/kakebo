<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Exception;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Balance $balance)
    {
        /* resticted access - only user who owns the type has access
        if ($balance->user_id !== request()->user()->id) {
            abort(403);
        }*/
        try {
            $balance->delete();
            return to_route('balances.index')->with('message', 'Account (' . $balance->name . ') successfully deleted');
        } catch (Exception $e) {
            return to_route('balances.index')->with('message', 'Error (' . $e->getCode() . ') Account: ' . $balance->name . ' can not be deleted');
        }
    }
}
