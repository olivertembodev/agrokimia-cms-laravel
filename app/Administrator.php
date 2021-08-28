<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Administrator extends Authenticatable
    {
        use Notifiable;

        protected $table 	= 'administrators';
        protected $guard = 'administrator';
        
        use SoftDeletes;
        public $incrementing = false; public $keyType = 'uuid';

        protected $fillable = [
            'name', 'email', 'password', 'nik', 'nip', 'phone', 'tanggal_lahir', 'address', 'status', 'deleted_at', 'created_at', 'updated_at',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        public function role()
        {
            return $this->hasOne('App\Role', 'id_role');
        }
    }