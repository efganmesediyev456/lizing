<?php

namespace App\Services;

use App\Models\Leasing;
use PhpOffice\PhpWord\TemplateProcessor;

class ContractService
{

    function numberToWordsAz($number)
    {
        $ones = [
            0 => 'sıfır',
            1 => 'bir',
            2 => 'iki',
            3 => 'üç',
            4 => 'dörd',
            5 => 'beş',
            6 => 'altı',
            7 => 'yeddi',
            8 => 'səkkiz',
            9 => 'doqquz',
            10 => 'on',
            11 => 'on bir',
            12 => 'on iki',
            13 => 'on üç',
            14 => 'on dörd',
            15 => 'on beş',
            16 => 'on altı',
            17 => 'on yeddi',
            18 => 'on səkkiz',
            19 => 'on doqquz'
        ];

        $tens = [
            2 => 'iyirmi',
            3 => 'otuz',
            4 => 'qırx',
            5 => 'əlli',
            6 => 'altmış',
            7 => 'yetmiş',
            8 => 'səksən',
            9 => 'doxsan'
        ];

       
        if ($number < 20) {
            return $ones[$number] ?? '';
        } elseif ($number < 100) {
            $ten = intdiv($number, 10);
            $one = $number % 10;

            $tenText = $tens[$ten] ?? '';
            $oneText = $one > 0 ? ($ones[$one] ?? '') : '';

            return trim($tenText . ' ' . $oneText);
        } elseif ($number == 100) {
            return 'yüz';
        }


        return (string) $number;
    }


    public function generate(Leasing $leasing): string
    {
        $templatePath = storage_path('app/templates/muqavile.docx');

        if (!file_exists($templatePath)) {
            throw new \Exception("Müqavilə şablonu tapılmadı: " . $templatePath);
        }

        $templateProcessor = new TemplateProcessor($templatePath);


        $templateProcessor->setValue('driver_fullname', $leasing->driver->fullname ?? '');
        $templateProcessor->setValue('driver_fin', $leasing->driver->fin ?? '');
        $templateProcessor->setValue('driver_id_card_serial_code', $leasing->driver->id_card_serial_code ?? '');
        $templateProcessor->setValue(
            'leasing_start_date',
            $leasing->start_date
            ? $leasing->start_date->locale('az')->translatedFormat('d F Y')
            : ''
        );
        $templateProcessor->setValue(
            'leasing_end_date',
            $leasing->end_date
                ? $leasing->end_date->locale('az')->translatedFormat('d F Y')
                : ''
        );
        $templateProcessor->setValue('vehicle_brand', $leasing->vehicle?->brand?->title ?? '');
        $templateProcessor->setValue('vehicle_state_registration_number', $leasing->vehicle?->state_registration_number ?? '');
        $templateProcessor->setValue('vehicle_production_year', $leasing->vehicle?->production_year ?? '');
        $templateProcessor->setValue('vehicle_engine', $leasing->vehicle?->engine ?? '');
        $templateProcessor->setValue('vehicle_ban', $leasing->vehicle?->model?->banType?->title ?? '');
        $templateProcessor->setValue('leasing_deposit_payment', $leasing->deposit_payment ?? '');
        $templateProcessor->setValue('leasing_period_months', $leasing->leasing_period_months ?? '');
        $templateProcessor->setValue('leasing_period_months_text', $this->numberToWordsAz($leasing->leasing_period_months) ?? '');
        $templateProcessor->setValue('leasing_daily_payment', $leasing->daily_payment ?? '');
        $templateProcessor->setValue('leasing_daily_payment_text', $this->numberToWordsAz($leasing->daily_payment ?? 0) ?? '');
        $templateProcessor->setValue('leasing_color', $leasing->vehicle?->color?->title ?? '');


        $fileName = 'muqavile_' . $leasing->id . '.docx';
        $savePath = storage_path('app/public/muqavile/' . $fileName);

        if (!is_dir(dirname($savePath))) {
            mkdir(dirname($savePath), 0777, true);
        }

        // Faylı yaz
        $templateProcessor->saveAs($savePath);

        // DB-də yolunu saxla (əgər contract_file sütunu varsa)
        $leasing->update(['contract_file' => 'muqavile/' . $fileName]);

        return $savePath;
    }
}
