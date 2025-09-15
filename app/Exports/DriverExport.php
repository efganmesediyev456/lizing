<?php

namespace App\Exports;

use App\Models\Driver;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DriverExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private int $index = 0;

    public function collection()
    {
        $query =  Driver::orderBy('id','desc');
        $search = request()->search;
        if($search){
            $query=$query->where('tableId', 'like','%'.$search.'%')->orWhere('name','like',"%$search%")
            ->orWhere("surname","like","%$search%")
            ->orWhere("email","like","%$search%")
            ->orWhere("fin","like","%$search%")
            ->orWhere("phone","like","%$search%");
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No:',
            'Table İD',
            'Ad Soyad',
            'Ata adı',
            'Leasing Borcu',
            'Ilkin Deposit Borcu',
            'Deposit Borcu',
            'Mail',
            'Fin',
            'Şəxsiyyətin seriya nömrəsi',
            'Faktiki yaşadığı ünvan',
            'Qeydiyyatda olduğu ünvan',
            'Doğum Tarixi',
            'Cinsi',
            'Şəhər',
            'Əlaqə nömrəsi',
            'Əlaqə nömrəsi2',
            'Əlaqə nömrəsi3',
            'Əlaqə nömrəsi4'
        ];
    }

    public function map($driver): array
    {
        return [
            ++$this->index, 
            $driver->tableId,
            $driver->name . ' ' . $driver->surname,
            $driver->father_name,
            $driver->debt > 0 ?  $driver->debt  : 0,
            $driver->leasing?->deposit_payment > 0 ?   $driver->leasing?->deposit_payment : 0,
            $driver->leasing?->deposit_debt > 0 ?   $driver->leasing?->deposit_debt  : 0,
            $driver->email,
            $driver->fin,
            $driver->id_card_serial_code,
            $driver->current_address,
            $driver->registered_address,
            $driver->date?->format('Y-m-d'),
            match ($driver->gender) {
                    0 => 'Kişi',
                    1 => 'Qadın',
                    default => 'Naməlum',
            },
            $driver->city?->title,
            $driver->phone,
            ($driver->phone2_label.'-' ?? '') .  $driver->phone2,
            ($driver->phone3_label.'-' ?? '') .  $driver->phone3,
            ($driver->phone4_label.'-' ?? '') .  $driver->phone4,
            // $driver->created_at->format('Y-m-d'),
        ];
    }
}
