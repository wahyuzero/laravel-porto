<x-public-layout pageTitle="500 — Server Error" metaDescription="Server error">
    <div style="text-align:center;padding:40px 0">
        <pre class="mono text-accent" style="font-size:10px;line-height:1.3">
  ____   ___   ___
 | ___| / _ \ / _ \
 |___ \| | | | | | |
  ___) | |_| | |_| |
 |____/ \___/ \___/
        </pre>
        <h1 class="mt-2">SEGFAULT</h1>
        <p class="mono text-muted mt-1" style="font-size:12px">
            <span class="text-accent">error: internal server error</span><br>
            something broke. the developer has been notified (probably).
        </p>
        <p class="mt-2 mono" style="font-size:12px">
            <a href="{{ route('home') }}">[← home]</a>
        </p>
    </div>
</x-public-layout>