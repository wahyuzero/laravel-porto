<x-admin-layout pageTitle="Settings">
        <div class="admin-header">
                <h1>Site Settings</h1>
        </div>
        <form action="{{ route('admin.settings.update') }}" method="POST" style="max-width:700px">@csrf @method('PUT')
                <div class="form-group"><label class="form-label">Site Name</label><input type="text" name="site_name"
                                class="form-input" value="{{ $settings['site_name'] ?? 'FrugalDev' }}"></div>
                <div class="form-group"><label class="form-label">Tagline</label><input type="text" name="site_tagline"
                                class="form-input" value="{{ $settings['site_tagline'] ?? '' }}"></div>
                <div class="form-group"><label class="form-label">Description (SEO)</label><textarea
                                name="site_description" class="form-input"
                                rows="2">{{ $settings['site_description'] ?? '' }}</textarea></div>
                <div class="form-group"><label class="form-label">Footer Text</label><input type="text"
                                name="footer_text" class="form-input" value="{{ $settings['footer_text'] ?? '' }}">
                </div>
                <div class="form-group"><label class="form-label">ASCII Banner</label><textarea name="ascii_banner"
                                class="form-input" rows="6"
                                style="font-family:monospace">{{ $settings['ascii_banner'] ?? '' }}</textarea></div>

                <div style="margin:16px 0;border-top:1px solid #334155;padding-top:16px">
                        <h3 style="color:#94a3b8;font-size:14px;margin-bottom:12px">📊 Analytics Tracking</h3>
                        <div class="form-group"><label class="form-label">Google Analytics ID (GA4)</label><input
                                        type="text" name="ga_id" class="form-input"
                                        value="{{ $settings['ga_id'] ?? '' }}" placeholder="G-XXXXXXXXXX"></div>
                        <div class="form-group"><label class="form-label">Plausible Domain</label><input type="text"
                                        name="plausible_domain" class="form-input"
                                        value="{{ $settings['plausible_domain'] ?? '' }}" placeholder="yourdomain.com">
                        </div>
                        <div class="form-group"><label class="form-label">Umami Website ID</label><input type="text"
                                        name="umami_id" class="form-input" value="{{ $settings['umami_id'] ?? '' }}"
                                        placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"></div>
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
</x-admin-layout>