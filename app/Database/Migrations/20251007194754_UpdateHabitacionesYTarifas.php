<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHabitacionesYTarifas extends Migration
{
    public function up()
    {
        // 🔧 Desactivar restricciones de FK temporalmente
        $this->db->disableForeignKeyChecks();

        // 🔥 Eliminar tablas si existen (evita error #1451)
        $this->forge->dropTable('habitacion_tarifas', true);
        $this->forge->dropTable('habitaciones', true);

        // ✅ Crear tabla habitaciones
        $this->forge->addField([
            'idHabitacion' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => 50
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'estado' => [
                'type'       => "ENUM('disponible','ocupada','mantenimiento')",
                'default'    => 'disponible'
            ],
            'imagen' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('idHabitacion', true);
        $this->forge->createTable('habitaciones');

        // ✅ Crear tabla habitacion_tarifas (sin campo estado)
        $this->forge->addField([
            'idTarifa' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'idHabitacion' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 100
            ],
            'capacidad' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'default'    => 1
            ],
            'precio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'moneda' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'ARS'
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'nino' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00
            ]
        ]);

        $this->forge->addKey('idTarifa', true);
        $this->forge->addForeignKey('idHabitacion', 'habitaciones', 'idHabitacion', 'CASCADE', 'CASCADE');
        $this->forge->createTable('habitacion_tarifas');

        // 🔒 Volver a activar las foreign keys
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('habitacion_tarifas', true);
        $this->forge->dropTable('habitaciones', true);
        $this->db->enableForeignKeyChecks();
    }
}
