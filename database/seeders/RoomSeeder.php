<?php

namespace Database\Seeders;

use App\Models\PartialCost;
use App\Models\PartialRates;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\RoomType;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = RoomStatus::firstWhere('name', 'Disponible');

        $six_hour = RoomType::firstWhere('name', '6H');
        $six_hour_partial = PartialRates::firstWhere('name', '6h');
        $eight_hour_partial = PartialRates::firstWhere('name', '8h');
        $eight_hour = RoomType::firstWhere('name', '8H');

        PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 213,
        ]);

        PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 250
        ]);
        PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 300
        ]);
        PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 300
        ]);
        PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 500
        ]);
        PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 400
        ]);
        $partialCost = PartialCost::create([
            "room_type_id"     => $six_hour->id,
            "partial_rates_id" => $six_hour_partial->id,
            "rate"             => 450
        ]);

        Room::create([
            'room_status_id' => $status->id,
            'partial_cost_id' => $partialCost->id,
            'description' => '6H',
            'name' => '6H'
        ]);

        // --------------------------------------------

        PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 213,
        ]);
        PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 250,
        ]);
        PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 300,
        ]);
        PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 300,
        ]);
        PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 500,
        ]);
        PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 400,
        ]);
        $partialCost = PartialCost::create([
            "room_type_id"     => $eight_hour->id,
            "partial_rates_id" => $eight_hour_partial->id,
            'rate' => 450,
        ]);

        Room::create([
            'room_status_id' => $status->id,
            'partial_cost_id' => $partialCost->id,
            'description' => '8H',
            'name' => '8H'
        ]);
    }
}
