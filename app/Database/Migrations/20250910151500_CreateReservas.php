<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idReserva'        => ['type' => 'INT', 'auto_increment' => true],
            'idUsuario'        => ['type' => 'INT', 'unsigned' => true],
            'idHabitacion'     => ['type' => 'INT', 'unsigned' => true],
            'fechaInicio'      => ['type' => 'DATE'],
            'fechaFin'         => ['type' => 'DATE'],
            'cantidadHuespedes'=> ['type' => 'TINYINT', 'unsigned' => true, 'default' => 1],
            'precio_por_noche' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'total'            => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'estado'           => ['type' => 'ENUM("pendiente","confirmada","cancelada")', 'default' => 'pendiente'],
            'pago_estado'      => ['type' => 'ENUM("pendiente","pagado","fallido")', 'default' => 'pendiente'],
            'comentarios'      => ['type' => 'TEXT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addKey('idReserva', true);
        $this->forge->addForeignKey('idUsuario', 'usuarios', 'idUsuario', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idHabitacion', 'habitaciones', 'idHabitacion', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reservas');
    }

    public function down()
    {
        $this->forge->dropTable('reservas');
    }
}
