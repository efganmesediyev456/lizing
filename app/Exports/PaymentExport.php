<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
{
    $search = request('search') ? request('search') : '';

    $query = Payment::with([
        'driver',
        'leasing.vehicle.brand',
        'leasing.vehicle.model'
    ])->orderBy('id','desc');

    if ($search) {
        $searchMap = [
            'depozit' => 'deposit_debt',
            'ilkin depozit' => 'deposit_payment',
            'aylıq' => 'monthly',
            'günlük' => 'daily',
            'admin' => 'deposit_admin'
        ];

        $matchedTypes = collect($searchMap)
            ->filter(function ($originalType, $displayType) use ($search) {
                return stripos($displayType, $search) !== false;
            })
            ->values()
            ->toArray();

        $query = $query->whereHas('driver', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('surname', 'like', "%$search%");
            })->orWhereHas('leasing.vehicle', function ($q) use ($search) {
                $q->where('state_registration_number', 'like', "%$search%")
                  ->orWhereHas('brand', function ($q) use ($search) {
                      $q->where('title', 'like', "%$search%");
                  })->orWhereHas('model', function ($q) use ($search) {
                      $q->where('title', 'like', "%$search%");
                  });
            })->orWhere('price', 'like', "%{$search}%")
              ->orWhere('created_at', 'like', "%{$search}%")
              ->orWhereIn('payment_type', $matchedTypes);
    }

    return $query->get();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Tarix',
            'Ad Soyad',
            'Marka',
            'Model',
            'D.Q.N.', 
            'Qiymət',
            'Ödəniş Tipi',
            'Nağd/Onlayn',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->created_at->format('Y-m-d'),
            $payment->driver?->fullName,
            $payment->leasing?->vehicle?->brand?->title,
            $payment->leasing?->vehicle?->model?->title,
            $payment->leasing?->vehicle?->state_registration_number,
            $payment->price . ' AZN',
            match($payment->payment_type) {
                'deposit_debt' => 'Depozit',
                'deposit_payment' => 'İlkin Depozit',
                'monthly' => 'Aylıq',
                'daily' => 'Günlük',
                "deposit_admin" => "Admin",
                default => "Bilinməyən status"
            },
            $payment->payment_back_or_app==0 ? 'Onlayn' : ($payment->payment_back_or_app==1 ? 'Nağd' : '')
        ];
    }
}
