<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * app/Models/VehicleCargoTankDetail.php
 * Model do tabeli szczegółów zbiorników ładunkowych pojazdów, zawierający informacje o typie zbiornika, klasie ciśnienia, ochronie termicznej, metodzie rozładunku, materiale oraz czy jest to pojazd ADR
 */
class VehicleCargoTankDetail extends Model
{
    protected $table='vehicle_cargo_tank_details';
    protected $fillable=[
        'vehicle_id',
        'tank_type_id',
        'pressure_class_id',
        'thermal_protection_id',
        'discharge_method_id',
        'material_id',
        'is_adr',
        'adr_id',
        'compartment_count'
    ];
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    public function tankType(){
        return $this->belongsTo(VehicleTankType::class,'tank_type_id');
    }
    public function pressureClass(){
        return $this->belongsTo(VehicleTankPressureType::class,'pressure_class_id');
    }
    public function thermalProtection(){
        return $this->belongsTo(VehicleThermalProtectionType::class,'thermal_protection_id');
    }
    public function dischargeMethod(){
        return $this->belongsTo(VehicleTankDischargeMethod::class,'discharge_method_id');
    }
    public function material(){
        return $this->belongsTo(VehicleBodyMaterial::class,'material_id');
    }
    public function adrType(){
        return $this->belongsTo(VehicleAdrType::class,'adr_id');
    }
    protected $casts=[
        'is_adr'=>'boolean',
    ];
}
