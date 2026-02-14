<x-public-layout pageTitle="404 — Not Found" metaDescription="Page not found">
    <div style="text-align:center;padding:40px 0">
        <pre class="mono text-accent" style="font-size:10px;line-height:1.3">
  _  _    ___  _  _
 | || |  / _ \| || |
 | || |_| | | | || |_
 |__   _| | | |__   _|
    | | | |_| |  | |
    |_|  \___/   |_|
        </pre>
        <h1 class="mt-2">FILE NOT FOUND</h1>
        <p class="mono text-muted mt-1" style="font-size:12px">
            <span class="text-muted">$</span> ls {{ request()->path() }}<br>
            <span class="text-accent">error: no such file or directory</span>
        </p>
        <p class="mt-2 mono" style="font-size:12px">
            <a href="{{ route('home') }}">[← home]</a>
        </p>
    </div>
</x-public-layout>