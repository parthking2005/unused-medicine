<?php

namespace App\Http\Controllers;

use App\Models\MedicineExpiration;
use App\Models\MedicineStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicineExpirationController extends Controller
{
    public function index()
    {
        $ngoId = Auth::user()->ngo_id;
        
        $expiringSoon = MedicineExpiration::with('medicineStock.medicine')
            ->whereHas('medicineStock', function($query) use ($ngoId) {
                $query->where('ngo_id', $ngoId);
            })
            ->expiringSoon()
            ->get();

        $expired = MedicineExpiration::with('medicineStock.medicine')
            ->whereHas('medicineStock', function($query) use ($ngoId) {
                $query->where('ngo_id', $ngoId);
            })
            ->expired()
            ->get();

        return view('ngo.medicine.expiration.index', [
            'expiringSoon' => $expiringSoon,
            'expired' => $expired
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'medicine_stock_id' => 'required|exists:medicine_stocks,id',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today'
        ]);

        $medicineStock = MedicineStock::findOrFail($request->medicine_stock_id);
        
        // Check if user belongs to the same NGO as the medicine stock
        if ($medicineStock->ngo_id !== Auth::user()->ngo_id) {
            return back()->withErrors(['error' => 'Unauthorized action']);
        }

        MedicineExpiration::create($request->all());

        return back()->with('success', 'Medicine expiration date added successfully');
    }

    public function dispose(Request $request, MedicineExpiration $expiration)
    {
        $this->validate($request, [
            'disposal_notes' => 'nullable|string|max:500'
        ]);

        // Check authorization
        if ($expiration->medicineStock->ngo_id !== Auth::user()->ngo_id) {
            return back()->withErrors(['error' => 'Unauthorized action']);
        }

        $expiration->dispose($request->disposal_notes);

        return back()->with('success', 'Medicine marked as disposed successfully');
    }

    public function report()
    {
        $ngoId = Auth::user()->ngo_id;
        
        $disposedMedicines = MedicineExpiration::with('medicineStock.medicine')
            ->whereHas('medicineStock', function($query) use ($ngoId) {
                $query->where('ngo_id', $ngoId);
            })
            ->where('status', 'disposed')
            ->orderBy('disposed_at', 'desc')
            ->get();

        return view('ngo.medicine.expiration.report', [
            'disposedMedicines' => $disposedMedicines
        ]);
    }
}
