<?php

class Deduction
{
    public static function total()
    {
        $query = "SELECT 
            SUM(amount) as total_deductions
        FROM 
            deductions";

		$total = self::connection()
            ->query($query)
            ->fetch_object();

        return $total;
    }

    public static function find(int $id)
    {
        $query = "SELECT * FROM deductions WHERE id = $id";

        $deduction = self::connection()
            ->query($query)
            ->fetch_object();

        return $deduction;
    }

    public static function connection()
    {
        try {
            return mysqli_connect("localhost","root","","berserk");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function create(string $description, float $amount)
    {
        $query = 
            "INSERT INTO 
                deductions(description, amount)
            VALUES
                ('". $description ."', " . $amount . ")
            ";
        
        $isStored = self::connection()->query($query);

        return $isStored;
    }

    public static function update(int $deductionID, string $description, float $amount)
    {
        $query = 
            "UPDATE 
                deductions
            SET
                description = '". $description ."', 
                amount = ". $amount ."
            WHERE
                id = {$deductionID}
            ";
        
        $isUpdated = self::connection()->query($query);

        return $isUpdated;
    }

    public static function delete(int $deductionID)
    {
        $query = "DELETE from deductions WHERE id = ". $deductionID ."";
        
        $isDestroyed = self::connection()->query($query);

        return $isDestroyed;
    }
}