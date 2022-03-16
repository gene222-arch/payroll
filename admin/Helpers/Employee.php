<?php

class Employee
{
    public static function all()
    {
        $query = "SELECT * FROM employees";

		$employees = self::connection()
            ->query($query)
            ->fetch_all(1);

        return $employees;
    }

    public static function allBySupervisor(int $supervisorID)
    {
        $sql = "SELECT 
            *,
            employees.id as empid
        FROM 
            employee_supervisors
        INNER JOIN 
            employees 
        ON 
            employees.id = employee_supervisors.employee_id
        INNER JOIN 
            `position`
        ON 
            `position`.id = employees.position_id
        LEFT JOIN 
            schedules 
        ON 
            schedules.id = employees.schedule_id
        WHERE 
            employee_supervisors.supervisor_id = '". $supervisorID ."'";

        $employees = self::connection()
            ->query($sql)
            ->fetch_all(1);

        return $employees;
    }

    public static function connection()
    {
        try {
            return mysqli_connect("localhost","root","","berserk");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function assignSupervisor(int $employeeID, int $supervisorID)
    {
        $query = 
            "INSERT INTO 
                employee_supervisors(employee_id, supervisor_id)
            VALUES 
                ($employeeID, $supervisorID)
            ";

        $sql = self::connection()->query($query);

        return $sql;
    }

    public static function switchSupervisor(int $employeeID, int $supervisorID)
    {
        $query = 
            "UPDATE 
                employee_supervisors
            SET 
                supervisor_id = $supervisorID
            WHERE 
                employee_id = $employeeID
            ";

        $sql = self::connection()->query($query);

        return $sql;
    }
}