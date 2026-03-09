<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;

final class WebsiteService
{
    /**
     * Get the site name.
     */
    public function getSiteName(): string
    {
        return (string) Setting::get('site.name', config('app.name', 'Penguin'));
    }

    /**
     * Get the site tagline.
     */
    public function getSiteTagline(): string
    {
        return (string) Setting::get('site.tagline', 'The ultimate starter kit for your next project.');
    }

    /**
     * Get the contact email.
     */
    public function getContactEmail(): string
    {
        return (string) Setting::get('site.contact_email', 'hello@example.com');
    }

    /**
     * Get the light mode logo URL or path.
     */
    public function getLogoLight(): ?string
    {
        return Setting::get('site.logo_light');
    }

    /**
     * Get the dark mode logo URL or path.
     */
    public function getLogoDark(): ?string
    {
        return Setting::get('site.logo_dark');
    }

    /**
     * Get the favicon URL or path.
     */
    public function getFavicon(): ?string
    {
        return Setting::get('site.favicon');
    }

    /**
     * Get the global SEO title.
     */
    public function getSeoTitle(): string
    {
        return (string) Setting::get('site.seo_title', $this->getSiteName());
    }

    /**
     * Get the global SEO description.
     */
    public function getSeoDescription(): string
    {
        return (string) Setting::get('site.seo_description', $this->getSiteTagline());
    }

    /**
     * Get the global SEO keywords.
     */
    public function getSeoKeywords(): string
    {
        return (string) Setting::get('site.seo_keywords', 'laravel, starter kit, penguin');
    }

    /**
     * Get the global SEO social sharing image.
     */
    public function getSeoSocialImage(): ?string
    {
        return Setting::get('site.seo_social_image');
    }

    /**
     * Get the Google Analytics ID.
     */
    public function getGoogleAnalyticsId(): ?string
    {
        return Setting::get('site.google_analytics_id');
    }

    /**
     * Get the Google Tag Manager ID.
     */
    public function getGtmId(): ?string
    {
        return Setting::get('site.gtm_id');
    }

    /**
     * Get the Meta (Facebook) Pixel ID.
     */
    public function getMetaPixelId(): ?string
    {
        return Setting::get('site.meta_pixel_id');
    }

    /**
     * Get custom header scripts.
     */
    public function getCustomScriptsHeader(): ?string
    {
        return Setting::get('site.custom_scripts_header');
    }

    /**
     * Get custom footer scripts.
     */
    public function getCustomScriptsFooter(): ?string
    {
        return Setting::get('site.custom_scripts_footer');
    }

    /**
     * Save multiple site settings at once.
     *
     * @param  array<string, mixed>  $settings
     */
    public function save(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::set('site.'.$key, $value, 'site');
        }
    }
}
