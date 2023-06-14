<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRolesAndPermissions
{
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(...$roles) : bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка на доступ к Админ панели
     * slug = E (Entrance|вход) разрешает войти
     * @return bool
     */
    public function hasEntrance() : bool
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role){
            if($role->permissions->contains('slug', 'E')){
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка на доступ к удалению
     * slug = D (Delete|удалить) разрешает удалить
     * @return bool
     */
    public function hasDelete() : bool
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role){
            if($role->permissions->contains('slug', 'D')){
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка на доступ к импорту данных
     * slug = I (Import|Импорт) разрешает импортировать
     * @return bool
     */
    public function hasImport() : bool
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role){
            if($role->permissions->contains('slug', 'I')){
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка на доступ к созданию и редактированию пользователей
     * slug = UCU (User_Create_Update)
     * @return bool
     */
    public function hasUser() : bool
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role){
            if($role->permissions->contains('slug', 'U-CUD')){
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка на доступ к созданию, удаление, редактированию разрешонных IP
     * slug = IP (Access_ip|уникальный сетевой адрес узла в компьютерной сети)
     * @return bool
     */
    public function hasAccessIp() : bool
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role){
            if($role->permissions->contains('slug', 'IP-CUD')){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermission($permission) : bool
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }
    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermissionTo($permission) : bool
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission) : bool
    {
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }
    /**
     * @param array $permissions
     * @return mixed
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug',$permissions)->get();
    }

    protected function getAllRole(array $role)
    {

        return Role::whereIn('slug',$role)->get();
    }
    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
    public function giveRolesTo($roles)
    {
        $roles = $this->getAllRole($roles);

        if($roles === null) {
            return $this;
        }
        $this->roles()->saveMany($roles);
        return $this;
    }
    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(... $permissions )
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }
    /**
     * @param mixed ...$permissions
     * @return HasRolesAndPermissions
     */
    public function refreshPermissions(... $permissions )
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deleteRoles(... $role )
    {
        $roles = $this->getAllRole($role);
        $this->roles()->detach($roles);
        return $this;
    }

    public function refreshRoles($roles)
    {
        $this->roles()->detach();
        return $this->giveRolesTo($roles);
    }
}
