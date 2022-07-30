<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $birthdate
 * @property int|null $birthplace_id
 * @property int|null $address_id
 * @property int|null $gender
 * @property string|null $family_status
 * @property int|null $children_number
 * @property string|null $wife_name
 * @property string|null $birthday_document_number
 * @property string|null $education_level
 * @property string|null $blood_type
 * @property string|null $postal_account_number
 * @property string|null $social_security_number
 * @property string|null $recruitment_date
 * @property string|null $insurance_date
 * @property string|null $national_service
 * @property string|null $national_service_rank
 * @property string|null $phone
 * @property string|null $national_card
 * @property string|null $document_date
 * @property int|null $document_address
 * @property string|null $driver_license
 * @property string|null $driver_license_date
 * @property string|null $document_number
 *
 *
 **/

class Employees extends Model
{
    use HasFactory;
}
