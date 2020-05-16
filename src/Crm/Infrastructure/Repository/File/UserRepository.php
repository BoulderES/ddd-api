<?php


namespace Cuadrik\Crm\Infrastructure\Repository\File;


use Cuadrik\Crm\Domain\User\User;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;

class UserRepository //implements UserRepositoryInterface
{
    public function save(User $obj): void
    {

        $objData = json_encode($obj);
        $filePath = '/var/www/html/public/persistence/object'.$obj->uuid().'.txt';
        $filesystem = new Filesystem();
        if($filesystem->exists($filePath)){
            $filesystem->remove($filePath);
        }

        $filesystem->appendToFile($filePath, $objData);
        if (is_writable($filePath)) {
            $fp = fopen($filePath, "w");
            fwrite($fp, $objData);
            fclose($fp);
        }

    }


    public function userByUuid($obj)
    {
        $filePath = '/var/www/html/public/persistence/object'.$obj.'.txt';
        if (file_exists($filePath)){
            $objData = file_get_contents($filePath);
            $user_aux = json_decode($objData);
            $user = User::dummyUser($user_aux);
            return $user;

        }

    }

}