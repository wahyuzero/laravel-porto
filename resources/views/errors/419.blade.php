<x-public-layout pageTitle="419 — Session Expired">

    <div style="text-align:center;padding:60px 0">
        <pre class="mono text-accent" style="font-size:11px;line-height:1.2">
 _  _ _ ___
| || / |/ _ \
| || | |\_, /
|__  | |/ /
   |_|_/_/
        </pre>

        <h1 style="margin-top:24px">SESSION EXPIRED</h1>

        <div class="ascii-border mt-2" style="display:inline-block;text-align:left;max-width:500px">
            <div class="mono" style="font-size:12px">
                <span class="text-muted">$</span> <span class="text-heading">submit --form</span><br>
                <span class="text-accent">ERROR: CSRF token mismatch</span><br>
                <span class="text-muted">Your session has expired. Please refresh and try again.</span><br><br>
                <span class="text-green">Tip: This usually happens if you left the page open too long.</span><br><br>
                <span class="text-muted">$</span> <span class="cursor-blink"></span>
            </div>
        </div>

        <div class="mt-2">
            <a href="javascript:location.reload()" class="btn">refresh page</a>
            <a href="{{ route('home') }}" class="btn">← cd ~</a>
        </div>
    </div>

</x-public-layout>