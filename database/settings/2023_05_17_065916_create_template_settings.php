<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('template.home_page_title', 'Faites vos achats avec K-shop Ecommerce - Simplifiez votre expérience shopping');
        $this->migrator->add('template.home_page_description', 'Découvrez une vaste sélection d’électroménagers et de gadgets électroniques haut de gamme. Améliorez votre vie avec des solutions innovantes et économes en énergie.');
        $this->migrator->add('template.home_page_hero_carousel_handle', '');
        $this->migrator->add('template.home_page_perk_carousel_handle', '');
        $this->migrator->add('template.home_page_sections', []);
    }

    public function down()
    {
        $this->migrator->deleteIfExists('template.home_page_title');
        $this->migrator->deleteIfExists('template.home_page_description');
        $this->migrator->deleteIfExists('template.home_page_hero_carousel_handle');
        $this->migrator->deleteIfExists('template.home_page_perk_carousel_handle');
        $this->migrator->deleteIfExists('template.home_page_sections');
    }
};
