<x-public-layout pageTitle="403 — Forbidden" metaDescription="Access denied">
    <div style="text-align:center;padding:40px 0">
        <pre class="mono text-accent" style="font-size:10px;line-height:1.3">
  _  _    ___ _____
 | || |  / _ \___ /
 | || |_| | | ||_ \
 |__   _| | | |__) |
    | | | |_| / __/
    |_|  \___/_____|
        </pre>
        <h1 class="mt-2">ACCESS DENIED</h1>
        <p class="mono text-muted mt-1" style="font-size:12px">
            <span class="text-accent">error: permission denied (0o750)</span>
        </p>
        <p class="mt-2 mono" style="font-size:12px">
            <a href="{{ route('home') }}">[← home]</a>
        </p>
    </div>
</x-public-layout>