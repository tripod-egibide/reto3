<?php
require_once __DIR__ . "/../core/database.php";

class Pedido
{
    private $idPedido, $nombre, $apellidos, $email, $telefono, $fechaEntrega, $total, $confirmado;

    /**
     * Pedido constructor.
     * @param $idPedido
     * @param $nombre
     * @param $apellidos
     * @param $email
     * @param $telefono
     * @param $fechaEntrega
     * @param $total
     * @param $confirmado
     */
    public function __construct($idPedido, $nombre, $apellidos, $email, $telefono, $fechaEntrega, $total, $confirmado)
    {
        $this->idPedido = $idPedido;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->fechaEntrega = $fechaEntrega;
        $this->total = $total;
        $this->confirmado= $confirmado;
    }

    public function toArray()
    {
        $data = [
            "nombre" => $this->nombre,
            "apellidos" => $this->apellidos,
            "email" => $this->email,
            "telefono" => $this->telefono,
            "fechaEntrega" => $this->fechaEntrega,
            "total" => $this->total,
            "confirmado" => $this->confirmado
        ];

        if (isset($this->idPedido)) {
            $data["idPedido"] = $this->idPedido;
        }

        return $data;
    }

    public function insert()
    {
        preparedStatement("INSERT INTO Pedido (nombre, apellidos, email, telefono, fechaEntrega, total, confirmado) 
            VALUES (:nombre, :apellidos, :email, :telefono, :fechaEntrega, :total, :confirmado)", $this->toArray());
        return connection()->query("SELECT idPedido FROM Pedido ORDER BY idPedido desc limit 1")->fetchAll();
    }

    public function insertDetallePedido($idPedido,$carrito)
    {
        $sentencia = "INSERT INTO DetallePedido (idPedido, idPlato, cantidad) VALUES ";
        foreach ($carrito as $clave => $valor){
            $sentencia .= " ( '" . $idPedido["idPedido"] . "', '" . $clave . "', '" . $valor["cantidad"] . "' ),";
        }
        connection()->query(substr($sentencia,0,strlen($sentencia)-1));
        return "Ok";
    }

    public static function delete($id)
    {
        preparedStatement("DELETE FROM Pedido WHERE idPedido = :idPedido", ["idPedido" => $id]);
    }

    public function update($id)
    {
        $data = $this->toArray();
        $data['idPedido'] = $id;

        preparedStatement("UPDATE Pedido
            SET nombre = :nombre,
                apellidos = :apellidos,
                email = :email,
                telefono = :telefono,
                fechaEntrega = :fechaEntrega,
                total = :total,
                confirmado = :confirmado
            WHERE idPedido = :idPedido", $data);
    }

    public static function getAll()
    {
        // esta función, como las otras get, seguramente tendrán que ser modificadas luego para paginar
        // si no, podríamos estar cargando cientos de platos a la vez
        // (aunque realísticamente el restaurante querría tener todos sus platos visibles, y no tendrían tantos en primer lugar)
        return connection()->query("SELECT * FROM Pedido")->fetchAll();
    }

    public static function getByNombre($nombre)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE nombre like :nombre", ["nombre" => "%$nombre%"])->fetchAll();
    }

    public static function getByApellidos($apellidos)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE apellidos like :apellidos", ["apellidos" => "%$apellidos%"])->fetchAll();
    }

    public static function getByString($string)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE nombre like :string or apellidos like :string", ["string" => $string])->fetchAll();
    }

    public static function getByEmail($email)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE email like :email", ["email" => "%$email%"])->fetchAll();
    }

    public static function getByTelf($telf)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE telefono like :telf ", ["telf" => "%$telf%"])->fetchAll();
    }

    public static function getByDate($fechaI, $fechaF)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE fechaEntrega between :fechaI and :fechaF ", ["fechaI" => $fechaI, "fechaF" => $fechaF])->fetchAll();
    }

    public static function getByConfirmado($confirmado)
    {
        return preparedStatement("SELECT * FROM Pedido WHERE confirmado = :confirmado", ["confirmado" => $confirmado])->fetchAll();
    }

    public static function getAllDetallePedidoByIdPedido($idPedido)
    {
        return preparedStatement("SELECT categoria.idCategoria, categoria.nombre, categoria.emailDepartamento FROM detallepedido 
inner join plato on plato.idPlato = detallepedido.idPlato 
inner join categoria on categoria.idCategoria = plato.idCategoria 
where detallepedido.idPedido = :idPedido 
group by plato.idCategoria", ["idPedido" => $idPedido])->fetchAll();
    }

    public static function getDetallePedidoByIdPedido($idPedido)
    {
        return preparedStatement("SELECT * FROM DetallePedido WHERE idPedido = :idPedido", ["idPedido" => $idPedido])->fetchAll();
    }

    public static function confirmarPedido($idPedido)
    {
        return preparedStatement("UPDATE pedido SET confirmado = 1 WHERE idPedido = :idPedido", ["idPedido" => $idPedido]);
    }

    /**
     * @return mixed
     */
    public function getIdPedido()
    {
        return $this->idPedido;
    }

    /**
     * @param mixed $idPedido
     */
    public function setIdPedido($idPedido): void
    {
        $this->idPedido = $idPedido;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * @param mixed $fechaEntrega
     */
    public function setFechaEntrega($fechaEntrega): void
    {
        $this->fechaEntrega = $fechaEntrega;
    }

}
?>