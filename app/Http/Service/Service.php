<?php

namespace App\Http\Service;

use App\User;
use App\EstUser;
use App\RoleXUser;
use App\RoleXPermission;
use App\Role;
use Session;

class Service
{
    /**
     * This method register the especific user
     *
     * @param array $arrParms
     * @return static
     */
    public function createUser($arrParms)
    {
        $arrParms['create_date'] = date('Y-m-d H:i:s');
        $arrParms['id_est_user'] = 1;
        return User::create($arrParms);
    }

    /**
     * This method register by default de user role customer
     *
     * @param int $idUser
     */
    public function createUserRole($idUser)
    {
        $arrParms['id_user'] = $idUser;
        $arrParms['id_role'] = 3;
        $arrParms['create_date'] = date('Y-m-d H:i:s');
        RoleXUser::create($arrParms);

    }

    /**
     * This method update the user row
     *
     * @param int $idUser
     * @param array $arrParms
     */
    public function updateUser($idUser, $arrParms)
    {
        $arrPar['modified_date'] = date('Y-m-d H:i:s');
        User::where('id_user', $idUser)->update($arrParms);
    }

    /**
     * This method validated if exist the user
     *
     * @param $email
     * @return bool
     */
    public function existUser($email)
    {
        $objUser = User::where('email', $email)->first();
        return ((!empty($objUser->id_user)) ? $objUser->id_user : 0);
    }

    /**
     * This methos get all status of the user
     *
     * @return array
     */
    public function getRow($nomModel, $nomTable)
    {
        $arrModel = [];
        $objModel = $nomModel::all();
        foreach ($objModel as $model) {
            $id = 'id_'.$nomTable;
            $nom = 'nom_'.$nomTable;
            $arrModel[$model->$id] = $model->$nom;
        }
        return $arrModel;
    }

    /**
     * This methos get all permission available for the logged user
     *
     * @param $idUser
     * @return mixed
     */
    public function getPermissionByRole($idUser)
    {
        $objUserRole = RoleXUser::where('id_user', $idUser)->first();
        $objPermission = RoleXPermission::where('id_role', $objUserRole->id_role)->get();
        Session::set('id_role', $objUserRole->id_role);
        return $objPermission;
    }

    /**
     * This methos get an especific permission according to Module and Permission
     *
     * @param int $idModule
     * @param int $idPermission
     * @return mixed
     */
    public function getPermission($idModule, $idPermission, $idRole)
    {
        $objUserRole = RoleXPermission::where('id_module', $idModule)
            ->where('id_permission', $idPermission)
            ->where('id_role', $idRole)->first();

        return $objUserRole;
    }

    /**
     * This method get all relation on the user by role
     *
     * @return array
     */
    public function getUserXRole()
    {
        $arrUserXRole = [];
        $objUser = User::all();

        foreach ($objUser as $user) {
            $objRoleXUser = RoleXUser::where('id_user', $user->id_user)->first();
            $objRole = Role::where('id_role', $objRoleXUser['id_role'])->first();
            $user->nom_role = $objRole['nom_role'];
            $user->id_role_xuser = $objRoleXUser['id_role_xuser'];
            $arrUserXRole[] = $user;
        }

        return $arrUserXRole;
    }

    /**
     * This method normalize the fields form to columns of database
     *
     * @param array $arrPar
     * @return array
     */
    public function normParUser($arrPar)
    {
        $arrReturn = [];
        foreach ($arrPar as $key => $value) {
            switch ($key) {
                case 'txtName':
                case 'name':
                    $arrReturn['name_user'] = $value;
                    break;
                case 'txtEmail':
                case 'email':
                    $arrReturn['email'] = $value;
                    break;
                case 'txtPhoneNumber':
                    $arrReturn['phone_number'] = $value;
                    break;
                case 'txtPassword':
                case 'password':
                    $arrReturn['password'] = bcrypt($value);
                    break;
                case 'optEst':
                case 'id_est_user':
                    $arrReturn['id_est_user'] = $value;
                    break;
            }
        }

        return $arrReturn;
    }
}