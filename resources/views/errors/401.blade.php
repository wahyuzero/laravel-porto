<x-public-layout pageTitle="401 — Unauthorized">

    <div style="text-align:center;padding:60px 0">
        <pre class="mono text-accent" style="font-size:11px;line-height:1.2">
 _  _    ___  _
| || |  / _ \/ |
| || |_| | | | |
|__   _| |_| | |
   |_|  \___/|_|
        </pre>

        <h1 style="margin-top:24px">UNAUTHORIZED</h1>

        <div class="ascii-border mt-2" style="display:inline-block;text-align:left;max-width:500px">
            <div class="mono" style="font-size:12px">
                <span class="text-muted">$</span> <span class="text-heading">sudo access</span><br>
                <span class="text-accent">ERROR: Permission denied</span><br>
                <span class="text-muted">You need to authenticate to access this resource.</span><br><br>
                <span class="text-muted">$</span> <span class="cursor-blink"></span>
            </div>
        </div>

        <div class="mt-2">
            <a href="{{ route('home') }}" class="btn">← cd ~</a>
            <a href="{{ url('/login') }}" class="btn">login →</a>
        </div>
    </div>

</x-public-layout>