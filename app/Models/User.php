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
        'gender',
        'blood_type',
        'phone',
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
        'expected_jobs',
        'job_preferences',
        'birth_date',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'languages' => 'array',
        'expected_jobs' => 'array',
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
    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function savedJobs()
    {
        return $this->belongsToMany(JobListing::class, 'saved_jobs', 'user_id', 'job_listing_id')->withTimestamps();
    }
    public function tpaSessions()
    {
        return $this->hasMany(TpaTestSession::class);
    }
    public function tpaResults()
    {
        return $this->hasMany(TpaResult::class);
    }
    public function institution()
    {
        return $this->hasOne(Institution::class);
    }
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class, 'teacher_id');
    }

    public function teacherClasses()
    {
        return $this->hasMany(TeacherClass::class, 'teacher_id');
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class);
    }

    public function initiatedConversations()
    {
        return $this->hasMany(DirectConversation::class, 'industry_id');
    }

    public function receivedConversations()
    {
        return $this->hasMany(DirectConversation::class, 'job_seeker_id');
    }

    public function totalUnreadMessages()
    {
        if ($this->isIndustryOrStaff()) {
            return DirectMessage::whereIn('conversation_id', $this->initiatedConversations()->pluck('id'))
                ->where('sender_id', '!=', $this->id)
                ->where('is_read', false)
                ->count();
        } elseif ($this->isJobSeeker()) {
            return DirectMessage::whereIn('conversation_id', $this->receivedConversations()->pluck('id'))
                ->where('sender_id', '!=', $this->id)
                ->where('is_read', false)
                ->count();
        }
        return 0;
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
    public function isTeacher()
    {
        return $this->role === 'teacher';
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
        $hasPhoto = \App\Models\UserDocument::where('user_id', $this->id)->where('document_type', 'photo')->exists();
        if ($hasPhoto) {
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
        if (!empty($this->major) || $this->education_level === 'Tidak Sekolah') {
            $percentage += 15;
        }

        // cv_path (25%)
        $hasCv = \App\Models\UserDocument::where('user_id', $this->id)->where('document_type', 'cv')->exists();
        if ($hasCv) {
            $percentage += 25;
        }

        return $percentage;
    }

    public function hasCompletedProfile()
    {
        return $this->profile_completion_percentage === 100;
    }
}
