<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $paymentTypes = PaymentType::latest()->get();
        return view('admin.payment-type.index', compact('paymentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:payment_types,name'],
        ]);

        PaymentType::create($validated);

        return redirect()
            ->route('admin.payment-types.index')
            ->with('success', 'Tipe pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, PaymentType $payment_type)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:payment_types,name,' . $payment_type->id],
        ]);

        $payment_type->update($validated);

        return redirect()
            ->route('admin.payment-types.index')
            ->with('success', 'Tipe pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentType $payment_type)
    {
        $payment_type->delete();

        return redirect()
            ->route('admin.payment-types.index')
            ->with('success', 'Tipe pembayaran berhasil dihapus.');
    }

    // Tidak dipakai karena CRUD kita taruh di 1 halaman (index + modal)
    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
}
