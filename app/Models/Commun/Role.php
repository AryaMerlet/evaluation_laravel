<?php

namespace App\Models\Commun;

use App\Traits\LogAction;
use Database\Factories\Commun\RoleFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Silber\Bouncer\Database\Role as BouncerRole;

/**
 * @property-read Collection<int, \Silber\Bouncer\Database\Ability> $abilities
 * @property-read int|null $abilities_count
 * @property-read string $actions
 * @property-read Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\Commun\RoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereAssignedTo($model, ?array $keys = null)
 *
 * @mixin \Eloquent
 */
class Role extends BouncerRole      // @phpstan-ignore-line
{
    /**
     * @use HasFactory<RoleFactory>
     */
    use HasFactory;

    use LogAction;

    public const ADMIN = 'admin';

    public const SALARIE = 'salarie';

    /**
     * @var list<string>
     */
    protected $appends = [
        'actions',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'scope' => 1,
    ];

    /**
     * @var array<string>
     */
    protected static $foreign_keys = [
        'users',
    ];

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }
}
