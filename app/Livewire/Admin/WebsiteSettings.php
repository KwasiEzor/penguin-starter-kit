<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\PermissionEnum;
use App\Livewire\Concerns\HasToast;
use App\Services\WebsiteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
final class WebsiteSettings extends Component
{
    use HasToast;
    use WithFileUploads;

    // General
    public string $name = '';

    public string $tagline = '';

    public string $contactEmail = '';

    // Branding
    public $logoLight;

    public $logoDark;

    public $favicon;

    public ?string $currentLogoLight = null;

    public ?string $currentLogoDark = null;

    public ?string $currentFavicon = null;

    // SEO
    public string $seoTitle = '';

    public string $seoDescription = '';

    public string $seoKeywords = '';

    public $seoSocialImage;

    public ?string $currentSeoSocialImage = null;

    // Integrations
    public ?string $googleAnalyticsId = null;

    public ?string $gtmId = null;

    public ?string $metaPixelId = null;

    // Scripts
    public ?string $customScriptsHeader = null;

    public ?string $customScriptsFooter = null;

    public function mount(WebsiteService $websiteService): void
    {
        $this->name = $websiteService->getSiteName();
        $this->tagline = $websiteService->getSiteTagline();
        $this->contactEmail = $websiteService->getContactEmail();

        $this->currentLogoLight = $websiteService->getLogoLight();
        $this->currentLogoDark = $websiteService->getLogoDark();
        $this->currentFavicon = $websiteService->getFavicon();

        $this->seoTitle = $websiteService->getSeoTitle();
        $this->seoDescription = $websiteService->getSeoDescription();
        $this->seoKeywords = $websiteService->getSeoKeywords();
        $this->currentSeoSocialImage = $websiteService->getSeoSocialImage();

        $this->googleAnalyticsId = $websiteService->getGoogleAnalyticsId();
        $this->gtmId = $websiteService->getGtmId();
        $this->metaPixelId = $websiteService->getMetaPixelId();

        $this->customScriptsHeader = $websiteService->getCustomScriptsHeader();
        $this->customScriptsFooter = $websiteService->getCustomScriptsFooter();
    }

    public function deleteImage(string $type, WebsiteService $websiteService): void
    {
        $path = match ($type) {
            'logo_light' => $this->currentLogoLight,
            'logo_dark' => $this->currentLogoDark,
            'favicon' => $this->currentFavicon,
            'seo_social_image' => $this->currentSeoSocialImage,
            default => null,
        };

        if ($path) {
            Storage::disk('public')->delete($path);
            $websiteService->save([$type => null]);

            match ($type) {
                'logo_light' => $this->currentLogoLight = null,
                'logo_dark' => $this->currentLogoDark = null,
                'favicon' => $this->currentFavicon = null,
                'seo_social_image' => $this->currentSeoSocialImage = null,
            };

            $this->toastSuccess('Image deleted successfully.');
        }
    }

    public function save(WebsiteService $websiteService): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'contactEmail' => 'nullable|email|max:255',
            'logoLight' => 'nullable|image|max:1024',
            'logoDark' => 'nullable|image|max:1024',
            'favicon' => 'nullable|image|max:512',
            'seoTitle' => 'nullable|string|max:255',
            'seoDescription' => 'nullable|string|max:500',
            'seoKeywords' => 'nullable|string|max:500',
            'seoSocialImage' => 'nullable|image|max:2048',
            'googleAnalyticsId' => 'nullable|string|max:50',
            'gtmId' => 'nullable|string|max:50',
            'metaPixelId' => 'nullable|string|max:50',
        ]);

        $settings = [
            'name' => $this->name,
            'tagline' => $this->tagline,
            'contact_email' => $this->contactEmail,
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
            'seo_keywords' => $this->seoKeywords,
            'google_analytics_id' => $this->googleAnalyticsId,
            'gtm_id' => $this->gtmId,
            'meta_pixel_id' => $this->metaPixelId,
        ];

        // Security check for custom scripts (XSS protection)
        if (Auth::user()->can(PermissionEnum::SettingsManage->value)) {
            $settings['custom_scripts_header'] = $this->customScriptsHeader;
            $settings['custom_scripts_footer'] = $this->customScriptsFooter;
        }

        if ($this->logoLight) {
            if ($this->currentLogoLight) {
                Storage::disk('public')->delete($this->currentLogoLight);
            }
            $settings['logo_light'] = $this->logoLight->store('branding', 'public');
            $this->currentLogoLight = $settings['logo_light'];
            $this->logoLight = null;
        }

        if ($this->logoDark) {
            if ($this->currentLogoDark) {
                Storage::disk('public')->delete($this->currentLogoDark);
            }
            $settings['logo_dark'] = $this->logoDark->store('branding', 'public');
            $this->currentLogoDark = $settings['logo_dark'];
            $this->logoDark = null;
        }

        if ($this->favicon) {
            if ($this->currentFavicon) {
                Storage::disk('public')->delete($this->currentFavicon);
            }
            $settings['favicon'] = $this->favicon->store('branding', 'public');
            $this->currentFavicon = $settings['favicon'];
            $this->favicon = null;
        }

        if ($this->seoSocialImage) {
            if ($this->currentSeoSocialImage) {
                Storage::disk('public')->delete($this->currentSeoSocialImage);
            }
            $settings['seo_social_image'] = $this->seoSocialImage->store('seo', 'public');
            $this->currentSeoSocialImage = $settings['seo_social_image'];
            $this->seoSocialImage = null;
        }

        $websiteService->save($settings);

        $this->toastSuccess('Website settings saved successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.website-settings');
    }
}
