<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * app/Models/Employee.php
 * Model reprezentujący pracowników w systemie, przechowujący informacje o imieniu, nazwisku, numerze pracownika, aktywności oraz powiązaniu z użytkownikiem. Pracownicy mogą mieć przypisane narodowości oraz adresy, co pozwala na zarządzanie danymi personalnymi i kontaktowymi pracowników w systemie.
 */
class Employee extends Model
{
    use HasFactory;
    protected $table='employees';
    protected $fillable=['first_name','second_name','last_name','employee_number','user_id','is_active'];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    protected $casts=['is_active'=>'boolean'];
    public function nationalities(){
        return $this->belongsToMany(Country::class,'employee_nationalities','employee_id','country_tag','id','tag')
            ->withTimestamps();
    }
    public function addresses(){
        return $this->belongsToMany(Address::class,'address_employee','employee_id','address_id','id','id')
            ->withPivot('address_type_code')
            ->withTimestamps();
    }
    public function phoneNumbers(){
        return $this->belongsToMany(PhoneNumber::class,'employee_phone_number','employee_id','phone_number','id','number')
            ->withPivot('phone_usage_type_code')
            ->withTimestamps();
    }
    public function emails(){
        return $this->user->emails();
    }
    public function moreInformation(){
        return $this->hasOne(EmployeeMoreInformation::class,'employee_id','id');
    }
    public function documents(){
        return $this->hasMany(EmployeeDocument::class,'employee_id','id');
    }
    public function medicalExams(){
        return $this->hasMany(EmployeeMedicalExam::class,'employee_id','id');
    }
    public function licenseExperiences(){
        return $this->hasMany(EmployeeLicenseExperience::class,'employee_id','id');
    }
    public function driver(){
        return $this->hasOne(Driver::class,'employee_id','id');
    }
    public function isDriver(){
        return $this->driver()->exists();
    }
}
