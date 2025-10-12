@component('mail::message')
# Payment Receipt - Invoice #{{ $invoice->number }}

Hello {{ $supplier->name }},

We have attached the payment receipt for invoice **#{{ $invoice->number }}**.

@component('mail::panel')
**Invoice Date:** {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
**Total Amount:** {{ number_format($invoice->total, 2) }} €
@endcomponent

If you have any questions, please contact us.

Best regards,<br>

@endcomponent