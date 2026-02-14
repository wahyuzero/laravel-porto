<x-public-layout pageTitle="503 — System Maintenance">

    <div style="text-align:center;padding:60px 0">
        <pre class="mono text-accent" style="font-size:11px;line-height:1.2">
 __  __    _    ___ _   _ _____ _____ _   _    _    _   _  ____ _____
|  \/  |  / \  |_ _| \ | |_   _| ____| \ | |  / \  | \ | |/ ___| ____|
| |\/| | / _ \  | ||  \| | | | |  _| |  \| | / _ \ |  \| | |   |  _|
| |  | |/ ___ \ | || |\  | | | | |___| |\  |/ ___ \| |\  | |___| |___
|_|  |_/_/   \_\___|_| \_| |_| |_____|_| \_/_/   \_\_| \_|\____|_____|
        </pre>

        <h1 style="margin-top:24px">SERVICE UNAVAILABLE</h1>

        <div class="ascii-border mt-2" style="display:inline-block;text-align:left;max-width:500px">
            <div class="mono" style="font-size:12px">
                <span class="text-muted">$</span> <span class="text-heading">systemctl status web</span><br>
                <span class="text-accent">● web.service - FrugalDev</span><br>
                <span class="text-muted">&nbsp;&nbsp;Status:</span> <span class="text-accent">maintenance
                    mode</span><br>
                <span class="text-muted">&nbsp;&nbsp;Since:</span> {{ date('Y-m-d H:i:s T') }}<br><br>
                <span class="text-green">We're performing scheduled maintenance.</span><br>
                <span class="text-green">System will be back online shortly.</span><br><br>
                <span class="text-muted">$</span> <span class="cursor-blink"></span>
            </div>
        </div>

        <div class="mt-2">
            <span class="mono text-muted" style="font-size:11px">try again in a few minutes</span>
        </div>
    </div>

</x-public-layout>