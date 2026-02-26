<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHabitaciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idHabitacion' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'tipo'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'descripcion'  => ['type' => 'TEXT', 'null' => true],
            'estado'       => [
                'type'    => 'ENUM("disponible","ocupada","mantenimiento")',
                'default' => 'disponible'
            ],
            'imagen'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('idHabitacion', true);
        $this->forge->createTable('habitaciones');
    }

    public function down()
    {
        $this->forge->dropTable('habitaciones');
    }
}
