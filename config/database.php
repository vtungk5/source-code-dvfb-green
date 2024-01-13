<?php
ini_set('display_errors', 0);
class connect
{
    public static $site_me = '127.0.0.1'; // tên miền site mẹ

    private $mysqli = [
        'host'     => 'localhost',
        'username' => 'localhost',
        'password' => 'localhost',
        'database' => 'localhost',
        'port'     =>  3306
    ];

    private $config = [
        'insert' => 'INSERT INTO',
        'update' => 'UPDATE',
        'delete' => 'DELETE FROM',
        'select' => 'SELECT * FROM'
    ];

    public function ketnoi()
    {
        $ketnoi = mysqli_connect(
            $this->mysqli['host'],
            $this->mysqli['username'],
            $this->mysqli['password'],
            $this->mysqli['database'],
            $this->mysqli['port']
        ) or die(mysqli_connect_error());
        return $ketnoi;
        mysqli_query($ketnoi, "set names 'utf8'");
    }

    public function dis_connect()
    {
        if ($this->ketnoi) {
            return mysqli_close($this->ketnoi());
        }
    }

    public function save($table, $data)
    {
        try {
            $sql = $this->config['insert'] . " `$table` SET ";
            $i = 0;
            foreach ($data as $key => $value) {
                if ($i++ === 0) {
                    $sql .= "`$key`='$value'";
                } else {
                    $sql .= ",`$key`='$value'";
                }
            }
            return mysqli_query($this->ketnoi(), $sql);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($table, $data, $where = null)
    {
        try {
            $sql = $this->config['update'] . " `$table` SET ";
            $i = 0;
            foreach ($data as $key => $value) {
                if ($i++ === 0) {
                    $sql .= "`$key`='$value'";
                } else {
                    $sql .= ",`$key`='$value'";
                }
            }
            if ($where != null) {
                $sql .= "WHERE ";
                $x = 0;
                foreach ($where as $where_key => $where_value) {
                    if ($x++ === 0) {
                        $sql .= "`$where_key`='$where_value'";
                    } else {
                        $sql .= " AND `$where_key`='$where_value'";
                    }
                }
            }
            return  mysqli_query($this->ketnoi(), $sql);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function query($table, $where = null, $order_by = null, $limit = null)
    {
        try {
            $sql = $this->config['select'] . " `$table` ";

            if ($where != null) {
                $sql .= "WHERE ";
                $i = 0;
                foreach ($where as $where_key => $where_value) {
                    if ($i++ === 0) {
                        $sql .= "`$where_key`='$where_value'";
                    } else {
                        $sql .= " AND `$where_key`='$where_value'";
                    }
                }
            }

            if ($order_by != null) {
                $sql .= " ORDER BY ";
                $x = 0;
                foreach ($order_by as $order_by_id) {
                    if ($x++ === 0) {
                        $sql .= $order_by_id;
                    } else {
                        $sql .= ',' . $order_by_id;
                    }
                }
            }

            if ($limit != null) {
                $sql .= ' LIMIT ' . $limit[0] . ',' . $limit[1];
            }

            $result = mysqli_query($this->ketnoi(), $sql);
            $return = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $return[] = $row;
            }
            mysqli_free_result($result);
            if (isset($return)) {
                return $return;
            } else {
                return false;
            }
       
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function query_one($table, $where = null, $order_by = null, $limit = null)
    {
            $sql = $this->config['select'] . " `$table` ";

            if ($where != null) {
                $sql .= "WHERE ";
                $i = 0;
                foreach ($where as $where_key => $where_value) {
                    if ($i++ === 0) {
                        $sql .= "`$where_key` = '$where_value'";
                    } else {
                        $sql .= " AND `$where_key` = '$where_value'";
                    }
                }
            }

            if ($order_by != null) {
                $sql .= " ORDER BY ";
                $x = 0;
                foreach ($order_by as $order_by_id) {
                    if ($x++ === 0) {
                        $sql .= $order_by_id;
                    } else {
                        $sql .= ',' . $order_by_id;
                    }
                }
            }

            if ($order_by != null) {
                $sql .= ' LIMIT ' . $limit[0] . ',' . $limit[1];
            }

            $result = mysqli_query($this->ketnoi(), $sql);
            if (!$result)
            {
                die ('Lỗi kết nối cơ sở dữ liệu x'.$sql);
            }
            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            if ($row) {
                return $row;
            }
            return false;
    }

    
    public function delete($table, $where = null)
    {
        try {
            $sql = $this->config['delete'] . " `$table` ";
            $i = 0;
            if ($where != null) {
                $sql .= "WHERE ";
                $x = 0;
                foreach ($where as $where_key => $where_value) {
                    if ($x++ === 0) {
                        $sql .= "`$where_key`='$where_value'";
                    } else {
                        $sql .= " AND `$where_key`='$where_value'";
                    }
                }
            }
            return mysqli_query($this->ketnoi(), $sql);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function num_rows($table, $where = null)
    {
            $sql = $this->config['select'] . " `$table` ";
            if ($where != null) {
                $sql .= "WHERE ";
                $x = 0;
                foreach ($where as $where_key => $where_value) {
                    if ($x++ === 0) {
                        $sql .= "`$where_key`='$where_value'";
                    } else {
                        $sql .= " AND `$where_key`='$where_value'";
                    }
                }
            }
            $result = mysqli_query($this->ketnoi(), $sql);
            if (!$result) {
                die('Lỗi kết nối cơ sở dữ liệu');
            } else {
                $row = mysqli_num_rows($result);
                mysqli_free_result($result);
                if ($row) {
                    return $row;
                }
                return false;
            }

    }
    public function create_table($file)
    {   
        $myfile = fopen($_SERVER['DOCUMENT_ROOT'].$file, "r") or die("Unable to open file!");
        $data = fread($myfile, filesize($_SERVER['DOCUMENT_ROOT'].$file));
        $conn = $this->ketnoi();
        try {
            if (mysqli_query($conn, $data)) {
                echo "Tạo bảng thành công";
            } else {
                die(mysqli_error($conn));
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
$DB = new connect;