<?php

class Supervisor
{
    public static function all()
    {
        $query = "SELECT * FROM supervisors";

		$supervisors = self::connection()
            ->query($query)
            ->fetch_all(1);

        return $supervisors;
    }

    public static function connection()
    {
        try {
            return mysqli_connect("localhost","root","","berserk");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}