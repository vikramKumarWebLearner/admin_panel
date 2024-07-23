<?php

namespace App\Repositories;

use Carbon\Carbon;

/**
 * Class DashboardRepository
 * @package App\Repositories
 * @version July 26, 2021, 12:17 pm UTC
 */

class DashboardRepository
{
    /** @var  UserRepository */
    private $userRepository;
    /** @var  RoleRepository */
    private $roleRepository;
    /** @var  PermissionRepository */
    private $permissionRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo, PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
    }

    private function getDashboardInfo()
    {
        $dashboardInfo = [];
        $dashboardInfo['user_count'] =  $this->userRepository->count();
        $dashboardInfo['role_count'] =  $this->roleRepository->count();
        return $dashboardInfo;
    }

    public function GetData()
    {
        $dashboard = [];
        $dashboard['dashboardInfo'] = $this->getDashboardInfo();
        return $dashboard;
    }
}
