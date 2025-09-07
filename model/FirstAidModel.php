<?php
class FirstAidModel {
    public function getGuides() {
        return [
            ["title" => "🔥 Burns", "desc" => "Cool under running water for 20 minutes. Do not use ice."],
            ["title" => "🩸 Bleeding", "desc" => "Apply pressure with a clean cloth. Keep wound elevated."],
            ["title" => "☀ Heat Stroke", "desc" => "Move to shade, sip water, and seek medical help."],
            ["title" => "🦴 Fractures", "desc" => "Immobilize the area and avoid unnecessary movement."]
        ];
    }
}
