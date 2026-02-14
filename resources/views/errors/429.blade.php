<x-public-layout pageTitle="429 — Too Many Requests" metaDescription="Rate limit exceeded">
    <div style="text-align:center;padding:40px 0">
        <pre class="mono text-accent" style="font-size:10px;line-height:1.3">
  _  _  ____  ___
 | || ||___ \/ _ \
 | || |_ __) | (_) |
 |__   _/ __/ \__, |
    |_||_____|  /_/
        </pre>
        <h1 class="mt-2">RATE LIMITED</h1>
        <p class="mono text-muted mt-1" style="font-size:12px">
            <span class="text-accent">error: too many requests</span><br>
            slow down, cowboy. try again in a minute.
        </p>
        <p class="mt-2 mono" style="font-size:12px">
            <a href="{{ route('home') }}">[← home]</a>
        </p>
    </div>
</x-public-layout>