<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\NewMessageNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Fortify\TwoFactorAuthenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,TwoFactorAuthenticatable;

    protected $table ="users";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'age',
        'city',
        

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'tasks_tables', 'user_id', 'task_id')
                    ->withPivot('status', 'assigned_at')  // Additional fields in the pivot table
                    ->withTimestamps();  // Automatically handles timestamps for pivot table
    }
  
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

     
       public function broadcastOn()
       {
           return new Channel('task.' . $this->task->id);
       }
   
   
       public function broadcastAs()
       {
           return 'task-assigned';
       }
       public function hasRole($role)
    {
        return $this->role === $role;
    }
       
}
