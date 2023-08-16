<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
 
if (!function_exists('getPermissionsMap')) {
    function getPermissionsMap()
    {

        $permissions_map = [
            'c' => 'create',
            'r' => 'read',
            'u' => 'update',
            'd' => 'delete', 
        ];

        return $permissions_map;

    }
}

if (!function_exists('getAllMolesWithPermissions')) {
    function getAllMolesWithPermissions()
    {

        $models = [
            'admins' => 'c,r,u,d,e',
            'annualEvaluationFeet' => 'c,r,u,d,e',
            'Attachment' => 'c,r,u,d,e',
            'Discount' => 'c,r,u,d,e',
            'EarlyComplication' => 'c,r,u,d,e',
            'GeneticDisease' => 'c,r,u,d,e',
            'LateComplication' => 'c,r,u,d,e',
            'MedicalExamination' => 'c,r,u,d,e', 
            'NewCase' => 'c,r,u,d,e',
            'Patient' => 'c,r,u,d,e', 
            'PatientDisease' => 'c,r,u,d,e',
            'PatientFollowUp' => 'c,r,u,d,e', 
            'Pharmaceutical' => 'c,r,u,d,e',
            'PreviousAnalysis' => 'c,r,u,d,e', 
            'ProcedureForPatient' => 'c,r,u,d,e',
            'RiskFactor' => 'c,r,u,d,e', 
            'Staff' => 'c,r,u,d,e',
            'StaffSalary' => 'c,r,u,d,e', 
            'User' => 'c,r,u,d,e',
            'Visit' => 'c,r,u,d,e', 
        ];

        return $models;
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($folder, $image)
    { 
        $image->store('/', $folder);
        $fileName = $image->hashName();
        $path = 'images/' . $folder . '/' . $fileName;
        return $path;
    }
} 
 
function get_application_name()
{ 
    return  'API Task';
}

function get_application_logo_url()
{ 
    return "layout/img/logo.png";
}
  
  
  
