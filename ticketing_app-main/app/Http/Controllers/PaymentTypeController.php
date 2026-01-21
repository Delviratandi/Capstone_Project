<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    // READ - tampilkan semua tipe pembayaran
    public function index()
    {
        return response()->json(PaymentType::all());
    }

    // CREATE - tambah tipe pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentType = PaymentType::create([
            'name' => $request->name,
        ]);

        return response()->json($paymentType, 201);
    }

    // UPDATE - update tipe pembayaran
    public function update(Request $request, $id)
    {
        $paymentType = PaymentType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentType->update([
            'name' => $request->name,
        ]);

        return response()->json($paymentType);
    }

    // DELETE - hapus tipe pembayaran
    public function destroy($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $paymentType->delete();

        return response()->json([
            'message' => 'Payment type deleted successfully'
        ]);
    }
}
