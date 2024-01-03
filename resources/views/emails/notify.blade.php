<x-mail::message>
# Introduction

Congrstulations! You are now a premium member.
<p>Your purchace details</p>
<p>Plan: {{ $plan }}</p>
<p>Your plan end on {{ $billingEndsAt }}</p>
<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
