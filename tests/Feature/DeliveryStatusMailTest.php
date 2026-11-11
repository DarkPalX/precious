<?php

namespace Tests\Feature;

use Tests\TestCase;

class DeliveryStatusMailTest extends TestCase
{
    private function renderStatusMail(string $deliveryType, string $deliveryStatus = 'In Transit'): string
    {
        $order = (object) [
            'delivery_type' => $deliveryType,
            'delivery_status' => $deliveryStatus,
            'order_number' => 'INV-1001',
            'cancellation_reason' => null,
            'user' => (object) ['firstname' => 'Customer'],
            'deliveries' => collect(),
        ];

        $setting = (object) [
            'company_logo' => 'logo.png',
            'company_name' => 'Precious Pages',
            'mobile_no' => '09123456789',
            'tel_no' => '1234567',
            'email' => 'support@example.test',
        ];

        return view('mail.delivery-status', compact('order', 'setting'))
            ->with('h', $order)
            ->render();
    }

    public function test_pickup_status_uses_pickup_details_without_courier_language(): void
    {
        $html = $this->renderStatusMail('pickup');

        $this->assertStringContainsString('ready for pickup', $html);
        $this->assertStringContainsString('G/F Jrich Corporate Center', $html);
        $this->assertStringContainsString('Monday to Friday', $html);
        $this->assertStringNotContainsString('DOOR-TO-DOOR DELIVERY', $html);
        $this->assertStringNotContainsString('CHAMP COURIER', $html);
        $this->assertStringNotContainsString('endorsed to our courier', $html);
    }

    public function test_door_to_door_status_keeps_courier_details(): void
    {
        $html = $this->renderStatusMail('d2d');

        $this->assertStringContainsString('DOOR-TO-DOOR DELIVERY', $html);
        $this->assertStringContainsString('CHAMP COURIER', $html);
        $this->assertStringNotContainsString('FOR PICK-UP ORDERS', $html);
    }
}
