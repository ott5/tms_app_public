<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * app/models/Vehicle.php
 * Model do tabeli pojazdów
 */
class Vehicle extends Model
{
    use HasFactory;
    protected $table='vehicles';
    protected $fillable=[
        'registration_number',
        'owner_type_id',
        'vin',
        'mileage',
        'model_id',
        'production_year',
        'axle_configuration_type_id',
        'is_active'
    ];
    public function model(){
        return $this->belongsTo(VehicleModel::class,'model_id');
    }
    public function ownerType(){
        return $this->belongsTo(VehicleOwnerType::class,'owner_type_id');
    }
    public function axleConfigurationType(){
        return $this->belongsTo(VehicleAxleConfigurationType::class,'axle_configuration_type_id');
    }
    protected $casts = [
        'is_active' => 'boolean',
        'production_year' => 'integer',
        'mileage' => 'integer'
    ];
}
