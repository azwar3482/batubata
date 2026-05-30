<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'phone',
        'photo',
        'cv_path',
        'education_level',
        'major',
        'graduation_year',
        'experience_years',
        'institution_id',
        'target_position',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'bio',
        'latitude',
        'longitude',
        'address',
        'skills',
        'languages',
        'expected_job_type',
        'expected_salary',
        'job_preferences',
        'birth_date',
        'company_id',
        'company_role',
        'status',
        'custom_permissions'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'languages' => 'array',
        'custom_permissions' => 'array',
    ];

    // Relasi
    public function careerHistories()
    {
        return $this->hasMany(CareerHistory::class);
    }

    public function assessments()
    {
        return $this->hasMany(UserAssessment::class);
    }
    public function courseProgress()
    {
        return $this->hasMany(UserCourseProgress::class);
    }
    public function roadmaps()
    {
        return $this->hasMany(CareerRoadmap::class);
    }
    public function jobApplications()
    {
        return $this->hasMany(UserJobApplication::class);
    }
    public function institution()
    {
        return $this->hasOne(Institution::class);
    }
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    // Helper untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isJobSeeker()
    {
        return $this->role === 'job_seeker';
    }
    public function isIndustry()
    {
        return $this->role === 'industry';
    }
    public function isEducation()
    {
        return $this->role === 'education';
    }
    public function isStaff()
    {
        return str_starts_with($this->role, 'staf_');
    }
    public function isIndustryOrStaff()
    {
        return $this->isIndustry() || $this->isStaff();
    }
    public function hasPermission($permission)
    {
        if ($this->isIndustry()) {
            return true;
        }

        if (is_array($this->custom_permissions) && in_array($permission, $this->custom_permissions)) {
            return true;
        }

        $rolePermissions = [
            'staf_hr_manager' => [
                'post_jobs',
                'view_candidates',
                'manage_applications',
                'schedule_interview',
                'submit_feedback',
                'view_reports',
            ],
            'staf_recruiter' => [
                'view_candidates',
                'schedule_interview',
                'submit_feedback',
            ],
            'staf_talent_sourcer' => [
                'view_candidates',
            ],
            'staf_interviewer' => [
                'view_candidates',
                'submit_feedback',
            ],
        ];

        return in_array($permission, $rolePermissions[$this->role] ?? []);
    }

    public function getProfileCompletionPercentageAttribute()
    {
        if (!$this->isJobSeeker()) {
            return 100;
        }

        $percentage = 0;

        // name (10%)
        if (!empty($this->name)) {
            $percentage += 10;
        }

        // photo (10%)
        if (!empty($this->photo)) {
            $percentage += 10;
        }

        // phone (10%)
        if (!empty($this->phone)) {
            $percentage += 10;
        }

        // gender (10%)
        if (!empty($this->gender)) {
            $percentage += 10;
        }

        // address (10%)
        if (!empty($this->address) || (!empty($this->latitude) && !empty($this->longitude))) {
            $percentage += 10;
        }

        // education_level (10%)
        if (!empty($this->education_level)) {
            $percentage += 10;
        }

        // major (15%)
        if (!empty($this->major)) {
            $percentage += 15;
        }

        // cv_path (25%)
        if (!empty($this->cv_path)) {
            $percentage += 25;
        }

        return $percentage;
    }

    public function hasCompletedProfile()
    {
        return $this->profile_completion_percentage === 100;
    }
}
