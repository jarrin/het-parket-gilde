<?php
// POST handler for admin forms
// This file should be included in admin/index.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section'])) {
    $section = $_POST['section'];
    
    switch ($section) {
        case 'site':
            $content['site']['title'] = $_POST['site_title'] ?? '';
            $content['site']['description'] = $_POST['site_description'] ?? '';
            $content['site']['contact']['phone'] = $_POST['contact_phone'] ?? '';
            $content['site']['contact']['email'] = $_POST['contact_email'] ?? '';
            $content['site']['contact']['address'] = $_POST['contact_address'] ?? '';
            $content['site']['contact']['city'] = $_POST['contact_city'] ?? '';
            $content['site']['contact']['zipcode'] = $_POST['contact_zipcode'] ?? '';
            
            // Header kleuren
            $content['site']['colors']['header']['background'] = $_POST['header_bg'] ?? '';
            $content['site']['colors']['header']['text'] = $_POST['header_text'] ?? '';
            $content['site']['colors']['header']['logo'] = $_POST['header_logo'] ?? '';
            
            // Footer kleuren
            $content['site']['colors']['footer']['background'] = $_POST['footer_bg'] ?? '';
            $content['site']['colors']['footer']['text'] = $_POST['footer_text'] ?? '';
            $content['site']['colors']['footer']['links'] = $_POST['footer_links'] ?? '';
            break;
            
        case 'home':
            $content['home']['hero']['title'] = $_POST['hero_title'] ?? '';
            $content['home']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
            $content['home']['hero']['description'] = $_POST['hero_description'] ?? '';
            $content['home']['hero']['image'] = $_POST['hero_image'] ?? '';
            
            $content['home']['intro']['title'] = $_POST['intro_title'] ?? '';
            $content['home']['intro']['text'] = $_POST['intro_text'] ?? '';
            $content['home']['intro']['image'] = $_POST['intro_image'] ?? '';
            
            $content['home']['vakmanschap']['title'] = $_POST['vak_title'] ?? '';
            $content['home']['vakmanschap']['subtitle'] = $_POST['vak_subtitle'] ?? '';
            $content['home']['vakmanschap']['text'] = $_POST['vak_text'] ?? '';
            break;
            
        case 'home_colors':
            // Hero sectie kleuren
            $content['home']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
            $content['home']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
            $content['home']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
            
            // Intro sectie kleuren
            $content['home']['intro']['colors']['background'] = $_POST['intro_bg'] ?? '';
            $content['home']['intro']['colors']['text'] = $_POST['intro_text'] ?? '';
            $content['home']['intro']['colors']['title'] = $_POST['intro_title'] ?? '';
            
            // Vakmanschap sectie kleuren
            $content['home']['vakmanschap']['colors']['background'] = $_POST['vak_bg'] ?? '';
            $content['home']['vakmanschap']['colors']['text'] = $_POST['vak_text'] ?? '';
            $content['home']['vakmanschap']['colors']['title'] = $_POST['vak_title'] ?? '';
            break;
            
        case 'diensten':
            $content['diensten']['hero']['title'] = $_POST['hero_title'] ?? '';
            $content['diensten']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
            $content['diensten']['hero']['image'] = $_POST['hero_image'] ?? '';
            
            // Update services
            for ($i = 0; $i < 3; $i++) {
                if (isset($_POST['service_title_' . $i])) {
                    $content['diensten']['services'][$i]['title'] = $_POST['service_title_' . $i];
                    $content['diensten']['services'][$i]['description'] = $_POST['service_desc_' . $i] ?? '';
                    $content['diensten']['services'][$i]['image'] = $_POST['service_image_' . $i] ?? '';
                }
            }
            break;
            
        case 'diensten_colors':
            // Pagina achtergrond kleur
            $content['diensten']['colors']['page_background'] = $_POST['page_bg'] ?? '';
            
            // Hero sectie kleuren
            $content['diensten']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
            $content['diensten']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
            $content['diensten']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
            
            // Service secties kleuren
            for ($i = 0; $i < 3; $i++) {
                if (isset($_POST['service_bg_' . $i])) {
                    $content['diensten']['services'][$i]['colors']['background'] = $_POST['service_bg_' . $i];
                    $content['diensten']['services'][$i]['colors']['text'] = $_POST['service_text_' . $i] ?? '';
                    $content['diensten']['services'][$i]['colors']['title'] = $_POST['service_title_' . $i] ?? '';
                }
            }
            break;
            
        case 'over_ons':
            $content['over_ons']['hero']['title'] = $_POST['hero_title'] ?? '';
            $content['over_ons']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
            $content['over_ons']['hero']['image'] = $_POST['hero_image'] ?? '';
            
            $content['over_ons']['story']['title'] = $_POST['story_title'] ?? '';
            $content['over_ons']['story']['paragraphs'][0] = $_POST['story_p1'] ?? '';
            $content['over_ons']['story']['paragraphs'][1] = $_POST['story_p2'] ?? '';
            $content['over_ons']['story']['paragraphs'][2] = $_POST['story_p3'] ?? '';
            
            $content['over_ons']['founder']['name'] = $_POST['founder_name'] ?? '';
            $content['over_ons']['founder']['title'] = $_POST['founder_title'] ?? '';
            $content['over_ons']['founder']['quote'] = $_POST['founder_quote'] ?? '';
            $content['over_ons']['founder']['image'] = $_POST['founder_image'] ?? '';
            break;
            
        case 'over_ons_colors':
            // Hero sectie
            $content['over_ons']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
            $content['over_ons']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
            $content['over_ons']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
            
            // Story sectie
            $content['over_ons']['story']['colors']['background'] = $_POST['story_bg'] ?? '';
            $content['over_ons']['story']['colors']['text'] = $_POST['story_text'] ?? '';
            $content['over_ons']['story']['colors']['title'] = $_POST['story_title'] ?? '';
            
            // Founder sectie
            $content['over_ons']['founder']['colors']['background'] = $_POST['founder_bg'] ?? '';
            $content['over_ons']['founder']['colors']['text'] = $_POST['founder_text'] ?? '';
            $content['over_ons']['founder']['colors']['title'] = $_POST['founder_title'] ?? '';
            
            // Values sectie
            $content['over_ons']['values_colors']['background'] = $_POST['values_bg'] ?? '';
            $content['over_ons']['values_colors']['text'] = $_POST['values_text'] ?? '';
            $content['over_ons']['values_colors']['title'] = $_POST['values_title'] ?? '';
            break;
            
        case 'contact':
            $content['contact']['hero']['title'] = $_POST['hero_title'] ?? '';
            $content['contact']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
            $content['contact']['hero']['image'] = $_POST['hero_image'] ?? '';
            
            $content['contact']['intro']['title'] = $_POST['intro_title'] ?? '';
            $content['contact']['intro']['text'] = $_POST['intro_text'] ?? '';
            
            // Contact info
            $content['contact']['info']['phone']['value'] = $_POST['phone_value'] ?? '';
            $content['contact']['info']['phone']['link'] = $_POST['phone_link'] ?? '';
            $content['contact']['info']['email']['value'] = $_POST['email_value'] ?? '';
            $content['contact']['info']['email']['link'] = $_POST['email_link'] ?? '';
            $content['contact']['info']['address']['street'] = $_POST['address_street'] ?? '';
            $content['contact']['info']['address']['city'] = $_POST['address_city'] ?? '';
            
            // Hours
            $content['contact']['hours']['title'] = $_POST['hours_title'] ?? '';
            $content['contact']['hours']['schedule'] = [
                $_POST['schedule_0'] ?? '',
                $_POST['schedule_1'] ?? '',
                $_POST['schedule_2'] ?? ''
            ];
            break;
            
        case 'contact_colors':
            // Page level colors
            $content['contact']['colors']['header'] = $_POST['color_header'] ?? '';
            $content['contact']['colors']['heroText'] = $_POST['color_hero_text'] ?? '';
            $content['contact']['colors']['sectionBg'] = $_POST['color_section_bg'] ?? '';
            
            // Hero sectie
            $content['contact']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
            $content['contact']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
            if (isset($_POST['hero_overlay'])) {
                $content['contact']['hero']['colors']['overlay'] = $_POST['hero_overlay'];
            }
            
            // Intro sectie
            $content['contact']['intro']['colors']['background'] = $_POST['intro_bg'] ?? '';
            $content['contact']['intro']['colors']['text'] = $_POST['intro_text'] ?? '';
            $content['contact']['intro']['colors']['title'] = $_POST['intro_title'] ?? '';
            
            // Info sectie
            $content['contact']['info']['colors']['background'] = $_POST['info_bg'] ?? '';
            $content['contact']['info']['colors']['text'] = $_POST['info_text'] ?? '';
            $content['contact']['info']['colors']['title'] = $_POST['info_title'] ?? '';
            
            // Hours sectie
            $content['contact']['hours']['colors']['background'] = $_POST['hours_bg'] ?? '';
            $content['contact']['hours']['colors']['text'] = $_POST['hours_text'] ?? '';
            $content['contact']['hours']['colors']['title'] = $_POST['hours_title'] ?? '';
            break;
    }
    
    if (saveContent($content)) {
        $saved = true;
        // Reload content to show updated values
        $content = loadContent();
    } else {
        $error = 'Kon de wijzigingen niet opslaan';
    }
}
