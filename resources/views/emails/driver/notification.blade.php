@component("mail::message")
#Salam , {{ $driver->name }}

Yeni bir bildirişiniz var. Lütfən sistemə daxil olun və yoxlayın.

Təşəkkürlər,<br>
{{ config('app.name') }}
@endcomponent