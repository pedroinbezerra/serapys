<?php

class mMemorial extends mConnection
{
    public function manageMemorial($NAME, $SURNAME, $BIRTH, $DEATH, $BIOGRAPHY, $IMAGE, $ACTION, $ID = '')
    {
        try {
            $result = '';

            if ($IMAGE == '' && $ACTION == 'update') {
                $uploadImage = 'noImage';
            } else {
                $uploadImage = $this->uploadImage($IMAGE);
            }

            if ($uploadImage) {
                if ($ACTION == 'insert') {
                    $result = $this->insertMemorial($NAME, $SURNAME, $BIRTH, $DEATH, $BIOGRAPHY, $uploadImage);
                } else {
                    $result = $this->updateMemorial($ID, $NAME, $SURNAME, $BIRTH, $DEATH, $BIOGRAPHY, $uploadImage);
                }
            } else {
                $result = false;
            }

            return $result;
        } catch (Exception $e) {
            print_r($e);
            exit;
        }
    }

    public function insertMemorial($NAME, $SURNAME, $BIRTH, $DEATH, $BIOGRAPHY, $IMAGE)
    {
        $con = $this->Connect();

        try {
            $sql = "INSERT INTO MEMORIAL(NAME, SURNAME, BIRTH, DEATH, BIOGRAPHY, IMAGE) VALUES (:NAME, :SURNAME, :BIRTH, :DEATH, :BIOGRAPHY, :IMAGE)";
            $con->beginTransaction();
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":NAME", $NAME, PDO::PARAM_STR);
            $stmt->bindParam(":SURNAME", $SURNAME, PDO::PARAM_STR);
            $stmt->bindParam(":BIRTH", $BIRTH, PDO::PARAM_STR);
            $stmt->bindParam(":DEATH", $DEATH, PDO::PARAM_STR);
            $stmt->bindParam(":BIOGRAPHY", $BIOGRAPHY, PDO::PARAM_STR);
            $stmt->bindParam(":IMAGE", $IMAGE, PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                $con->commit();
            } else {
                $con->rollBack();
            }

            return $result;
        } catch (Exception $e) {
            $con->rollBack();
            return false;
        }
    }

    public function updateMemorial($ID, $NAME, $SURNAME, $BIRTH, $DEATH, $BIOGRAPHY, $IMAGE)
    {
        $con = $this->Connect();

        try {
            if ($IMAGE == 'noImage') {
                $sql = "UPDATE MEMORIAL SET NAME = :NAME, SURNAME = :SURNAME, BIRTH = :BIRTH, DEATH = :DEATH, BIOGRAPHY = :BIOGRAPHY WHERE ID = :ID";
            } else {
                $sql = "UPDATE MEMORIAL SET NAME = :NAME, SURNAME = :SURNAME, BIRTH = :BIRTH, DEATH = :DEATH, BIOGRAPHY = :BIOGRAPHY, IMAGE = :IMAGE WHERE ID = :ID";
            }

            $con->beginTransaction();
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
            $stmt->bindParam(":NAME", $NAME, PDO::PARAM_STR);
            $stmt->bindParam(":SURNAME", $SURNAME, PDO::PARAM_STR);
            $stmt->bindParam(":BIRTH", $BIRTH, PDO::PARAM_STR);
            $stmt->bindParam(":DEATH", $DEATH, PDO::PARAM_STR);
            $stmt->bindParam(":BIOGRAPHY", $BIOGRAPHY, PDO::PARAM_STR);

            if ($IMAGE != 'noImage') {
                $stmt->bindParam(":IMAGE", $IMAGE, PDO::PARAM_STR);
            }

            $result = $stmt->execute();

            if ($result) {
                $con->commit();
            } else {
                $con->rollBack();
            }

            return $result;
        } catch (Exception $e) {
            $con->rollBack();
            var_dump($e);
            exit;
            return false;
        }
    }

    public function deleteMemorial($ID)
    {
        $sql = "DELETE FROM MEMORIAL WHERE ID = :ID";
        $con = $this->Connect();
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function getMemorials()
    {
        $sql = "SELECT * FROM MEMORIAL";
        $con = $this->Connect();
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMemorial($ID)
    {
        $sql = "SELECT * FROM MEMORIAL WHERE ID = :ID";
        $con = $this->Connect();
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function uploadImage($IMAGE)
    {
        try {
            $fileType = $this->typeOfFile($IMAGE["name"]);

            $date = new DateTime();

            $newName = $date->getTimestamp() . rand() . '.' . $fileType;

            $path = join(DIRECTORY_SEPARATOR, array('img', 'memorials', $newName));

            $result = move_uploaded_file($IMAGE['tmp_name'], $path);

            if ($result) {
                return $path;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function typeOfFile($FILENAME)
    {
        try {
            $filename_array = explode('.', $FILENAME);
            $position_of_extension = count($filename_array) - 1;
            return $filename_array[$position_of_extension];
        } catch (Exception $e) {
            return false;
        }
    }

    public function countMemorials()
    {
        $sql = "SELECT COUNT(1) AS CONT FROM MEMORIAL";
        $con = $this->Connect();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['CONT'];
    }

    public function getMemorialsWithPagination($BEGIN_LIST, $MAXIMUM = 4) {
        $sql = "SELECT * FROM MEMORIAL LIMIT :BEGIN_LIST, :MAXIMUM";
        $con = $this->Connect();
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":BEGIN_LIST", $BEGIN_LIST, PDO::PARAM_INT);
        $stmt->bindParam(":MAXIMUM", $MAXIMUM, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
