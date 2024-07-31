<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('brand.slogan', 'Faites vos achats avec K-shop Ecommerce - Simplifiez votre expérience shopping');
        $this->migrator->add('brand.short_description', 'Découvrez une vaste sélection d’électroménagers et de gadgets électroniques haut de gamme. Améliorez votre vie avec des solutions innovantes et économes en énergie.');
        $this->migrator->add('brand.logo_path', '');
        $this->migrator->add('brand.favicon_path', '');
        $this->migrator->add('brand.cover_path', '');
        $this->migrator->add('brand.social_links', [
            [
                'name' => 'Facebook',
                'url' => '',
                'url_placeholder' => 'https://facebook.com/k-shop',
            ],
            [
                'name' => 'Twitter',
                'url' => '',
                'url_placeholder' => 'https://twitter.com/k-shop',
            ],
            [
                'name' => 'Pinterest',
                'url' => '',
                'url_placeholder' => 'https://pinterest.com/k-shop',
            ],
            [
                'name' => 'Instagram',
                'url' => '',
                'url_placeholder' => 'https://instagram.com/k-shop',
            ],
            [
                'name' => 'TikTok',
                'url' => '',
                'url_placeholder' => 'https://tiktok.com/@k-shop',
            ],
            [
                'name' => 'Tumblr',
                'url' => '',
                'url_placeholder' => 'https://k-shop.tumblr.com',
            ],
            [
                'name' => 'Snapchat',
                'url' => '',
                'url_placeholder' => 'https://snapchat.com/add/k-shop',
            ],
            [
                'name' => 'YouTube',
                'url' => '',
                'url_placeholder' => 'https://youtube.com/c/k-shop',
            ],
            [
                'name' => 'Vimeo',
                'url' => '',
                'url_placeholder' => 'https://vimeo.com/k-shop',
            ],
        ]);
    }

    public function down()
    {
        $this->migrator->deleteIfExists('brand.slogan');
        $this->migrator->deleteIfExists('brand.short_description');
        $this->migrator->deleteIfExists('brand.logo_path');
        $this->migrator->deleteIfExists('brand.favicon_path');
        $this->migrator->deleteIfExists('brand.cover_path');
        $this->migrator->deleteIfExists('brand.socials');
    }
};
