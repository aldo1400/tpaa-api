<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class RenameNotificationsTableToNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::rename('notificacions', 'notificaciones');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::rename('notificaciones', 'notificacions');
    }
}
